<?php

namespace App\Models\Front\Catalog;

use App\Models\Back\Marketing\Action\ActionTranslation;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Action extends Model
{

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
    protected $appends = ['title'];

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
     * @param Builder $query
     *
     * @return Builder
     */
    public function scopeBasic(Builder $query): Builder
    {
        return $query->select('id', 'type', 'discount', 'extra', 'price_regular', 'price_weekends', 'date_start', 'date_end', 'badge');
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

}
