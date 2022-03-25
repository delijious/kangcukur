<?php

use Illuminate\Support\Facades\Route;

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

Auth::routes();

// ------------------------------------------- website start -------------------------
Route::get('/', function () {
    return redirect('owner/login');
});

// Route::get('/login', function () {
//     return redirect('owner/login');
// })->name('login');
Route::get('/login', function () {
    return redirect('/');
})->name('login');

Route::get('/', 'website\WebsiteController@index');
Route::post('/loginPost', 'website\WebsiteController@login');
Route::post('/forgotPassword', 'website\WebsiteController@forgotPassword');
Route::post('/register', 'website\WebsiteController@register');
Route::post('/sendotp', 'website\WebsiteController@sendotp');
Route::post('/verifyotp', 'website\WebsiteController@checkotp');

Route::get('/all-categories', 'website\WebsiteController@allCat');
Route::get('/all-salons', 'website\WebsiteController@allSalon');
Route::post('/all-salons', 'website\WebsiteController@allSalon');
Route::get('/salon/{id}/{salon_name}', 'website\WebsiteController@singleSalon');
Route::get('/salon/{id}/{salon_name}/booking', 'website\WebsiteController@bookingPage');
Route::post('/salon/{id}/{salon_name}/booking', 'website\WebsiteController@bookingPage');

Route::post('/booking/timeslot', 'website\WebsiteController@timeSlot');
Route::post('/useCoupon', 'website\WebsiteController@useCoupon');

Route::post('/changeLanguage', 'website\WebsiteController@changeLanguage');

Route::middleware(['auth'])->group(function()
{
    Route::post('/booking', 'website\WebsiteController@booking');
    Route::get('/success/{booking_id}', 'website\WebsiteController@success')->name('success');
    Route::get('/profile', 'website\WebsiteController@profile');
    Route::post('/profile-data', 'website\WebsiteController@profile_data');
    Route::post('/changePassword', 'website\WebsiteController@changePassword');
    Route::post('/addAddress', 'website\WebsiteController@addAddress');
    Route::get('/getAddress/{id}', 'website\WebsiteController@getAddress');
    Route::post('/editAddress', 'website\WebsiteController@editAddress');
    Route::get('/deleteAddress/{id}', 'website\WebsiteController@deleteAddress');
    Route::get('/appointments', 'website\WebsiteController@appointments');
    Route::post('/addReview', 'website\WebsiteController@addReview');
    Route::get('/cancelAppointment/{id}', 'website\WebsiteController@cancelAppointment');
    Route::get('/invoice/{id}', 'website\WebsiteController@invoice');
});

// ------------------------------------------- website over -------------------------

Route::get('/clear-cache', function() {
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('route:clear');
    Artisan::call('view:clear');
    return "Cache is cleared";
});

Route::post('/saveEnvData', 'Auth\LoginController@saveEnvData');
Route::post('/savelicense', 'Auth\LoginController@savelicense');

Route::get('/admin/login', 'Auth\LoginController@admin')->name('admin.login');
Route::post('/admin/login/verify', 'Auth\LoginController@login_verify');

Route::get('/owner/login', 'Auth\LoginController@owner');
Route::post('/owner/login/done', 'owner\DashboardController@ownerlogin');

Route::get('/owner/register', 'Auth\RegisterController@owner');
Route::post('/owner/register/done', 'owner\DashboardController@ownerregister');

Route::get('/owner/forgetpassword', 'Auth\LoginController@forgetpassword');
Route::post('/owner/forgetpassword/change', 'Auth\LoginController@ownerforgetpassword');

Route::get('download-sample', 'admin\LanguageController@downloadSample');

Route::prefix('admin')->middleware(['auth','admin'])->group(function()
{
    Route::get('/module', 'admin\ModuleController@index');
    Route::post('/module/store', 'admin\ModuleController@store');
    Route::get('/module/edit/loyaltyModule/{id}', 'admin\ModuleController@loyaltyModuleEdit');
    Route::post('/module/loyaltyModule/update/{id}', 'admin\ModuleController@loyaltyModuleUpdate');

    Route::get('/language/{lang}', 'admin\LanguageController@language');
    Route::post('/language/store', 'admin\LanguageController@store');
    Route::post('/language/hideLanguage', 'admin\LanguageController@hideLanguage');
    Route::post('/language/changeDirection', 'admin\LanguageController@changeDirection');

    Route::get('/language', 'admin\LanguageController@index');

    Route::get('/logout', 'Auth\LoginController@admin_logout');
    Route::get('/dashboard', 'admin\DashboardController@index');

    Route::get('/adminuserchartdata', 'admin\DashboardController@adminUserChartData');
    Route::get('/adminuserchartmonthdata', 'admin\DashboardController@adminUserMonthChartData');
    Route::get('/adminusercharweekdata', 'admin\DashboardController@adminUserWeekChartData');
    Route::get('/adminsalondata', 'admin\DashboardController@adminsalondata');
    Route::get('/adminsaloncountrydata', 'admin\DashboardController@adminsaloncountrydata');

    
    Route::get('/adminrevenuechartdata', 'admin\DashboardController@adminRevenueChartData');
    Route::get('/adminrevenuechartmonthdata', 'admin\DashboardController@adminRevenueMonthChartData');
    Route::get('/adminrevenuecharweekdata', 'admin\DashboardController@adminRevenueWeekChartData');

    //profile
    Route::get('/profile', 'admin\SettingController@admin_show');
    Route::post('/profile/update', 'admin\SettingController@admin_update');
    Route::post('/profile/changepassword', 'admin\SettingController@admin_changePassword');


    //categories
    Route::resource('/categories', 'admin\CategoryController');
    Route::get('/categories', 'admin\CategoryController@index');
    Route::post('/categories/create', 'admin\CategoryController@create');
    Route::post('/categories/store', 'admin\CategoryController@store');
    Route::get('/categories/edit/{id}', 'admin\CategoryController@edit');
    Route::post('/categories/update/{id}', 'admin\CategoryController@update');
    Route::post('/categories/hideCategory', 'admin\CategoryController@hideCategory');

    // Banner 
    Route::resource('/banner', 'admin\BannerController');
    Route::get('/banner', 'admin\BannerController@index');
    Route::get('/banner/{id}', 'admin\BannerController@show');
    Route::post('/banner/create', 'admin\BannerController@create');
    Route::post('/banner/store', 'admin\BannerController@store');
    Route::get('/banner/edit/{id}', 'admin\BannerController@edit');
    Route::post('/banner/update/{id}', 'admin\BannerController@update');
    Route::get('/banner/delete/{id}', 'admin\BannerController@destroy');
    Route::post('/banner/hideBanner', 'admin\BannerController@hideBanner');

    
    // Offer
    Route::resource('/offer', 'admin\OfferController');
    Route::get('/offer', 'admin\OfferController@index');
    Route::get('/offer/{id}', 'admin\OfferController@show');
    Route::post('/offer/create', 'admin\OfferController@create');
    Route::post('/offer/store', 'admin\OfferController@store');
    Route::get('/offer/edit/{id}', 'admin\OfferController@edit');
    Route::post('/offer/update/{id}', 'admin\OfferController@update');
    Route::get('/offer/delete/{id}', 'admin\OfferController@destroy');
    Route::post('/offer/hideOffer', 'admin\OfferController@hideOffer');
    
    //Coupon
    Route::resource('/coupon', 'admin\CouponController');
    Route::get('/coupon', 'admin\CouponController@index');
    Route::get('/coupon/{id}', 'admin\CouponController@show');
    Route::post('/coupon/create', 'admin\CouponController@create');
    Route::post('/coupon/store', 'admin\CouponController@store');
    Route::get('/coupon/edit/{id}', 'admin\CouponController@edit');
    Route::post('/coupon/update/{id}', 'admin\CouponController@update');
    Route::get('/coupon/delete/{id}', 'admin\CouponController@destroy');
    Route::post('/coupon/hideCoupon', 'admin\CouponController@hideCoupon');

    //users
    Route::resource('/users', 'admin\UserController');
    Route::get('/users/{id}', 'admin\UserController@show');
    Route::get('/users/delete/{id}', 'admin\UserController@destroy');
    
    Route::get('/users/invoice/{id}', 'owner\BookingController@invoice');
    Route::get('/users/invoice/print/{id}', 'owner\BookingController@invoice_print');

    Route::post('/users/hideUser', 'admin\UserController@hideUser');

    //Salon owner
    Route::resource('/salonowners', 'admin\SalonOwnerController');
    Route::get('/salonowners/{id}', 'admin\SalonOwnerController@show');
    Route::post('/salonowner/hideUser', 'admin\UserController@hideUser');
    Route::get('/salonowner/delete/{id}', 'admin\SalonOwnerController@destroy');

    //Salons
    Route::resource('/salons', 'admin\SalonController');
    Route::get('/salons/{id}', 'admin\SalonController@show');
    Route::post('/salons/hideSalon', 'admin\SalonController@hideSalon');
    Route::get('/salons/delete/{id}', 'admin\SalonController@destroy');

    // Reports
    Route::get('/report/revenue', 'admin\ReportController@revenue');
    Route::post('/report/revenue', 'admin\ReportController@revenue');
    Route::get('/report/user', 'admin\ReportController@user');
    Route::post('/report/user', 'admin\ReportController@user');
    Route::get('/report/salon/revenue', 'admin\ReportController@salonrevenue');
    Route::post('/report/salon/revenue', 'admin\ReportController@salonrevenue');
    Route::get('/report/wallet/withdraw','admin\ReportController@wallet_withdraw_report');
    Route::post('/report/wallet/withdraw','admin\ReportController@wallet_withdraw_report');
    Route::get('/report/wallet/deposit','admin\ReportController@wallet_deposit_report');
    Route::post('/report/wallet/deposit','admin\ReportController@wallet_deposit_report');
    
    //Refaund
    Route::resource('/refund', 'admin\RefaundController');
    Route::get('user_bank_details/{id}','admin\RefaundController@user_bank_details');
    Route::post('refund/refund_status','admin\RefaundController@status');
    Route::post('refund/refaundStripePayment','admin\RefaundController@refaundStripePayment');
    Route::post('refund/confirm_refund','admin\RefaundController@confirm_refund');

    //settings
    Route::get('/settings', 'admin\SettingController@index');
    Route::post('/settings/update/{id}', 'admin\SettingController@update');
    Route::post('/license/update/{id}', 'admin\SettingController@update_license');

    // Review Report
    Route::get('/review', 'admin\ReviewController@index');
    Route::get('/review/{id}', 'admin\ReviewController@show');
    Route::get('/review/delete/{id}', 'admin\ReviewController@destroy');
    Route::get('/review/approve/{id}', 'admin\ReviewController@approve');

    // Notification
    Route::get('/notification/template', 'admin\NotificationController@template');
    Route::get('/notification/template/edit/{id}', 'admin\NotificationController@edit_template');
    Route::post('/notification/template/update/{id}', 'admin\NotificationController@update_template');
    Route::get('/notification/send', 'admin\NotificationController@send');
    Route::post('/notification/store', 'admin\NotificationController@store');

});

Route::prefix('owner')->middleware(['auth','owner'])->group(function()
{
    
    Route::get('/logout', 'Auth\LoginController@owner_logout');

    Route::get('/dashboard', 'owner\DashboardController@index')->name('onwerDashboard');
    Route::get('/language/{lang}', 'admin\LanguageController@language');

    
    Route::get('/ownerorderchartdata', 'owner\DashboardController@ownerOrderChartData');
    Route::get('/ownerorderchartmonthdata', 'owner\DashboardController@ownerOrderMonthChartData');
    Route::get('/ownerordercharweekdata', 'owner\DashboardController@ownerOrderWeekChartData');
    
    Route::get('/ownerrevenuechartdata', 'owner\DashboardController@ownerRevenueChartData');
    Route::get('/ownerrevenuechartmonthdata', 'owner\DashboardController@ownerRevenueMonthChartData');
    Route::get('/ownerrevenuecharweekdata', 'owner\DashboardController@ownerRevenueWeekChartData');

    //profile
    Route::get('/profile', 'owner\SalonOwnerController@show');
    Route::post('/profile/update', 'owner\SalonOwnerController@update');
    Route::post('/profile/changepassword', 'owner\SalonOwnerController@changePassword');

    //Salons
    Route::resource('/salons', 'owner\SalonController');
    Route::get('/salons', 'owner\SalonController@index');
    Route::get('/salons/create', 'owner\SalonController@create');
    Route::post('/salons/store', 'owner\SalonController@store');
    Route::get('/salons/edit/{id}', 'owner\SalonController@edit');
    Route::post('/salons/update/{id}', 'owner\SalonController@update');
    Route::post('/salons/hideSalon', 'owner\SalonController@hideSalon');
    Route::post('/salons/dayoff', 'owner\SalonController@salonDayOff');

    //Employees
    Route::resource('/employee', 'owner\EmployeeController');
    Route::get('/employee', 'owner\EmployeeController@index');
    Route::get('/employee/{id}', 'owner\EmployeeController@show');
    Route::get('/employee/create', 'owner\EmployeeController@create');
    Route::post('/employee/store', 'owner\EmployeeController@store');
    Route::get('/employee/edit/{id}', 'owner\EmployeeController@edit');
    Route::post('/employee/update/{id}', 'owner\EmployeeController@update');
    Route::post('/employee/hideEmp', 'owner\EmployeeController@hideEmp');
    Route::get('/employee/delete/{id}', 'owner\EmployeeController@destroy');
    
    //services
    Route::resource('/services', 'owner\ServiceController');
    Route::get('/services', 'owner\ServiceController@index');
    Route::get('/services/{id}', 'owner\ServiceController@show');
    Route::get('/services/create', 'owner\ServiceController@create');
    Route::post('/services/store', 'owner\ServiceController@store');
    Route::get('/services/edit/{id}', 'owner\ServiceController@edit');
    Route::post('/services/update/{id}', 'owner\ServiceController@update');
    Route::post('/services/hideService', 'owner\ServiceController@hideService');
    Route::get('/services/delete/{id}', 'owner\ServiceController@destroy');

    //gallery
    Route::resource('/gallery', 'owner\GalleryController');
    Route::get('/gallery', 'owner\GalleryController@index');
    Route::get('/gallery/{id}', 'owner\GalleryController@show');
    Route::get('/gallery/create', 'owner\GalleryController@create');
    Route::post('/gallery/store', 'owner\GalleryController@store');
    Route::get('/gallery/delete/{id}', 'owner\GalleryController@destroy');
    Route::post('/gallery/hideGallery', 'owner\GalleryController@hideGallery');

    //review
    Route::resource('/review', 'owner\ReviewController');
    Route::get('/review', 'owner\ReviewController@index');
    Route::get('/review/{id}', 'owner\ReviewController@show');
    Route::post('/review/reportreview', 'owner\ReviewController@reportReview');

    // Reports
    Route::get('/report/revenue', 'owner\ReportController@revenue');
    Route::post('/report/revenue', 'owner\ReportController@revenue');
    Route::get('/report/user', 'owner\ReportController@user');
    Route::post('/report/user', 'owner\ReportController@user');

    Route::get('/report/commission', 'admin\ReportController@commission');

    //booking
    Route::resource('/booking', 'owner\BookingController');
    Route::get('/booking', 'owner\BookingController@index');
    Route::get('/booking/{id}', 'owner\BookingController@show');
    Route::get('/booking/invoice/{id}', 'owner\BookingController@invoice');
    Route::get('/booking/invoice/print/{id}', 'owner\BookingController@invoice_print');

    Route::get('/modal/getdata/{id}', 'owner\BookingController@show');
    Route::get('/booking/create', 'owner\BookingController@create');
    Route::post('/booking/store', 'owner\BookingController@store');
    Route::post('/booking/changestatus', 'owner\BookingController@changeStatus');
    Route::post('/booking/paymentcount', 'owner\BookingController@paymentcount');
    Route::post('/booking/addressSelect', 'owner\BookingController@addressSelect');
    Route::post('/booking/timeslot', 'owner\BookingController@timeslot');
    Route::post('/booking/selectemployee', 'owner\BookingController@selectemployee');


    // Calendar
    Route::resource('/calendar', 'owner\CalendarController');
    Route::get('/calendar', 'owner\CalendarController@index');

    // User
    Route::resource('/users', 'owner\UserController');
    Route::get('/users', 'owner\UserController@index');
    Route::post('/users', 'owner\UserController@index');
    Route::get('/users/{id}', 'owner\UserController@show');
    Route::get('/users/create', 'owner\UserController@create');
    Route::post('/users/store', 'owner\UserController@store');
    Route::post('/users/hideUser', 'owner\UserController@hideUser');
    Route::post('/users/address_add', 'owner\UserController@address_add');

    // Settings
    Route::get('/settings', 'owner\SettingController@index');
    Route::post('/settings/update/{id}', 'owner\SettingController@update');
});