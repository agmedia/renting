<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Log;
use Intervention\Image\Facades\Image;

class Import
{

    /**
     * @param array $data
     *
     * @return array|null[]
     */
    public function setAttributes(array $data): array
    {
        $list_attributes = ['Autor', 'Izdavač', 'Dimenzije', 'Broj stranica', 'Godina izdavanja', 'Mjesto izdavanja', 'Uvez', 'Pismo', 'Stanje'];
        $attributes = [];

        foreach ($list_attributes as $key) {
            $attributes[$key] = null;
        }

        if (in_array($data['AN'], $list_attributes)) {
            $attributes[$data['AN']] = $data['AO'];
        }
        if (in_array($data['AR'], $list_attributes)) {
            $attributes[$data['AR']] = $data['AS'];
        }
        if (in_array($data['AV'], $list_attributes)) {
            $attributes[$data['AV']] = $data['AW'];
        }
        if (in_array($data['AZ'], $list_attributes)) {
            $attributes[$data['AZ']] = $data['BA'];
        }
        if (in_array($data['BD'], $list_attributes)) {
            $attributes[$data['BD']] = $data['BE'];
        }
        if (in_array($data['BH'], $list_attributes)) {
            $attributes[$data['BH']] = $data['BI'];
        }
        if (in_array($data['BL'], $list_attributes)) {
            $attributes[$data['BL']] = $data['BM'];
        }
        if (in_array($data['BP'], $list_attributes)) {
            $attributes[$data['BP']] = $data['BQ'];
        }
        if (in_array($data['CK'], $list_attributes)) {
            $attributes[$data['CK']] = $data['CL'];
        }

        return [
            'author'     => $attributes['Autor'],
            'publisher'  => $attributes['Izdavač'],
            'pages'      => $attributes['Broj stranica'],
            'dimensions' => $attributes['Dimenzije'],
            'origin'     => $attributes['Mjesto izdavanja'],
            'letter'     => $attributes['Pismo'],
            'condition'  => $attributes['Stanje'],
            'binding'    => $attributes['Uvez'],
            'year'       => $attributes['Godina izdavanja'],
        ];
    }


    /**
     * @param array $images
     *
     * @return array
     */
    public function resolveImages(array $images, string $name): array
    {
        $response = [];

        foreach ($images as $image) {
            $img = Image::make($image);
            $data = $img->exif();

            $path = config('filesystems.disks.products.url') . $name . '.' . str_replace('image/', $data['MimeType']);

            $img->save($path);

            $response[] = $path;
        }

        return $response;
    }


    /**
     * @param array $categories
     *
     * @return array
     */
    public function resolveCategories(array $categories): array
    {

    }
}
