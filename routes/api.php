<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['namespace'=>'Api'],function (){
    Route::post('login','UserController@login');

    Route::post('register','UserController@register');

    Route::post('search', 'ProductController@search');

    Route::get('parentcategory','CategoryController@pCategory');
    Route::get('parentcategory/{id}/childcategory','CategoryController@cCategory');

    Route::get('newscategory', 'NewsController@getCategory');
    Route::get('newstitlesbycategoryid/{id}', 'NewsController@getNewsTitlesByCategoryId');
    Route::get('newscontentbyid/{id}', 'NewsController@getNewsContentById');
    Route::get('newstitles', 'NewsController@getNewsTitles');

    Route::post('qtyupdate', 'CartController@qtyupdate');
    Route::delete('cart/{id}', 'CartController@deletecartproduct');

    Route::group(['middleware' => ['ApiAuth:4, true']],function(){
        Route::post('getuserinfo', 'ConversationApiController@getuserinfo');
    });

    Route::post('updateConversation', 'ConversationApiController@update');

    Route::group(['middleware' => ['ApiAuth:0, true']],function(){
        Route::get('category/{id}/productslist', 'ProductController@list');
        Route::get('product/{id}', 'ProductController@details');

        Route::post('addtocart', 'CartController@add');
        Route::get('cart', 'CartController@getcart');
        Route::post('commentconfirmbyuser', 'CartController@commentConfirmByUser');
        Route::post('commentcancelbyuser', 'CartController@commentCancelByUser');
        Route::get('preorders', 'CartController@preorders');

        Route::get('mypage', 'MyController@index');

        Route::get('favorites', 'FavoriteController@list');
        Route::post('product/{id}/favorite', 'FavoriteController@favorite');
        Route::delete('favorite/{id}', 'FavoriteController@delete');

        Route::get('address', 'AddressController@list');
        Route::get('address/{id}', 'AddressController@show');
        Route::post('addressphone', 'AddressController@addressphone');
        Route::post('addresssign', 'AddressController@addresssign');
        Route::post('address', 'AddressController@store');
        Route::put('address/{id}', 'AddressController@update');

        Route::get('addressreadstatus', 'AddressController@readstatus');
        Route::post('addressreadset', 'AddressController@setread');

        Route::get('orders', 'OrderController@list');
        Route::get('orders/{id}', 'OrderController@show');
        Route::put('reorders/{id}', 'OrderController@reorder');
        Route::get('orders/{id}/detail', 'OrderController@detail');
        Route::post('orders', 'OrderController@store');



        //chat part
        Route::prefix('chat')->group(function () {
            Route::get('/list', 'ConversationApiController@list');
            Route::get('conversation', 'ConversationApiController@receiver');
            Route::post('/create', 'ConversationApiController@create');
            Route::post('/send/text', 'ConversationApiController@sendTextMessage');
            Route::post('/send/image', 'ConversationApiController@sendImageMessage');
            Route::post('/send/audio', 'ConversationApiController@sendAudioMessage');
            Route::post('/send/video', 'ConversationApiController@sendVideoMessage');
            Route::get('/conversation/list', 'ConversationApiController@getConversationUsers');
            Route::post('/remove/conversation', 'ConversationApiController@removeMessage');
        });
    });

    Route::group(['middleware' => ['ApiAuth:0, false']],function(){
        Route::get('clientChat', 'ConversationApiController@getClientChat');
        Route::get('category/{id}/productslist', 'ProductController@list');
        Route::get('product/{id}', 'ProductController@details');
    });

    Route::group(['middleware' => ['ApiAuth:2, true']], function(){
        Route::get('commentuserbyadmin1', 'CartController@getCommentUserByAdmin');
        Route::delete('chat/{id}', 'ConversationApiController@deleteChat');
        Route::get('commentuserbyadmin', 'ConversationApiController@getAdminChats');
        Route::get('commentbyadmin/{id}', 'CartController@getCommentByAdmin');
        Route::post('commentconfirmbyadmin', 'CartController@commentConfirmByAdmin');
        // Route::get('adminorders', 'OrderController@adminlist');
        Route::get('adminOrders', 'ConversationApiController@getAdminChats');
        Route::get('serviceOrders', 'ConversationApiController@getServiceChats');
        Route::get('myOrders', 'ConversationApiController@getMyChats');
        Route::post('chatItem', 'ConversationApiController@getChatItem');
        Route::post('moveOrder', 'ConversationApiController@moveToMyChat');
        Route::get('adminOrders/{id}', 'OrderController@adminshow');
        Route::put('adminOrders/{id}', 'OrderController@adminupdate');

        //chat part
        Route::prefix('adminchat')->group(function () {
            Route::get('/list', 'ConversationApiController@list');
            Route::post('/send/text', 'ConversationApiController@sendTextMessage');
            Route::post('/send/image', 'ConversationApiController@sendImageMessage');
            Route::post('/send/audio', 'ConversationApiController@sendAudioMessage');
            Route::post('/send/video', 'ConversationApiController@sendVideoMessage');
            Route::get('/conversation/list', 'ConversationApiController@getConversationUsers');
            Route::post('/remove/conversation', 'ConversationApiController@removeMessage');
        });
    });

});