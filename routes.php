<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/




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
            echo "<td><a href='" . $value->getPath() . "' target='_blank'>" . $value->getPath() . "</a>	</td>";
            echo "<td>" . $value->getActionName() . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
    return philsroutes();
});


/**
 * Model binding into route
 */
Route::model('blogcategory', 'App\BlogCategory');
Route::model('blog', 'App\Blog');
Route::model('file', 'App\File');

Route::pattern('slug', '[a-z0-9- _]+');

Route::group(array('prefix' => 'admin'), function () {

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

	# All basic routes defined here
	Route::get('signin', array('as' => 'signin', 'uses' => 'AuthController@getSignin'));
	Route::post('signin', 'AuthController@postSignin');
	Route::post('signup', array('as' => 'signup', 'uses' => 'AuthController@postSignup'));
	Route::post('forgot-password', array('as' => 'forgot-password', 'uses' => 'AuthController@postForgotPassword'));
	Route::get('login2', function () {
		return View::make('admin/login2');
	});

	# Register2
	Route::get('register2', function () {
		return View::make('admin/register2');
	});
	Route::post('register2', array('as' => 'register2', 'uses' => 'AuthController@postRegister2'));

	# Forgot Password Confirmation
	Route::get('forgot-password/{userId}/{passwordResetCode}', array('as' => 'forgot-password-confirm', 'uses' => 'AuthController@getForgotPasswordConfirm'));
	Route::post('forgot-password/{userId}/{passwordResetCode}', 'AuthController@postForgotPasswordConfirm');

	# Logout
	Route::get('logout', array('as' => 'logout', 'uses' => 'AuthController@getLogout'));

	# Account Activation
	Route::get('activate/{userId}/{activationCode}', array('as' => 'activate', 'uses' => 'AuthController@getActivate'));
});

Route::group(array('prefix' => 'admin', 'middleware' => 'SentinelAdmin'), function () {
    # Dashboard / Index
	Route::get('/', array('as' => 'dashboard','uses' => 'JoshController@showHome'));



	# User Management
    Route::group(array('prefix' => 'users'), function () {
    	Route::get('/', array('as' => 'users', 'uses' => 'UsersController@getIndex'));
    	Route::get('create', array('as' => 'create/user', 'uses' => 'UsersController@getCreate'));
        Route::post('create', 'UsersController@postCreate');
        Route::get('{userId}/edit', array('as' => 'users.update', 'uses' => 'UsersController@getEdit'));
        Route::post('{userId}/edit', 'UsersController@postEdit');
    	Route::get('{userId}/delete', array('as' => 'delete/user', 'uses' => 'UsersController@getDelete'));
		Route::get('{userId}/confirm-delete', array('as' => 'confirm-delete/user', 'uses' => 'UsersController@getModalDelete'));
		Route::get('{userId}/restore', array('as' => 'restore/user', 'uses' => 'UsersController@getRestore'));
		Route::get('{userId}', array('as' => 'users.show', 'uses' => 'UsersController@show'));
	});
	Route::get('deleted_users',array('as' => 'deleted_users','before' => 'Sentinel', 'uses' => 'UsersController@getDeletedUsers'));

	# Group Management
    Route::group(array('prefix' => 'groups'), function () {
        Route::get('/', array('as' => 'groups', 'uses' => 'GroupsController@getIndex'));
        Route::get('create', array('as' => 'create/group', 'uses' => 'GroupsController@getCreate'));
        Route::post('create', 'GroupsController@postCreate');
        Route::get('{groupId}/edit', array('as' => 'update/group', 'uses' => 'GroupsController@getEdit'));
        Route::post('{groupId}/edit', 'GroupsController@postEdit');
        Route::get('{groupId}/delete', array('as' => 'delete/group', 'uses' => 'GroupsController@getDelete'));
        Route::get('{groupId}/confirm-delete', array('as' => 'confirm-delete/group', 'uses' => 'GroupsController@getModalDelete'));
        Route::get('{groupId}/restore', array('as' => 'restore/group', 'uses' => 'GroupsController@getRestore'));
    });
    /*routes for blog*/
	Route::group(array('prefix' => 'blog'), function () {
		Route::get('/', array('as' => 'blogs', 'uses' => 'BlogController@getIndex'));
		Route::get('create', array('as' => 'create/blog', 'uses' => 'BlogController@getCreate'));
		Route::post('create', 'BlogController@postCreate');
		Route::get('{blog}/edit', array('as' => 'update/blog', 'uses' => 'BlogController@getEdit'));
		Route::post('{blog}/edit', 'BlogController@postEdit');
		Route::get('{blog}/delete', array('as' => 'delete/blog', 'uses' => 'BlogController@getDelete'));
		Route::get('{blog}/confirm-delete', array('as' => 'confirm-delete/blog', 'uses' => 'BlogController@getModalDelete'));
		Route::get('{blog}/restore', array('as' => 'restore/blog', 'uses' => 'BlogController@getRestore'));
        Route::get('{blog}/show', array('as' => 'blog/show', 'uses' => 'BlogController@show'));
        Route::post('{blog}/storecomment', array('as' => 'restore/blog', 'uses' => 'BlogController@storecomment'));
	});

    /*routes for blog category*/
	Route::group(array('prefix' => 'blogcategory'), function () {
		Route::get('/', array('as' => 'blogcategories', 'uses' => 'BlogCategoryController@getIndex'));
		Route::get('create', array('as' => 'create/blogcategory', 'uses' => 'BlogCategoryController@getCreate'));
		Route::post('create', 'BlogCategoryController@postCreate');
		Route::get('{blogcategory}/edit', array('as' => 'update/blogcategory', 'uses' => 'BlogCategoryController@getEdit'));
		Route::post('{blogcategory}/edit', 'BlogCategoryController@postEdit');
		Route::get('{blogcategory}/delete', array('as' => 'delete/blogcategory', 'uses' => 'BlogCategoryController@getDelete'));
		Route::get('{blogcategory}/confirm-delete', array('as' => 'confirm-delete/blogcategory', 'uses' => 'BlogCategoryController@getModalDelete'));
		Route::get('{blogcategory}/restore', array('as' => 'restore/blogcategory', 'uses' => 'BlogCategoryController@getRestore'));
	});

	/*routes for file*/
	Route::group(array('prefix' => 'file'), function () {
		Route::post('create', 'FileController@postCreate');
		Route::post('createmulti', 'FileController@postFilesCreate');
		Route::delete('delete', 'FileController@delete');
	});

	Route::get('crop_demo', function () {
        return redirect('admin/imagecropping');
    });
    Route::post('crop_demo','JoshController@crop_demo');

	/* laravel example routes */
	# datatables
	Route::get('datatables', 'DataTablesController@index');
	Route::get('datatables/data', array('as' => 'admin.datatables.data', 'uses' => 'DataTablesController@data'));

	# Remaining pages will be called from below controller method
	# in real world scenario, you may be required to define all routes manually

	Route::get('{name?}', 'JoshController@showView');

});

#FrontEndController
Route::get('login', array('as' => 'login','uses' => 'FrontEndController@getLogin'));
Route::post('login','FrontEndController@postLogin');
Route::get('register', array('as' => 'register','uses' => 'FrontEndController@getRegister'));
Route::post('register','FrontEndController@postRegister');
Route::get('activate/{userId}/{activationCode}',array('as' =>'activate','uses'=>'FrontEndController@getActivate'));
Route::get('forgot-password',array('as' => 'forgot-password','uses' => 'FrontEndController@getForgotPassword'));
Route::post('forgot-password','FrontEndController@postForgotPassword');
# Forgot Password Confirmation
Route::get('forgot-password/{userId}/{passwordResetCode}', array('as' => 'forgot-password-confirm', 'uses' => 'FrontEndController@getForgotPasswordConfirm'));
Route::post('forgot-password/{userId}/{passwordResetCode}', 'FrontEndController@postForgotPasswordConfirm');
# My account display and update details
Route::group(array('middleware' => 'SentinelUser'), function () {
	Route::get('my-account', array('as' => 'my-account', 'uses' => 'FrontEndController@myAccount'));
	Route::post('my-account', 'FrontEndController@updateAccount');
});
Route::get('logout', array('as' => 'logout','uses' => 'FrontEndController@getLogout'));
# contact form
Route::post('contact',array('as' => 'contact','uses' => 'FrontEndController@postContact'));

#frontend views
Route::get('/', array('as' => 'home', function () {
    return View::make('index');
}));

Route::get('live', array('as' => 'live', function () {
    return View::make('live');
}));

Route::get('blog', array('as' => 'blog', 'uses' => 'BlogController@getIndexFrontend'));
Route::get('blog/{slug}/tag', 'BlogController@getBlogTagFrontend');
Route::get('blogitem/{slug?}', 'BlogController@getBlogFrontend');
Route::post('blogitem/{blog}/comment', 'BlogController@storeCommentFrontend');

Route::get('{name?}', 'JoshController@showFrontEndView');
# End of frontend views
# 
# 
Route::get('/myitems/{filter?}', 
    ['as' => 'myitems.list', 'uses' => 'ItemController@myitems']
);

   // Route::post('profiles/new', function(){
   //      $user = User::create([
   //          'username'=>Input::get('username'),
   //          'name'=>Input::get('name')
   //      ]);
   //      $profile = new Profile([
   //          'first_name' => Input::get('first_name'),
   //          'last_name' => Input::get('last_name')
   //      ]);
   //      $user->profile()->save();
   //  });
    


/*
|--------------------------------------------------------------------------
| API routes
|--------------------------------------------------------------------------
*/

Route::group(['prefix' => 'api', 'namespace' => 'API'], function ()
{
	Route::group(['prefix' => 'v1'], function ()
	{
        require Config::get('generator.path_api_routes');
	});
});
