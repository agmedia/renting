<?php

namespace App\Models\Back\Settings\Options;

use Carbon\Carbon;
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
     * @var
     */
    protected $links;


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
     * Validate new action Request.
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
        $id = $this->insertGetId(
            $this->createModelArray()
        );

        if ($id) {
            OptionTranslation::create($id, $this->request);
            OptionApartment::populate($id, $this->links->toArray());

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
        $updated = $this->update(
            $this->createModelArray('update')
        );

        if ($updated) {
            OptionTranslation::edit($this->id, $this->request);
            OptionApartment::populate($this->id, $this->links->toArray());

            return $this;
        }

        return false;
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

        $response = [
            'group'       => $this->request->group,
            'reference'   => $this->request->reference,
            'price'       => $this->request->price,
            'price_per'   => $this->request->price_per,
            'links'       => $this->links->flatten()->toJson(),
            'price'       => $this->request->price,
            'auto_insert' => (isset($this->request->auto_insert) and $this->request->auto_insert == 'on') ? 1 : 0,
            'sort_order'  => $this->request->sort_order ?: 0,
            'featured'    => (isset($this->request->featured) and $this->request->featured == 'on') ? 1 : 0,
            'status'      => (isset($this->request->status) and $this->request->status == 'on') ? 1 : 0,
            'updated_at'  => Carbon::now()
        ];

        if ($method == 'insert') {
            $response['created_at'] = Carbon::now();
        }

        return $response;
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

}
