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
Route::get('/', function () {
    $content = json_decode(file_get_contents('https://buffviewer.com/api/order/getavailableamount?token=C2JazyBohSME6LWpfwNm93Y4IPVXGqcKQu5FevgTbkxHiORrj7'));
    $count_content = json_decode(file_get_contents('https://autofb.net/log_livestream/count_live.php'));
    $viewer_content = json_decode(file_get_contents('https://amazingcpanel.com/omg-api?token=Xjno2X9eYTUoMmCxiwgmuoNHgHivalxpoX6ms7UydvWDEIqHBH1zsBr5eCBoSZVETehDS2tnxW75gqBligprKNyiwwXCf3gPBXic&action=getcountviewerlivestream&is_vip=yes'));
    $amount_livestream_unit_limited_available = $content->amount_livestream_unit_limited_available;
    $number_available_order_buff_view_server_vip_speed_fast = $content->number_available_order_buff_view_server_vip_speed_fast;
    $number_available_order_buff_view_server_vip_speed_normal = $content->number_available_order_buff_view_server_vip_speed_normal;
    $count = $count_content->count;
    $viewers_counter = $viewer_content->viewers;

});
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
