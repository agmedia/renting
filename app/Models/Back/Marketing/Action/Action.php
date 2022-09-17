<?php

namespace App\Models\Back\Marketing\Action;

use App\Helpers\Helper;
use App\Models\Back\Apartment\Apartment;
use App\Models\Back\Apartment\ApartmentTranslation;
use App\Models\Back\Catalog\Author;
use App\Models\Back\Catalog\Product\Product;
use App\Models\Back\Catalog\Product\ProductCategory;
use App\Models\Back\Marketing\Category;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use voku\helper\ASCII;

class Action extends Model
{

    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'apartment_actions';

    /**
     * @var array
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * @var string[]
     */
    protected $appends = ['title', 'amount'];

    /**
     * @var string
     */
    protected $locale = 'en';

    /**
     * @var Request
     */
    protected $request;


    /**
     * Gallery constructor.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->locale = current_locale();
    }


    /**
     * @param null  $lang
     * @param false $all
     *
     * @return Model|\Illuminate\Database\Eloquent\Relations\HasMany|\Illuminate\Database\Eloquent\Relations\HasOne|object|null
     */
    public function translation($lang = null, bool $all = false)
    {
        if ($lang) {
            return $this->hasOne(ActionTranslation::class, 'apartment_action_id')->where('lang', $lang)->first();
        }

        if ($all) {
            return $this->hasMany(ActionTranslation::class, 'apartment_action_id');
        }

        return $this->hasOne(ActionTranslation::class, 'apartment_action_id')->where('lang', $this->locale)->first();
    }


    /**
     * @return string
     */
    public function getTitleAttribute()
    {
        return $this->translation()->title;
    }


    /**
     * @return string
     */
    public function getAmountAttribute(): string
    {
        if ($this->discount > 0) {
            return '-' . number_format($this->discount) . '%';
        }

        if ($this->extra > 0) {
            return '+' . number_format($this->extra) . '%';
        }

        return '0';
    }


    /**
     * Validate new action Request.
     *
     * @param Request $request
     *
     * @return $this
     */
    public function validateRequest(Request $request)
    {
        $request->validate([
            'title.*'  => 'required',
            'type'     => 'required',
            'group'    => 'required',
            'discount' => 'required'
        ]);

        $this->request = $request;

        if ($this->listRequired()) {
            $request->validate([
                'action_list' => 'required'
            ]);
        }

        return $this;
    }


    /**
     * Store new category.
     *
     * @return false
     */
    public function create()
    {
        $links = collect(['all']);

        if ($this->request->action_list) {
            $links = collect($this->request->action_list);
        }

        $status = (isset($this->request->status) and $this->request->status == 'on') ? 1 : 0;
        $repeat = (isset($this->request->repeat) and $this->request->repeat == 'on') ? 1 : 0;
        $start  = $this->request->date_start ? Carbon::make($this->request->date_start) : null;
        $end    = $this->request->date_end ? Carbon::make($this->request->date_end) : null;

        $this->resolveDiscount();

        $id = $this->insertGetId([
            'type'       => $this->request->type,
            'discount'   => $this->request->discount,
            'extra'      => $this->request->extra,
            'group'      => $this->request->group,
            'links'      => $links->flatten()->toJson(),
            'date_start' => $start,
            'date_end'   => $end,
            'status'     => $status,
            'repeat'     => $repeat,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        if ($id) {
            ActionTranslation::create($id, $this->request);

            /*if ($status) {
                $this->updateApartment($this->resolveTarget($links), $id, $start, $end);
            }*/

            return $this->find($id);
        }

        return false;
    }


    /**
     * @param Category $category
     *
     * @return false
     */
    public function edit()
    {
        $links = collect(['all']);

        if ($this->request->action_list) {
            $links = collect($this->request->action_list);
        }

        $status = (isset($this->request->status) and $this->request->status == 'on') ? 1 : 0;
        $repeat = (isset($this->request->repeat) and $this->request->repeat == 'on') ? 1 : 0;
        $start  = $this->request->date_start ? Carbon::make($this->request->date_start) : null;
        $end    = $this->request->date_end ? Carbon::make($this->request->date_end) : null;

        $this->resolveDiscount();

        $updated = $this->update([
            'type'       => $this->request->type,
            'discount'   => $this->request->discount,
            'extra'      => $this->request->extra,
            'group'      => $this->request->group,
            'links'      => $links->flatten()->toJson(),
            'date_start' => $start,
            'date_end'   => $end,
            'status'     => $status,
            'repeat'     => $repeat,
            'updated_at' => Carbon::now()
        ]);

        if ($updated) {
            ActionTranslation::edit($this->id, $this->request);

            $this->updateApartments($links, $this->id);

            if ( ! $status) {
                $this->truncateApartmentActions($this->id);
            }

            return $this;
        }

        return false;
    }


    /**
     * @return bool
     */
    public function listRequired(): bool
    {
        if ($this->request->group == 'all') {
            return false;
        }

        return true;
    }


    /**
     * @return void
     */
    private function resolveDiscount(): void
    {
        $discount                = $this->request->discount;
        $this->request->discount = 0;
        $this->request->extra    = 0;

        if (substr($discount, 0, 1) == '-') {
            $this->request->discount = intval(substr($discount, 1));
        }

        $this->request->extra = intval(substr($discount, 1));
    }


    /**
     * @param     $apartments
     * @param int $action_id
     *
     * @return bool
     */
    private function updateApartments($apartments, int $action_id): bool
    {
        if ($apartments == 'all') {
            return Apartment::update(
                ['action_id' => $action_id]
            );

        } else {
            return Apartment::whereIn('id', $apartments)->update(
                ['action_id' => $action_id]
            );
        }
    }


    /**
     * @param int $action_id
     *
     * @return mixed
     */
    private function truncateApartmentActions(int $action_id)
    {
        return Apartment::where('action_id', $action_id)->update([
            'action_id' => 0
        ]);
    }
}
