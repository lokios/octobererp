<?php

namespace Olabs\Oims\Models;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Model;

/**
 * Model
 */
class ProductsImport extends \Backend\Models\ImportModel {

    protected $rules = [];

    public function importData($results, $sessionKey = null) {
        foreach ($results as $row => $data) {

            try {
                if (isset($data['id'])) {
                    $entry = Product::findOrFail($data['id']);
//                    $entry = Product::where('id',$data['id'])->get();
                } else {
                    $entry = Product::where('title', $data['title'])->firstOrFail();
                }

//                if(!$entry){
//                    $entry = new Product;
//                }
                $entry->fill($data);
                $entry->save();
                $this->logUpdated();
            } catch (ModelNotFoundException $ex) {
                if ($data['title']) {
                    $entry = new Product;
                    $entry->fill($data);
                    
                    if(empty($entry->retail_price_with_tax)){
                        $entry->retail_price_with_tax = 0;
                    }
//                $entry->minimum_quantity =
                    $entry->save();
                    $this->logCreated();
                }
            } catch (\Exception $ex) {
                $this->logError($row, $ex->getMessage());
            }
        }
    }

}
