<?php

namespace App\Models\Back\Apartment;

use App\Helpers\iCal;
use App\Models\Back\Marketing\Action\Action;
use App\Models\Back\Marketing\Gallery\Gallery;
use App\Models\Back\Orders\Order;
use App\Models\Back\Settings\Options\Option;
use App\Models\Back\Settings\Options\OptionApartment;
use App\Models\Back\Settings\Settings;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Bouncer;
use Illuminate\Support\Facades\Log;

class Apartment extends Model
{

    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'apartments';

    /**
     * @var array
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * @var string[]
     */
    protected $appends = ['title', 'webp', 'thumb', 'airbnb', 'booking'];

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
     * @param bool $all
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function images()
    {
        return $this->hasMany(ApartmentImage::class, 'apartment_id')->orderBy('sort_order');
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
            return $this->hasOne(ApartmentTranslation::class, 'apartment_id')->where('lang', $lang)->first();
        }

        if ($all) {
            return $this->hasMany(ApartmentTranslation::class, 'apartment_id');
        }

        return $this->hasOne(ApartmentTranslation::class, 'apartment_id')->where('lang', $this->locale)/*->first()*/;
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function translation_search()
    {
        return $this->hasMany(ApartmentTranslation::class, 'apartment_id')->where('lang', $this->locale);
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function action()
    {
        return $this->belongsTo(Action::class, 'action_id', 'id');
    }


    /**
     * @return Relation
     */
    public function options()
    {
        return $this->hasManyThrough(Option::class, OptionApartment::class, 'apartment_id', 'id', 'id', 'option_id');
    }


    /**
     * @return string
     */
    public function getTitleAttribute()
    {
        return $this->translation->title;
    }


    /**
     * @return string
     */
    public function getWebpAttribute()
    {
        return asset(str_replace('.jpg', '.webp', $this->image)) ?: config('settings.default_apartment_image');
    }


    /**
     * @return string
     */
    public function getThumbAttribute()
    {
        return asset(str_replace('.jpg', '-thumb.webp', $this->image)) ?: config('settings.default_apartment_image');
    }


    /**
     * @return array
     */
    public function getAirbnbAttribute(): array
    {
        return $this->getLinks('airbnb', $this->links);
    }


    /**
     * @return array
     */
    public function getBookingAttribute(): array
    {
        return $this->getLinks('booking', $this->links);
    }


    /**
     * @return array
     */
    public function dates()
    {
        $response = [];
        $orders   = Order::where('date_to', '>', now())->get();

        foreach ($orders as $order) {
            $response[] = [\Illuminate\Support\Carbon::make($order->date_from)->format('Y-m-d'), Carbon::make($order->date_to)->format('Y-m-d')];
        }

        return $response;
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
            'title.*'         => 'required',
            'type'            => 'required',
            'target'          => 'required',
            'price_regular'   => 'required',
            'price_weekends'  => 'required',
            'regular_persons' => 'required',
            'max_adults'      => 'required',
            'max_children'    => 'required',
            //
            'm2'              => 'required',
            'rooms'           => 'required',
            'beds'            => 'required',
            'baths'           => 'required'

        ]);

        if (config('app.env') == 'production') {
            $request->validate([
                'address'   => 'required',
                'city'      => 'required',
                'zip'       => 'required',
                'state'     => 'required',
                'latitude'  => 'required',
                'longitude' => 'required'
            ]);
        }

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
        $id = $this->insertGetId($this->createModelArray());

        if ($id) {
            $this->resolveFeaturedAmenities($id);

            ApartmentTranslation::create($id, $this->request);
            ApartmentDetail::createAmenities($id, $this->request);
            ApartmentDetail::createDetails($id, $this->request);

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
        $updated = $this->update($this->createModelArray('update'));

        if ($updated) {
            $this->resolveFeaturedAmenities();

            ApartmentTranslation::edit($this->id, $this->request);
            ApartmentDetail::editAmenities($this->id, $this->request);
            ApartmentDetail::editDetails($this->id, $this->request);

            return $this;
        }

        return false;
    }


    /**
     * @return array
     */
    public function getEditViewData()
    {
        return [
            'details'   => ApartmentDetail::getDetailsByApartment(($this->id ?: 0)),
            'amenities' => ApartmentDetail::getAmenitiesByApartment($this->id ?: 0),
            'images'    => ApartmentImage::getExistingImages($this ?: null),
            'favorites' => ApartmentDetail::getFavorites(),
            'galleries' => Gallery::adminSelectList(),
            'taxes'     => Settings::get('tax', 'list')
        ];
    }


    /**
     * @return bool|mixed
     */
    public function storeImages(Request $request = null)
    {
        if ( ! $request) {
            $request = $this->request;
        }

        return (new ApartmentImage())->store($this->find($this->id), $request);
    }


    /**
     * @param int|null $id
     *
     * @return mixed
     */
    public function resolveFeaturedAmenities(int $id = null)
    {
        if ( ! $id) {
            $id = $this->id;
        }

        $amenities = collect(\App\Models\Front\Apartment\ApartmentDetail::getAmenitiesByApartment($id, false));
        $new       = [];

        $featured = Settings::get('amenity', 'list')->where('featured', 1);

        foreach ($featured as $item) {
            $has = $amenities->where('id', $item->id)->first();

            if ($has) {
                array_push($new, $this->setViewAmenity($item));
            }
        }

        /*if (count($new) < config('settings.amenities_list_count')) {
            $all = Settings::get('amenity', 'list')->where('featured', 0);

            foreach ($all as $item) {
                if (count($new) < config('settings.amenities_list_count')) {
                    $has = $amenities->where('id', $item->id)->first();

                    if ($has) {
                        array_push($new, $this->setViewAmenity($item));
                    }
                }
            }
        }

        if (count($new) > config('settings.amenities_list_count')) {
            array_slice($new, 0, config('settings.amenities_list_count') - 1);
        }*/

        $updated = $this->where('id', $id)->update([
            'featured_amenities' => json_encode($new),
        ]);

        return $updated;
    }


    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function syncUrlWith(Request $request)
    {
        $ical   = new iCal($request->input('url'));
        $passed = true;

        $apartment = Apartment::query()->where('id', $request->input('apartment'))->first();
        $links     = json_decode($apartment->links, true);
        $target    = $request->input('target');

        $links[$target]['updated'] = now();
        $links[$target]['icon']    = 'fa-check text-success';

        if ( ! empty($ical->events)) {
            foreach ($ical->events as $event) {
                $order = Order::storeSyncData(
                    $target,
                    $event,
                    $request->input('apartment')
                );

                if ( ! $order) {
                    $passed = false;

                    $links[$target]['icon'] = 'fa-exclamation-triangle text-danger';
                }
            }

            $existing_orders = Order::query()
                                    ->where('apartment_id', $request->input('apartment'))
                                    ->where('sync_uid', '!=', '')
                                    ->where('payment_email', 'info@' . $target . '.com')
                                    ->where('date_from', '>', now())
                                    ->pluck('sync_uid');

            $sent = collect($ical->events)->random(2)->pluck('uid');

            $diff = $existing_orders->diff($sent);

            Order::query()->whereIn('sync_uid', $diff)->update([
                'order_status_id' => config('settings.order.status.canceled')
            ]);
        }

        if ( ! filter_var($links[$target]['link'], FILTER_VALIDATE_URL)) {
            $links[$target]['icon'] = 'fa-exclamation-triangle text-danger';
        }

        $apartment->update([
            'links' => json_encode($links)
        ]);

        if ($passed) {
            return response()->json(['success' => __('back/app.save_success')]);
        }

        return response()->json(['error' => 400, 'message' => __('back/app.save_failure')]);
    }


    /**
     * @param Request $request
     *
     * @return Builder
     */
    public function filter(Request $request): Builder
    {
        $query = $this->newQuery();

        if ($request->has('search') && ! empty($request->input('search'))) {
            $query->whereHas('translation_search', function ($subquery) use ($request) {
                $subquery->where('title', 'like', '%' . $request->input('search') . '%');
            });
        }

        if ($request->has('status')) {
            $status = $request->has('status');

            if ($status == 'active') {
                $query->where('status', 1);
            }
            if ($status == 'inactive') {
                $query->where('status', 0);
            }
        }

        if ($request->has('sort')) {
            $sort = $request->input('sort');

            if ($sort == 'new') {
                $query->orderBy('created_at', 'desc');
            }
            if ($sort == 'old') {
                $query->orderBy('created_at');
            }
            if ($sort == 'price_up') {
                $query->orderBy('price_regular');
            }
            if ($sort == 'price_down') {
                $query->orderBy('price_regular', 'desc');
            }
            if ($sort == 'az') {
                $query->with(['translation_search' => function ($subquery) {
                    $subquery->orderBy('apartment_id', 'desc');
                }]);
            }
            if ($sort == 'za') {
                $query->whereHas('translation_search', function ($subquery) {
                    $subquery->orderBy('title', 'desc');
                });
            }
        }

        return $query;
    }


    /*******************************************************************************
     *                                Copyright : AGmedia                           *
     *                              email: filip@agmedia.hr                         *
     *******************************************************************************/

    private function setViewAmenity($item): array
    {
        return [
            'id'    => $item->id,
            'title' => $item->title,
            'icon'  => $item->icon
        ];
    }


    /**
     * @param string $method
     *
     * @return array
     */
    private function createModelArray(string $method = 'insert'): array
    {
        $response = [
            /*'action_id'    => $this->request->action ?: 0,*/
            'sku'             => $this->request->sku,
            'address'         => $this->request->address,
            'zip'             => $this->request->zip,
            'city'            => $this->request->city,
            //'region'       => $this->request->region,
            'state'           => $this->request->state,
            'type'            => $this->request->type,
            'target'          => $this->request->target,
            'longitude'       => $this->request->longitude,
            'latitude'        => $this->request->latitude,
            'links'           => $this->serializeLinks($this->request->links, 'update'),
            'price_regular'   => $this->request->price_regular ?: 0,
            'price_weekends'  => $this->request->price_weekends ?: 0,
            'price_per'       => $this->request->price_per ?: 1,
            'tax_id'          => $this->request->tax_id ?: 1,
            'special'         => $this->request->special,
            'special_from'    => $this->request->special_from,
            'special_to'      => $this->request->special_to,
            'm2'              => $this->request->m2,
            'beds'            => $this->request->beds,
            'rooms'           => $this->request->rooms,
            'baths'           => $this->request->baths,
            'regular_persons' => $this->request->regular_persons,
            'max_adults'      => $this->request->max_adults,
            'max_children'    => $this->request->max_children,
            'max_persons'     => $this->request->max_persons,
            'sort_order'      => 0,
            'featured'        => (isset($this->request->featured) and $this->request->featured == 'on') ? 1 : 0,
            'status'          => (isset($this->request->status) and $this->request->status == 'on') ? 1 : 0,
            'updated_at'      => Carbon::now()
        ];

        if ($method == 'insert') {
            $response['created_at'] = Carbon::now();
            $response['links']      = $this->serializeLinks($this->request->links);
        }

        return $response;
    }


    /**
     * @param array  $links
     * @param string $method
     *
     * @return false|string|null
     */
    private function serializeLinks(array $links, string $method = 'insert')
    {
        if ( ! empty($links)) {
            $new  = [];
            $time = now();
            $icon = 'fa-check text-success';

            foreach ($links as $target => $link) {
                if ($method == 'update') {
                    if (isset(json_decode($this->links, true)[$target])) {
                        $existing = json_decode($this->links, true)[$target];

                        if (isset($existing['updated'])) {
                            $time = $existing['updated'];
                        }
                        if (isset($existing['icon'])) {
                            $icon = $existing['icon'];
                        }
                    }
                }

                $new[$target]['link']    = $link;
                $new[$target]['updated'] = $time;
                $new[$target]['icon']    = $icon;

                if ( ! filter_var($link, FILTER_VALIDATE_URL)) {
                    $new[$target]['icon'] = 'fa-exclamation-triangle text-danger';
                }
            }

            return json_encode($new);
        }

        return null;
    }


    /**
     * @param string $target
     * @param        $links
     *
     * @return array
     */
    private function getLinks(string $target, $links): array
    {
        if ($links) {
            // If old serialized links are still in DB
            if (@unserialize($links) !== false) {
                $this->update([
                    'links' => $this->serializeLinks(@unserialize($links))
                ]);

                $this->getAirbnbAttribute();
            }

            if (is_array(json_decode($links, true))) {
                $links = json_decode($links, true);

                foreach ($links as $key => $link) {
                    $key = str_replace("'", "", $key);

                    if ($key == $target) {
                        return [
                            'link'    => $link['link'],
                            'updated' => Carbon::make($link['updated'])->locale(current_locale())->diffForHumans(),
                            'icon'    => isset($link['icon']) ? $link['icon'] : (($link['link'] == '') ? 'fa-exclamation-triangle text-danger' : 'fa-check text-success')
                        ];
                    }
                }
            }
        }

        return [
            'link'    => '',
            'updated' => 0
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
}
