<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Image
{

    /**
     * @param string $base_64_string
     *
     * @return false|string
     */
    public static function makeImageFromBase(string $base_64_string)
    {
        $image_parts = explode(";base64,", $base_64_string);

        return base64_decode($image_parts[1]);
    }


    /**
     * @param string $folder
     * @param string $path
     *
     * @return string
     */
    public static function cleanPath(string $disk, string $folder, string $path): string
    {
        return str_replace(config('filesystems.disks.' . $disk . '.url') . $folder . '/', '', $path);
    }


    /**
     * @param string $disk
     * @param string $new_image
     * @param        $resource
     *
     * @return string
     */
    public static function save(string $disk, array $new_image, $resource): string
    {
        $image = json_decode($new_image['image']);
        $time  = Str::random(4);
        $img   = \Intervention\Image\Facades\Image::make(self::makeImageFromBase($image->output->image));

        $path = $resource->id . '/' . Str::slug($resource->translation()->title) . '-' . $time . '.';

        $path_jpg = $path . 'jpg';
        Storage::disk($disk)->put($path_jpg, $img->encode('jpg'));

        $path_webp = $path . 'webp';
        Storage::disk($disk)->put($path_webp, $img->encode('webp'));

        // Thumb creation
        $path_thumb = $resource->id . '/' . Str::slug($resource->translation()->title) . '-' . $time . '-thumb.';

        $img = $img->resize(null, 300, function ($constraint) {
            $constraint->aspectRatio();
        })->resizeCanvas(250, null);

        $path_webp_thumb = $path_thumb . 'webp';
        Storage::disk($disk)->put($path_webp_thumb, $img->encode('webp'));

        return $path_jpg;
    }


    /**
     * @param string $disk
     * @param string $folder
     * @param string $path
     */
    public static function delete(string $disk, string $folder, string $path): void
    {
        $webp  = str_replace('.jpg', '.webp', $path);
        $thumb = str_replace('.jpg', '-thumb.webp', $path);

        Storage::disk($disk)->delete($folder . '/' . $path);
        Storage::disk($disk)->delete($folder . '/' . $webp);
        Storage::disk($disk)->delete($folder . '/' . $thumb);
    }

}
