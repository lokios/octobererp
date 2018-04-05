<?php namespace Cyd293\Extenders\Behaviors;


use Backend\Behaviors\RelationController as RelationControllerBase;
/**
 * Relation Controller Behavior
 * Uses a combination of lists and forms for managing Model relations.
 *
 * @package october\backend
 * @author Alexey Bobkov, Samuel Georges
 */
class RelationController extends RelationControllerBase
{
    
    protected function makeViewWidget()
    {
        /*
         * Multiple (has many, belongs to many)
         */
        if ($this->viewMode == 'multi') {
            $config = $this->makeConfigForMode('view', 'list');
            $config->model = $this->relationModel;
            $config->alias = $this->alias . 'ViewList';
            $config->showSorting = $this->getConfig('view[showSorting]', true);
            $config->defaultSort = $this->getConfig('view[defaultSort]');
            $config->recordsPerPage = $this->getConfig('view[recordsPerPage]');
            $config->showCheckboxes = $this->getConfig('view[showCheckboxes]', !$this->readOnly);
            $config->recordUrl = $this->getConfig('view[recordUrl]', null);

            $defaultOnClick = sprintf(
                "$.oc.relationBehavior.clickViewListRecord(':%s', '%s', '%s')",
                $this->relationModel->getKeyName(),
                $this->field,
                $this->relationGetSessionKey()
            );

            if ($config->recordUrl) {
                $defaultOnClick = null;
            }
            elseif (
                !$this->makeConfigForMode('manage', 'form', false) &&
                !$this->makeConfigForMode('pivot', 'form', false)
            ) {
                $defaultOnClick = null;
            }

            $config->recordOnClick = $this->getConfig('view[recordOnClick]', $defaultOnClick);

            if ($emptyMessage = $this->getConfig('emptyMessage')) {
                $config->noRecordsMessage = $emptyMessage;
            }

            /*
             * Constrain the query by the relationship and deferred items
             */
            //throw new \Exception($this->relationObject->getQuery()->toSql());
            
            $widget = $this->makeWidget('Backend\Widgets\Lists', $config);
            $widget->bindEvent('list.extendQueryBefore',function($query){
                $relQuery = $this->relationObject->getQuery()->getQuery();
                $query->setQuery($relQuery);
            });
            $widget->bindEvent('list.extendQuery', function ($query) {
                $this->relationObject->setQuery($query);

                $sessionKey = $this->deferredBinding ? $this->relationGetSessionKey() : null;

                if ($sessionKey) {
                    $this->relationObject->withDeferred($sessionKey);
                }
                elseif ($this->model->exists) {
                    $this->relationObject->addConstraints();
                }

                $this->controller->relationExtendQuery($query, $this->field);

                /*
                 * Allows pivot data to enter the fray
                 */
                if ($this->relationType == 'belongsToMany') {
                    $this->relationObject->setQuery($query->getQuery());
                    return $this->relationObject;
                }
            });

            /*
             * Constrain the list by the search widget, if available
             */
            if ($this->toolbarWidget && $this->getConfig('view[showSearch]')) {
                if ($searchWidget = $this->toolbarWidget->getSearchWidget()) {
                    $searchWidget->bindEvent('search.submit', function () use ($widget, $searchWidget) {
                        $widget->setSearchTerm($searchWidget->getActiveTerm());
                        return $widget->onRefresh();
                    });

                    /*
                     * Persist the search term across AJAX requests only
                     */
                    if (Request::ajax()) {
                        $widget->setSearchTerm($searchWidget->getActiveTerm());
                    }
                    else {
                        $searchWidget->setActiveTerm(null);
                    }
                }
            }
        }
        /*
         * Single (belongs to, has one)
         */
        elseif ($this->viewMode == 'single') {
            $this->viewModel = $this->relationObject->getResults()
                ?: $this->relationModel;

            $config = $this->makeConfigForMode('view', 'form');
            $config->model = $this->viewModel;
            $config->arrayName = class_basename($this->relationModel);
            $config->context = 'relation';
            $config->alias = $this->alias . 'ViewForm';

            $widget = $this->makeWidget('Backend\Widgets\Form', $config);
            $widget->previewMode = true;
        }

        return $widget;
    }
}
