<?php namespace Olabs\Oims\Models;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Model;

/**
 * Model
 */
class ProductsExport extends \Backend\Models\ExportModel
{
//    protected $rules = [];
    public function exportData($columns, $sessionKey = null) {
        $entries = Product::all();
        $entries->each(function($subscriber) use ($columns) {
            $subscriber->addVisible($columns);
        });
        return $entries->toArray();
    }
}