<?php

namespace App\Models\Back\Catalog\Product;

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
    public function actions()
    {
        return $this->hasOne(ProductAction::class, 'product_id')
                    ->where('date_start', '<', Carbon::now())
                    ->where('date_end', '>', Carbon::now())
                    ->orWhere('date_start', null)
                    ->orWhere('date_end', null);
    }


    /**
     * @return Relation
     */
    public function all_actions()
    {
        return $this->hasOne(ProductAction::class, 'product_id');
    }


    /**
     * @return Relation
     */
    public function categories()
    {
        return $this->hasManyThrough(Category::class, ProductCategory::class, 'product_id', 'id', 'id', 'category_id');
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
        $id = $this->insertGetId([
            'author_id'        => $this->request->author ?: 0,
            'publisher_id'     => $this->request->publisher ?: 0,
            'action_id'        => $this->request->action ?: 0,
            'name'             => $this->request->name,
            'sku'              => $this->request->sku,
            'description'      => $this->cleanHTML($this->request->description),
            'slug'             => $this->request->slug ?: Str::slug($this->request->name),
            'price'            => $this->request->price,
            'quantity'         => isset($this->request->quantity) ? 1 : 0,
            'tax_id'           => 1,
            'special'          => $this->request->special,
            'special_from'     => $this->request->special_from ? Carbon::make($this->request->special_from) : null,
            'special_to'       => $this->request->special_to ? Carbon::make($this->request->special_to) : null,
            'meta_title'       => $this->request->seo_title,
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
        $updated = $this->update([
            'author_id'        => $this->request->author ?: 0,
            'publisher_id'     => $this->request->publisher ?: 0,
            'action_id'        => $this->request->action ?: 0,
            'name'             => $this->request->name,
            'sku'              => $this->request->sku,
            'description'      => $this->cleanHTML($this->request->description),
            'slug'             => $this->request->slug ?: Str::slug($this->request->name),
            'price'            => isset($this->request->price) ? $this->request->price : 0,
            'quantity'         => isset($this->request->quantity) ? 1 : 0,
            'tax_id'           => 1,
            'special'          => $this->request->special,
            'special_from'     => $this->request->special_from ? Carbon::make($this->request->special_from) : null,
            'special_to'       => $this->request->special_to ? Carbon::make($this->request->special_to) : null,
            'meta_title'       => $this->request->seo_title,
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


    public function getRelationsData(): array
    {
        return [
            'categories' => (new Category())->getList(false),
            'authors'    => Author::all()->pluck('title', 'id'),
            'publishers' => Publisher::all()->pluck('title', 'id'),
            'letters'    => Settings::getProduct('letter_styles'),
            'conditions' => Settings::getProduct('condition_styles'),
            'bindings'   => Settings::getProduct('binding_styles')
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
     * @param int $product_id
     *
     * @return array
     */
    private function resolveCategories(int $product_id)
    {
        return ProductCategory::storeData($this->request->category, $product_id);
    }

}
