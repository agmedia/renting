<?php

namespace App\Models\Back\Marketing;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class Action extends Model
{

    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'product_actions';

    /**
     * @var array
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * @var Request
     */
    protected $request;


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
            'title' => 'required',
            'type' => 'required',
            'group' => 'required',
            'action_list' => 'required'
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
        $links = collect($this->request->action_list)->flatten()->toJson();

        $id = $this->insertGetId([
            'title'      => $this->request->title,
            'type'       => $this->request->type,
            'discount'   => $this->request->discount,
            'group'      => $this->request->group,
            'links'      => $links,
            'date_start' => $this->request->date_start ? Carbon::make($this->request->date_start) : null,
            'date_end'   => $this->request->date_end ? Carbon::make($this->request->date_end) : null,
            'status'     => (isset($this->request->status) and $this->request->status == 'on') ? 1 : 0,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
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
        $links = collect($this->request->action_list)->flatten()->toJson();

        $id = $this->update([
            'title'      => $this->request->title,
            'type'       => $this->request->type,
            'discount'   => $this->request->discount,
            'group'      => $this->request->group,
            'links'      => $links,
            'date_start' => $this->request->date_start ? Carbon::make($this->request->date_start) : null,
            'date_end'   => $this->request->date_end ? Carbon::make($this->request->date_end) : null,
            'status'     => (isset($this->request->status) and $this->request->status == 'on') ? 1 : 0,
            'updated_at' => Carbon::now()
        ]);

        if ($id) {
            return $this;
        }

        return false;
    }
}
