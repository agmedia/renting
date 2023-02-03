<?php

namespace App\Models\Front\Catalog;

use App\Helpers\Currency;
use App\Models\Back\Settings\Options\OptionTranslation;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Option extends Model
{

    /**
     * @var string
     */
    protected $table = 'options';

    /**
     * @var array
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * @var string[]
     */
    protected $appends = ['title', 'description', 'price_text'];

    /**
     * @var string
     */
    protected $locale = 'en';

    /**
     * @var \Illuminate\Contracts\Foundation\Application|\Illuminate\Session\SessionManager|\Illuminate\Session\Store|mixed
     */
    protected $main_currency;


    /**
     * Gallery constructor.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->locale = current_locale();
        $this->main_currency = Currency::session();
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
            return $this->hasOne(OptionTranslation::class, 'option_id')->where('lang', $lang)->first();
        }

        if ($all) {
            return $this->hasMany(OptionTranslation::class, 'option_id');
        }

        return $this->hasOne(OptionTranslation::class, 'option_id')->where('lang', $this->locale)->first();
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
    public function getDescriptionAttribute()
    {
        return $this->translation()->description;
    }


    /**
     * @return string
     */
    public function getPriceTextAttribute()
    {
        $left = $this->main_currency->symbol_left ? $this->main_currency->symbol_left . ' ' : '';
        $right = $this->main_currency->symbol_right ? ' ' . $this->main_currency->symbol_right : '';

        return $left . $this->resolvePrice() . $right;
    }


    /**
     * @return string
     */
    public function resolvePrice()
    {
        return number_format(($this->price * $this->main_currency->value), $this->main_currency->decimal_places, ',', '.');
    }


    /**
     * @param Builder $query
     *
     * @return Builder
     */
    public function scopeWithoutPersons(Builder $query): Builder
    {
        return $query->where('reference', '!=', 'person');
    }


    /**
     * @param Builder $query
     *
     * @return Builder
     */
    public function scopePersonOption(Builder $query): Builder
    {
        return $query->where('reference', '=', 'person');
    }


    /**
     * @param Builder $query
     *
     * @return Builder
     */
    public function scopeCleaningOption(Builder $query): Builder
    {
        return $query->where('reference', '=', 'service');
    }


    /**
     * @param Builder $query
     *
     * @return Builder
     */
    public function scopeWithoutAutoInsert(Builder $query): Builder
    {
        return $query->where('auto_insert', '==', 0);
    }


    /**
     * @param Builder $query
     *
     * @return Builder
     */
    public function scopeAutoInsertOnly(Builder $query): Builder
    {
        return $query->where('auto_insert', '=', 1)->where('reference', '!=', 'person');
    }


    /**
     * @param Builder $query
     *
     * @return Builder
     */
    public function scopeBasic(Builder $query): Builder
    {
        return $query->select('id', 'reference', 'price', 'featured', 'status');
    }

}
