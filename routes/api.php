<?php

use Illuminate\Http\Request;

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
Route::middleware('client')->get('/test', function (Request $request) {
    return '111';
});
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group(['namespace'=>'api'],function(){
    Route::post('/user/login','wechatUsers@wechatUserLogin');
    Route::post('/register','wechatUsers@wechatRegister');
    Route::post('/user/selcachet','wechatCachet@UserSelCachet');
    Route::post('/user/selcadetail','wechatCachet@UserSelCachetDetail');
    Route::post('/user/addshopcar','wechatShopcar@UserAddtoShopcar');
    Route::post('/user/selshopcar','wechatShopcar@UserSelShopcar');
    Route::post('/user/selshopcar2','wechatShopcar@UserSelShopcar2');
    Route::post('/user/scChangeNum','wechatShopcar@UserChangeNumber');
    Route::post('/user/delshopcar','wechatShopcar@UserDelShopcar');
    Route::post('/user/delshopcar2','wechatShopcar@UserDelShopcar2');
    Route::post('/user/kindchoose','wechatShopcar@ScKindchoosedChange');
    Route::post('/user/checkboxchoose','wechatShopcar@SccheckboxchooseChange');
    Route::post('/user/allchoose','wechatShopcar@ScAllchoose');
    Route::post('/user/alldelete','wechatShopcar@ScAllDel');
    Route::post('/user/alldelete2','wechatShopcar@ScAllDel2');
    Route::post('/user/CountMoney','wechatShopcar@CountMoney');
    Route::post('/user/AffirmOrderSel','wechatOrder@AffirmOrderSel');
    Route::post('/user/AffirmOrderSel2','wechatOrder@AffirmOrderSel2');
    Route::post('/user/checkboxFlase','wechatShopcar@checkboxFlase');
    Route::post('/user/addAddress','wechatAddress@addAddress');
    Route::post('/user/SelAddress','wechatAddress@SelAddress');
    Route::post('/user/SelAddByid','wechatAddress@SelAddByid');
    Route::post('/user/UpdataAddByid','wechatAddress@UpdataAddByid');
    Route::post('/user/DeleteAddByid','wechatAddress@DeleteAddByid');
    Route::post('/user/BuyNowSel','wechatOrder@BuyNowSel');
    Route::post('/user/BuyNowAddOrder','wechatOrder@BuyNowAddOrder');
    Route::post('/user/OrderAdd','wechatOrder@subOrder');
    Route::post('/user/OrderAddProve','wechatOrder@subOrderUploadPic');
    Route::post('/user/OrderSel','wechatOrder@OrderSel');
   // 分页查询
    Route::get('/user/OrderSelPage','wechatOrder@OrderSelPage');
    Route::post('/user/OrderCancel','wechatOrder@OrderCancel');
    Route::post('/user/OrderLenSel','wechatOrder@OrderLenSel');
    Route::post('/user/OrderDelete','wechatOrder@OrderDelete');
    Route::post('/user/orderdetail','wechatOrder@UserOrderDetail');
    Route::post('/user/confirm','wechatOrder@confirm');
    Route::post('/user/paybyorder','wechatOrder@WechatPayByOrder');
    Route::post('/user/paybyorchangestatus','wechatOrder@PayByOrderChangeStatus');
    Route::post('/user/addreinfotomaker','wechatRemindinfo@addReinfoToMaker');
    Route::post('/user/selmakerInfo','wechatCompanyInfo@userSelComInfo');


    Route::post('/maker/login','wechatUsers@wechatMakerLogin');
    Route::post('/maker/addcachet','wechatCachet@MakerAddCachet');
    Route::post('/maker/selcakind','wechatCakind@SelCachetKind');
    Route::post('/maker/selcakind2','wechatCakind@SelCachetKind2');
    Route::post('/maker/selcakindby','wechatCakind@SelCachetKindby');
    Route::post('/maker/addcakind','wechatCakind@AddCachetKind');
    Route::post('/maker/updatecakind','wechatCakind@UpdateCachetkind');
    Route::post('/maker/deletecakind','wechatCakind@DelCachetkind');
    Route::post('/maker/selcachet','wechatCachet@MakerSelCachet');
    Route::post('/maker/selcachetbykind','wechatCachet@MakerSelCachetByKind');
    Route::post('/maker/checkrepeat','wechatCachet@MakerAddSelReapet');
    Route::post('/maker/delcachet','wechatCachet@MakerDelCachet');
    Route::post('/maker/updatecachet','wechatCachet@MakerUpCachet');
    Route::post('/maker/selcachetby','wechatCachet@MakerSelCachetBy');
    Route::post('/maker/delcachepicpath','wechatCachet@MakerDelPicpath');
//    Route::get('/maker/downpic/{id}','wechatCachet@MakerDownCachetPic');
    Route::post('/maker/downpic','wechatCachet@MakerDownCachetPic');
    Route::post('/maker/orderLenSel','wechatOrder@MakerOrderLenSel');
    Route::post('/maker/ordersel','wechatOrder@MakerOrderSel');
    Route::get('/maker/orderselpage','wechatOrder@MakerOrderSelPage');
    Route::post('/maker/affirmsend','wechatOrder@MakerAffirmSend');
    Route::post('/maker/selinfolen','wechatRemindinfo@selReinfolen');
    Route::post('/maker/selinfo','wechatRemindinfo@selReinfo');
    Route::get('/maker/selinfopage','wechatRemindinfo@selReinfoPage');
    Route::post('/maker/infoback','wechatRemindinfo@addReinfoToUser');
    Route::post('/maker/addMakerInfo','wechatCompanyInfo@makerInfoAdd');
    Route::post('/maker/selMakerInfo','wechatCompanyInfo@makerInfoSel');
    Route::post('/maker/UpdateMakerInfo','wechatCompanyInfo@makerInfoUpdate');
    Route::post('/maker/DelMakerInfo','wechatCompanyInfo@makerInfoDel');
    Route::post('/maker/UpdateDelMakerInfo','wechatCompanyInfo@makerInfoUpDel');
    Route::post('/maker/expressSel','wechatExpress@expressSel');
    Route::post('/maker/expressAdd','wechatExpress@expressAdd');
    Route::post('/maker/expressUpdate','wechatExpress@expressUpdate');
});
//Route::group(['middleware'=>'client','namespace'=>'api'],function(){
//    Route::post('/user/login','wechatUsers@wechatUserLogin');
//    Route::post('/register','wechatUsers@wechatRegister');
//    Route::post('/user/selcachet','wechatCachet@UserSelCachet');
//    Route::post('/user/selcadetail','wechatCachet@UserSelCachetDetail');
//    Route::post('/user/addshopcar','wechatShopcar@UserAddtoShopcar');
//    Route::post('/user/selshopcar','wechatShopcar@UserSelShopcar');
//    Route::post('/user/selshopcar2','wechatShopcar@UserSelShopcar2');
//    Route::post('/user/scChangeNum','wechatShopcar@UserChangeNumber');
//    Route::post('/user/delshopcar','wechatShopcar@UserDelShopcar');
//    Route::post('/user/delshopcar2','wechatShopcar@UserDelShopcar2');
//    Route::post('/user/kindchoose','wechatShopcar@ScKindchoosedChange');
//    Route::post('/user/checkboxchoose','wechatShopcar@SccheckboxchooseChange');
//    Route::post('/user/allchoose','wechatShopcar@ScAllchoose');
//    Route::post('/user/alldelete','wechatShopcar@ScAllDel');
//    Route::post('/user/alldelete2','wechatShopcar@ScAllDel2');
//    Route::post('/user/CountMoney','wechatShopcar@CountMoney');
//    Route::post('/user/AffirmOrderSel','wechatOrder@AffirmOrderSel');
//    Route::post('/user/AffirmOrderSel2','wechatOrder@AffirmOrderSel2');
//    Route::post('/user/checkboxFlase','wechatShopcar@checkboxFlase');
//    Route::post('/user/addAddress','wechatAddress@addAddress');
//    Route::post('/user/SelAddress','wechatAddress@SelAddress');
//    Route::post('/user/SelAddByid','wechatAddress@SelAddByid');
//    Route::post('/user/UpdataAddByid','wechatAddress@UpdataAddByid');
//    Route::post('/user/DeleteAddByid','wechatAddress@DeleteAddByid');
//    Route::post('/user/BuyNowSel','wechatOrder@BuyNowSel');
//    Route::post('/user/BuyNowAddOrder','wechatOrder@BuyNowAddOrder');
//    Route::post('/user/OrderAdd','wechatOrder@subOrder');
//    Route::post('/user/OrderAddProve','wechatOrder@subOrderUploadPic');
//    Route::post('/user/OrderSel','wechatOrder@OrderSel');
//    Route::post('/user/OrderLenSel','wechatOrder@OrderLenSel');
//    Route::post('/user/OrderDelete','wechatOrder@OrderDelete');
//    Route::post('/user/orderdetail','wechatOrder@UserOrderDetail');
//    Route::post('/user/confirm','wechatOrder@confirm');
//    Route::post('/user/paybyorder','wechatOrder@WechatPayByOrder');
//    Route::post('/user/paybyorchangestatus','wechatOrder@PayByOrderChangeStatus');
//    Route::post('/user/addreinfotomaker','wechatRemindinfo@addReinfoToMaker');
//
//    Route::post('/maker/login','wechatUsers@wechatMakerLogin');
//    Route::post('/maker/addcachet','wechatCachet@MakerAddCachet');
//    Route::post('/maker/selcakind','wechatCakind@SelCachetKind');
//    Route::post('/maker/selcakind2','wechatCakind@SelCachetKind2');
//    Route::post('/maker/selcakindby','wechatCakind@SelCachetKindby');
//    Route::post('/maker/addcakind','wechatCakind@AddCachetKind');
//    Route::post('/maker/updatecakind','wechatCakind@UpdateCachetkind');
//    Route::post('/maker/deletecakind','wechatCakind@DelCachetkind');
//    Route::post('/maker/selcachet','wechatCachet@MakerSelCachet');
//    Route::post('/maker/selcachetbykind','wechatCachet@MakerSelCachetByKind');
//    Route::post('/maker/checkrepeat','wechatCachet@MakerAddSelReapet');
//    Route::post('/maker/delcachet','wechatCachet@MakerDelCachet');
//    Route::post('/maker/updatecachet','wechatCachet@MakerUpCachet');
//    Route::post('/maker/selcachetby','wechatCachet@MakerSelCachetBy');
//    Route::post('/maker/delcachepicpath','wechatCachet@MakerDelPicpath');
////    Route::get('/maker/downpic/{id}','wechatCachet@MakerDownCachetPic');
//    Route::post('/maker/downpic','wechatCachet@MakerDownCachetPic');
//    Route::post('/maker/orderLenSel','wechatOrder@MakerOrderLenSel');
//    Route::post('/maker/ordersel','wechatOrder@MakerOrderSel');
//    Route::post('/maker/affirmsend','wechatOrder@MakerAffirmSend');
//    Route::post('/maker/selinfolen','wechatRemindinfo@selReinfolen');
//    Route::post('/maker/selinfo','wechatRemindinfo@selReinfo');
//    Route::post('/maker/infoback','wechatRemindinfo@addReinfoToUser');
//    Route::post('/maker/addMakerInfo','wechatCompanyInfo@makerInfoAdd');
//    Route::post('/maker/selMakerInfo','wechatCompanyInfo@makerInfoSel');
//    Route::post('/maker/UpdateMakerInfo','wechatCompanyInfo@makerInfoUpdate');
//    Route::post('/maker/DelMakerInfo','wechatCompanyInfo@makerInfoDel');
//    Route::post('/maker/UpdateDelMakerInfo','wechatCompanyInfo@makerInfoUpDel');
//});

//Route::group(['middleware'=>'client','namespace'=>'api'],function(){
//    Route::any('/login','wechatUsers@wechatLogin');
//});
//Route::middleware('client')->get('/test', function (Request $request) {
//    return '欢迎访问 Laravel 学院!';
//});
//Route::middleware('auth:api')->any('/login','wechatUsers@wechatLogin');
Route::get('/test',function(){
    return json_encode(['res'=>'datatest']);
});
Route::group(['namespace'=>'api'],function() {
    Route::post('/admin/login', 'wechatUsers@AdminLogin');
});