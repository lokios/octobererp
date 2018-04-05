<?php namespace Olabs\Oims\Models;

use Model;

/**
 * Model
 */
class Status extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    use \October\Rain\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at'];
    
    const STATUS_NEW = 'new';
    const STATUS_SUBMITTED = 'submitted';
    const STATUS_APPROVED = 'approved';
    const STATUS_REJECTED = 'rejected';
    const STATUS_HO_APPROVED = 'ho-approved';
    const STATUS_HO_REJECTED = 'ho-rejected';
    const STATUS_HO_SUBMITTED = 'ho-submitted';
    
    const PAYMENT_STATUS_PENDING = 'pending';
    const PAYMENT_STATUS_PARTIALLY_PAID = 'partially_paid';
    const PAYMENT_STATUS_PAID = 'paid';

    /*
     * Validation
     */
    public $rules = [
        'slug' => [
            'required',
            'alpha_dash',
            'between:1,255',
            'unique:olabs_oims_units',
        ],      
    ];
    
    protected $primaryKey = 'slug';
    public $incrementing = false;
    
    /**
     * @var string The database table used by the model.
     */
    public $table = 'olabs_oims_statuses';
    
    public function getDefaultStatus(){
        return self::STATUS_NEW;
    }
}