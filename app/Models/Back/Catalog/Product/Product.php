<?php

namespace App\Models\Back\Catalog\Product;

use App\Helpers\Helper;
use App\Models\Back\Catalog\Author;
use App\Models\Back\Catalog\Category;
use App\Models\Back\Catalog\Publisher;
use App\Models\Back\Settings\Settings;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Bouncer;

class Product extends Model
{

    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'products';

    /**
     * @var array
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * @var Request
     */
    protected $request;


    /**
     * @return Relation
     */
    public function images()
    {
        return $this->hasMany(ProductImage::class, 'product_id')->orderBy('sort_order');
    }


    /**
     * @return Relation
     */
    /*public function actions()
    {
        return $this->hasOne(ProductAction::class, 'product_id')
                    ->where('date_start', '<', Carbon::now())
                    ->where('date_end', '>', Carbon::now())
                    ->orWhere('date_start', null)
                    ->orWhere('date_end', null);
    }*/


    /**
     * @return Relation
     */
    public function all_actions()
    {
        return $this->hasOne(ProductAction::class, 'product_id');
    }


    /**
     * @return false|mixed
     */
    public function special()
    {
        // If special is set, return special.
        if ($this->special) {
            $from = now()->subDay();
            $to = now()->addDay();

            if ($this->special_from) {
                $from = Carbon::make($this->special_from);
            }
            if ($this->special_to) {
                $to = Carbon::make($this->special_to);
            }

            if ($from <= now() && now() <= $to) {
                return $this->special;
            }
        }

        // If special is not set, check actions.
        $actions = ProductAction::active()->get();

        foreach ($actions as $action) {
            $ids = json_decode($action->links, true);

            if ($action->group == 'product') {
                if (in_array($this->id, $ids)) {
                    return Helper::calculateDiscountPrice($this->price, $action->discount);
                }
            }
            if ($action->group == 'category') {
                if (isset($this->category()->id)) {
                    if (in_array($this->category()->id, $ids)) {
                        return Helper::calculateDiscountPrice($this->price, $action->discount);
                    }
                }
                if (isset($this->subcategory()->id)) {
                    if (in_array($this->subcategory()->id, $ids)) {
                        return Helper::calculateDiscountPrice($this->price, $action->discount);
                    }
                }
            }
            if ($action->group == 'author') {
                if (in_array($this->author_id, $ids)) {
                    return Helper::calculateDiscountPrice($this->price, $action->discount);
                }
            }
            if ($action->group == 'publisher') {
                if (in_array($this->publisher_id, $ids)) {
                    return Helper::calculateDiscountPrice($this->price, $action->discount);
                }
            }
        }

        return false;
    }


    /**
     * @return Relation
     */
    public function categories()
    {
        return $this->hasManyThrough(Category::class, ProductCategory::class, 'product_id', 'id', 'id', 'category_id');
    }

    /**
     * @return Model|\Illuminate\Database\Eloquent\Relations\HasOneThrough|\Illuminate\Database\Query\Builder|mixed|object|null
     */
    public function category()
    {
        return $this->hasOneThrough(Category::class, ProductCategory::class, 'product_id', 'id', 'id', 'category_id')
                    ->where('parent_id', 0)
                    ->first();
    }


    /**
     * @return Model|\Illuminate\Database\Eloquent\Relations\HasOneThrough|\Illuminate\Database\Query\Builder|mixed|object|null
     */
    public function subcategory()
    {
        return $this->hasOneThrough(Category::class, ProductCategory::class, 'product_id', 'id', 'id', 'category_id')
                    ->where('parent_id', '!=', 0)
                    ->first();
    }


    /**
     * Validate New Product Request.
     *
     * @param Request $request
     *
     * @return $this
     */
    public function validateRequest(Request $request)
    {
        // Validate the request.
        $request->validate([
            'name'  => 'required',
            'sku'   => 'required',
            'price' => 'required'
        ]);

        // Set Product Model request variable
        $this->setRequest($request);

        return $this;
    }


    /**
     * Create and return new Product Model.
     *
     * @return mixed
     */
    public function create()
    {
        $author = $this->resolveAuthor();
        $publisher = $this->resolvePublisher();

        $id = $this->insertGetId([
            'author_id'        => $author,
            'publisher_id'     => $publisher,
            'action_id'        => $this->request->action ?: 0,
            'name'             => $this->request->name,
            'sku'              => $this->request->sku,
            'description'      => $this->cleanHTML($this->request->description),
            'slug'             => $this->request->slug ?: Str::slug($this->request->name),
            'price'            => $this->request->price,
            'quantity'         => isset($this->request->quantity) ? 1 : 0,
            'tax_id'           => $this->request->tax_id ?: 1,
            'special'          => $this->request->special,
            'special_from'     => $this->request->special_from ? Carbon::make($this->request->special_from) : null,
            'special_to'       => $this->request->special_to ? Carbon::make($this->request->special_to) : null,
            'meta_title'       => $this->request->meta_title ?: $this->request->name . '-' . Str::random(9),
            'meta_description' => $this->request->meta_description,
            'pages'            => $this->request->pages,
            'dimensions'       => $this->request->dimensions,
            'origin'           => $this->request->origin,
            'letter'           => $this->request->letter,
            'condition'        => $this->request->condition,
            'binding'          => $this->request->binding,
            'viewed'           => 0,
            'sort_order'       => 0,
            'push'             => 0,
            'status'           => (isset($this->request->status) and $this->request->status == 'on') ? 1 : 0,
            'created_at'       => Carbon::now(),
            'updated_at'       => Carbon::now()
        ]);

        if ($id) {
            $this->resolveCategories($id);

            return $this->find($id);
        }

        return false;
    }


    /**
     * Update and return new Product Model.
     *
     * @return mixed
     */
    public function edit()
    {
        $author = $this->resolveAuthor();
        $publisher = $this->resolvePublisher();

        $updated = $this->update([
            'author_id'        => $author,
            'publisher_id'     => $publisher,
            'action_id'        => $this->request->action ?: 0,
            'name'             => $this->request->name,
            'sku'              => $this->request->sku,
            'description'      => $this->cleanHTML($this->request->description),
            'slug'             => $this->request->slug ?: Str::slug($this->request->name),
            'price'            => isset($this->request->price) ? $this->request->price : 0,
            'quantity'         => isset($this->request->quantity) ? 1 : 0,
            'tax_id'           => $this->request->tax_id ?: 1,
            'special'          => $this->request->special,
            'special_from'     => $this->request->special_from ? Carbon::make($this->request->special_from) : null,
            'special_to'       => $this->request->special_to ? Carbon::make($this->request->special_to) : null,
            'meta_title'       => $this->request->meta_title ?: $this->request->name . '-' . Str::random(9),
            'meta_description' => $this->request->meta_description,
            'pages'            => $this->request->pages,
            'dimensions'       => $this->request->dimensions,
            'origin'           => $this->request->origin,
            'letter'           => $this->request->letter,
            'condition'        => $this->request->condition,
            'binding'          => $this->request->binding,
            'viewed'           => 0,
            'sort_order'       => 0,
            'push'             => 0,
            'status'           => (isset($this->request->status) and $this->request->status == 'on') ? 1 : 0,
            'updated_at'       => Carbon::now()
        ]);

        if ($updated) {
            $this->resolveCategories($this->id);

            return $this;
        }

        return false;
    }


    /**
     * @return array
     */
    public function getRelationsData(): array
    {
        return [
            'categories' => (new Category())->getList(false),
            'authors'    => Author::all()->pluck('title', 'id'),
            'publishers' => Publisher::all()->pluck('title', 'id'),
            'letters'    => Settings::get('product', 'letter_styles'),
            'conditions' => Settings::get('product', 'condition_styles'),
            'bindings'   => Settings::get('product', 'binding_styles'),
            'taxes'      => Settings::get('tax', 'list')
        ];
    }


    /**
     * @return $this
     */
    public function checkSettings()
    {
        Settings::setProduct('letter_styles', $this->request->letter);
        Settings::setProduct('condition_styles', $this->request->condition);
        Settings::setProduct('binding_styles', $this->request->binding);

        return $this;
    }


    /**
     * @param Product $product
     *
     * @return mixed
     */
    public function storeImages(Product $product)
    {
        return (new ProductImage())->store($product, $this->request);
    }


    public static function setCounts($p_query)
    {
        $all = Product::all()->count();
        $active = Product::where('status', 1)->count();
        $inactive = Product::where('status', 0)->count();
        /*$actions = Product::whereNotNull('special')->where('special_from', '<', Carbon::now())->where(function ($query) {
            $query->where('special_to', '>', Carbon::now())->orWhereNull('special_to');
        })->count();*/
        $actions = 0;

        $products = Product::all();

        foreach ($products as $product) {
            if ($product->special()) {
                $actions++;
            }
        }

        return [
            'all' => $all,
            'active' => $active,
            'inactive' => $inactive,
            'actions' => $actions,
        ];
    }


    /**
     * Set Product Model request variable.
     *
     * @param $request
     */
    private function setRequest($request)
    {
        $this->request = $request;
    }


    /**
     * @param null $description
     *
     * @return string
     */
    private function cleanHTML($description = null): string
    {
        $clean = preg_replace('/ style=("|\')(.*?)("|\')/', '', $description ? $description : '');

        return preg_replace('/ face=("|\')(.*?)("|\')/', '', $clean);
    }


    /**
     * @return false|mixed
     */
    private function resolveAuthor()
    {
        if ($this->request->author) {
            $author = Author::where('id', $this->request->author)->first();

            if ( ! $author) {
                $id = Author::insertGetId([
                    'title'            => $this->request->author,
                    'meta_title'       => $this->request->author,
                    'lang'             => 'hr',
                    'sort_order'       => 0,
                    'status'           => 1,
                    'slug'             => Str::slug($this->request->author),
                    'created_at'       => Carbon::now(),
                    'updated_at'       => Carbon::now()
                ]);

                return $id;
            }

            return $this->request->author;
        }

        return false;
    }


    /**
     * @return false|mixed
     */
    private function resolvePublisher()
    {
        if ($this->request->publisher) {
            $publisher = Author::where('id', $this->request->publisher)->first();

            if ( ! $publisher) {
                $id = Publisher::insertGetId([
                    'title'            => $this->request->publisher,
                    'meta_title'       => $this->request->publisher,
                    'lang'             => 'hr',
                    'sort_order'       => 0,
                    'status'           => 1,
                    'slug'             => Str::slug($this->request->publisher),
                    'created_at'       => Carbon::now(),
                    'updated_at'       => Carbon::now()
                ]);

                return $id;
            }

            return $this->request->publisher;
        }

        return false;
    }


    /**
     * @param int $product_id
     *
     * @return array
     */
    private function resolveCategories(int $product_id)
    {
        if ($this->request->category) {
            return ProductCategory::storeData($this->request->category, $product_id);
        }

        return false;
    }

}
