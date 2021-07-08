<?php

namespace App\Models\Back\Settings;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class Page extends Model
{

    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'pages';

    /**
     * @var array
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * @var Request
     */
    protected $request;


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
        $id = $this->insertGetId([
            'category_id'       => null,
            'group'             => 'page',
            'title'             => $this->request->title,
            'short_description' => $this->request->short_description,
            'description'       => $this->request->description,
            'meta_title'        => $this->request->meta_title,
            'meta_description'  => $this->request->meta_description,
            'slug'              => isset($this->request->slug) ? Str::slug($this->request->slug) : Str::slug($this->request->title),
            'keywords'          => null,
            'publish_date'      => null,
            'keywords'          => false,
            'status'            => (isset($this->request->status) and $this->request->status == 'on') ? 1 : 0,
            'created_at'        => Carbon::now(),
            'updated_at'        => Carbon::now()
        ]);

        if ($id) {
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
        $id = $this->update([
            'category_id'       => null,
            'group'             => 'page',
            'title'             => $this->request->title,
            'short_description' => $this->request->short_description,
            'description'       => $this->request->description,
            'meta_title'        => $this->request->meta_title,
            'meta_description'  => $this->request->meta_description,
            'slug'              => isset($this->request->slug) ? Str::slug($this->request->slug) : Str::slug($this->request->title),
            'keywords'          => null,
            'publish_date'      => null,
            'keywords'          => false,
            'status'            => (isset($this->request->status) and $this->request->status == 'on') ? 1 : 0,
            'updated_at'        => Carbon::now()
        ]);

        Log::info('$id');
        Log::info($this->id);
        Log::info($this->request);

        if ($id) {
            return $this->find($this->id);
        }

        return false;
    }


    /**
     * @param Category $category
     *
     * @return bool
     */
    public function resolveImage(Page $page)
    {
        if ($this->request->hasFile('image')) {
            $name = Str::slug($page->title) . '-' . Str::random(9) . '.' . $this->request->image->extension();

            $this->request->image->storeAs('/', $name, 'page');

            return $page->update([
                'image' => config('filesystems.disks.page.url') . $name
            ]);
        }

        return false;
    }
}
