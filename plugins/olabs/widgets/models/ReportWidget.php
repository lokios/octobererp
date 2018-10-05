<?php 
namespace Olabs\Widgets\Models;

use Model;
use Carbon\Carbon;
use DB;
use Lang;
use BackendAuth;


/**
 * Model
 */
class ReportWidget extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    use \October\Rain\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at'];

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'olabs_widgets_reportwidgets';
}
