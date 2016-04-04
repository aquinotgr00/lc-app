<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

// Authentication routes...
Route::get( 'auth/login',               ['as' => 'login',                   'uses' => 'Auth\AuthController@getLogin']);
Route::post('auth/login',               ['as' => 'loginPost',               'uses' => 'Auth\AuthController@postLogin']);
Route::get( 'auth/logout',              ['as' => 'logout',                  'uses' => 'Auth\AuthController@getLogout']);
// Registration routes...
Route::get( 'auth/register',            ['as' => 'register',                'uses' => 'Auth\AuthController@getRegister']);
Route::post('auth/register',            ['as' => 'registerPost',            'uses' => 'Auth\AuthController@postRegister']);
// Password reset link request routes...
Route::get( 'password/email',           ['as' => 'recover_password',        'uses' => 'Auth\PasswordController@getEmail']);
Route::post('password/email',           ['as' => 'recover_passwordPost',    'uses' => 'Auth\PasswordController@postEmail']);
// Password reset routes...
Route::get( 'password/reset/{token}',   ['as' => 'reset_password',          'uses' => 'Auth\PasswordController@getReset']);
Route::post('password/reset',           ['as' => 'reset_passwordPost',      'uses' => 'Auth\PasswordController@postReset']);
// Registration terms
Route::get( 'faust',                    ['as' => 'faust',                   'uses' => 'FaustController@index']);

// Application routes...
Route::get( '/',       ['as' => 'backslash',   'uses' => 'HomeController@index']);
Route::get( 'home',    ['as' => 'home',        'uses' => 'HomeController@index']);
Route::get( 'welcome', ['as' => 'welcome',     'uses' => 'HomeController@welcome']);

// Routes in this group must be authorized.
Route::group(['middleware' => 'authorize'], function () {
    // Application routes...
    Route::get( 'dashboard', ['as' => 'dashboard', 'uses' => 'DashboardController@index']);

    // Site administration section
    Route::group(['prefix' => 'admin'], function () {
        // Expedition routes
        Route::get(   'expeditions',                   ['as' => 'admin.expeditions.index',      'uses' => 'ExpeditionsController@index']);
        Route::post(  'expeditions',                   ['as' => 'admin.expeditions.store',      'uses' => 'ExpeditionsController@store']);
        Route::get(   'expeditions/create',            ['as' => 'admin.expeditions.create',     'uses' => 'ExpeditionsController@create']);
        Route::get(   'expeditions/search',            ['as' => 'admin.expeditions.search',     'uses' => 'ExpeditionsController@search']);
        Route::get(   'expeditions/{exId}',            ['as' => 'admin.expeditions.show',       'uses' => 'ExpeditionsController@show']);
        Route::patch( 'expeditions/{exId}',            ['as' => 'admin.expeditions.update',     'uses' => 'ExpeditionsController@update']);
        Route::get(   'expeditions/{exId}/edit',       ['as' => 'admin.expeditions.edit',       'uses' => 'ExpeditionsController@edit']);
        Route::get(   'expeditions/{exId}/delete',        ['as' => 'admin.expeditions.destroy',    'uses' => 'ExpeditionsController@destroy']);
        Route::get(   'expeditions/{exId}/confirm-delete', ['as' => 'admin.expeditions.confirm-delete', 'uses' => 'ExpeditionsController@getModalDelete']);
        // Product routes
        Route::post(  'products',                      ['as' => 'admin.products.store',      'uses' => 'ProductsController@store']);
        Route::get(   'products/cat/{catId}',          ['as' => 'admin.products.index',      'uses' => 'ProductsController@index']);
        Route::get(   'products/create',               ['as' => 'admin.products.create',     'uses' => 'ProductsController@create']);
        Route::get(   'products/getInfo',              ['as' => 'admin.products.get-info',   'uses' => 'ProductsController@getInfo']);
        Route::get(   'products/{proId}',              ['as' => 'admin.products.show',       'uses' => 'ProductsController@show']);
        Route::patch( 'products/{proId}',              ['as' => 'admin.products.update',     'uses' => 'ProductsController@update']);
        Route::get(   'products/{proId}/edit',         ['as' => 'admin.products.edit',       'uses' => 'ProductsController@edit']);
        Route::get(   'products/{proId}/delete',       ['as' => 'admin.products.destroy',    'uses' => 'ProductsController@destroy']);
        Route::get(   'products/{proId}/confirm-delete', ['as' => 'admin.products.confirm-delete', 'uses' => 'ProductsController@getModalDelete']);
        // Supplier routes
        Route::get(   'suppliers',                     ['as' => 'admin.suppliers.index',      'uses' => 'SuppliersController@index']);
        Route::post(  'suppliers',                     ['as' => 'admin.suppliers.store',      'uses' => 'SuppliersController@store']);
        Route::get(   'suppliers/create',              ['as' => 'admin.suppliers.create',     'uses' => 'SuppliersController@create']);
        Route::get(   'suppliers/search',              ['as' => 'admin.suppliers.search',     'uses' => 'SuppliersController@search']);
        Route::get(   'suppliers/{suppId}',            ['as' => 'admin.suppliers.show',       'uses' => 'SuppliersController@show']);
        Route::patch( 'suppliers/{suppId}',            ['as' => 'admin.suppliers.update',     'uses' => 'SuppliersController@update']);
        Route::get(   'suppliers/{suppId}/edit',       ['as' => 'admin.suppliers.edit',       'uses' => 'SuppliersController@edit']);
        Route::get(   'suppliers/{suppId}/delete',     ['as' => 'admin.suppliers.destroy',    'uses' => 'SuppliersController@destroy']);
        Route::get(   'suppliers/{suppId}/confirm-delete', ['as' => 'admin.suppliers.confirm-delete', 'uses' => 'SuppliersController@getModalDelete']);
        //======================================================================================================================/
        // User routes
        Route::post(  'users/enableSelected',          ['as' => 'admin.users.enable-selected',  'uses' => 'UsersController@enableSelected']);
        Route::post(  'users/disableSelected',         ['as' => 'admin.users.disable-selected', 'uses' => 'UsersController@disableSelected']);
        Route::get(   'users/search',                  ['as' => 'admin.users.search',           'uses' => 'UsersController@searchByName']);
        Route::get(   'users/list',                    ['as' => 'admin.users.list',             'uses' => 'UsersController@listByPage']);
        Route::post(  'users/getInfo',                 ['as' => 'admin.users.get-info',         'uses' => 'UsersController@getInfo']);
        Route::post(  'users',                         ['as' => 'admin.users.store',            'uses' => 'UsersController@store']);
        Route::get(   'users',                         ['as' => 'admin.users.index',            'uses' => 'UsersController@index']);
        Route::get(   'users/create',                  ['as' => 'admin.users.create',           'uses' => 'UsersController@create']);
        Route::get(   'users/{userId}',                ['as' => 'admin.users.show',             'uses' => 'UsersController@show']);
        Route::patch( 'users/{userId}',                ['as' => 'admin.users.patch',            'uses' => 'UsersController@update']);
        Route::put(   'users/{userId}',                ['as' => 'admin.users.update',           'uses' => 'UsersController@update']);
        Route::delete('users/{userId}',                ['as' => 'admin.users.destroy',          'uses' => 'UsersController@destroy']);
        Route::get(   'users/{userId}/edit',           ['as' => 'admin.users.edit',             'uses' => 'UsersController@edit']);
        Route::get(   'users/{userId}/confirm-delete', ['as' => 'admin.users.confirm-delete',   'uses' => 'UsersController@getModalDelete']);
        Route::get(   'users/{userId}/delete',         ['as' => 'admin.users.delete',           'uses' => 'UsersController@destroy']);
        Route::get(   'users/{userId}/enable',         ['as' => 'admin.users.enable',           'uses' => 'UsersController@enable']);
        Route::get(   'users/{userId}/disable',        ['as' => 'admin.users.disable',          'uses' => 'UsersController@disable']);
        Route::get(   'users/{userId}/replayEdit',     ['as' => 'admin.users.replay-edit',      'uses' => 'UsersController@replayEdit']);
        // Role routes
        Route::post(  'roles/enableSelected',          ['as' => 'admin.roles.enable-selected',  'uses' => 'RolesController@enableSelected']);
        Route::post(  'roles/disableSelected',         ['as' => 'admin.roles.disable-selected', 'uses' => 'RolesController@disableSelected']);
        Route::get(   'roles/search',                  ['as' => 'admin.roles.search',           'uses' => 'RolesController@searchByName']);
        Route::post(  'roles/getInfo',                 ['as' => 'admin.roles.get-info',         'uses' => 'RolesController@getInfo']);
        Route::post(  'roles',                         ['as' => 'admin.roles.store',            'uses' => 'RolesController@store']);
        Route::get(   'roles',                         ['as' => 'admin.roles.index',            'uses' => 'RolesController@index']);
        Route::get(   'roles/create',                  ['as' => 'admin.roles.create',           'uses' => 'RolesController@create']);
        Route::get(   'roles/{roleId}',                ['as' => 'admin.roles.show',             'uses' => 'RolesController@show']);
        Route::patch( 'roles/{roleId}',                ['as' => 'admin.roles.patch',            'uses' => 'RolesController@update']);
        Route::put(   'roles/{roleId}',                ['as' => 'admin.roles.update',           'uses' => 'RolesController@update']);
        Route::delete('roles/{roleId}',                ['as' => 'admin.roles.destroy',          'uses' => 'RolesController@destroy']);
        Route::get(   'roles/{roleId}/edit',           ['as' => 'admin.roles.edit',             'uses' => 'RolesController@edit']);
        Route::get(   'roles/{roleId}/confirm-delete', ['as' => 'admin.roles.confirm-delete',   'uses' => 'RolesController@getModalDelete']);
        Route::get(   'roles/{roleId}/delete',         ['as' => 'admin.roles.delete',           'uses' => 'RolesController@destroy']);
        Route::get(   'roles/{roleId}/enable',         ['as' => 'admin.roles.enable',           'uses' => 'RolesController@enable']);
        Route::get(   'roles/{roleId}/disable',        ['as' => 'admin.roles.disable',          'uses' => 'RolesController@disable']);
        // Menu routes
        Route::post(  'menus',                         ['as' => 'admin.menus.save',             'uses' => 'MenusController@save']);
        Route::get(   'menus',                         ['as' => 'admin.menus.index',            'uses' => 'MenusController@index']);
        Route::get(   'menus/getData/{menuId}',        ['as' => 'admin.menus.get-data',         'uses' => 'MenusController@getData']);
        Route::get(   'menus/{menuId}/confirm-delete', ['as' => 'admin.menus.confirm-delete',   'uses' => 'MenusController@getModalDelete']);
        Route::get(   'menus/{menuId}/delete',         ['as' => 'admin.menus.delete',           'uses' => 'MenusController@destroy']);
        // Modules routes
        Route::get(   'modules',                               ['as' => 'admin.modules.index',            'uses' => 'ModulesController@index']);
        Route::get(   'modules/{slug}/initialize',             ['as' => 'admin.modules.initialize',       'uses' => 'ModulesController@initialize']);
        Route::get(   'modules/{slug}/uninitialize',           ['as' => 'admin.modules.uninitialize',     'uses' => 'ModulesController@uninitialize']);
        Route::get(   'modules/{slug}/enable',                 ['as' => 'admin.modules.enable',           'uses' => 'ModulesController@enable']);
        Route::get(   'modules/{slug}/disable',                ['as' => 'admin.modules.disable',          'uses' => 'ModulesController@disable']);
        Route::post(  'modules/enableSelected',                ['as' => 'admin.modules.enable-selected',  'uses' => 'ModulesController@enableSelected']);
        Route::post(  'modules/disableSelected',               ['as' => 'admin.modules.disable-selected', 'uses' => 'ModulesController@disableSelected']);
        Route::get(   'modules/optimize',                      ['as' => 'admin.modules.optimize',         'uses' => 'ModulesController@optimize']);
        // Permission routes
        Route::get(   'permissions/generate',                      ['as' => 'admin.permissions.generate',         'uses' => 'PermissionsController@generate']);
        Route::post(  'permissions/enableSelected',                ['as' => 'admin.permissions.enable-selected',  'uses' => 'PermissionsController@enableSelected']);
        Route::post(  'permissions/disableSelected',               ['as' => 'admin.permissions.disable-selected', 'uses' => 'PermissionsController@disableSelected']);
        Route::post(  'permissions',                               ['as' => 'admin.permissions.store',            'uses' => 'PermissionsController@store']);
        Route::get(   'permissions',                               ['as' => 'admin.permissions.index',            'uses' => 'PermissionsController@index']);
        Route::get(   'permissions/create',                        ['as' => 'admin.permissions.create',           'uses' => 'PermissionsController@create']);
        Route::get(   'permissions/{permissionId}',                ['as' => 'admin.permissions.show',             'uses' => 'PermissionsController@show']);
        Route::patch( 'permissions/{permissionId}',                ['as' => 'admin.permissions.patch',            'uses' => 'PermissionsController@update']);
        Route::put(   'permissions/{permissionId}',                ['as' => 'admin.permissions.update',           'uses' => 'PermissionsController@update']);
        Route::delete('permissions/{permissionId}',                ['as' => 'admin.permissions.destroy',          'uses' => 'PermissionsController@destroy']);
        Route::get(   'permissions/{permissionId}/edit',           ['as' => 'admin.permissions.edit',             'uses' => 'PermissionsController@edit']);
        Route::get(   'permissions/{permissionId}/confirm-delete', ['as' => 'admin.permissions.confirm-delete',   'uses' => 'PermissionsController@getModalDelete']);
        Route::get(   'permissions/{permissionId}/delete',         ['as' => 'admin.permissions.delete',           'uses' => 'PermissionsController@destroy']);
        Route::get(   'permissions/{permissionId}/enable',         ['as' => 'admin.permissions.enable',           'uses' => 'PermissionsController@enable']);
        Route::get(   'permissions/{permissionId}/disable',        ['as' => 'admin.permissions.disable',          'uses' => 'PermissionsController@disable']);
        // Route routes
        Route::get(   'routes/load',                     ['as' => 'admin.routes.load',             'uses' => 'RoutesController@load']);
        Route::post(  'routes/enableSelected',           ['as' => 'admin.routes.enable-selected',  'uses' => 'RoutesController@enableSelected']);
        Route::post(  'routes/disableSelected',          ['as' => 'admin.routes.disable-selected', 'uses' => 'RoutesController@disableSelected']);
        Route::post(  'routes/savePerms',                ['as' => 'admin.routes.save-perms',       'uses' => 'RoutesController@savePerms']);
        Route::get(   'routes/search',                   ['as' => 'admin.routes.search',           'uses' => 'RoutesController@searchByName']);
        Route::post(  'routes/getInfo',                  ['as' => 'admin.routes.get-info',         'uses' => 'RoutesController@getInfo']);
        Route::post(  'routes',                          ['as' => 'admin.routes.store',            'uses' => 'RoutesController@store']);
        Route::get(   'routes',                          ['as' => 'admin.routes.index',            'uses' => 'RoutesController@index']);
        Route::get(   'routes/create',                   ['as' => 'admin.routes.create',           'uses' => 'RoutesController@create']);
        Route::get(   'routes/{routeId}',                ['as' => 'admin.routes.show',             'uses' => 'RoutesController@show']);
        Route::patch( 'routes/{routeId}',                ['as' => 'admin.routes.patch',            'uses' => 'RoutesController@update']);
        Route::put(   'routes/{routeId}',                ['as' => 'admin.routes.update',           'uses' => 'RoutesController@update']);
        Route::delete('routes/{routeId}',                ['as' => 'admin.routes.destroy',          'uses' => 'RoutesController@destroy']);
        Route::get(   'routes/{routeId}/edit',           ['as' => 'admin.routes.edit',             'uses' => 'RoutesController@edit']);
        Route::get(   'routes/{routeId}/confirm-delete', ['as' => 'admin.routes.confirm-delete',   'uses' => 'RoutesController@getModalDelete']);
        Route::get(   'routes/{routeId}/delete',         ['as' => 'admin.routes.delete',           'uses' => 'RoutesController@destroy']);
        Route::get(   'routes/{routeId}/enable',         ['as' => 'admin.routes.enable',           'uses' => 'RoutesController@enable']);
        Route::get(   'routes/{routeId}/disable',        ['as' => 'admin.routes.disable',          'uses' => 'RoutesController@disable']);
        // Audit routes
        Route::get( 'audit',                           ['as' => 'admin.audit.index',             'uses' => 'AuditsController@index']);
        Route::get( 'audit/purge',                     ['as' => 'admin.audit.purge',             'uses' => 'AuditsController@purge']);
        Route::get( 'audit/{auditId}/replay',          ['as' => 'admin.audit.replay',            'uses' => 'AuditsController@replay']);
        Route::get( 'audit/{auditId}/show',            ['as' => 'admin.audit.show',              'uses' => 'AuditsController@show']);
        // Settings routes
        // TODO: Implements settings
        Route::get('settings',                         ['as' => 'admin.settings.index',          'uses' => 'TestController@test_flash_warning']);

    }); // End of ADMIN group

    // TODO: Remove this before release...
    if ($this->app->environment('development')) {
        // TEST-ACL routes
        Route::group(['prefix' => 'test-acl'], function () {
            Route::get('home',                  ['as' => 'test-acl.home',                'uses' => 'TestController@test_acl_home']);
            Route::get('do-not-pre-load',       ['as' => 'test-acl.do-not-pre-load',     'uses' => 'TestController@test_acl_do_not_load']);
            Route::get('no-perm',               ['as' => 'test-acl.no-perm',             'uses' => 'TestController@test_acl_no_perm']);
            Route::get('basic-authenticated',   ['as' => 'test-acl.basic-authenticated', 'uses' => 'TestController@test_acl_basic_authenticated']);
            Route::get('guest-only',            ['as' => 'test-acl.guest-only',          'uses' => 'TestController@test_acl_guest_only']);
            Route::get('open-to-all',           ['as' => 'test-acl.open-to-all',         'uses' => 'TestController@test_acl_open_to_all']);
            Route::get('admins',                ['as' => 'test-acl.admins',              'uses' => 'TestController@test_acl_admins']);
            Route::get('power-users',           ['as' => 'test-acl.power-users',         'uses' => 'TestController@test_acl_power_users']);
        }); // End of TEST-ACL group

        // TEST-FLASH routes
        Route::group(['prefix' => 'test-flash'], function () {
            Route::get('home',    ['as' => 'test-flash.home',     'uses' => 'TestController@test_flash_home']);
            Route::get('success', ['as' => 'test-flash.success',  'uses' => 'TestController@test_flash_success']);
            Route::get('info',    ['as' => 'test-flash.info',     'uses' => 'TestController@test_flash_info']);
            Route::get('warning', ['as' => 'test-flash.warning',  'uses' => 'TestController@test_flash_warning']);
            Route::get('error',   ['as' => 'test-flash.error',    'uses' => 'TestController@test_flash_error']);
        }); // End of TEST-FLASH group
        // TEST-MENU routes
        Route::group(['prefix' => 'test-menus'], function () {
            Route::get('home',     ['as' => 'test-menus.home',  'uses' => 'TestMenusController@test_menu_home']);
            Route::get('one',      ['as' => 'test-menus.one',   'uses' => 'TestMenusController@test_menu_one']);
            Route::get('two',      ['as' => 'test-menus.two',   'uses' => 'TestMenusController@test_menu_two']);
            Route::get('two-a',    ['as' => 'test-menus.two-a', 'uses' => 'TestMenusController@test_menu_two_a']);
            Route::get('two-b',    ['as' => 'test-menus.two-b', 'uses' => 'TestMenusController@test_menu_two_b']);
            Route::get('three',    ['as' => 'test-menus.three', 'uses' => 'TestMenusController@test_menu_three']);
        }); // End of TEST-MENU group
    } // End of if DEV environment

    require __DIR__.'/rapyd.php';
}); // end of AUTHORIZE middleware group
