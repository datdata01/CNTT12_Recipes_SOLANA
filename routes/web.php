<?php

use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\AttributeController;
use App\Http\Controllers\Admin\AttributeValueController;
use App\Http\Controllers\Admin\CategoryArticleController;
use App\Http\Controllers\Admin\CategoryProductController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FeedbackController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\ImageArticleController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\VoucherController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Client\AddersController;
use App\Http\Controllers\Client\BlogController;
use App\Http\Controllers\Client\CartController;
use App\Http\Controllers\Client\CheckOutController;
use App\Http\Controllers\Client\CollectionBlogController;
use App\Http\Controllers\Client\CollectionProductController;
use App\Http\Controllers\Client\CommentPostController;
use App\Http\Controllers\Client\ContactController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\MyVoucherController;
use App\Http\Controllers\Client\OrderController;
use App\Http\Controllers\Client\ProductController;
use App\Http\Controllers\Client\ProfileController;
use App\Http\Controllers\Client\WishListController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\DefaultController;
use App\Http\Controllers\Admin\RefundController;
use App\Models\Article;
use App\Http\Controllers\Client\SearchController;

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// test

// Route::get('/', function () {
//     return view('welcome');
// });
// Route::get("/home", [Controller::class, 'notification'])->name("home");
Route::get("/test", [Controller::class, 'test'])->name("test");

// admin
Route::prefix('/admin')->middleware(['auth', 'checkAccountStatus', 'checkRole:2'])->group(function () {
    Route::resource('article', ArticleController::class);
    Route::resource('banner', BannerController::class);
    Route::resource('attributes', AttributeController::class);
    Route::resource('attributeValues', AttributeValueController::class);
    Route::resource('category-product', CategoryProductController::class);
    Route::resource('category-article', CategoryArticleController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::resource('voucher', VoucherController::class);
    Route::resource('refund', RefundController::class);
    Route::resource('products', AdminProductController::class);
    Route::resource('imagearticle', ImageArticleController::class);
    Route::resource('orders', AdminOrderController::class);
    Route::resource('feedback', FeedbackController::class);
    Route::get('', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('refund/check-order', [RefundController::class, 'checkOrder'])->name('refund.checkOrder');
});

// client
Route::prefix('')->middleware(['auth', 'checkAccountStatus', 'checkRole:1', 'updateOrderStatus'])->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart');
    Route::get('/check-out', [CheckOutController::class, 'checkOutByCart'])->name('check-out');
    Route::get('/check-out-now', [CheckOutController::class, 'checkOutByNow'])->name('check-out-now');

    // Route::get('check-out-now', [CheckOutController::class, '']);

    Route::post("/place-order", [CheckOutController::class, 'placeOrder'])->name('place-order');
    Route::post("/place-order/buy-now", [CheckOutController::class, 'placeOrderBuyNow'])->name('place-order-buy-now');
    Route::get('/order-success/{id}', [OrderController::class, 'index'])->name('order-success');
    //profile
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'infomation'])->name('infomation');
        Route::get('/order-history', [ProfileController::class, 'orderHistory'])->name('order-history');
        Route::get('/order/{id}', [ProfileController::class, 'orderDetail'])->name('order.details');
        // Route::get('/address', [ProfileController::class, 'address'])->name('address');
        Route::get('address', [AddersController::class, 'index'])->name('address');
        Route::post('/feedback/store', [ProfileController::class, 'feedbackstore'])->name('feedback.store');
        Route::put('/orders/{order}/cancel', [ProfileController::class, 'orderCancel'])->name('order.cancel');
        Route::put('/orders/{order}/delelte-order', [ProfileController::class, 'orderDelete'])->name('order.delete');
        Route::put('/orders/{order}/confirmstatus', [ProfileController::class, 'confirmstatus'])->name('order.confirmstatus');

        // Store a new address
        Route::post('address', [AddersController::class, 'store'])->name('createUserAddress');
        // Show the form for editing a specific address
        Route::get('address/{id}/edit', [AddersController::class, 'edit'])->name('address.edit');
        // Update a specific address
        Route::put('address/{id}', [AddersController::class, 'update'])->name('address.update');

        // Delete a specific address
        Route::get('address/{id}', [AddersController::class, 'destroy'])->name('address.destroy');

        //Chỉnh sửa thông tin tài khoản
        Route::post('/edit-profile', [ProfileController::class, 'editProfile'])->name('edit-profile');

        Route::get('my-voucher', [MyVoucherController::class, 'index'])->name('myVoucher.index');
        Route::post('create-my-voucher', [MyVoucherController::class, 'create'])->name('myVoucher.create');
    });
    // Yêu thích sản phẩm
    // Route::post('/toggle-favorite', [WishListController::class, 'toggleFavorite'])->name('toggle.favorite');
});

Route::post('/search', [SearchController::class, 'search'])->name('search');

Route::get('/wish-list', [WishListController::class, 'index'])->name('wish-list');
Route::get('/collection-product', [CollectionProductController::class, 'index'])->name('collection-product');
// <!--Phần này giữ hay bỏ thì nhìn route  nhé - chọn 1 trong 2-->
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/product/{id}', [ProductController::class, 'index'])->name('product');
Route::get('/collection-product/{id?}', [CollectionProductController::class, 'index'])->name('collection-product');
Route::get('/collection-blog/{id?}', [CollectionBlogController::class, 'index'])->name('collection-blog');
Route::get('/blog', [BlogController::class, 'index'])->name('blog');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/blog/{articleId}/comment', [BlogController::class, 'storeComment'])->name('blog.comment.store');
Route::get('/blog/{id}', [BlogController::class, 'show'])->name('blog.show');
Route::get('/category-blog/{id}', [CollectionBlogController::class, 'articlesByCategory'])->name('category-articles');
Route::get('/blog/category-blog/{id}', [BlogController::class, 'articlesByCategory'])->name('category-blog');
Route::post('/product/filter', [CollectionProductController::class, 'filter'])->name('product.filter');
Route::get('/404', [DefaultController::class, 'pageNotFound'])->name('404');
Route::post('/feedback/reply', [ProductController::class, 'replyFeedback'])->name('feedback.reply');
Route::delete('/comments/{id}', [BlogController::class, 'deleteComment'])->name('comments.delete');


// auth
Route::prefix('auth')->name('auth.')->group(function () {
    Route::get('/login', [AuthController::class, 'loginView'])->name('login-view');
    Route::post('/postlogin', [AuthController::class, 'storeLogin'])->name('login-post');
    Route::get('/register', [AuthController::class, 'registerView'])->name('register-view');
    Route::post('/register', [AuthController::class, 'storeRegister'])->name('register-post');
    Route::get('/foget-password', [AuthController::class, 'fogetPasswordView'])->name('foget-password-view');
    Route::post('/foget-password', [AuthController::class, 'checkfogetPasswordView']);
    Route::get('/verify-account/{email}', [AuthController::class, 'verify'])->name('verify-account');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('/profile/change-password', [AuthController::class, 'changePassword'])->name('profile.change-password');
});

// hiện tại quy ước 1 là user 2 là admin ae nào ngược đời thì sửa lại nhé=))
Route::middleware(['auth', 'checkAccountStatus', 'checkRole:2'])->group(function () {
    // Các route yêu cầu đăng nhập
    Route::get("/test", [Controller::class, 'test'])->name("test");
});
