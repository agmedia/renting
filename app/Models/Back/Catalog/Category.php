<?php

namespace App\Models\Back\Catalog;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class Category extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'categories';

    /**
     * @var array
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * @var Request
     */
    protected $request;


    public function subcategories()
    {
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }


    /**
     * @param Builder $query
     *
     * @return Builder
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', 1);
    }


    /**
     * @param Builder $query
     *
     * @return Builder
     */
    public function scopeTopList(Builder $query, string $group = ''): Builder
    {
        if ( ! empty($group)) {
            return $query->where('group', $group)->where('parent_id', '==', 0);
        }

        return $query->where('parent_id', '==', 0);
    }


    /**
     * @param Builder $query
     *
     * @return Builder
     */
    public function scopeGroups(Builder $query): Builder
    {
        return $query->active()->groupBy('group');
    }


    /**
     * Validate new category Request.
     *
     * @param Request $request
     *
     * @return $this
     */
    public function validateRequest(Request $request)
    {
        $request->validate([
            'title' => 'required'
        ]);

        $this->request = $request;

        return $this;
    }


    /**
     * Store new category.
     *
     * @return false
     */
    public function create()
    {
        $parent = $this->request->parent ?: 0;
        $group  = isset($this->request->group) ? $this->request->group : 0;

        if ($parent) {
            $topcat = $this->where('id', $parent)->first();
            $group  = $topcat->group;
        }

        //dd($parent, $group, $this->request);

        $id = $this->insertGetId([
            'parent_id'        => $parent,
            'title'            => $this->request->title,
            'description'      => $this->request->description,
            'meta_title'       => $this->request->meta_title,
            'meta_description' => $this->request->meta_description,
            'group'            => $group,
            'lang'             => 'hr',
            'status'           => (isset($this->request->status) and $this->request->status == 'on') ? 1 : 0,
            'slug'             => isset($this->request->slug) ? Str::slug($this->request->slug) : Str::slug($this->request->title),
            'created_at'       => Carbon::now(),
            'updated_at'       => Carbon::now()
        ]);

        if ($id) {
            return $this->find($id);
        }

        return false;
    }


    /**
     * Update category.
     *
     * @return false
     */
    public function edit(Category $category)
    {
        $top    = (isset($this->request->top) and $this->request->top == 'on') ? 1 : 0;
        $parent = ( ! $top and isset($this->request->parent)) ? intval($this->request->parent) : 0;
        $group  = isset($this->request->group) ? $this->request->group : 0;

        //dd($top, $parent, $group, $request);

        if ($parent) {
            $topcat = $this->where('id', $parent)->first();
            $group  = $topcat->group;
        }

        $id = $category->update([
            'title'            => $this->request->title,
            'description'      => $this->request->description,
            'meta_title'       => $this->request->meta_title,
            'meta_description' => $this->request->meta_description,
            'parent_id'        => $parent,
            'group'            => $group,
            'top'              => $top,
            'status'           => (isset($this->request->status) and $this->request->status == 'on') ? 1 : 0,
            'slug'             => isset($this->request->slug) ? Str::slug($this->request->slug) : Str::slug($this->request->title),
            'updated_at'       => Carbon::now()
        ]);

        if ($id) {
            return $this->find($id);
        }

        return false;
    }


    /**
     * @return bool
     */
    public function resolveImage()
    {
        /*if ($this->request->hasFile('image')) {
            $path
        }*/

        $data = json_decode($this->request->image);
        $type = str_replace('image/', '', $data->output->type);
        $name = str_replace('.' . $type, '', $data->output->title);

        $path = time() . '_' . Str::slug($name) . '.' . $type;
        $img  = Image::make($data->output->image)->encode($type);

        Storage::disk('category')->put($path, $img);

        $default_path = config('filesystems.disks.category.url') . 'default.jpg';

        if ($this->image && $this->image != $default_path) {
            $delete_path = str_replace(config('filesystems.disks.category.url'), '', $this->image);

            Storage::disk('category')->delete($delete_path);
        }

        return $this->update([
            'image' => config('filesystems.disks.category.url') . $path
        ]);
    }

}
