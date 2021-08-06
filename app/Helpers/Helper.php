<?php


namespace App\Helpers;


use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class Helper
{

    public static function calculateDiscountPrice(float $price, int $discount)
    {
        return $price - ($price * ($discount / 100));
    }


    public static function abc()
    {
        return ['A', 'B', 'C', 'Ć', 'Č', 'D', 'Đ', 'DŽ', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'LJ', 'M', 'N', 'NJ', 'O', 'P', 'R', 'S', 'Š', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'Ž'];
    }
}
