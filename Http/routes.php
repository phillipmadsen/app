<?php

/*
|--------------------------------------------------------------------------
| Frontend Routes
|--------------------------------------------------------------------------
*/

// Route::get('users/{user}', function (AppUser $user) {
//     return $user;
// })


 Route::get('routes', function () {
    \Artisan::call('route:list');
    return '<pre>' . \Artisan::output() . '</pre>';

 });

    Route::get('/r', function () {


        function philsroutes()
        {
            $routeCollection = Route::getRoutes();

            echo "<table style='width:100%'>";
            echo "<tr>";
            echo "<td width='10%'><h4>HTTP Method</h4></td>";
            echo "<td width='10%'><h4>Route</h4></td>";
            echo "<td width='80%'><h4>Corresponding Action</h4></td>";
            echo "</tr>";
            foreach ($routeCollection as $value) {
                echo "<tr>";
                echo "<td>" . $value->getMethods()[0] . "</td>";
                echo "<td><a href='" . $value->getPath() . "' target='_blank'>" . $value->getPath() . "</a> </td>";
                echo "<td>" . $value->getActionName() . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        }


        return philsroutes();

    });

    Route::pattern('slug', '[a-z0-9- _]+');

    Route::model('blog', 'App\Models\Article');



    # Error pages should be shown without requiring login
    Route::get('404', function () {
        return View('admin/404');
    });
    Route::get('500', function () {
        return View::make('admin/500');
    });

    # Lock screen
    Route::get('lockscreen', function () {
        return View::make('admin/lockscreen');
    });







 // Route::get('login', array('as' => 'login','uses' => 'FrontEndController@getLogin'));
 //    Route::post('login', 'FrontEndController@postLogin');
 //    Route::get('register', array('as' => 'register','uses' => 'FrontEndController@getRegister'));
 //    Route::post('register', 'FrontEndController@postRegister');
 //    Route::get('activate/{userId}/{activationCode}', array('as' =>'activate','uses'=>'FrontEndController@getActivate'));
 //    Route::get('forgot-password', array('as' => 'forgot-password','uses' => 'FrontEndController@getForgotPassword'));
 //    Route::post('forgot-password', 'FrontEndController@postForgotPassword');


    $languages = LaravelLocalization::getSupportedLocales();
    foreach ($languages as $language => $values) {
        $supportedLocales[] = $language;
    }

    $locale = Request::segment(1);
    if (in_array($locale, $supportedLocales)) {
        LaravelLocalization::setLocale($locale);
        App::setLocale($locale);
    }

    Route::get('/', function () {

        return Redirect::to(LaravelLocalization::getCurrentLocale(), 302);
    });

    Route::group(array('prefix' => LaravelLocalization::getCurrentLocale(), 'before' => array('localization', 'before')), function () {

        Session::put('my.locale', LaravelLocalization::getCurrentLocale());

        // frontend dashboard
        Route::get('/', ['as' => 'dashboard', 'uses' => 'HomeController@index']);

        // article
        Route::get('/article', array('as' => 'dashboard.article', 'uses' => 'ArticleController@index'));
        Route::get('/article/{slug}', array('as' => 'dashboard.article.show', 'uses' => 'ArticleController@show'));

        // news
        Route::get('/news', array('as' => 'dashboard.news', 'uses' => 'NewsController@index'));
        Route::get('/news/{slug}', array('as' => 'dashboard.news.show', 'uses' => 'NewsController@show'));

        // tags
        Route::get('/tag/{slug}', array('as' => 'dashboard.tag', 'uses' => 'TagController@index'));

        // categories
        Route::get('/category/{slug}', array('as' => 'dashboard.category', 'uses' => 'CategoryController@index'));

        // page
        Route::get('/page', array('as' => 'dashboard.page', 'uses' => 'PageController@index'));
        Route::get('/page/{slug}', array('as' => 'dashboard.page.show', 'uses' => 'PageController@show'));

        // photo gallery
        Route::get('/photo-gallery/{slug}', array('as'   => 'dashboard.photo_gallery.show',
                                              'uses' => 'PhotoGalleryController@show'));

        // video
        Route::get('/video', array('as' => 'dashboard.video', 'uses' => 'VideoController@index'));
        Route::get('/video/{slug}', array('as' => 'dashboard.video.show', 'uses' => 'VideoController@show'));

        // projects
        Route::get('/project', array('as' => 'dashboard.project', 'uses' => 'ProjectController@index'));
        Route::get('/project/{slug}', array('as' => 'dashboard.project.show', 'uses' => 'ProjectController@show'));

        // contact
        Route::get('/contact', array('as' => 'dashboard.contact', 'uses' => 'FormPostController@getContact'));

        // faq
        Route::get('/faq', array('as' => 'dashboard.faq', 'uses' => 'FaqController@show'));

        // rss
        Route::get('/rss', array('as' => 'rss', 'uses' => 'RssController@index'));

        // search
        Route::get('/search', ['as' => 'admin.search', 'uses' => 'SearchController@index']);

        // language
        // Route::get('/set-locale/{language}', array('as' => 'language.set', 'uses' => 'LanguageController@setLocale'));

        // maillist
        Route::get('/save-maillist', array('as' => 'frontend.maillist', 'uses' => 'MaillistController@getMaillist'));
        Route::post('/save-maillist', array('as' => 'frontend.maillist.post', 'uses' => 'MaillistController@postMaillist'));
    });

/*
|--------------------------------------------------------------------------
| Backend Routes
|--------------------------------------------------------------------------
*/

// Route::post('/photos', '\PhpSoft\Photos\Controllers\PhotosController@upload');


    Route::group(array('prefix' => LaravelLocalization::getCurrentLocale()), function () {

        Route::group(array('prefix'    => '/admin', 'namespace' => 'Admin',  'middleware' => ['sentinel.auth', 'sentinel.permission']), function () {

            // admin dashboard
            Route::get('/', array('as' => 'admin.dashboard', 'uses' => 'DashboardController@index'));

            // user
            Route::resource('user', 'UserController');
            Route::get('user/{id}/profile', ['as' => 'profile', function ($id) {
                $url = route('profile', ['id' => 1]);
            }]);
            Route::get('user/{id}/delete', array('as'   => 'admin.user.delete',
                                             'uses' => 'UserController@confirmDestroy'))->where('id', '[0-9]+');

            // role
            Route::resource('role', 'RoleController');
            Route::get('role/{id}/delete', array('as'   => 'admin.role.delete',
                                              'uses' => 'RoleController@confirmDestroy'))->where('id', '[0-9]+');

            // blog
            Route::resource('article', 'ArticleController', array('before' => 'hasAccess:article'));
            Route::get('article/{id}/delete', array('as'   => 'admin.article.delete',
                                                'uses' => 'ArticleController@confirmDestroy'))->where('id', '\d+');

            // news
            Route::resource('news', 'NewsController', array('before' => 'hasAccess:news'));
            Route::get('news/{id}/delete', array('as'   => 'admin.news.delete',
                                             'uses' => 'NewsController@confirmDestroy'))->where('id', '[0-9]+');

            // category
            Route::resource('category', 'CategoryController', array('before' => 'hasAccess:category'));
            Route::get('category/{id}/delete', array('as'   => 'admin.category.delete',
                                                 'uses' => 'CategoryController@confirmDestroy'))->where('id', '[0-9]+');

            // faq
            Route::resource('faq', 'FaqController', array('before' => 'hasAccess:faq'));
            Route::get('faq/{id}/delete', array('as'   => 'admin.faq.delete',
                                            'uses' => 'FaqController@confirmDestroy'))->where('id', '[0-9]+');

            // project
            Route::resource('project', 'ProjectController');
            Route::get('project/{id}/delete', array('as'   => 'admin.project.delete',
                                                'uses' => 'ProjectController@confirmDestroy'))->where('id', '[0-9]+');

            // page
            Route::resource('page', 'PageController');
            Route::get('page/{id}/delete', array('as'   => 'admin.page.delete',
                                             'uses' => 'PageController@confirmDestroy'))->where('id', '[0-9]+');

            // photo gallery
            Route::resource('photo-gallery', 'PhotoGalleryController');
            Route::get('photo-gallery/{id}/delete', array('as'   => 'admin.photo-gallery.delete',
                                                      'uses' => 'PhotoGalleryController@confirmDestroy'))->where('id', '[0-9]+');

            // video
            Route::resource('video', 'VideoController');
            Route::get('video/{id}/delete', ['as'   => 'admin.video.delete', 'uses' =>
                'VideoController@confirmDestroy'])->where('id', '[0-9]+');
            Route::post('/video/get-video-detail', ['as'   => 'admin.video.detail', 'uses' =>
                'VideoController@getVideoDetail'])->where(
                    'id',
                    '[0-9]+'
                );

            // ajax - blog
                Route::post('article/{id}/toggle-publish', array('as'   => 'admin.article.toggle-publish',
                                                         'uses' => 'ArticleController@togglePublish'))->where('id', '[0-9]+');

            // ajax - news
                Route::post('news/{id}/toggle-publish', array('as'   => 'admin.news.toggle-publish',
                                                      'uses' => 'NewsController@togglePublish'))->where('id', '[0-9]+');

            // ajax - photo gallery
                Route::post('photo-gallery/{id}/toggle-publish', array('as'   => 'admin.photo_gallery.toggle-publish',
                                                               'uses' => 'PhotoGalleryController@togglePublish'))->where('id', '[0-9]+');
                Route::post('photo-gallery/{id}/toggle-menu', array('as'   => 'admin.photo_gallery.toggle-menu',
                                                            'uses' => 'PhotoGalleryController@toggleMenu'))->where('id', '[0-9]+');

            // ajax - page
                Route::post('page/{id}/toggle-publish', array('as'   => 'admin.page.toggle-publish',
                                                      'uses' => 'PageController@togglePublish'))->where('id', '[0-9]+');
                Route::post('page/{id}/toggle-menu', array('as'   => 'admin.page.toggle-menu',
                                                   'uses' => 'PageController@toggleMenu'))->where('id', '[0-9]+');

            // ajax - form post
                Route::post('form-post/{id}/toggle-answer', array('as'   => 'admin.form-post.toggle-answer',
                                                          'uses' => 'FormPostController@toggleAnswer'))->where('id', '[0-9]+');

            // file upload photo gallery
                Route::post('/photo-gallery/upload/{id}', array('as'   => 'admin.photo.gallery.upload.image',
                                                        'uses' => 'PhotoGalleryController@upload'))->where('id', '[0-9]+');
                Route::post('/photo-gallery-delete-image', array('as'   => 'admin.photo.gallery.delete.image',
                                                         'uses' => 'PhotoGalleryController@deleteImage'));

            // settings
                Route::get('/settings', array('as' => 'admin.settings', 'uses' => 'SettingController@index'));
                Route::post('/settings', array('as'   => 'admin.settings.save',
                                       'uses' => 'SettingController@save'), array('before' => 'csrf'));

            // form post
                Route::resource('form-post', 'FormPostController', array('only' => array('index', 'show', 'destroy')));
                Route::get('form-post/{id}/delete', array('as'   => 'admin.form-post.delete',
                                                  'uses' => 'FormPostController@confirmDestroy'))->where('id', '[0-9]+');

            // slider
                Route::get('/slider', array(
                'as' => 'admin.slider',
                function () {

                    return View::make('backend/slider/index');
                }));

        // slider
                Route::resource('slider', 'SliderController');
                Route::get('slider/{id}/delete', array('as'   => 'admin.slider.delete',
                                               'uses' => 'SliderController@confirmDestroy'))->where('id', '[0-9]+');

        // file upload slider
                Route::post('/slider/upload/{id}', array('as'   => 'admin.slider.upload.image',
                                                 'uses' => 'SliderController@upload'))->where('id', '[0-9]+');
                Route::post('/slider-delete-image', array('as'   => 'admin.slider.delete.image',
                                                  'uses' => 'SliderController@deleteImage'));

        // menu-managment
                Route::resource('menu', 'MenuController');
                Route::post('menu/save', array('as' => 'admin.menu.save', 'uses' => 'MenuController@save'));
                Route::get('menu/{id}/delete', array('as'   => 'admin.menu.delete',
                                             'uses' => 'MenuController@confirmDestroy'))->where('id', '[0-9]+');
                Route::post('menu/{id}/toggle-publish', array('as'   => 'admin.menu.toggle-publish',
                                                      'uses' => 'MenuController@togglePublish'))->where('id', '[0-9]+');

        // log
                Route::any('log', ['as' => 'admin.log', 'uses' => 'LogController@index']);

        // language
                Route::get('language/set-locale/{language}', array('as'   => 'admin.language.set',
                                                           'uses' => 'LanguageController@setLocale'));
        });
    });

    Route::post('/contact', array('as'   => 'dashboard.contact.post', 'uses' => 'FormPostController@postContact'), array('before' => 'csrf'));


    Route::get('filemanager/show', function () {
        return View::make('backend/plugins/filemanager');

    })->before('sentinel.auth');


    Route::get('/admin/login', array('as' => 'admin.login', function () {
        return view('backend.auth.login');

    }));
    // Route::group(array('namespace' => 'Admin'), function () {

    //     // admin auth
    //     Route::get('admin/logout', array('as' => 'admin.logout', 'uses' => 'AuthController@getLogout'));
    //     Route::get('admin/login', array('as' => 'admin.login', 'uses' => 'AuthController@getLogin'));
    //     Route::post('admin/login', array('as' => 'admin.login.post', 'uses' => 'AuthController@postLogin'));

    //     // admin password reminder
    //     Route::get('admin/forgot-password', array('as'   => 'admin.forgot.password', 'uses' => 'AuthController@getForgotPassword'));
    //     Route::post('admin/forgot-password', array('as'   => 'admin.forgot.password.post', 'uses' => 'AuthController@postForgotPassword'));
    //     Route::get('admin/{id}/reset/{code}', array('as'   => 'admin.reset.password', 'uses' => 'AuthController@getResetPassword'))->where('id', '[0-9]+');
    //     Route::post('admin/reset-password', array('as'   => 'admin.reset.password.post', 'uses' => 'AuthController@postResetPassword'));


    // });





# My account display and update details
    // Route::group(array('prefix' => 'secure', 'namespace' => 'Secure',  'middleware' => ['sentinel.auth', 'sentinel.permission']), function () {
    //     Route::get('my-account', ['as' => 'my-account', 'uses' => 'LivePageController@myAccount']);
    //     Route::post('my-account', 'LivePageController@updateAccount');
    // });





/*
 *   frontend views
 */

    // Route::get('/', array('as' => 'home', function () {
    //     return View::make('index');
    // }));





/*
|--------------------------------------------------------------------------
| General Routes
|--------------------------------------------------------------------------
*/

// error


// 404 page not found
#frontend views
    Route::get('/', array('as' => 'home', function () {
        return View::make('frontend.index');
    }));







        Route::group(array('prefix' => '/sewing-machines/qnique'), function () {
            Route::get('comparison', array('as' => 'live.pages.qnique.comparison', 'uses' => 'LivePageController@comparison'));
            Route::get('/', array('as' => 'live.pages.qnique.qnique', 'uses' => 'LivePageController@qnique'));
            Route::get('/features', array('as' => 'live.pages.qnique.features', 'uses' => 'LivePageController@qniquefeatures'));
            Route::get('/specs', array('as' => 'live.pages.qnique.specs', 'uses' => 'LivePageController@qniquespecs'));
            Route::get('/accessories', array('as' => 'live.pages.qnique.accessories', 'uses' => 'LivePageController@qniqueaccessories'));

        });



        Route::group(array('prefix' => '/automated/qct'), function () {
            Route::get('/', array('as' => 'qct', 'uses' => 'LivePageController@qct'));
            Route::get('/qct-features', array('as' => 'live.pages.qct.feature-list', 'uses' => 'LivePageController@qctfeatures'));
            Route::get('/qct-specs', array('as' => 'live.pages.qct.qct-specs', 'uses' => 'LivePageController@qctspecs'));
            Route::get('/qct-purchase', array('as' => 'live.pages.qct.qct-purchase', 'uses' => 'LivePageController@qctpurchase'));
            Route::get('/qct-support', array('as' => 'live.pages.qct.qct-support', 'uses' => 'LivePageController@qctsupport'));
        });


        Route::group(array('prefix' => '/machine-frames'), function () {
            Route::get('/', array('as' => 'live.pages.machine-frames.machine', 'uses' => 'LivePageController@machine'));
            Route::get('/gq-frame', array('as' => 'live.pages.machine-frames.gq-frame', 'uses' => 'LivePageController@gqframe'));
            Route::get('/compare-machine-frames', array('as' => 'live.pages.machine-frames.compare-machine-frames', 'uses' => 'LivePageController@compareMachineFrames'));
        });



        Route::group(array('prefix' => '/hand-quilting'), function () {
            Route::get('/', array('as' => 'live.pages.hand-quilting.handquilting', 'uses' => 'LivePageController@handquilting'));
            Route::get('/z44-frame', array('as' => 'live.pages.hand-quilting.z44-frame', 'uses' => 'LivePageController@z44frame'));
            Route::get('/start-right-ez3', array('as' => 'live.pages.hand-quilting.start-right-ez3', 'uses' => 'LivePageController@startrightez3'));
            Route::get('/grace-hoop-2', array('as' => 'live.pages.hand-quilting.grace-hoop-2', 'uses' => 'LivePageController@gracehoop2'));
            Route::get('/grace-lap-hoops', array('as' => 'live.pages.hand-quilting.grace-lap-hoops', 'uses' => 'LivePageController@gracelaphoops'));
            Route::get('/graciebee', array('as' => 'live.pages.hand-quilting.graciebee', 'uses' => 'LivePageController@graciebee'));
            Route::get('/accessories', array('as' => 'live.pages.hand-quilting.accessories', 'uses' => 'LivePageController@accessories'));
            Route::get('/compare-frames', array('as' => 'live.pages.hand-quilting.compare-frames', 'uses' => 'LivePageController@comparehandframes'));

        });





        Route::get('categories', '\PhpSoft\ShoppingCart\Controllers\CategoryController@index');
        Route::get('categories/{id}', '\PhpSoft\ShoppingCart\Controllers\CategoryController@show');
        Route::group(['middleware'=>'auth'], function () {

            Route::post('categories', [
            'middleware' => 'permission:create-category',
            'uses' => '\PhpSoft\ShoppingCart\Controllers\CategoryController@store'
            ]);
            Route::put('categories/{id}', [
            'middleware' => 'permission:update-category',
            'uses' => '\PhpSoft\ShoppingCart\Controllers\CategoryController@update'
            ]);
            Route::delete('categories/{id}', [
            'middleware' => 'permission:delete-category',
            'uses' => '\PhpSoft\ShoppingCart\Controllers\CategoryController@destroy'
            ]);
        });

        Route::get('categories/{id}/products', '\PhpSoft\ShoppingCart\Controllers\ProductController@index');


        Route::get('products', '\PhpSoft\ShoppingCart\Controllers\ProductController@index');
        Route::get('products/{id}', '\PhpSoft\ShoppingCart\Controllers\ProductController@show');

        Route::group(['middleware'=>'auth'], function () {

            Route::post('products', [
            'middleware' => 'permission:create-product',
            'uses' => '\PhpSoft\ShoppingCart\Controllers\ProductController@store'
            ]);
            Route::put('products/{id}', [
            'middleware' => 'permission:update-product',
            'uses' => '\PhpSoft\ShoppingCart\Controllers\ProductController@update'
            ]);
            Route::delete('products/{id}', [
            'middleware' => 'permission:delete-product',
            'uses' => '\PhpSoft\ShoppingCart\Controllers\ProductController@destroy'
            ]);
        });
