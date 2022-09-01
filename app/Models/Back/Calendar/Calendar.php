<?php

namespace App\Models\Back\Calendar;

use App\Helpers\Helper;
use App\Helpers\ProductHelper;
use App\Models\Back\Apartment\Apartment;
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
use Illuminate\Validation\ValidationException;

class Calendar extends Model
{

    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'orders';

    /**
     * @var array
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * @var Request
     */
    protected $request;


    public function apartment()
    {
        return $this->hasOne(Apartment::class, 'id', 'apartment_id');
    }


    /**
     * @param Request $request
     *
     * @return Builder
     */
    public function filter(Request $request): Builder
    {
        $query = (new Calendar())->newQuery();

        /*if ($request->has('search') && ! empty($request->input('search'))) {
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
            if ($request->input('sort') == 'qty_up') {
                $query->orderBy('quantity', 'asc');
            }
            if ($request->input('sort') == 'qty_down') {
                $query->orderBy('quantity', 'desc');
            }
        } else {
            $query->orderBy('updated_at', 'desc');

        }*/

        return $query;
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

}
