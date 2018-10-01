<?php namespace Kocholes\BarcodeGenerator;

use Kocholes\BarcodeGenerator\Classes\BarcodeManager;
use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public function registerComponents()
    {
        return [
            'Kocholes\BarcodeGenerator\Components\Barcode' => 'barcode'
        ];
    }
    
    public function registerMarkupTags()
    {
        return [
            'functions' => [
                'barcodeHTML' => function($params) {
                    return $this->getBarcode('HTML', $params);
                },
                'barcodeSVG' => function($params) {
                    return $this->getBarcode('SVG', $params);
                },
                'barcodePNG' => function($params) {
                    return $this->getBarcode('PNG', $params);
                },
            ]
        ];
    }
    
    private function getBarcode($format, $params) {
        $manager = new BarcodeManager();
        if(!isset($params['width'])) {
            $params['width'] = 2;
        }
        if(!isset($params['height'])) {
            $params['height'] = 30;
        }
        if(!isset($params['color'])) {
            $params['color'] = $format != 'PNG' ? 'black' : [0,0,0];
        }
        return $manager->getBarcode($format,$params['data'],strtoupper($params['type']),$params['width'],$params['height'],$params['color']);
    }

}
