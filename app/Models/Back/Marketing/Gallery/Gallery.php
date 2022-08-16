<?php

namespace App\Models\Back\Marketing\Gallery;

use App\Helpers\ProductHelper;
use App\Models\Back\Catalog\Product\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{

    /**
     * @var string
     */
    protected $table = 'galleries';

    /**
     * @var array
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * @var string[]
     */
    protected $appends = ['title', 'image', 'thumb'];

    /**
     * @var string
     */
    protected $locale = 'en';

    /**
     * @var Model
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
    public function images(bool $all = false)
    {
        if ($all) {
            return $this->hasMany(GalleryImage::class, 'gallery_id')->orderBy('sort_order');
        }

        return $this->hasMany(GalleryImage::class, 'gallery_id')->where('lang', $this->locale)->orderBy('sort_order');
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
            return $this->hasOne(GalleryTranslation::class, 'gallery_id')->where('lang', $lang)->first();
        }

        if ($all) {
            return $this->hasMany(GalleryTranslation::class, 'gallery_id');
        }

        return $this->hasOne(GalleryTranslation::class, 'gallery_id')->where('lang', $this->locale)->first();
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
        return $this->images()->where('default', 1)->first()->image;
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
        $request->validate([
            'title.*' => 'required'
        ]);

        $this->setRequest($request);

        return $this;
    }


    /**
     * @return false
     */
    public function create()
    {
        $id = $this->insertGetId([
            'group'      => $this->request->group ?: '/',
            'featured'   => (isset($this->request->featured) and $this->request->featured == 'on') ? 1 : 0,
            'status'     => (isset($this->request->status) and $this->request->status == 'on') ? 1 : 0,
            'sort_order' => 0,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        if ($id) {
            GalleryTranslation::create($id, $this->request);

            return $this->find($id);
        }

        return false;
    }


    /**
     * @return $this|false
     */
    public function edit()
    {
        $id = $this->update([
            'group'      => $this->request->group ?: '/',
            'featured'   => (isset($this->request->featured) and $this->request->featured == 'on') ? 1 : 0,
            'status'     => (isset($this->request->status) and $this->request->status == 'on') ? 1 : 0,
            'sort_order' => 0,
            'updated_at' => Carbon::now()
        ]);

        if ($id) {
            GalleryTranslation::edit($this->id, $this->request);

            return $this;
        }

        return false;
    }


    /**
     * @param Gallery $gallery
     *
     * @return mixed
     */
    public function storeImages(Gallery $gallery)
    {
        return (new GalleryImage())->store($gallery, $this->request);
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

    /*******************************************************************************
    *                                Copyright : AGmedia                           *
    *                              email: filip@agmedia.hr                         *
    *******************************************************************************/

    public static function adminSelectList()
    {
        $response = [];
        $items = static::all();

        foreach ($items as $item) {
            $response[] = [
                'id' => $item->id,
                'title' => $item->title,
            ];
        }

        return collect($response);
    }
}
