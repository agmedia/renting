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
use Illuminate\Support\Facades\File;
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
    protected $appends = ['title', 'image', 'thumb', 'airbnb', 'booking'];

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

        return $this->hasOne(ApartmentTranslation::class, 'apartment_id')->where('lang', $this->locale)->first();
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
        return $this->translation()->title;
    }


    /**
     * @return string
     */
    public function getImageAttribute()
    {
        return $this->images()->where('published', 1)->where('default', 1)->first()->image;
    }


    /**
     * @return string
     */
    public function getThumbAttribute()
    {
        return 'test-thumb';
    }


    /**
     * @return string
     */
    public function getAirbnbAttribute(): string
    {
        if ($this->links) {
            foreach (unserialize($this->links) as $key => $link) {
                if ($key == "'airbnb'") {
                    return $link ?: '';
                }
            }
        }

        return '';
    }


    /**
     * @return string
     */
    public function getBookingAttribute(): string
    {
        if ($this->links) {
            foreach (unserialize($this->links) as $key => $link) {
                if ($key == "'booking'") {
                    return $link ?: '';
                }
            }
        }

        return '';
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
            'title.*'        => 'required',
            'type'           => 'required',
            'target'         => 'required',
            'price_regular'  => 'required',
            'price_weekends' => 'required'
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
        $id = $this->insertGetId($this->createModelArray());

        if ($id) {
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
    public function storeImages()
    {
        return (new ApartmentImage())->store($this->find($this->id), $this->request);
    }


    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function syncUrlWith(Request $request)
    {
        $ical = new iCal($request->input('url'));

        if ( ! empty($ical->events)) {
            foreach ($ical->events as $event) {
                $order = Order::storeSyncData(
                    $request->input('target'),
                    $event,
                    $request->input('apartment')
                );

                /*if ( ! $order) {
                    return response()->json(['error' => 400, 'message' => 'Nešto je pošlo po krivu..!']);
                }*/
            }
        }

        return response()->json(['success' => 200, 'message' => 'Sve je OK prošlo..!']);
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
            'sku'            => $this->request->sku,
            'address'        => $this->request->address,
            'zip'            => $this->request->zip,
            'city'           => $this->request->city,
            //'region'       => $this->request->region,
            'state'          => $this->request->state,
            'type'           => $this->request->type,
            'target'         => $this->request->target,
            'longitude'      => $this->request->longitude,
            'latitude'       => $this->request->latitude,
            'links'          => $this->serializeLinks(),
            'price_regular'  => $this->request->price_regular ?: 0,
            'price_weekends' => $this->request->price_weekends ?: 0,
            'price_per'      => $this->request->price_per ?: 1,
            'tax_id'         => $this->request->tax_id ?: 1,
            'special'        => $this->request->special,
            'special_from'   => $this->request->special_from,
            'special_to'     => $this->request->special_to,
            'm2'             => $this->request->m2,
            'beds'           => $this->request->beds,
            'rooms'          => $this->request->rooms,
            'baths'          => $this->request->baths,
            'adults'         => $this->request->adults,
            'children'       => $this->request->children,
            'sort_order'     => 0,
            'featured'       => (isset($this->request->featured) and $this->request->featured == 'on') ? 1 : 0,
            'status'         => (isset($this->request->status) and $this->request->status == 'on') ? 1 : 0,
            'updated_at'     => Carbon::now()
        ];

        if ($method == 'insert') {
            $response['created_at'] = Carbon::now();
        }

        return $response;
    }


    /**
     * @return string|null
     */
    private function serializeLinks()
    {
        if (isset($this->request->links) && ! empty($this->request->links)) {
            return serialize($this->request->links);
        }

        return null;
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
