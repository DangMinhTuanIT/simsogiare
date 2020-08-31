<?php

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

// phan loai sim sim-loc-phat.html | gia-sim-duoi-500-nghin.html | sim-nam-sinh-1968.html

Auth::routes();

/* XỬ LÝ CHỨNG THỰC NGƯỜI DÙNG */
Route::group(['prefix' => 'gateway'], function () {

    Route::get('login', 'Auth\LoginController@showLoginForm')->name('account.login');
    Route::post('login', 'Auth\LoginController@login');
    Route::post('logout', 'Auth\LoginController@logout')->name('logout');
});

Route::get('dang-nhap', 'Auth\LoginFacebookController@index')->name('login');
Route::get('dang-nhap/{facebook}', 'Auth\LoginFacebookController@redirectToProvider')->name('social.login');
Route::get('dang-nhap/{facebook}/callback', 'Auth\LoginFacebookController@handleProviderCallback');

Route::middleware('auth')->get('thong-tin-ca-nhan', 'UserController@show')->name('profile.info');
Route::middleware('auth')->post('cap-nhat-tai-khoan', 'UserController@profile')->name('profile.update');

Route::get('/', 'Frontend\HomeController@index')->name('home');
Route::get('khong-the-truy-cap', 'Auth\LoginController@access_denied')->name('access_denied');
Route::get('tai-khoan-chua-kich-hoat', 'Auth\LoginController@inactive')->name('inactive');
// crawler data




/* ADMIN MENU */
Route::group(['prefix' => 'admin', 'middleware' => [
    'admin',
    'auth',
]], function () {
    
    Route::get('/', 'UserController@index')->name('admin.list');
    /* ======== HỆ THỐNG ======== */
    /* THÀNH VIÊN */
    Route::group(['prefix' => 'thanh-vien', 'middleware' => [
        'permission:Xem thành viên|Thêm thành viên|Xóa thành viên|Sửa thành viên|Kích hoạt thành viên|Xóa tất cả thành viên',
    ]], function () {
        Route::get('danh-sach/{item?}', 'UserController@index')->name('user.list');
        Route::get('phan-trang/{item?}', 'UserController@getData')->name('user.data');
        Route::post('them-moi', 'UserController@store')->middleware('permission:Thêm thành viên')->name('user.create');
        Route::get('chi-tiet/{item?}', 'UserController@showUserInfo')->middleware('permission:Sửa thành viên')->name('user.info');
        Route::put('cap-nhat/{item?}', 'UserController@update')->middleware('permission:Sửa thành viên')->name('user.update');
        Route::delete('xoa/{item?}', 'UserController@destroy')->middleware('permission:Xóa thành viên')->name('user.remove');
        Route::get('tim-kiem/{item?}', 'UserController@search')->name('user.search');
        Route::delete('xoa-tat-ca', 'UserController@removeAll')->middleware('permission:Xóa tất cả thành viên')->name('user.truncate');
    });

    /* PHÂN QUYỀN */
    Route::group(['prefix' => 'phan-quyen', 'middleware' => [
        'permission:Xem phân quyền|Thêm phân quyền|Xóa phân quyền|Sửa phân quyền|Kích hoạt phân quyền|Xóa tất cả phân quyền',
    ]], function () {
        Route::get('danh-sach/{item?}', 'RoleController@index')->name('role.list');
        Route::get('phan-trang/{item?}', 'RoleController@getData')->name('role.data');
        Route::post('them-moi', 'RoleController@store')->middleware('permission:Thêm phân quyền')->name('role.create');
        Route::get('chi-tiet/{item?}', 'RoleController@show')->name('role.info');
        Route::put('cap-nhat/{item?}', 'RoleController@update')->middleware('permission:Sửa phân quyền')->name('role.update');
        Route::delete('xoa/{item?}', 'RoleController@destroy')->middleware('permission:Xóa phân quyền')->name('role.remove');
        Route::get('tim-kiem/{item?}', 'RoleController@search')->name('role.search');
        Route::delete('xoa-tat-ca', 'RoleController@removeAll')->middleware('permission:Xóa tất cả phân quyền')->name('role.truncate');
    });
    Route::group(['prefix' => 'ajax', 'middleware' => [
        // 'permission:Xem group service|Thêm group service|Xóa group service|Sửa group service|Xóa tất cả group service',
    ]], function () {
        Route::post('images', 'Admin\AjaxController@images')->name('ajax.admin.images');
    });
    // order

    Route::group(['prefix' => 'orders', 'middleware' => [
        // 'permission:Xem group service|Thêm group service|Xóa group service|Sửa group service|Xóa tất cả group service',
    ]], function () {
        Route::get('danh-sach/{item?}', 'Admin\OrderController@index')->name('orders.list');
        Route::get('edit/{id}', 'Admin\OrderController@edit')->name('orders.edit');
        Route::put('update/{id?}', 'Admin\OrderController@update_db')->name('orders.update_db');
        Route::get('phan-trang/{item?}', 'Admin\OrderController@getData')->name('orders.data');
        Route::get('chi-tiet/{item?}', 'Admin\OrderController@show')->name('orders.info');
        Route::delete('xoa/{item?}', 'Admin\OrderController@destroy')->name('orders.remove');
        Route::get('tim-kiem/{item?}', 'Admin\OrderController@search')->name('orders.search');
        Route::delete('xoa-tat-ca', 'Admin\OrderController@removeAll')->name('orders.truncate');
    });
    // quan ly nha mang
    Route::group(['prefix' => 'category_networks', 'middleware' => [
        // 'permission:Xem group service|Thêm group service|Xóa group service|Sửa group service|Xóa tất cả group service',
    ]], function () {
        Route::get('danh-sach/{item?}', 'Admin\CategoryNetworkController@index')->name('category_networks.list');
         Route::get('add', 'Admin\CategoryNetworkController@add')->name('category_networks.add');
         Route::post('store', 'Admin\CategoryNetworkController@store')->name('category_networks.store');
        Route::get('edit/{id}', 'Admin\CategoryNetworkController@edit')->name('category_networks.edit');
        Route::put('update/{id?}', 'Admin\CategoryNetworkController@update_db')->name('category_networks.update_db');
        Route::get('phan-trang/{item?}', 'Admin\CategoryNetworkController@getData')->name('category_networks.data');
        Route::get('chi-tiet/{item?}', 'Admin\CategoryNetworkController@show')->name('category_networks.info');
        Route::delete('xoa/{item?}', 'Admin\CategoryNetworkController@destroy')->name('category_networks.remove');
        Route::get('tim-kiem/{item?}', 'Admin\CategoryNetworkController@search')->name('category_networks.search');
        Route::delete('xoa-tat-ca', 'Admin\CategoryNetworkController@removeAll')->name('category_networks.truncate');
    });
    // sim hop menh
    Route::group(['prefix' => 'sim_fate', 'middleware' => [
        // 'permission:Xem group service|Thêm group service|Xóa group service|Sửa group service|Xóa tất cả group service',
    ]], function () {
        Route::get('danh-sach/{item?}', 'Admin\SimFateController@index')->name('sim_fate.list');
         Route::get('add', 'Admin\SimFateController@add')->name('sim_fate.add');
         Route::post('store', 'Admin\SimFateController@store')->name('sim_fate.store');
        Route::get('edit/{id}', 'Admin\SimFateController@edit')->name('sim_fate.edit');
        Route::put('update/{id?}', 'Admin\SimFateController@update_db')->name('sim_fate.update_db');
        Route::get('phan-trang/{item?}', 'Admin\SimFateController@getData')->name('sim_fate.data');
        Route::get('chi-tiet/{item?}', 'Admin\SimFateController@show')->name('sim_fate.info');
        Route::delete('xoa/{item?}', 'Admin\SimFateController@destroy')->name('sim_fate.remove');
        Route::get('tim-kiem/{item?}', 'Admin\SimFateController@search')->name('sim_fate.search');
        Route::delete('xoa-tat-ca', 'Admin\SimFateController@removeAll')->name('sim_fate.truncate');
    });
    // sim hop tuổi
    Route::group(['prefix' => 'sim_age', 'middleware' => [
        // 'permission:Xem group service|Thêm group service|Xóa group service|Sửa group service|Xóa tất cả group service',
    ]], function () {
        Route::get('danh-sach/{item?}', 'Admin\SimAgeController@index')->name('sim_age.list');
         Route::get('add', 'Admin\SimAgeController@add')->name('sim_age.add');
         Route::post('store', 'Admin\SimAgeController@store')->name('sim_age.store');
        Route::get('edit/{id}', 'Admin\SimAgeController@edit')->name('sim_age.edit');
        Route::put('update/{id?}', 'Admin\SimAgeController@update_db')->name('sim_age.update_db');
        Route::get('phan-trang/{item?}', 'Admin\SimAgeController@getData')->name('sim_age.data');
        Route::get('chi-tiet/{item?}', 'Admin\SimAgeController@show')->name('sim_age.info');
        Route::delete('xoa/{item?}', 'Admin\SimAgeController@destroy')->name('sim_age.remove');
        Route::get('tim-kiem/{item?}', 'Admin\SimAgeController@search')->name('sim_age.search');
        Route::delete('xoa-tat-ca', 'Admin\SimAgeController@removeAll')->name('sim_age.truncate');
    });
    
    // quan ly the loai sim
    Route::group(['prefix' => 'section', 'middleware' => [
        // 'permission:Xem group service|Thêm group service|Xóa group service|Sửa group service|Xóa tất cả group service',
    ]], function () {
        Route::get('danh-sach/{id}/{item?}', 'Admin\SectionController@index')->name('section.list');
         Route::get('add/{id}', 'Admin\SectionController@add')->name('section.add');
         Route::post('store/{id}', 'Admin\SectionController@store')->name('section.store');
        Route::get('edit/{id}/{id2}', 'Admin\SectionController@edit')->name('section.edit');
        Route::put('update/{id?}/{id2}', 'Admin\SectionController@update_db')->name('section.update_db');
        Route::get('phan-trang/{id}/{item?}', 'Admin\SectionController@getData')->name('section.data');
        Route::get('chi-tiet/{item?}', 'Admin\SectionController@show')->name('section.info');
        Route::delete('xoa/{item?}', 'Admin\SectionController@destroy')->name('section.remove');
        Route::get('tim-kiem/{id}/{item?}', 'Admin\SectionController@search')->name('section.search');
        Route::delete('xoa-tat-ca', 'Admin\SectionController@removeAll')->name('section.truncate');
    });

    // quan ly the loai sim
    Route::group(['prefix' => 'genre', 'middleware' => [
        // 'permission:Xem group service|Thêm group service|Xóa group service|Sửa group service|Xóa tất cả group service',
    ]], function () {
        Route::get('danh-sach/{item?}', 'Admin\GenreController@index')->name('genre.list');
         Route::get('add', 'Admin\GenreController@add')->name('genre.add');
         Route::post('store', 'Admin\GenreController@store')->name('genre.store');
        Route::get('edit/{id}', 'Admin\GenreController@edit')->name('genre.edit');
        Route::put('update/{id?}', 'Admin\GenreController@update_db')->name('genre.update_db');
        Route::get('phan-trang/{item?}', 'Admin\GenreController@getData')->name('genre.data');
        Route::get('chi-tiet/{item?}', 'Admin\GenreController@show')->name('genre.info');
        Route::delete('xoa/{item?}', 'Admin\GenreController@destroy')->name('genre.remove');
        Route::get('tim-kiem/{item?}', 'Admin\GenreController@search')->name('genre.search');
        Route::delete('xoa-tat-ca', 'Admin\GenreController@removeAll')->name('genre.truncate');
    });
    // quan ly sim theo nam sinh
    Route::group(['prefix' => 'sim_birth', 'middleware' => [
        // 'permission:Xem group service|Thêm group service|Xóa group service|Sửa group service|Xóa tất cả group service',
    ]], function () {
        Route::get('danh-sach/{item?}', 'Admin\SimBirthController@index')->name('sim_birth.list');
         Route::get('add', 'Admin\SimBirthController@add')->name('sim_birth.add');
         Route::post('store', 'Admin\SimBirthController@store')->name('sim_birth.store');
        Route::get('edit/{id}', 'Admin\SimBirthController@edit')->name('sim_birth.edit');
        Route::put('update/{id?}', 'Admin\SimBirthController@update_db')->name('sim_birth.update_db');
        Route::get('phan-trang/{item?}', 'Admin\SimBirthController@getData')->name('sim_birth.data');
        Route::get('chi-tiet/{item?}', 'Admin\SimBirthController@show')->name('sim_birth.info');
        Route::delete('xoa/{item?}', 'Admin\SimBirthController@destroy')->name('sim_birth.remove');
        Route::get('tim-kiem/{item?}', 'Admin\SimBirthController@search')->name('sim_birth.search');
        Route::delete('xoa-tat-ca', 'Admin\SimBirthController@removeAll')->name('sim_birth.truncate');
    });
    // quan ly sim
    Route::group(['prefix' => 'sim', 'middleware' => [
        // 'permission:Xem group service|Thêm group service|Xóa group service|Sửa group service|Xóa tất cả group service',
    ]], function () {
        Route::get('danh-sach/{item?}', 'Admin\SimController@index')->name('sim.list');
         Route::get('import', 'Admin\SimController@import')->name('sim.add');
         Route::post('import', 'Admin\SimController@store')->name('sim.store');
         Route::get('import_sim', 'Admin\SimController@import_sim')->name('sim.import_sim');
         Route::post('import_sim_post', 'Admin\SimController@import_sim_post')->name('sim.import_sim_post');
        Route::get('edit/{id}', 'Admin\SimController@edit')->name('sim.edit');
        Route::put('update/{id?}', 'Admin\SimController@update_db')->name('sim.update_db');
        Route::get('phan-trang/{item?}', 'Admin\SimController@getData')->name('sim.data');
        Route::get('chi-tiet/{item?}', 'Admin\SimController@show')->name('sim.info');
        Route::delete('xoa/{item?}', 'Admin\SimController@destroy')->name('sim.remove');
        Route::get('tim-kiem/{item?}', 'Admin\SimController@search')->name('sim.search');
        Route::delete('xoa-tat-ca', 'Admin\SimController@removeAll')->name('sim.truncate');
    });
    // quan ly khoang gia
    Route::group(['prefix' => 'price_range', 'middleware' => [
        // 'permission:Xem group service|Thêm group service|Xóa group service|Sửa group service|Xóa tất cả group service',
    ]], function () {
        Route::get('danh-sach/{item?}', 'Admin\PriceRangeController@index')->name('price_range.list');
         Route::get('add', 'Admin\PriceRangeController@add')->name('price_range.add');
         Route::post('store', 'Admin\PriceRangeController@store')->name('price_range.store');
        Route::get('edit/{id}', 'Admin\PriceRangeController@edit')->name('price_range.edit');
        Route::put('update/{id?}', 'Admin\PriceRangeController@update_db')->name('price_range.update_db');
        Route::get('phan-trang/{item?}', 'Admin\PriceRangeController@getData')->name('price_range.data');
        Route::get('chi-tiet/{item?}', 'Admin\PriceRangeController@show')->name('price_range.info');
        Route::delete('xoa/{item?}', 'Admin\PriceRangeController@destroy')->name('price_range.remove');
        Route::get('tim-kiem/{item?}', 'Admin\PriceRangeController@search')->name('price_range.search');
        Route::delete('xoa-tat-ca', 'Admin\PriceRangeController@removeAll')->name('price_range.truncate');
    });

    // setting
     Route::group(['prefix' => 'setting', 'middleware' => [
        // 'permission:Xem group service|Thêm group service|Xóa group service|Sửa group service|Xóa tất cả group service',
    ]], function () {
        Route::get('danh-sach/{item?}', 'Admin\SettingController@index')->name('setting.list');
        Route::get('view_setting', 'Admin\SettingController@view_setting')->name('setting.view_setting');
        Route::get('phan-trang/{item?}', 'Admin\SettingController@getData')->name('setting.data');
        Route::put('update/{id?}', 'Admin\SettingController@update_db')->name('Admin.update_db');
        Route::post('them-moi', 'Admin\SettingController@store')->name('setting.create');
        Route::get('chi-tiet/{item?}', 'Admin\SettingController@show')->name('setting.info');
        Route::put('cap-nhat/{item?}', 'Admin\SettingController@update')->name('setting.update');
        Route::delete('xoa/{item?}', 'Admin\SettingController@destroy')->name('setting.remove');
        Route::get('tim-kiem/{item?}', 'Admin\SettingController@search')->name('setting.search');
        Route::delete('xoa-tat-ca', 'Admin\SettingController@removeAll')->name('setting.truncate');
    });

     //
     Route::group(['prefix' => 'category', 'middleware' => [
        // 'permission:Xem group service|Thêm group service|Xóa group service|Sửa group service|Xóa tất cả group service',
    ]], function () {
        Route::get('danh-sach/{item?}', 'Admin\CategoryController@index')->name('category.list');
        Route::get('add', 'Admin\CategoryController@add')->name('category.add');
        Route::get('edit/{id}', 'Admin\CategoryController@edit')->name('category.edit');
        Route::put('update/{id?}', 'Admin\CategoryController@update_db')->name('category.update_db');
        Route::get('phan-trang/{item?}', 'Admin\CategoryController@getData')->name('category.data');
        Route::post('them-moi', 'Admin\CategoryController@store')->name('category.create');
        Route::get('chi-tiet/{item?}', 'Admin\CategoryController@show')->name('category.info');
        Route::put('cap-nhat/{item?}', 'Admin\CategoryController@update')->name('category.update');
        Route::delete('xoa/{item?}', 'Admin\CategoryController@destroy')->name('category.remove');
        Route::get('tim-kiem/{item?}', 'Admin\CategoryController@search')->name('category.search');
        Route::delete('xoa-tat-ca', 'Admin\CategoryController@removeAll')->name('category.truncate');
    });
    // tags

    Route::group(['prefix' => 'tags', 'middleware' => [
        // 'permission:Xem group service|Thêm group service|Xóa group service|Sửa group service|Xóa tất cả group service',
    ]], function () {
        Route::get('danh-sach/{item?}', 'Admin\TagsController@index')->name('tags.list');
        Route::get('add', 'Admin\TagsController@add')->name('tags.add');
        Route::get('edit/{id}', 'Admin\TagsController@edit')->name('tags.edit');
        Route::put('update/{id?}', 'Admin\TagsController@update_db')->name('tags.update_db');
        Route::get('phan-trang/{item?}', 'Admin\TagsController@getData')->name('tags.data');
        Route::post('them-moi', 'Admin\TagsController@store')->name('tags.create');
        Route::get('chi-tiet/{item?}', 'Admin\TagsController@show')->name('tags.info');
        Route::put('cap-nhat/{item?}', 'Admin\TagsController@update')->name('tags.update');
        Route::delete('xoa/{item?}', 'Admin\TagsController@destroy')->name('tags.remove');
        Route::get('tim-kiem/{item?}', 'Admin\TagsController@search')->name('tags.search');
        Route::delete('xoa-tat-ca', 'Admin\TagsController@removeAll')->name('tags.truncate');
    });
    // news

    Route::group(['prefix' => 'news', 'middleware' => [
        // 'permission:Xem group service|Thêm group service|Xóa group service|Sửa group service|Xóa tất cả group service',
    ]], function () {
        Route::get('danh-sach/{item?}', 'Admin\NewsController@index')->name('news.list');
        Route::get('add', 'Admin\NewsController@add')->name('news.add');
        Route::get('edit/{id}', 'Admin\NewsController@edit')->name('news.edit');
        Route::put('update/{id?}', 'Admin\NewsController@update_db')->name('news.update_db');
        Route::get('phan-trang/{item?}', 'Admin\NewsController@getData')->name('news.data');
        Route::post('them-moi', 'Admin\NewsController@store')->name('news.create');
        Route::get('chi-tiet/{item?}', 'Admin\NewsController@show')->name('news.info');
        Route::put('cap-nhat/{item?}', 'Admin\NewsController@update')->name('news.update');
        Route::delete('xoa/{item?}', 'Admin\NewsController@destroy')->name('news.remove');
        Route::get('tim-kiem/{item?}', 'Admin\NewsController@search')->name('news.search');
        Route::delete('xoa-tat-ca', 'Admin\NewsController@removeAll')->name('news.truncate');
    });

    /* CÀI ĐẶT */
    Route::group(['prefix' => 'cai-dat', 'middleware' => [
        'permission:Xem cài đặt|Thay đổi cài đặt',
    ]], function () {
        Route::get('he-thong', 'OptionsController@index')->name('options.list');
        Route::post('he-thong', 'OptionsController@update')->middleware('permission:Thay đổi cài đặt')->name('options.update');
    });

    /* LOG HỆ THỐNG */
    Route::group(['prefix' => 'log', 'middleware' => [
        'permission:Xem log hệ thống|Xóa log hệ thống|Xóa tất cả log hệ thống',
    ]], function () {
        Route::get('danh-sach/{item?}', 'LogController@index')->name('log.list');
        Route::get('phan-trang/{item?}', 'LogController@getData')->name('log.data');
        Route::get('tim-kiem/{item?}', 'LogController@search')->name('log.search');
        Route::delete('xoa/{item?}', 'LogController@destroy')->middleware('permission:Xóa log hệ thống')->name('log.remove');
        Route::delete('xoa-tat-ca', 'LogController@removeAll')->middleware('permission:Xóa tất cả log hệ thống')->name('log.truncate');
    });

});
    Route::pattern('string', '([A-Za-z0-9_-]+)');
Route::get('sim-phong-thuy.html', array(
                    'as' => 'home.simphongthuy',
                    'uses' => 'Frontend\SimPhongThuyController@simphongthuy')
            );
Route::get('sim-phong-thuy/{string}.html', array(
                    'as' => 'home.sim_phong_thuy_filter',
                    'uses' => 'Frontend\SimPhongThuyController@sim_phong_thuy_filter')
            );
Route::get('check_sim_phong_thuy', array(
                    'as' => 'home.check_sim_phong_thuy',
                    'uses' => 'Frontend\SimPhongThuyController@check_sim_phong_thuy')
            );
Route::post('order_sim', array(
                    'as' => 'category.order_sim',
                'uses' => 'Frontend\CategoryController@order_sim'));
 Route::pattern('slug', '([A-Za-z0-9_-]+)');
    Route::pattern('string', '([A-Za-z0-9_-]+)');
    Route::pattern('num', '([0-9]+)');
    Route::pattern('num2', '([0-9]+)');
    Route::get('/tim-sim-duoi-so-{num}.html', array(
                    'as' => 'search.search_sim_duoi',
                    'uses' => 'Frontend\SearchController@search_sim_duoi')
            );
Route::get('/tim-sim-dau-so-{num}.html', array(
                    'as' => 'search.search_sim_dau',
                    'uses' => 'Frontend\SearchController@search_sim_dau')
            );
Route::get('/sim-duoi-so-{num}-dau-{num2}.html', array(
                    'as' => 'search.search_sim_giua',
                    'uses' => 'Frontend\SearchController@search_sim_giua')
            );
// tim theo theo loai duoi so
Route::get('/tim-sim-duoi-so-{num}/{string}.html', array(
                    'as' => 'search.search_sim_duoi_theloai',
                    'uses' => 'Frontend\SearchController@search_sim_duoi_theloai')
            );
// tim theo theo loai dau so

Route::get('/tim-sim-dau-so-{num}/{string}.html', array(
                    'as' => 'search.search_sim_dau_theloai',
                    'uses' => 'Frontend\SearchController@search_sim_dau_theloai')
            );
// tim theo theo so giua

Route::get('/sim-duoi-so-{num}-dau-{num2}/{string}.html', array(
                    'as' => 'search.search_sim_giua_theloai',
                    'uses' => 'Frontend\SearchController@search_sim_giua_theloai')
            );
Route::get('/{string}-sb{num}.html', array(
                    'as' => 'page.list_slug1',
                    'uses' => 'Frontend\PageController@single')
            )->where('any', '(.*)\/$');
Route::get('/{string}-n{num}.html', array(
                    'as' => 'news.list_slug1',
                    'uses' => 'Frontend\NewsController@single')
            )->where('any', '(.*)\/$');
Route::get('/{slug1}.html', array(
                    'as' => 'category.list_slug1',
                    'uses' => 'Frontend\CategoryController@category_detail1slug')
            )->where('any', '(.*)\/$');
// filter sim sim-luc-quy/dau-so-09.html
Route::get('/{slug1}/{slug2}.html', array(
                'as' => 'category.list_slug2',
                'uses' => 'Frontend\CategoryController@category_detail2slug'));
// filter sim sim-luc-quy/sim-vinaphone/dau-so-09.html
Route::get('/{slug1}/{slug2}/{slug3}.html', array(
                'as' => 'category.list_slug3',
                'uses' => 'Frontend\CategoryController@category_detail3slug'));
// filter sim vidu sim-luc-quy/sim-vinaphone/dau-so-09/gia-0-500000.html
Route::get('/{slug1}/{slug2}/{slug3}/{slug4}.html', array(
                'as' => 'category.list_slug4',
                'uses' => 'Frontend\CategoryController@category_detail4slug'));
//
// filter sim vidu sim-luc-quy/sim-vinaphone/dau-so-09/gia-0-500000.html
Route::get('/{slug1}', array(
                'as' => 'single_sim.list',
                'uses' => 'Frontend\SingleController@single_sim'));

