<?php

namespace App\Models\Back\Apartment;

use App\Helpers\Helper;
use App\Helpers\ProductHelper;
use App\Models\Back\Settings\System\Category;
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
use Illuminate\Validation\ValidationException;

class Apartment extends Model
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
            'name'     => 'required',
            'sku'      => 'required',
            'price'    => 'required',
            'category' => 'required'
        ]);

        // Set Product Model request variable
        $this->setRequest($request);

        if ($this->isDuplicateSku()) {
            throw ValidationException::withMessages(['sku_dupl' => $this->request->sku . ' - Šifra već postoji...']);
        }

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

        $id = $this->insertGetId([
            'author_id'        => $this->request->author_id ?: 6,
            'publisher_id'     => $this->request->publisher_id ?: 2,
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

            $product->update([
                'url'             => ProductHelper::url($product),
                'category_string' => ProductHelper::categoryString($product)
            ]);

            return $product;
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
        $this->old_product = $this->setHistoryProduct();

        $slug = $this->resolveSlug('update');

        $updated = $this->update([
            'author_id'        => $this->request->author_id ?: 6,
            'publisher_id'     => $this->request->publisher_id ?: 2,
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
                'url'             => ProductHelper::url($this),
                'category_string' => ProductHelper::categoryString($this)
            ]);

            return $this;
        }

        return false;
    }




    /**
     * @param Request $request
     *
     * @return Builder
     */
    public function filter(Request $request): Builder
    {
        $query = (new Apartment())->newQuery();



        return $query;
    }


}
