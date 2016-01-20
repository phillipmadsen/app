<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Feeder\Feeder;

/**
 * Class FeederServiceProvider
 * @package App\Providers
 * @author Phillip Madsen
 */
class FeederServiceProvider extends ServiceProvider
{

    /**
     * Register
     */
    public function register()
    {

        $this->app->bind('feeder', 'App\Feeder\Feeder');
    }
}
