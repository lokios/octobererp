<?php
/**
 * Created by PhpStorm.
 * User: Lokendra
 * Date: 10/4/16
 * Time: 5:06 PM
 */
namespace Olabs\Parsers\Models;
require __DIR__.'/../vendor/autoload.php';

use Olabs\Tenant\Classes\Tenant;
/**
 * Model
 */
class TextUtils
{

    public static function toText($html){

        if(!$html || $html=='')return $html;
        $text = \Html2Text\Html2Text::convert($html);
        return $text;
    }

}