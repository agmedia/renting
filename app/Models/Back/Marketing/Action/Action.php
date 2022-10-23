<?php

namespace App\Models\Back\Marketing\Action;

use App\Helpers\ActionHelper;
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

    protected $links;

    protected $status;

    protected $date_start;

    protected $date_end;

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
     * @param Request $request
     *
     * @return $this
     */
    public function setRequest(Request $request)
    {
        $this->request    = $request;
        $this->status     = $this->setStatus();
        $this->date_start = $this->request->date_start ? Carbon::make($this->request->date_start) : null;
        $this->date_end   = $this->request->date_end ? Carbon::make($this->request->date_end) : null;

        return $this->validateData();
    }


    /**
     * Validate new action Request.
     *
     * @param Request $request
     *
     * @return $this
     */
    public function validateData()
    {
        $this->request->validate([
            'title.*'  => 'required',
            'type'     => 'required',
            'group'    => 'required',
            'discount' => 'required'
        ]);

        if ($this->listRequired()) {
            $this->request->validate([
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
        $id = $this->insertGetId($this->createModelArray());

        if ($id) {
            ActionTranslation::create($id, $this->request);

            return $this->setApartmentsActions($id);
        }

        return false;
    }


    /**
     * @return $this|false|mixed
     */
    public function edit()
    {
        $updated = $this->update($this->createModelArray('update'));

        if ($updated) {
            ActionTranslation::edit($this->id, $this->request);

            return $this->setApartmentsActions();
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
     * @param string $method
     *
     * @return array
     */
    private function createModelArray(string $method = 'insert'): array
    {
        $this->links = collect(['all']);

        if ($this->request->action_list) {
            $this->links = collect($this->request->action_list);
        }

        $this->resolveDiscount();

        $response = [
            'type'       => $this->request->type,
            'discount'   => $this->request->discount,
            'extra'      => $this->request->extra,
            'group'      => $this->request->group,
            'links'      => $this->links->flatten()->toJson(),
            'date_start' => $this->date_start,
            'date_end'   => $this->date_end,
            'status'     => $this->status,
            'repeat'     => (isset($this->request->repeat) and $this->request->repeat == 'on') ? 1 : 0,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ];

        if ($method == 'insert') {
            $response['created_at'] = Carbon::now();
        }

        return $response;
    }


    /**
     * @return void
     */
    private function resolveDiscount(): void
    {
        $discount = $this->request->discount;

        if (in_array(substr($discount, 0, 1), ['+', '-'])) {
            $this->request->discount = 0;
            $this->request->extra    = 0;

            if (substr($discount, 0, 1) == '-') {
                $this->request->discount = intval(substr($discount, 1));
            }

            $this->request->extra = intval(substr($discount, 1));
        }
    }


    /**
     * @param int|null $id
     *
     * @return $this|mixed
     */
    private function setApartmentsActions(int $id = null)
    {
        if ( ! ActionHelper::isActiveByDates($this->date_start, $this->date_end) && ! $this->status) {
            $this->deleteApartmentActions();
        } else {
            $this->updateApartmentsActions();
        }

        if ($id) {
            return $this->find($id);
        }

        return $this;
    }


    /**
     * @return bool
     */
    private function updateApartmentsActions(): bool
    {
        if ($this->request->group == 'all') {
            return Apartment::update(
                ['action_id' => $this->id]
            );

        } else {
            return Apartment::whereIn('id', $this->links)->update(
                ['action_id' => $this->id]
            );
        }
    }


    /**
     * @return mixed
     */
    private function deleteApartmentActions()
    {
        return Apartment::where('action_id', $this->id)->update([
            'action_id' => 0
        ]);
    }


    /**
     * @return int
     */
    private function setStatus(): int
    {
        return (isset($this->request->status) and $this->request->status == 'on') ? 1 : 0;
    }

}
