<?php

namespace Olabs\Oims\ReportWidgets;

use BackendAuth;
use Backend\Models\AccessLog;
use Backend\Classes\ReportWidgetBase;
use Backend\Models\BrandSetting;
use Exception;

/**
 * User report report widget.
 *
 * @package october\backend
 * @author Alexey Bobkov, Samuel Georges
 */
class DprSummary extends ReportWidgetBase {

    /**
     * @var string A unique alias to identify this widget.
     */
    protected $defaultAlias = 'drpsummary';

    /**
     * Renders the widget.
     */
    public function render() {
        try {
            $this->loadData();
        } catch (Exception $ex) {
            $this->vars['error'] = $ex->getMessage();
        }

        return $this->makePartial('widget');
    }

    public function defineProperties() {
        return [
            'title' => [
                'title' => 'DPR Summary Report',
                'default' => 'DPR Summary Report',
                'type' => 'string',
                'validationPattern' => '^.+$',
                'validationMessage' => 'backend::lang.dashboard.widget_title_error',
            ],
            'report_months' => [
                'title' => 'Report for month',
                'default' => 'this month',
                'type' => 'dropdown',
                'options' => ['this month' => 'this month', 'last month' => 'last month'], //, 'this week' => 'this week', 'last week' => 'last week'],
                'validationPattern' => '^.+$',
                'validationMessage' => 'backend::lang.dashboard.widget_title_error',
            ]
        ];
    }

    /**
     * @inheritDoc
     */
    protected function loadAssets() {
//        $this->addCss('css/welcome.css', 'core');
    }

    protected function loadData() {
        $this->vars['user'] = $user = BackendAuth::getUser();
        $this->vars['appName'] = BrandSetting::get('app_name');
        $this->vars['lastSeen'] = AccessLog::getRecent($user);
    }

    

}
