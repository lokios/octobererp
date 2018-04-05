<?php
/**
 * Created by PhpStorm.
 * User: Lokendra
 * Date: 9/9/16
 * Time: 4:24 PM
 */

namespace Olabs\Tenant\classes;
//namespace App\Providers;
use Storage;
use League\Flysystem\Filesystem;
//use Dropbox\Client as DropboxClient;
use Illuminate\Support\ServiceProvider;
use League\Flysystem\GridFS\GridFSAdapter;
use MongoGridFs;
use MongoClient;
use MongoGridFSException;
use MongoGridFSFile;
use MongoRegex;

class GridFsServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        Storage::extend('gridfs', function($app, $config) {
            $m = new MongoClient(); // connect
            $db = $m->selectDB("example");
            $client = $db->getGridFS();
            /*$client = new DropboxClient(
                $config['accessToken'], $config['clientIdentifier']
            );*/

            return new Filesystem(new GridFSAdapter($client));
        });
    }

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}