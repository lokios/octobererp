<?php namespace Olabs\Oims\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use \Olabs\Oims\Models\PropertyOption;
use \Olabs\Oims\Models\Property;
use Flash;

/**
 * Properties Back-end Controller
 */
class Properties extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController',
        'Backend.Behaviors.RelationController',
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';
    public $relationConfig = 'config_relation.yaml';
    
    public $requiredPermissions = ['olabs.oims.properties'];

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Olabs.Oims', 'oims_setup', 'properties');
    }
    
    
    public function onOrderOptionUp()
    {
        $parentId = null;
        
        if (($checkedIds = post('checked')) && is_array($checkedIds) && count($checkedIds)) 
        {
            foreach ($checkedIds as $id) {
                if (!$object = PropertyOption::find($id))
                    continue;

                $parentId = $object->property_id;
                // - order
                $prevOrder = $object->order_index;
                $newOrder = $object->order_index - 1; if ($newOrder < 0) { $newOrder = 0; }
                $objectPrevOrder = PropertyOption::where("property_id","=",$object->property_id)->where("order_index","=",$newOrder)->first();
                $object->order_index = $newOrder;
                $object->save();
                
                // chagne order another object
                if ($objectPrevOrder != null) {
                    $objectPrevOrder->order_index = $prevOrder;
                    $objectPrevOrder->save();
                }                
            }

            Flash::success('Item has been moved up.');
        }

        if ($parentId!=null) {
            // October BUGs - init again
            $model = Property::find($parentId);
            $this->initForm($model);
            $this->initRelation($model,"options");

            // return refresh
            return $this->relationRefresh("options");
        }
    }
    
    public function onOrderOptionDown()
    {
        $parentId = null;

        if (($checkedIds = post('checked')) && is_array($checkedIds) && count($checkedIds)) 
        {
            foreach ($checkedIds as $id) {
                if (!$object = PropertyOption::find($id))
                    continue;

                $parentId = $object->property_id;
                // + order
                $prevOrder = $object->order_index;
                $newOrder = $object->order_index + 1;
                $objectPrevOrder = PropertyOption::where("property_id","=",$object->property_id)->where("order_index","=",$newOrder)->first();
                $object->order_index = $newOrder;
                $object->save();
                
                // chagne order another object
                if ($objectPrevOrder != null) {
                    $objectPrevOrder->order_index = $prevOrder;
                    $objectPrevOrder->save();
                }
                        
            }

            Flash::success('Item has been moved down.');            
        }
        
        if ($parentId!=null) {
            // October BUGs - init again
            $model = Property::find($parentId);
            $this->initForm($model);
            $this->initRelation($model,"options");

            // return refresh
            return $this->relationRefresh("options");
        }
    } 
}