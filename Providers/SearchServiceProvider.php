<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class SearchServiceProvider
 * @package App\Providers
 * @author Phillip Madsen
 */
class SearchServiceProvider extends ServiceProvider
{

    public function register()
    {

        $this->app->bind('search', 'App\Search\Search');
    }
}
