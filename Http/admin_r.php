<?php
/**
* @Author: Phillip Madsen
* @Date:   2016-01-15 14:00:32
* @Last Modified by:   Phillip Madsen
* @Last Modified time: 2016-01-15 14:00:32
*/
/*
|--------------------------------------------------------------------------
| Backend Routes
|--------------------------------------------------------------------------
*/

Route::group(array('prefix' => LaravelLocalization::getCurrentLocale()), function () {

    Route::group(array('prefix'    => '/admin', 'namespace' => 'Admin', 'middleware' => ['sentinel.auth', 'sentinel.permission']), function () {
        // admin dashboard
        Route::get('/', array('as' => 'admin.dashboard', 'uses' => 'DashboardController@index'));

        // user
        Route::resource('user', 'UserController');
        Route::get('user/{id}/delete', array('as'   => 'admin.user.delete',  'uses' => 'UserController@confirmDestroy'))->where('id', '[0-9]+');

        // role
        Route::resource('role', 'RoleController');
        Route::get('role/{id}/delete', array('as'   => 'admin.role.delete', 'uses' => 'RoleController@confirmDestroy'))->where('id', '[0-9]+');

        // blog
        Route::resource('article', 'ArticleController', array('before' => 'hasAccess:article'));
        Route::get('article/{id}/delete', array('as'   => 'admin.article.delete',  'uses' => 'ArticleController@confirmDestroy'))->where('id', '\d+');

        // news
        Route::resource('news', 'NewsController', array('before' => 'hasAccess:news'));
        Route::get('news/{id}/delete', array('as'   => 'admin.news.delete',  'uses' => 'NewsController@confirmDestroy'))->where('id', '[0-9]+');

        // category
        Route::resource('category', 'CategoryController', array('before' => 'hasAccess:category'));
        Route::get('category/{id}/delete', array('as'   => 'admin.category.delete', 'uses' => 'CategoryController@confirmDestroy'))->where('id', '[0-9]+');

        // faq
        Route::resource('faq', 'FaqController', array('before' => 'hasAccess:faq'));
        Route::get('faq/{id}/delete', array('as'   => 'admin.faq.delete',  'uses' => 'FaqController@confirmDestroy'))->where('id', '[0-9]+');

        // project
        Route::resource('project', 'ProjectController');
        Route::get('project/{id}/delete', array('as'   => 'admin.project.delete',  'uses' => 'ProjectController@confirmDestroy'))->where('id', '[0-9]+');

        // page
        Route::resource('page', 'PageController');
        Route::get('page/{id}/delete', array('as'   => 'admin.page.delete',  'uses' => 'PageController@confirmDestroy'))->where('id', '[0-9]+');

        // photo gallery
        Route::resource('photo-gallery', 'PhotoGalleryController');
        Route::get('photo-gallery/{id}/delete', array('as'   => 'admin.photo-gallery.delete',  'uses' => 'PhotoGalleryController@confirmDestroy'))->where('id', '[0-9]+');

        // video
        Route::resource('video', 'VideoController');
        Route::get('video/{id}/delete', array('as'   => 'admin.video.delete',  'uses' => 'VideoController@confirmDestroy'))->where('id', '[0-9]+');
        Route::post('/video/get-video-detail', array('as'   => 'admin.video.detail',  'uses' => 'VideoController@getVideoDetail'))->where('id', '[0-9]+');

        // ajax - blog
        Route::post('article/{id}/toggle-publish', array('as'   => 'admin.article.toggle-publish', 'uses' => 'ArticleController@togglePublish'))->where('id', '[0-9]+');

        // ajax - news
        Route::post('news/{id}/toggle-publish', array('as'   => 'admin.news.toggle-publish',  'uses' => 'NewsController@togglePublish'))->where('id', '[0-9]+');

        // ajax - photo gallery
        Route::post('photo-gallery/{id}/toggle-publish', array('as'   => 'admin.photo_gallery.toggle-publish', 'uses' => 'PhotoGalleryController@togglePublish'))->where('id', '[0-9]+');
        Route::post('photo-gallery/{id}/toggle-menu', array('as'   => 'admin.photo_gallery.toggle-menu', 'uses' => 'PhotoGalleryController@toggleMenu'))->where('id', '[0-9]+');

        // ajax - page
        Route::post('page/{id}/toggle-publish', array('as'   => 'admin.page.toggle-publish',  'uses' => 'PageController@togglePublish'))->where('id', '[0-9]+');
        Route::post('page/{id}/toggle-menu', array('as'   => 'admin.page.toggle-menu',  'uses' => 'PageController@toggleMenu'))->where('id', '[0-9]+');

        // ajax - form post
        Route::post('form-post/{id}/toggle-answer', array('as'   => 'admin.form-post.toggle-answer',  'uses' => 'FormPostController@toggleAnswer'))->where('id', '[0-9]+');

        // file upload photo gallery
        Route::post('/photo-gallery/upload/{id}', array('as'   => 'admin.photo.gallery.upload.image',  'uses' => 'PhotoGalleryController@upload'))->where('id', '[0-9]+');
        Route::post('/photo-gallery-delete-image', array('as'   => 'admin.photo.gallery.delete.image', 'uses' => 'PhotoGalleryController@deleteImage'));

        // settings
        Route::get('/settings', array('as' => 'admin.settings', 'uses' => 'SettingController@index'));
        Route::post('/settings', array('as'   => 'admin.settings.save', 'uses' => 'SettingController@save'), array('before' => 'csrf'));

        // form post
        Route::resource('form-post', 'FormPostController', array('only' => array('index', 'show', 'destroy')));
        Route::get('form-post/{id}/delete', array('as'   => 'admin.form-post.delete', 'uses' => 'FormPostController@confirmDestroy'))->where('id', '[0-9]+');

        // slider
        Route::get('/slider', array(  'as' => 'admin.slider', function () {
            return View::make('backend/slider/index');
        }));

        // slider
        Route::resource('slider', 'SliderController');
        Route::get('slider/{id}/delete', array('as'   => 'admin.slider.delete',  'uses' => 'SliderController@confirmDestroy'))->where('id', '[0-9]+');

        // file upload slider
        Route::post('/slider/upload/{id}', array('as'   => 'admin.slider.upload.image',  'uses' => 'SliderController@upload'))->where('id', '[0-9]+');
        Route::post('/slider-delete-image', array('as'   => 'admin.slider.delete.image', 'uses' => 'SliderController@deleteImage'));

        // menu-managment
        Route::resource('menu', 'MenuController');
        Route::post('menu/save', array('as' => 'admin.menu.save', 'uses' => 'MenuController@save'));
        Route::get('menu/{id}/delete', array('as'   => 'admin.menu.delete', 'uses' => 'MenuController@confirmDestroy'))->where('id', '[0-9]+');
        Route::post('menu/{id}/toggle-publish', array('as'   => 'admin.menu.toggle-publish', 'uses' => 'MenuController@togglePublish'))->where('id', '[0-9]+');

        // log
        Route::any('log', ['as' => 'admin.log', 'uses' => 'LogController@index']);

        // language
        Route::get('language/set-locale/{language}', array('as'   => 'admin.language.set', 'uses' => 'LanguageController@setLocale'));
    });
});
