<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// routes/web.php

/*
    |----------------------------------------------------
    | CHECK IF SITE IS TRANSLATED
    |----------------------------------------------------
    */



Route::group(['prefix' => LaravelLocalization::setLocale()], function () {

    /* GENERAL */

    Route::get('/', 'App\Http\Controllers\FrontendController@index')->name('home');
    Route::get('/oops', 'App\Http\Controllers\FrontendController@oops')->name('oops');
    //verification link
     Route::get('user/verify/link', 'App\Http\Controllers\Auth\VerificationController@verify_page')->name('user.verify');
     Route::get('user/verify/{userid}/{token}', 'App\Http\Controllers\Auth\VerificationController@verify')->name('user.verify.link');
     Route::post('user/verify/resend', 'App\Http\Controllers\Auth\VerificationController@verify_resend')->name('user.verify.resend');
    /*
    |----------------------------------------------------
    | Begin POSTS 
    |----------------------------------------------------
    */
    Route::group(['namespace' => 'App\Http\Controllers'], function () {
        Route::get('/pages/{slug}', 'FrontendController@show_page')->name('pages');
        Route::get('/page/{slug}', 'FrontendController@show_single_post')->name('page');
        Route::get('/blog', 'FrontendController@show_posts')->name('blog');
        Route::get('/blog/{slug}', 'FrontendController@show_single_post')->name('blog.post');
        Route::get('/tracking', 'ShipmentController@tracking')->name('tracking');
        Route::get('/contact-us', 'FrontendController@contact')->name('contact');
        Route::post('/contact-us', 'FrontendController@contact_submit')->name('contact');
        Route::get('/get-quote', 'FrontendController@quote')->name('quote');
        Route::post('/get-quote', 'FrontendController@quote_submit')->name('quote');

        Route::get('/shippo', 'FrontendController@createShipment')->name('shippo');

        // new fetch locations -  guest
        Route::get('/address/getstates/{id}', 'App\Http\Controllers\AddressController@getStates')->name('address.getstates');
        Route::get('/address/getcity/{id}', 'App\Http\Controllers\AddressController@getCity')->name('address.getCity');
        Route::get('/address/getarea/{id}', 'App\Http\Controllers\AddressController@getArea')->name('address.getArea');
        Route::post('/shipping/rates', 'App\Http\Controllers\ShipmentController@get_rates')->name('shipping.rates');
    });



    /*
    |----------------------------------------------------
    | Begin AUTH 
    |----------------------------------------------------
    */
    Route::group(['middleware' => ['guest']], function () {

        Route::group(['namespace' => 'App\Http\Controllers\Auth'], function () {
            //Login Routes
            Route::get('/login', 'LoginController@show')->name('login');
            Route::post('/login', 'LoginController@login')->name('login.perform');

            //Register Routes
            Route::get('/register', 'RegisterController@show')->name('register');
            Route::post('/register', 'RegisterController@register')->name('register.perform');

            // password resets link
            Route::get('forget-password', 'ForgotPasswordController@showForgetPasswordForm')->name('forget.password.get');
            Route::post('forget-password', 'ForgotPasswordController@submitForgetPasswordForm')->name('forget.password.post');
            Route::get('reset-password/{token}', 'ForgotPasswordController@showResetPasswordForm')->name('reset.password.get');
            Route::post('reset-password', 'ForgotPasswordController@submitResetPasswordForm')->name('reset.password.post');

            

        });
    });

    Route::group(['middleware' => ['auth']], function () {

        /**
         * Logout Routes
         */
        Route::get('/logout', 'App\Http\Controllers\Auth\LoginController@logout')->name('logout');
    });
    //});


    /*
    |----------------------------------------------------
    | Begin Dashboard 
    |----------------------------------------------------
   */
    Route::group(['middleware' => ['auth']], function () {
        Route::group(['prefix' => 'dashboard', 'as' => 'dashboard.'], function () {
            Route::get('/', 'App\Http\Controllers\DashboardController@dashboard')->name('index');

            //Settings routes
            Route::get('/settings/{type}', 'App\Http\Controllers\Settings\SettingsController@index')->name('settings');
            Route::post('/settings/{type}', 'App\Http\Controllers\Settings\SettingsController@update')->name('settings.update');
            Route::post('/system/update', 'App\Http\Controllers\Settings\SettingsController@update_system')->name('system.update');
            Route::get('/payment/settings', 'App\Http\Controllers\Settings\SettingsController@payment_method')->name('settings.payment');
            Route::post('/payment/settings/{id}', 'App\Http\Controllers\Settings\SettingsController@update_payment_method')->name('payment.update');

            Route::get('/locales/settings', 'App\Http\Controllers\Settings\LanguageController@show')->name('settings.languages');
            Route::post('/locales/settings/setlocale', 'App\Http\Controllers\Settings\LanguageController@setlocale')->name('languages.setlocale');
            Route::post('/locales/settings/update/{id}', 'App\Http\Controllers\Settings\LanguageController@update')->name('languages.update');
            Route::post('/locales/settings/create', 'App\Http\Controllers\Settings\LanguageController@create')->name('languages.create');
            Route::get('/locales/settings/delete/{id}', 'App\Http\Controllers\Settings\LanguageController@delete')->name('languages.delete');

            //shipment settings route
            Route::get('/settings/shipments', 'App\Http\Controllers\Settings\ShipmentSettingsController@settings')->name('shipments.settings');
            Route::get('/settings/shipments/cost', 'App\Http\Controllers\Settings\ShipmentSettingController@cost_show')->name('shipments.cost');
            Route::get('/settings/shipments/cost/datatable', 'App\Http\Controllers\Settings\ShipmentSettingController@cost_datatable')->name('cost.shipments.datatable');
            Route::get('/settings/shipments/cost/add', 'App\Http\Controllers\Settings\ShipmentSettingController@cost_add')->name('shipments.cost.add');
            Route::post('/settings/shipments/cost/add', 'App\Http\Controllers\Settings\ShipmentSettingController@cost_create')->name('shipments.cost.store');
            Route::get('/settings/shipments/cost/edit/{id}', 'App\Http\Controllers\Settings\ShipmentSettingController@cost_edit')->name('shipments.cost.edit');
            Route::post('/settings/shipments/cost/edit/{id}', 'App\Http\Controllers\Settings\ShipmentSettingController@cost_update')->name('shipments.cost.update');
            Route::post('/settings/shipments/cost/set', 'App\Http\Controllers\Settings\ShipmentSettingController@set_cost')->name('shipments.cost.set');
            Route::get('/settings/shipments/cost/delete/{id}', 'App\Http\Controllers\Settings\ShipmentSettingController@cost_delete')->name('shipments.cost.delete');
            Route::get('/settings/shipments/invoices', 'App\Http\Controllers\Settings\ShipmentSettingController@invoice')->name('shipments.invoices');
            Route::get('/settings/shipments/invoice/{id}', 'App\Http\Controllers\Settings\ShipmentSettingController@invoice_view')->name('shipments.invoice');
            Route::get('/shipments/invoice/pay/{id}', 'App\Http\Controllers\Settings\ShipmentSettingController@invoice_pay')->name('shipments.invoice.pay');
            Route::get('/shipments/settings', 'App\Http\Controllers\Settings\ShipmentSettingController@settings')->name('shipments.settings');
            Route::post('/shipments/settings', 'App\Http\Controllers\Settings\ShipmentSettingController@set_config')->name('shipments.settings.update');

            // Shipment routes
            Route::get('/shipments', 'App\Http\Controllers\ShipmentController@index')->name('shipments');
            Route::get('/shipments/filter/{status}', 'App\Http\Controllers\ShipmentController@index')->name('shipments.filter');
            Route::get('/shipments/datatable/{type}/{id}', 'App\Http\Controllers\ShipmentController@datatable')->name('shipments.datatable');
            Route::get('/shipments/create', 'App\Http\Controllers\ShipmentController@create')->name('shipments.create');
            Route::post('/shipments/create', 'App\Http\Controllers\ShipmentController@store')->name('shipments.store');
            Route::post('/shipments/getrates', 'App\Http\Controllers\ShipmentController@get_rates')->name('shipments.getcost');
            Route::get('/shipments/view/{id}', 'App\Http\Controllers\ShipmentController@view')->name('shipments.view');
            Route::get('/shipments/edit/{id}', 'App\Http\Controllers\ShipmentController@edit')->name('shipments.edit');
            Route::put('/shipments/edit/{id}', 'App\Http\Controllers\ShipmentController@update')->name('shipments.edit');
            Route::get('/shipments/print/{id}', 'App\Http\Controllers\ShipmentController@print')->name('print');
            Route::post('/shipments/updatelog/{id}', 'App\Http\Controllers\ShipmentController@updatelog')->name('updatelog');
            Route::get('/shipments/deletelog/{id}', 'App\Http\Controllers\ShipmentController@deletelog')->name('deletelog');
            Route::post('/shipments/updatepackage/{id}', 'App\Http\Controllers\ShipmentController@updatepackage')->name('updatepackage');
            Route::get('/shipments/deletepackage/{id}', 'App\Http\Controllers\ShipmentController@deletepackage')->name('deletepackage');
            Route::get('/shipments/delete/{id}', 'App\Http\Controllers\ShipmentController@delete')->name('shipments.delete');
            Route::get('/shipments/status/{id}', 'App\Http\Controllers\ShipmentController@status')->name('shipments.status');
            Route::get('/shipments/agents/{id}', 'App\Http\Controllers\ShipmentController@agent_list')->name('shipments.agent.list');
            Route::get('/shipments/agents/datatable/{country}', 'App\Http\Controllers\ShipmentController@agent_datatable')->name('shipments.agents.datatable');
            Route::get('/shipments/assign-agent/{id}/{agent}', 'App\Http\Controllers\ShipmentController@assign_agent')->name('shipments.assign.agent');

            //invoice route
            Route::get('/shipments/invoices', 'App\Http\Controllers\Settings\ShipmentSettingController@invoice_list')->name('shipments.invoices');
            Route::get('/shipments/invoices/datatable/{type}/{id}', 'App\Http\Controllers\Settings\ShipmentSettingController@invoice_datatable')->name('shipments.invoices.datatable');
            Route::get('/shipments/invoice/view/{id}', 'App\Http\Controllers\Settings\ShipmentSettingController@invoice_view')->name('shipments.invoice.view');
            Route::get('/shipments/invoice/edit/{id}', 'App\Http\Controllers\Settings\ShipmentSettingController@edit')->name('shipments.invoice.edit');
            Route::put('/shipments/invoice/edit/{id}', 'App\Http\Controllers\Settings\ShipmentSettingController@update')->name('update');
            Route::get('/shipments/invoice/label/{id}', 'App\Http\Controllers\Settings\ShipmentSettingController@invoice_label')->name('shipments.invoice.label');
            Route::get('/shipments/invoice/payment/{id}', 'App\Http\Controllers\PaymentController@index')->name('shipments.invoice.payment.process');
            Route::post('/shipments/invoice/payment/{id}', 'App\Http\Controllers\PaymentController@index')->name('shipments.invoice.payment.process');

            // orders
            Route::get('/shipments/orders', 'App\Http\Controllers\Settings\ShipmentSettingController@order_list')->name('shipments.orders');
            Route::get('/shipments/orders/datatable/{type}/{id}', 'App\Http\Controllers\Settings\ShipmentSettingController@orders_datatable')->name('shipments.orders.datatable');

            Route::get('/shipments/orders/status/{id}/{status}', 'App\Http\Controllers\Settings\ShipmentSettingController@order_status')->name('shipments.orders.status');


            //currency route
            Route::get('/currencies', 'App\Http\Controllers\Settings\CurrencyController@list')->name('currencies');
            Route::get('/currency/add/{type}', 'App\Http\Controllers\Settings\CurrencyController@add')->name('currency.add');
            Route::post('/currency/create/{type}', 'App\Http\Controllers\Settings\CurrencyController@create')->name('currencies.create');
            Route::get('/currency/edit/{type}/{id}', 'App\Http\Controllers\Settings\CurrencyController@edit')->name('currency.edit');
            Route::post('/currency/update/{type}/{id}', 'App\Http\Controllers\Settings\CurrencyController@update')->name('currency.update');
            Route::get('/currency/delete/{type}/{id}', 'App\Http\Controllers\Settings\CurrencyController@delete')->name('currency.delete');
            Route::post('/currency/setcurrency', 'App\Http\Controllers\Settings\CurrencyController@setcurrency')->name('currency.set');
            Route::get('/currencies/datatable', 'App\Http\Controllers\Settings\CurrencyController@datatable')->name('currencies.datatable');
            Route::get('/currencies/datatable/rates', 'App\Http\Controllers\Settings\CurrencyController@exchange_rates_datatable')->name('currencies.datatable.rates');



            //users route
            Route::get('/users/list/{user_type}/', 'App\Http\Controllers\UserController@list')->name('users');
            Route::get('/users/view/{id}', 'App\Http\Controllers\UserController@view')->name('users.view');
            Route::get('/users/add', 'App\Http\Controllers\UserController@add')->name('users.add');
            Route::post('/users/create', 'App\Http\Controllers\UserController@create')->name('users.create');
            Route::get('/users/edit/{id}', 'App\Http\Controllers\UserController@edit')->name('users.edit');
            Route::post('/users/update/{id}/{type}', 'App\Http\Controllers\UserController@update')->name('users.update');
            Route::get('/users/delete/{id}', 'App\Http\Controllers\UserController@delete')->name('users.delete');
            Route::get('/users/datatable/{user_type}', 'App\Http\Controllers\UserController@datatable')->name('users.datatable');
            Route::get('/users/update/{id}{value}', 'App\Http\Controllers\UserController@notice')->name('users.update.notice');
            Route::get('/users/notification', 'App\Http\Controllers\UserController@notification')->name('users.notification');
            Route::get('/users/notification/view/{id}', 'App\Http\Controllers\UserController@notification_view')->name('users.notification.view');
            Route::get('/users/notification/datatable', 'App\Http\Controllers\UserController@notification_datatable')->name('users.notification.datatable');
            Route::get('/users/notification/delete/{id}', 'App\Http\Controllers\UserController@notification_delete')->name('users.notification.delete');
            Route::get('/users/notify', 'App\Http\Controllers\UserController@notify')->name('users.notify');
            Route::get('/users/message/{id}', 'App\Http\Controllers\UserController@message')->name('users.message');
            Route::get('/users/search', 'App\Http\Controllers\UserController@search')->name('users.search');

            //Address route
            Route::get('/address', 'App\Http\Controllers\AddressController@list')->name('address');
            Route::post('/address/update/{id}', 'App\Http\Controllers\AddressController@update')->name('address.update');

            Route::get('/address/datatable/{type}/{id}', 'App\Http\Controllers\AddressController@datatable')->name('address.datatable');

            Route::get('/address/edit/{id}', 'App\Http\Controllers\AddressController@edit')->name('address.edit');
            Route::get('/address/add', 'App\Http\Controllers\AddressController@add')->name('address.add');
            Route::post('/address/create', 'App\Http\Controllers\AddressController@create')->name('address.create');
            Route::get('/address/delete/{id}', 'App\Http\Controllers\AddressController@delete')->name('address.delete');
            Route::get('/address/getstates/{id}', 'App\Http\Controllers\AddressController@getStates')->name('address.getstates');
            Route::get('/address/getcity/{id}', 'App\Http\Controllers\AddressController@getCity')->name('address.getCity');
            Route::get('/address/getarea/{id}', 'App\Http\Controllers\AddressController@getArea')->name('address.getArea');
            Route::get('/address/getbranch/{id}', 'App\Http\Controllers\AddressController@getBranch')->name('address.getBranch');
            Route::get('/address/getaddress/{type}/{id}', 'App\Http\Controllers\AddressController@getAddress')->name('address.getAddress');



            //Location route
            Route::get('/location/list/{type}', 'App\Http\Controllers\LocationController@list')->name('location.list');
            Route::get('/location/view/{type}/{id}', 'App\Http\Controllers\LocationController@view')->name('location.view');
            Route::post('/location/update/{type}/{id}', 'App\Http\Controllers\LocationController@update')->name('location.update');
            Route::get('/location/datatable/{type}', 'App\Http\Controllers\LocationController@datatable')->name('location.datatable');
            Route::get('/location/datatable/{type}/{id}', 'App\Http\Controllers\LocationController@datatable')->name('location.view.datatable');
            Route::get('/location/edit/{type}/{id}', 'App\Http\Controllers\LocationController@edit')->name('location.edit');
            Route::get('/location/add/{type}', 'App\Http\Controllers\LocationController@add')->name('location.add');
            Route::post('/location/create/{type}', 'App\Http\Controllers\LocationController@create')->name('location.create');
            Route::get('/location/delete/{type}/{id}', 'App\Http\Controllers\LocationController@delete')->name('location.delete');
            Route::get('/location/getstates/{id}', 'App\Http\Controllers\LocationController@getStates')->name('location.getstates');
            Route::get('/location/getcity/{id}', 'App\Http\Controllers\LocationController@getCity')->name('location.getCity');
            Route::get('/location/getarea/{id}', 'App\Http\Controllers\LocationController@getArea')->name('location.getArea');

            //Covered Areas route
            Route::get('/areas/list', 'App\Http\Controllers\AreasController@areas')->name('areas');
            Route::get('/area/view/{id}', 'App\Http\Controllers\AreasController@area_view')->name('area.view');
            Route::post('/area/update/{id}', 'App\Http\Controllers\AreasController@update')->name('area.update');
            Route::get('/area/datatable/{id}', 'App\Http\Controllers\AreasController@datatable')->name('area.datatable');
            Route::get('/area/edit/{id}', 'App\Http\Controllers\AreasController@edit')->name('area.edit');
            Route::get('/area/add', 'App\Http\Controllers\AreasController@add')->name('area.add');
            Route::post('/area/create', 'App\Http\Controllers\AreasController@create')->name('area.create');
            Route::get('/area/delete/{id}', 'App\Http\Controllers\AreasController@delete')->name('area.delete');

            //branches route
            Route::get('/branches', 'App\Http\Controllers\BranchController@branches')->name('branches');
            Route::post('/branch/update/{id}', 'App\Http\Controllers\BranchController@update')->name('branch.update');
            Route::get('/branch/edit/{id}', 'App\Http\Controllers\BranchController@edit')->name('branch.edit');
            Route::get('/branches/datatable', 'App\Http\Controllers\BranchController@datatable')->name('branches.datatable');
            Route::post('/branch/create', 'App\Http\Controllers\BranchController@create')->name('branch.create');
            Route::get('/branch/add', 'App\Http\Controllers\BranchController@add')->name('branch.add');
            Route::get('/branch/add_link/', 'App\Http\Controllers\BranchController@add_link')->name('branch.add.link');
            Route::get('/branch/delete/{id}', 'App\Http\Controllers\BranchController@delete')->name('branch.delete');
            Route::get('/address/getbranch/{id}', 'App\Http\Controllers\AddressController@getBranches')->name('address.getbranch');

            //Posts route
            Route::get('/posts/{type}', 'App\Http\Controllers\PostsController@list')->name('posts');
            Route::get('/posts/view/{id}', 'App\Http\Controllers\PostsController@view')->name('posts.view');
            Route::post('/posts/update/{id}', 'App\Http\Controllers\PostsController@update')->name('posts.update');
            Route::get('/posts/datatable/{type}', 'App\Http\Controllers\PostsController@datatable')->name('posts.datatable');
            Route::get('/posts/datatable/{type}/{id}', 'App\Http\Controllers\PostsController@datatable')->name('location.view.datatable');
            Route::get('/posts/edit/{id}', 'App\Http\Controllers\PostsController@edit')->name('posts.edit');
            Route::get('/posts/add/{type}', 'App\Http\Controllers\PostsController@add')->name('posts.add');
            Route::post('/posts/create/{type}', 'App\Http\Controllers\PostsController@create')->name('posts.create');
            Route::get('/posts/delete/{id}', 'App\Http\Controllers\PostsController@delete')->name('posts.delete');
            Route::get('/posts/category', 'App\Http\Controllers\PostsController@delete')->name('posts.category');
            Route::get('/posts/category/search', 'App\Http\Controllers\PostsController@category_search')->name('posts.category.search');
            Route::post('/posts/category/create', 'App\Http\Controllers\PostsController@category_create')->name('posts.category.create');
            Route::get('/posts/category/add', 'App\Http\Controllers\PostsController@category_add')->name('posts.category.add');

            //Themes route
            Route::get('/themes', 'App\Http\Controllers\Settings\ThemeController@list')->name('settings.themes');
            Route::get('/themes/add', 'App\Http\Controllers\Settings\ThemeController@add')->name('settings.themes.add');
            Route::post('/themes/create', 'App\Http\Controllers\Settings\ThemeController@create')->name('theme.create');
            Route::get('/themes/delete/{id}', 'App\Http\Controllers\Settings\ThemeController@delete')->name('settings.themes.delete');
            Route::get('/settings/themes/{slug}', 'App\Http\Controllers\Settings\ThemeController@theme_options')->name('settings.themes.option');
            Route::get('/settings/themes/activate/{slug}', 'App\Http\Controllers\Settings\ThemeController@theme_activate')->name('settings.themes.activate');
            Route::post('/settings/theme/{section}', 'App\Http\Controllers\Settings\ThemeController@theme_option_update')->name('theme.option.update');

            // Transactions
            Route::get('/transactions', 'App\Http\Controllers\PaymentController@transactions')->name('transactions');
            Route::get('/transactions/datatable', 'App\Http\Controllers\PaymentController@transaction_datatable')->name('transactions.datatable');
            Route::get('/transaction/{id}', 'App\Http\Controllers\PaymentController@transaction_view')->name('transaction');
        });
    });

    //OTHERS
    Route::get('/process/payment/{id}/{mode}/{response}', 'App\Http\Controllers\PaymentController@status')->name('payment.status');
    Route::get('/clear', function () {
        //Auth::guard('web')->loginUsingId(1);
        $output = new \Symfony\Component\Console\Output\BufferedOutput();
        Artisan::call('optimize:clear', array(), $output);
        return $output->fetch();
    })->name('/clear');

    Route::get('/test', function () {
        return view('test');
    });

    Route::get('/cronjobs/rates/refresh', function () {
        return get_exchange_rates();
    });

    Route::get('/cronjobs/shipments/update', function () {
        return get_shipment_status();
    });
});
