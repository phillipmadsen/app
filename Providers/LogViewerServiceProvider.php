<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class LogViewerServiceProvider
 * @package App\Providers
 * @author Phillip Madsen
 */
class LogViewerServiceProvider extends ServiceProvider
{

    public function register()
    {

        $this->app->bind('logviewer', 'App\LogViewer\LogViewer');
    }
}
