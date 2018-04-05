<?php namespace Olabs\Oims\Models;

use Model;

/**
 * OrderStatus Model
 */
class OrderStatus extends Model
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'olabs_oims_order_statuses';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];
    
    use \October\Rain\Database\Traits\Validation;

    public $rules = [
        'title' => 'required|between:3,50',
        'color' => 'required',
    ]; 
    
    
    
    /**
     * TranslatableModel
     *
     * @var type 
     */
    public $implement = ['@RainLab.Translate.Behaviors.TranslatableModel'];
    public $translatable = [
        'title'
    ];    
    

    /**
     * @var array Fillable fields
     */
    protected $fillable = [
        'title',
        'color',
        'active',

        'send_email_to_customer',
        'attach_invoice_pdf_to_email',

        'mail_template_id',
        
        'disallow_for_gateway',
        'qty_decrease',
        'qty_increase_back',
    ];
    

    /**
     * @var array Relations
     */
    public $hasOne = [];
    public $hasMany = [];
    public $belongsTo = [
        'mail_template' => [
            '\System\Models\MailTemplate', 
            'key' => 'mail_template_id'
        ],        
    ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];

}