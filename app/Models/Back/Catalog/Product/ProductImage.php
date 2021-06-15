<?php

namespace App\Models\Back\Catalog\Product;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProductImage extends Model
{

    /**
     * @var string
     */
    protected $table = 'product_images';

    /**
     * @var array
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * @var Model
     */
    protected $resource;


    /**
     * @param $resource
     * @param $request
     *
     * @return mixed
     */
    public function store($resource, $request)
    {
        $this->resource = $resource;

        //dd($this->resource->id, $request);

        $existing = isset($request['slim']) ? $request['slim'] : null;
        $new      = isset($request['files']) ? $request['files'] : null;

        Log::info($existing);

        // Ako ima novih slika
        if ($new) {
            foreach ($new as $new_image) {
                if (isset($new_image['image']) && $new_image['image']) {
                    $data = json_decode($new_image['image']);

                    $saved = $this->saveNew($data->output, $new_image['sort_order']);
                    // Ako je novi default ujedno i novo uploadana fotka.
                    // Također ako je ime novo uploadane slike isto kao $existing['default']
                    if (
                        isset($new['default']) &&
                        strpos($new['default'], 'image/') !== false &&
                        $data->output->name == str_replace('image/', '', $new['default'])
                    ) {
                        $this->switchDefault($saved);
                    }
                }
            }
        }

        if ($existing && isset($existing[0])) {
            Log::info('$existing[0]');
            // Ako se mijenja default i nismo ga već promjenili...
            if (isset($existing['default']) && $existing['default'] != 'on') {
                $this->switchDefault(
                    $this->where('id', $existing['default'])->first()
                );
            }

            foreach ($existing as $key => $image) {
                if ($key != 'default' && $key) {
                    //dd($key, $image);

                    $data = json_decode($image['image']);

                    if ($data) {
                        $this->replace($key, $data->output);
                    }

                    if ($key) {
                        $this->where('id', $key)->update([
                            'sort_order' => $image['sort_order']
                        ]);
                    }
                }
            }
        }

        return $this->where('product_id', $this->resource->id)->get();
    }


    /**
     * @param $id
     * @param $new
     *
     * @return mixed
     */
    public function replace($id, $new)
    {
        // Nađi staru sliku i izdvoji path
        $old  = $id ? $this->where('id', $id)->first() : $this->resource;
        $path = str_replace('media/images/gallery/products/', '', $old['image']);
        // Obriši staru sliku
        Storage::disk('products')->delete($path);

        // Složi novi path za novu sliku
        $path = $this->resource->id . '/' . $new->name;
        // Napravi novu sliku i snimi je na disk
        $img = $this->makeImageFromBase($new->image);
        Storage::disk('products')->put($path, $img);

        // Ako nije glavna slika updejtaj path na product_images DB
        if ($id) {
            return $this->where('id', $id)->update([
                'image' => config('filesystems.disks.products.url') . $path
            ]);
        }

        return Product::where('id', $this->resource->id)->update([
            'image' => config('filesystems.disks.products.url') . $path
        ]);
    }


    /**
     * @param $new
     *
     * @return mixed
     */
    public function switchDefault($new)
    {
        //dd($new, $this->resource);
        if (isset($new->id)) {

            if ($this->resource->image) {
                $this->where('id', $new->id)->update([
                    'image' => $this->resource->image
                ]);
            } else {
                $this->where('id', $new->id)->delete();
            }

            Product::where('id', $this->resource->id)->update([
                'image' => $new->image
            ]);
        }

        return $new;
    }


    /**
     * @param $new
     *
     * @return mixed
     */
    public function saveNew($new, $sort_order = 0)
    {
        // path for the new image
        $path = $this->resource->id . '/' . $new->name;

        // Make and store new image
        $img = $this->makeImageFromBase($new->image);
        Storage::disk('products')->put($path, $img);

        // Store image in product_images DB
        $id = $this->insertGetId([
            'product_id' => $this->resource->id,
            'image'      => config('filesystems.disks.products.url') . $path,
            'alt'        => $this->resource->name,
            'sort_order' => $sort_order,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        return $this->find($id);
    }


    /**
     * Save stack of images to the
     * product_images database.
     *
     * @param array $paths
     * @param       $product_id
     *
     * @return array|bool
     */
    public static function saveStack(array $paths, $product_id)
    {
        $images = [];

        foreach ($paths as $key => $path) {
            $images[] = self::create([
                'product_id' => $product_id,
                'image'      => $path,
                'sort_order' => $key,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }

        if ( ! empty($images)) {
            return $images;
        }

        return false;
    }


    /**
     * Save temporary stored images
     * to newly saved product folder.
     * The folder is based on product ID.
     *
     * @param array $paths
     * @param       $product_id
     *
     * @return array|bool
     */
    public static function transferTemporaryImages(array $paths, $product_id)
    {
        $targets = [];

        foreach ($paths as $key => $path) {
            $target    = str_replace('temp', $product_id, $path);
            $targets[] = $target;

            if ($key == 0) {
                self::setDefault($target, $product_id);
            }

            $_path   = str_replace(config('filesystems.disks.products.url'), '', $path);
            $_target = str_replace(config('filesystems.disks.products.url'), '', $target);

            Storage::disk('products')->move($_path, $_target);
            Storage::disk('products')->delete($_path);
        }

        return self::saveStack($targets, $product_id);
    }


    /**
     * Set default product image.
     *
     * @param string $path
     * @param        $id
     *
     * @return mixed
     */
    public static function setDefault(string $path, $id)
    {
        return Product::where('id', $id)->update([
            'image' => $path
        ]);
    }


    /**
     * @param string $base_64_string
     *
     * @return false|string
     */
    private function makeImageFromBase(string $base_64_string)
    {
        $image_parts = explode(";base64,", $base_64_string);

        return base64_decode($image_parts[1]);
    }
}
