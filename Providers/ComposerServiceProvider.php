<?php namespace App\Providers;

use View;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider {

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function boot()
    {
        // Frontend
        View::composer('frontend.layout.menu', 'App\Composers\MenuComposer');
        View::composer('frontend.layout.layout', 'App\Composers\SettingComposer');
        View::composer('frontend.layout.footer', 'App\Composers\ArticleComposer');
        View::composer('frontend.news.sidebar', 'App\Composers\NewsComposer');

        // Backend
        View::composer('backend/layout/layout', 'App\Composers\Admin\MenuComposer');
    }

    /**
     * Register
     *
     * @return void
     */
    public function register()
    {

    }

}