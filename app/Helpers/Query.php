<?php


namespace App\Helpers;


use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class Query
{


    /**
     * @param array $data
     *
     * @return string
     */
    public static function resolve(array $data): string
    {
        $response = '';

        foreach ($data as $item) {
            if ($item) {
                $response .= $item . ',';
            }
        }

        if ( ! $data) {
            $response = '';
        } else {
            $response = substr($response, 0, -1);
        }

        return $response;
    }


    /**
     * @param array $data
     *
     * @return array
     */
    public static function unset(array $data): array
    {
        foreach ($data as $key => $item) {
            if ( ! $item) {
                unset($data[$key]);
            }
        }

        return $data;
    }

}
