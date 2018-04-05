<?php namespace Olabs\Oims\Models;

use Model;

/**
 * Model
 */
class BankAccount extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    use \October\Rain\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at'];

    /*
     * Validation
     */
    public $rules = [
        'account_number' => 'required',
        'bank_name' => 'required',
        'bank_code' => 'required',
    ];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'olabs_oims_bank_accounts';
}