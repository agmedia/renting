<?php

namespace App\Models\Back\Catalog\Product;

use App\Helpers\Helper;
use App\Helpers\ProductHelper;
use App\Models\Back\Catalog\Author;
use App\Models\Back\Catalog\Category;
use App\Models\Back\Catalog\Publisher;
use App\Models\Back\Settings\Settings;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
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
     * @return Relation
     */
    public function images()
    {
        return $this->hasMany(ProductImage::class, 'product_id')->orderBy('sort_order');
    }


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

        return false;
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
        $slug = $this->resolveSlug();
        /*$author = $this->resolveAuthor();
        $publisher = $this->resolvePublisher();*/

        $id = $this->insertGetId([
            'author_id'        => $this->request->author_id,
            'publisher_id'     => $this->request->publisher_id,
            'action_id'        => $this->request->action ?: 0,
            'name'             => $this->request->name,
            'sku'              => $this->request->sku,
            'polica'           => $this->request->polica,
            'description'      => $this->cleanHTML($this->request->description),
            'slug'             => $slug,
            'price'            => $this->request->price,
            'quantity'         => $this->request->quantity ?: 0,
            'tax_id'           => $this->request->tax_id ?: 1,
            'special'          => $this->request->special,
            'special_from'     => $this->request->special_from ? Carbon::make($this->request->special_from) : null,
            'special_to'       => $this->request->special_to ? Carbon::make($this->request->special_to) : null,
            'meta_title'       => $this->request->meta_title ?: $this->request->name/* . ($author ? '-' . $author->title : '')*/,
            'meta_description' => $this->request->meta_description,
            'pages'            => $this->request->pages,
            'dimensions'       => $this->request->dimensions,
            'origin'           => $this->request->origin,
            'letter'           => $this->request->letter,
            'condition'        => $this->request->condition,
            'binding'          => $this->request->binding,
            'year'             => $this->request->year,
            'viewed'           => 0,
            'sort_order'       => 0,
            'push'             => 0,
            'status'           => (isset($this->request->status) and $this->request->status == 'on') ? 1 : 0,
            'created_at'       => Carbon::now(),
            'updated_at'       => Carbon::now()
        ]);

        if ($id) {
            $this->resolveCategories($id);

            $product = $this->find($id);

            return $product->update([
                'url' => ProductHelper::url($product)
            ]);
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
        $slug = $this->resolveSlug('update');
        /*$author = $this->resolveAuthor();
        $publisher = $this->resolvePublisher();*/

        $updated = $this->update([
            'author_id'        => $this->request->author_id,
            'publisher_id'     => $this->request->publisher_id,
            'action_id'        => $this->request->action ?: 0,
            'name'             => $this->request->name,
            'sku'              => $this->request->sku,
            'polica'           => $this->request->polica,
            'description'      => $this->cleanHTML($this->request->description),
            'slug'             => $slug,
            'price'            => isset($this->request->price) ? $this->request->price : 0,
            'quantity'         => $this->request->quantity ?: 0,
            'tax_id'           => $this->request->tax_id ?: 1,
            'special'          => $this->request->special,
            'special_from'     => $this->request->special_from ? Carbon::make($this->request->special_from) : null,
            'special_to'       => $this->request->special_to ? Carbon::make($this->request->special_to) : null,
            'meta_title'       => $this->request->meta_title ?: $this->request->name/* . '-' . ($author ? '-' . $author->title : '')*/,
            'meta_description' => $this->request->meta_description,
            'pages'            => $this->request->pages,
            'dimensions'       => $this->request->dimensions,
            'origin'           => $this->request->origin,
            'letter'           => $this->request->letter,
            'condition'        => $this->request->condition,
            'binding'          => $this->request->binding,
            'year'             => $this->request->year,
            'viewed'           => 0,
            'sort_order'       => 0,
            'push'             => 0,
            'status'           => (isset($this->request->status) and $this->request->status == 'on') ? 1 : 0,
            'updated_at'       => Carbon::now()
        ]);

        if ($updated) {
            $this->resolveCategories($this->id);

            $this->update([
                'url' => ProductHelper::url($this)
            ]);

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


    /**
     * @param Request $request
     *
     * @return Builder
     */
    public function filter(Request $request): Builder
    {
        $query = (new Product())->newQuery();

        if ($request->has('search') && ! empty($request->input('search'))) {
            $query->where('name', 'like', '%' . $request->input('search') . '%')
                  ->orWhere('sku', 'like', '%' . $request->input('search') . '%')
                    ->orWhere('polica', 'like', '%' . $request->input('search') . '%')
                    ->orWhere('year', 'like', '' . $request->input('search') . '');
        }

        if ($request->has('category') && ! empty($request->input('category'))) {
            $query->whereHas('categories', function ($query) use ($request) {
                $query->where('id', $request->input('category'));
            });
        }

        if ($request->has('author') && ! empty($request->input('author'))) {
            $query->where('author_id', $request->input('author'));
        }

        if ($request->has('publisher') && ! empty($request->input('publisher'))) {
            $query->where('publisher_id', $request->input('publisher'));
        }

        if ($request->has('status')) {
            if ($request->input('status') == 'active') {
                $query->where('status', 1);
            }
            if ($request->input('status') == 'inactive') {
                $query->where('status', 0);
            }
        }

        if ($request->has('sort')) {
            if ($request->input('sort') == 'new') {
                $query->orderBy('created_at', 'desc');
            }
            if ($request->input('sort') == 'old') {
                $query->orderBy('created_at', 'asc');
            }
            if ($request->input('sort') == 'price_up') {
                $query->orderBy('price', 'asc');
            }
            if ($request->input('sort') == 'price_down') {
                $query->orderBy('price', 'desc');
            }
            if ($request->input('sort') == 'az') {
                $query->orderBy('name', 'asc');
            }
            if ($request->input('sort') == 'za') {
                $query->orderBy('name', 'desc');
            }
        }

        return $query;
    }


    /**
     * @param $p_query
     *
     * @return array
     */
    public static function setCounts($p_query = null)
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
        $clean = preg_replace('/ style=("|\')(.*?)("|\')/', '', $description ?: '');

        return preg_replace('/ face=("|\')(.*?)("|\')/', '', $clean);
    }


    /**
     * @return false|mixed
     */
    /*private function resolveAuthor()
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

                return Author::find($id);
            }

            return $author;
        }

        return false;
    }*/


    /**
     * @return false|mixed
     */
    /*private function resolvePublisher()
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

                return Publisher::find($id);
            }

            return $publisher;
        }

        return false;
    }*/


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


    /**
     * @param Request|null $request
     *
     * @return string
     */
    private function resolveSlug(string $target = 'insert', Request $request = null): string
    {
        if ($request) {
            $this->request = $request;
        }

        $slug = $this->request->slug ?: Str::slug($this->request->name);

        $exist = $this->where('slug', $slug)->count();

        if ($exist > 1 && $target == 'update') {
            return $slug . '-' . time();
        }

        if ($exist && $target == 'insert') {
            return $slug . '-' . time();
        }

        return $slug;
    }

}
