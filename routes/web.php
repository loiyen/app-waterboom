<?php

use App\Services\JelajahService;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\frontend\BlogController;
use App\Http\Controllers\frontend\PromoController;
use App\Http\Controllers\frontend\BerandaController;
use App\Http\Controllers\frontend\JelajahController;
use App\Http\Controllers\frontend\PaymentTiketRegular;
use App\Http\Controllers\backend\ReportPrintController;
use App\Http\Controllers\frontend\AboutController;
use App\Http\Controllers\frontend\TiketGroupController;
use App\Http\Controllers\frontend\HistoryUserController;
use App\Http\Controllers\frontend\TiketRegularController;
use App\Http\Controllers\frontend\CheckoutTiketController;
use App\Http\Controllers\frontend\EventController;


Route::get('/', [BerandaController::class, 'index'])->name('beranda.utama');

// Route::get('/logout-user', [HistoryUserController::class, 'destroy_phone'])->name('logout.user');
Route::get('/search', [BerandaController::class, 'search'])->name('search.global')->middleware('throttle:30,1');

//tiket-regular
// Route::get('/ticket-reguler/buy', [TiketRegularController::class, 'index'])->name('tiket.checkout');
// Route::get('/tickets/by-date', [TiketRegularController::class, 'get_By_date'])->name('tickets.byDate');

//cart-tiket
// Route::get('/tickets/cart', [TiketRegularController::class, 'getCart'])->name('tickets.getCart');
// Route::post('/tiket/update-cart', [TiketRegularController::class, 'createCart'])->name('tickets.createCart');
// Route::post('/tickets/clear-cart', [TiketRegularController::class, 'clearCart1'])->name('tickets.clearCart');

//checkout
// Route::get('/checkout-ticket', [CheckoutTiketController::class, 'index'])->name('checkout.ticket');
// Route::post('/cart/update', [CheckoutTiketController::class, 'update'])->name('cart.update');
// Route::post('/checkout/service', [CheckoutTiketController::class, 'addService'])->name('add.service');
// Route::delete('/checkout-ticket/service/{id}', [CheckoutTiketController::class, 'destroyService'])->name('destroy.servicebyid');
// Route::delete('/delete/service', [CheckoutTiketController::class, 'destroyCartService'])->name('destroy.service');
// Route::delete('/tiket/keranjang-hapus', [TiketRegularController::class, 'destroyCartTiket'])->name('destroy.cart');

//payment-tiket 
// Route::get('/tiket-reguler/payment', [PaymentTiketRegular::class, 'index'])->name('payment.tiket');
// Route::post('/payment-proses', [PaymentTiketRegular::class, 'createOrder'])->name('create.order');
// Route::get('/payment-success', [PaymentTiketRegular::class, 'success'])->name('success');
// Route::get('/payment-failure', [PaymentTiketRegular::class, 'failed'])->name('failed');

// Route::get('/history-user', [HistoryUserController::class, 'index'])->name('history.buy');
// Route::get('/history/filter', [HistoryUserController::class, 'filterHistory'])->name('history.filter');
// Route::get('/detail-history/{id}', [HistoryUserController::class, 'historyDetail'])->name('history.detail');

//jelajah  
Route::get('/jelajah/{slug}', [JelajahController::class, 'index'])->name('jelajah.category');

Route::get('/jelajah/detail/{slug}', [JelajahController::class, 'detaiPlace'])->name('jelajah.detail');


//ticket & harga-group
Route::get('/info-reservasi/rombongan', [TiketGroupController::class, 'index'])->name('group.info');

//promo 
Route::get('/promo', [PromoController::class, 'index'])->name('promo.page');
Route::get('/detail-promo/{slug}', [PromoController::class, 'detailPromo'])->name('detail.promo');
// Route::get('/promo-load', [PromoController::class, 'loadMore'])->name('promo.load');
Route::get('/filter/promo', [PromoController::class, 'filterPromo'])->name('promo.filter');

//acara
Route::get('/acara', [EventController::class, 'index'])->name('event.page');
Route::get('/acara-detail/{slug}', [EventController::class, 'Detail'])->name('event.detail');

//blog
Route::get('/blog', [BlogController::class, 'index'])->name('blog.page');
// Route::get('/blog-load', [BlogController::class, 'loadMore'])->name('blog.load');
Route::get('/blog-detail/{slug}', [BlogController::class, 'detail'])->name('detail.blog');
Route::get('/kategori/{slug}', [BlogController::class, 'detail_by_category'])->name('blog.category');

//tentang-kami 
Route::get('/waterboom/tentang-kami', [AboutController::class, 'index'])->name('about.tentangkami');
Route::get('/Pengumuman/careers', [AboutController::class, 'careers'])->name('about.careers');
Route::get('/pengumuman/detail-careers/{slug}', [AboutController::class, 'careers_detail'])->name('detail.careers');

//pencarian 
Route::middleware('throttle:30,1')->group(function () {
    Route::get('/jelajah/{slug}/search', [JelajahController::class, 'getsearch'])->name('jelajah.search');
    Route::get('/sales/search', [TiketGroupController::class, 'search'])->name('group.search');
    Route::get('/blog/search', [BlogController::class, 'search'])->name('blog.search');
    Route::get('/acara-search', [EventController::class, 'search'])->name('event.search');
});

//filamnt 
// Route::get('/print/orders', [ReportPrintController::class, 'print_order'])->name('print.orders');
// Route::get('/print/order/{id}', [ReportPrintController::class, 'print_order_by_id'])->name('print.orderbyid');
