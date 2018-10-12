<?php

namespace Olabs\Widgets\ReportWidgets;

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
class CustomReportWidgets extends ReportWidgetBase {

    /**
     * @var string A unique alias to identify this widget.
     */
    protected $defaultAlias = 'customreportwidgets';

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
                'title' => 'Custom Report Widget',
                'default' => 'Custom Report Widget',
                'type' => 'string',
                'validationPattern' => '^.+$',
                'validationMessage' => 'backend::lang.dashboard.widget_title_error',
            ],
            'customWidget' => [
                'title' => 'Custom Widget',
//                'default' => '1',
                'required' => '1',
                'type' => 'dropdown',
                'validationPattern' => '^.+$',
                'validationMessage' => 'olabs.widgets::lang.settings.custom_widget_error',
            ],
        ];
    }

    public function getCustomWidgetOptions() {
        return [null => 'Select an Widget'] + \Olabs\Widgets\Models\ReportWidget::where('status', '1')->lists('title', 'id');
    }

    /**
     * @inheritDoc
     */
    protected function loadAssets() {
//        $this->addCss('css/welcome.css', 'core');
    }

    protected function loadData() {
//        $custom_widget = $this->property('customWidget') != "" ? $this->property('customWidget') : 0;
//        $this->vars['customWidget'] = \Olabs\Widgets\Models\ReportWidget::;
        $this->vars['user'] = $user = BackendAuth::getUser();
        $this->vars['appName'] = BrandSetting::get('app_name');
        $this->vars['lastSeen'] = AccessLog::getRecent($user);
    }

}
