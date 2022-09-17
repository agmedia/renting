<?php

namespace App\Models\Back\Marketing;

use App\Helpers\Helper;
use App\Models\Back\Catalog\Author;
use App\Models\Back\Catalog\Product\Product;
use App\Models\Back\Catalog\Product\ProductCategory;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class Review extends Model
{

    /**
     * @var string
     */
    protected $table = 'reviews';

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
            'firstname'        => 'required',
            /*'message'      => 'required',
            'stars'        => 'required'*/
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
        $id = $this->insertGetId(
            $this->createModelArray()
        );

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
        $updated = $this->update(
            $this->createModelArray('update')
        );

        if ($updated) {
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
        $stars = $this->request->stars ?: 0;

        $response = [
            'apartment_id' => 0,
            'order_id'     => 0,
            'user_id'      => 0,
            'lang'         => $this->request->lang,
            'fname'        => $this->request->firstname,
            'lname'        => isset($this->request->lastname) ? $this->request->lastname : '',
            'email'        => isset($this->request->email) ? $this->request->email : '',
            'avatar'       => isset($this->request->avatar) ? $this->request->avatar : 'media/avatar.jpg',
            'message'      => $this->request->message,
            'stars'        => $stars,
            'sort_order'   => isset($this->request->sort_order) ? $this->request->sort_order : 0,
            'featured'     => (isset($this->request->featured) and $this->request->featured == 'on') ? 1 : 0,
            'status'       => (isset($this->request->status) and $this->request->status == 'on') ? 1 : 0,
            'updated_at'   => Carbon::now()
        ];

        if ($method == 'insert') {
            $response['created_at'] = Carbon::now();
        }

        return $response;
    }
}
