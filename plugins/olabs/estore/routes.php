<?php
/**
 * Created by PhpStorm.
 * User: Lokendra
 * Date: 10/13/16
 * Time: 10:39 PM
 */

//require_once './vendor/autoload.php';
//require_once 'utils.php';



use Olabs\Tenant\Classes\Tenant;

use Olabs\Tenant\Models\Organizations;
use \CodesWholesale\Resource\ImageType;
use Olabs\Estore\Models\Products;
/**
 * https://github.com/codeswholesale/codeswholesale-sdk-php/blob/master/examples/utils.php
 */
Route::get('codes/import', function () {

    session_start();

    $params = array(
        /**
         * API Keys
         * These are common api keys, you can use it to test integration.
         */
        'cw.client_id' => 'ff72ce315d1259e822f47d87d02d261e',
        'cw.client_secret' => '$2a$10$E2jVWDADFA5gh6zlRVcrlOOX01Q/HJoT6hXuDMJxek.YEo.lkO2T6',
        /**
         * CodesWholesale ENDPOINT
         */
        'cw.endpoint_uri' => \CodesWholesale\CodesWholesale::SANDBOX_ENDPOINT,
        /**
         * Due to security reasons you should use SessionStorage only while testing.
         * In order to go live you should change it do database storage.
         */
        'cw.token_storage' => new \fkooman\OAuth\Client\SessionStorage()
    );
    /**
     * Session information is stored under
     * $_SESSION["php-oauth-client"] where we keep all connection tokens.
     *
     * Create client builder.
     */
    $clientBuilder = new \CodesWholesale\ClientBuilder($params);
    $client = $clientBuilder->build();
    /**
     * If you would like to clean session storage you can use belows line,
     * sometimes you can expire this issue in you development.
     *
     * $_SESSION["php-oauth-client"]= array();
     */
    $_SESSION["php-oauth-client"]= array();
    try{
        /**
         * Retrieve all products from price list
         */
        $products = $client->getProducts();
        /**
         * Display each in foreach loop
         */

        $list = array();
        foreach($products as $product) {
            //displayProductDetails($product);

            $o= array();

            $p = Products::where(['source_product_id'=>$product->getProductId()])->first();
            if(!$p){
               $p = new Products();
                $p->status ='D';
            }

            $p->source_product_id = $product->getProductId() ;
            $p->title = $product->getName() ;
            $p->source_identifier = $product->getIdentifier() ;
            $p->release_date = $product->getReleaseDate() ;
            $p->source_stock = $product->getStockQuantity() ;



            $l = array();
            foreach($product->getLanguages() as $lang) {
                $l[] = $lang ;
            }
            $p->languages = implode(",",$l) ;

            $l = array();
            foreach($product->getRegions() as $region) {
                $l[] =  $region ;
            }
            $p->regions = implode(",",$l) ;

            //$o['image_url_medium'] = $product->getImageUrl(ImageType::MEDIUM);
            //$o['image_url_small'] = $product->getImageUrl(ImageType::SMALL);
            $p->cost_price = $product->getDefaultPrice();


            foreach($product->getPrices() as $price) {
              //  echo $price->value . " from " . $price->from . " to ". ($price->to ? $price->to : "*"). " | ";
            }

            foreach ($product->getLinks() as $link) {
               // echo "link: ". $link->rel . "<br />";
               // echo "href: ". $link->href . "<br />";
            }
            //echo "<br />";



            //$p->

            $p->save();
            $list[] = $p;
        }

        return $list;
    } catch (\CodesWholesale\Resource\ResourceError $e) {
        if($e->isInvalidToken()) {
            echo "if you are using SessionStorage refresh your session and try one more time.";
        }
        echo $e->getCode();
        echo $e->getErrorCode();
        echo $e->getMoreInfo();
        echo $e->getDeveloperMessage();
        echo $e->getMessage();
    }

    return 'Hello World';
});

Route::post('api1/foo/bar', function () {
    return 'Hello World';
});