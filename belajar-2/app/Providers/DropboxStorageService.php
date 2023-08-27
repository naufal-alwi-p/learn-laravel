<?php

namespace App\Providers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;
use League\Flysystem\Filesystem;
use Spatie\Dropbox\Client;
use Spatie\FlysystemDropbox\DropboxAdapter;

class DropboxStorageService extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        /*
            Custom Filesystems

            Laravel's Flysystem integration provides support for several "drivers" out of the box; however, Flysystem is not
            limited to these and has adapters for many other storage systems. You can create a custom driver if you want to use
            one of these additional adapters in your Laravel application.

            In order to define a custom filesystem you will need a Flysystem adapter. Let's add a community maintained Dropbox
            adapter to our project:
            -> composer require spatie/flysystem-dropbox

            Next, you can register the driver within the boot method of one of your application's service providers. To accomplish
            this, you should use the extend method of the Storage facade
        */

        Storage::extend('dropbox_driver', function(Application $app, array $config) {
            $adapter = new DropboxAdapter(new Client($config['token']));

            return new FilesystemAdapter(
                new Filesystem($adapter, $config['settings']),
                $adapter,
                $config
            );
        });

        /*
            The first argument of the extend method is the name of the driver and the second is a closure that receives the $app and
            $config variables. The closure must return an instance of Illuminate\Filesystem\FilesystemAdapter. The $config variable
            contains the values defined in config/filesystems.php for the specified disk.

            Once you have created and registered the extension's service provider, you may use the dropbox driver in your
            config/filesystems.php configuration file.
        */
    }
}
