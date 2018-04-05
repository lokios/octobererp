<?php

namespace Olabs\Tenant\Classes;

use Illuminate\Database\Eloquent\SoftDeletes;
use October\Rain\Database\QueryBuilder;

trait MultiTenantTrait {

    //use SoftDeletes;

    public static $feature_enabled = true;

    /**
     * $events maps Eloquent events to trait methods.
      [
      'creating', 'created', 'updating', 'updated',
      'deleting', 'deleted', 'saving', 'saved',
      'restoring', 'restored', 'fetching', 'fetched'
      ],
     */
    protected $events = [
        'created' => 'createItem',
        'deleted' => 'deleteItem',
        'updating' => 'updateItem',
        'saving' => 'saveItem',
    ];

    /**
     * Set up event listeners for all Item types.
     * Named events are mapped to trait methods in $events.
     *
     * @return void
     */
    public static function bootMultiTenantTrait() {
        static::extend(function($model) {

            $model->bindEvent('model.beforeUpdate', function() use ($model) {
                $model->saveItem();
            });

            $model->bindEvent('model.beforeCreate', function() use ($model) {
                $model->saveItem();
            });


            $model->bindEvent('model.afterUpdate', function() use ($model) {
                //$model->revisionableAfterUpdate();
                $model->saveItem();
            });

            $model->bindEvent('model.afterDelete', function() use ($model) {
                //  $model->revisionableAfterDelete();
            });

            $model->bindEvent('model.beforeFetch', function() use ($model) {
                $model->saveItem();
            });
        });
    }

    protected function newBaseQueryBuilder22() {
        $conn = $this->getConnection();

        $grammar = $conn->getQueryGrammar();

        $builder = new QueryBuilder($conn, $grammar, $conn->getPostProcessor());
        //$query = $builder->getQuery();
        //$query->where('tenant_id', '=', \Olabs\Tenant\Classes\Tenant::getUserOrgId());
        ///$builder->setQuery($query);

        if (self::$feature_enabled)
            $builder = $builder->where('tenant_id', '=', \Olabs\Tenant\Classes\Tenant::getUserOrgId());

        return $builder;
    }

    public function newQuery() {
        $builder = $this->newQueryWithoutScopes();

        if (self::$feature_enabled)
            $builder = $builder->where('tenant_id', '=', \Olabs\Tenant\Classes\Tenant::getUserOrgId());
        return $this->applyGlobalScopes($builder);
    }

    public function newEloquentBuilder22($query) {
        $builder = new Builder($query);
        if (self::$feature_enabled)
            $builder = $builder->where('tenant_id', '=', \Olabs\Tenant\Classes\Tenant::getUserOrgId());

        return $builder;
    }

    /**
     * Retrieve events the model needs listeners for.
     *
     * @return array
     */
    protected static function getModelEvents() {
        if (isset(static::$modelEvents)) {
            //if a model needs fewer events available to SavesItem, define in that model's $modelEvents array.
            return static::$modelEvents;
        }
        return [
            'created', 'deleted', 'updating', 'saving'
        ];
    }

    public function createItem($item) {
        //runs when created event is dispatched
    }

    public function updateItem($item) {
        //runs when updating event is dispatched
    }

    public function saveItem() {

        if (self::$feature_enabled)
            $this->tenant_id = \Olabs\Tenant\Classes\Tenant::getUserOrgId();
        // $this->tenant_id_1 = \Olabs\Tenant\Classes\Tenant::getUserOrgId();
        //runs when saving event is dispatched
        //  throw new \Exception("Error Processing Request", 1);
    }

    public function deleteItem($item) {
        //runs when deleted event is dispatched
    }

}
