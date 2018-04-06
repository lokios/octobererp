<?php namespace Olabs\Social\Models;

use Model;

/**
 * Model
 */
class ClientsBilling extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    /*
     * Disable timestamps by default.
     * Remove this line if timestamps are defined in the database table.
     */
    public $timestamps = false;

    /*
     * Validation
     */
    public $rules = [
    ];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'olabs_social_clients_billing';

    public $belongsTo = [
        'client' => ['Olabs\Social\Models\Clients','key'=>'clients_id'],
        
    ];


     /**
     * Allows filtering for specifc categories
     * @param  Illuminate\Query\Builder  $query      QueryBuilder
     * @param  array                     $categories List of category ids
     * @return Illuminate\Query\Builder              QueryBuilder
     */
    public function scopeFilterCategories($query, $categories)
    {
        return $query->whereHas('client', function($q) use ($categories) {
            $q->whereIn('id', $categories);
        });
    }

}