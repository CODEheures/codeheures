<?php
/**
 * Created by PhpStorm.
 * User: Papoun
 * Date: 04/08/2016
 * Time: 17:03
 */

namespace App\Common;


class FormatManager {

    public static function price($price) {
        return number_format($price/100,2,'.', ' ');
    }

    public static function inputPrice($price) {
        return number_format($price/100,2,'.', '');
    }

}