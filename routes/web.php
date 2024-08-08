<?php

use Illuminate\Support\Facades\Route;
use App\Tables\ProductTable;

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

Route::post('auth', 'HomeController@auth');

Route::group(['namespace' => 'front'], function () {

	Route::get('/privacypolicy', 'PrivacyPolicyController@index');

	Route::get('/termscondition', 'TermsController@index');

	Route::get('/aboutus', 'AboutController@index');
});

Route::get('/auth', function () {
	return view('/auth');
});

Route::get('/', function () {
	return view('auth.login');
});

Route::group(['prefix' => 'admin', 'namespace' => 'admin'], function () {

	Route::group(['middleware' => ['AdminAuth']],function(){
		Route::get('home', 'AdminController@home');
		Route::get('serviceTime', 'ServicetimeController@index');
		Route::post('changePassword', 'AdminController@changePassword');
		Route::post('settings', 'AdminController@settings');
		Route::post('settings', 'AdminController@settings');

		Route::get('import', 'ExcelController@index');
		Route::post('excel/upload', 'ExcelController@import');
		
		Route::post('servicetime/store', 'ServicetimeController@store');

		Route::get('users', 'UserController@index');
		Route::post('users', 'UserController@store');
		Route::get('users/list', 'UserController@list');
		Route::post('user/show', 'UserController@show');
		Route::post('user/update', 'UserController@update');
		Route::post('user/status', 'UserController@status');
		Route::post('user/delete', 'UserController@delete');
		Route::post('user/search', 'UserController@search');

		Route::get('address', 'AddressController@index');
		Route::get('address/show', 'AddressController@show');
		Route::post('address/store', 'AddressController@store');
		Route::post('address/approve', 'AddressController@approve');
		Route::get('address/list', 'AddressController@list');
		Route::post('address/update', 'AddressController@update');
		Route::post('address/delete', 'AddressController@delete');
		Route::get('address/history', 'AddressController@history');

		Route::get('categories', 'CategoryController@index');
		Route::get('category/{id}', 'CategoryController@subcategory');
		Route::get('categories/list', 'CategoryController@list');
		Route::post('category/store', 'CategoryController@store');
		Route::post('category/show', 'CategoryController@show');
		Route::post('category/update', 'CategoryController@update');
		Route::post('category/status', 'CategoryController@status');
		Route::post('category/delete', 'CategoryController@delete');
		Route::post('category/swap', 'CategoryController@swap');

		Route::get('category/{id}/products', 'ProductController@subProducts');
		
		Route::get('delivery', 'DeliveryMethodController@index');
		Route::post('delivery/show', 'DeliveryMethodController@show');
		Route::post('delivery/delete', 'DeliveryMethodController@delete');
		Route::post('delivery/list', 'DeliveryMethodController@list');
		Route::post('delivery/store', 'DeliveryMethodController@store');

		Route::get('category/{id}/products/create', 'ProductController@createPageIndex')->name('product.create');
		Route::get('category/{id}/products/update', 'ProductController@updatePageIndex')->name('product.edite');
		Route::post('product/store', 'ProductController@store');
		Route::get('product/list', 'ProductController@list');
		Route::post('product/show', 'ProductController@show');
		Route::post('product/update', 'ProductController@update');
		Route::post('product/status', 'ProductController@status');
		Route::post('product/delete', 'ProductController@delete')->name('product.delete');
		Route::get('product/history', 'ProductController@history');
		Route::post('product/swap', 'ProductController@swap');

		Route::get('price/wholesalehistory', 'ProductController@wholesalehistory');
		Route::get('price/retailsalehistory', 'ProductController@retailsalehistory');

		Route::get('payments', 'PaymentController@index');
		Route::post('payment/store', 'PaymentController@store');
		Route::get('payment/list', 'PaymentController@list');
		Route::post('payment/show', 'PaymentController@show');
		Route::post('payment/update', 'PaymentController@update');
		Route::post('payment/status', 'PaymentController@status');
		Route::post('payment/delete', 'PaymentController@delete');

		Route::get('orders', 'OrderController@index');
		Route::get('orders/jingheobian', 'OrderController@jingheobian');
		Route::get('orders/jingheobianlist', 'OrderController@jingheobianlist');
		Route::get('orders/yamato', 'OrderController@yamato');
		Route::get('orders', 'OrderController@index');
		Route::get('orders/{id}/show', 'OrderController@orderShow');
		Route::get('order/history', 'OrderController@history');
		Route::post('orders/showUserAddress', 'OrderController@showUserAddress');
		Route::post('orders/confirm', 'OrderController@confirm');
		Route::post('orders/finished', 'OrderController@finished');

		Route::get('finance', 'FinanceController@index');
		Route::post('finance/status', 'FinanceController@status');
		Route::get('finance/list', 'FinanceController@list');

		Route::get('news', 'NewsController@index');
		Route::get('news/cate-{id}', 'NewsController@subNews');
		Route::get('news/cate-{cate_id}/title-{id}', 'NewsController@subTitles');
		Route::post('news/contentStore', 'NewsController@contentStore');
		Route::post('news/contentShow', 'NewsController@contentShow');
		Route::get('news/contentlist', 'NewsController@contentlist');
		Route::post('news/contentUpdate', 'NewsController@contentUpdate');
		Route::post('news/contentDelete', 'NewsController@contentDelete');
		Route::post('news/titleStore', 'NewsController@titleStore');
		Route::post('news/titleShow', 'NewsController@titleShow');
		Route::get('news/titlelist', 'NewsController@titlelist');
		Route::post('news/titleUpdate', 'NewsController@titleUpdate');
		Route::post('news/titleDelete', 'NewsController@titleDelete');
		Route::post('news/titleStatus', 'NewsController@status');
		Route::post('news/categoryStore', 'NewsController@categoryStore');
		Route::get('news/categorylist', 'NewsController@categorylist');
		Route::post('news/categoryShow', 'NewsController@categoryShow');
		Route::post('news/categoryUpdate', 'NewsController@categoryUpdate');
		Route::post('news/categoryDelete', 'NewsController@categoryDelete');

		Route::get('units', 'UnitController@index');
		Route::get('unit/list', 'UnitController@list');
		Route::post('unit/store', 'UnitController@store');
		Route::post('unit/delete', 'UnitController@delete');

		Route::get('tax', 'TaxController@index');
		Route::get('tax/list', 'TaxController@list');
		Route::post('tax/store', 'TaxController@store');
		Route::post('tax/delete', 'TaxController@delete');

		Route::get('purse', 'PurseController@index');
		Route::get('purse/show', 'PurseController@show');
		Route::get('purse/list', 'PurseController@list');
		Route::post('purse/update', 'PurseController@update');

		Route::get('reports', 'ReportController@index');
		Route::post('report/show', 'ReportController@show');

		Route::get('reportsYear', 'ReportController@year');
		Route::post('reportYear/showYear', 'ReportController@showYear');

		Route::get('reportsMonth', 'ReportController@month');
		Route::post('reportsMonth/showMonth', 'ReportController@showMonth');

		Route::get('reportsDay', 'ReportController@day');
		Route::post('reportDay/showDay', 'ReportController@showDay');

		Route::get('service', 'ServiceController@index');
		Route::get('service/list', 'ServiceController@list');
		Route::get('service/show', 'ServiceController@show');
		Route::post('service/update', 'ServiceController@update');

		//chat part
		Route::prefix('chat')->group(function () {
			Route::prefix('/user')->group(function () {
				Route::get('/', 'ConversationController@getConversationUsers');
				Route::get('/{id}', 'ConversationController@showSingleChat');
				Route::post('/message/send/text', 'ConversationController@sendTextMessage');
				Route::post('/message/send/image', 'ConversationController@sendImageMessage');
				Route::post('/message/send/audio', 'ConversationController@sendAudioMessage');
				Route::post('/message/send/video', 'ConversationController@sendVideoMessage');
				Route::post('/remove/conversation', 'ConversationApiController@removeConversation');
			});
		});
	});

	Route::get('logout', 'AdminController@logout');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

