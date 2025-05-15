<?php



use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Faq\FaqController;
use App\Http\Controllers\Mail\MailController;
use App\Http\Controllers\Page\PageController;
use App\Http\Controllers\SystemFileController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\Profile\ProfileController;
use App\Http\Controllers\Category\CategoryController;
use App\Http\Controllers\Favorite\FavoriteController;
use App\Http\Controllers\Filter\FilterController;
use App\Http\Controllers\General\TopController;
use App\Http\Controllers\Lang\LangController;
use App\Http\Controllers\Notification\NotificationController;
use App\Http\Controllers\Order\CartController;
use App\Http\Controllers\Order\OrderController;
use App\Http\Controllers\Order\MyOrdersController;
use App\Http\Controllers\Order\PaymentController;
use App\Http\Controllers\Order\PaynetController;
use App\Http\Controllers\PrintController;
use App\Http\Controllers\SpecialFilter\SpecialFilterController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\User\UserCredentialsController;
use App\Models\Payment\Payment;

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
if (!function_exists('allRoutes')) {
    function allRoutes($langslug = '')
    {
        Route::get('/', [Controller::class, 'homePage'])->name($langslug . 'web.index');
        Route::get('/page/{id?}', [PageController::class, 'pagePage'])->name($langslug . 'web.detail');
        Route::get('/files/{id?}', [SystemFileController::class, 'index'])->name($langslug .'web.images');
        Route::get('/faq/{id?}', [FaqController::class, 'fncPage'])->name($langslug .'web.faq');
        Route::get('/category/{id?}', [CategoryController::class, 'categoryPage'])->name($langslug .'web.category');
        Route::get('/test', [TestController::class, 'index'])->name($langslug .'web.test');
        Route::post('/testx', [TestController::class, 'testX'])->name($langslug .'web.testX');

        Route::get('/profile', [ProfileController::class, 'profile'])->name($langslug .'web.profile')->middleware('checkFront');

        Route::get('/notification/emailpreview/{id?}', [NotificationController::class, 'getNotifications'])->name($langslug .'notification.previewEmailTemplate');

        Route::post('/execprofile', [ProfileController::class, 'execProfile'])->name($langslug .'web.execProfile')->middleware('checkFront');

        Route::get('/settings', [ProfileController::class, 'settings'])->name($langslug .'web.settings')->middleware('checkFront');
        Route::post('/execsettings', [ProfileController::class, 'execSettings'])->name($langslug .'web.execSettings')->middleware('checkFront');

        Route::get('/logout', [ProfileController::class, 'logout'])->name($langslug .'web.logout')->middleware('checkFront');
        Route::post('/execlogout', [ProfileController::class, 'execLogout'])->name($langslug .'web.execLogout')->middleware('checkFront');

        Route::get('/user/signin', [UserCredentialsController::class, 'signIn'])->name($langslug .'web.signIn')->middleware('checkSignIn');
        Route::post('/user/execsignin', [UserCredentialsController::class, 'execSignIn'])->name($langslug .'web.execSignIn');
        Route::get('/user/execsignin', [UserCredentialsController::class, 'execSignIn'])->name($langslug .'web.execSignInGET')->middleware('checkSignIn');

        Route::get('/user/signup', [UserCredentialsController::class, 'signUp'])->name($langslug .'web.signUp')->middleware('checkSignIn');
        Route::post('/user/execsignup', [UserCredentialsController::class, 'execSignUp'])->name($langslug .'web.execSignUp');
        Route::get('/user/execsignup', [UserCredentialsController::class, 'execSignUp'])->name($langslug .'web.execSignUpGET')->middleware('checkSignIn');

        Route::get('/user/checkpassword', [UserCredentialsController::class, 'checkPassword'])->name($langslug .'web.checkPassword')->middleware('checkForPassword');
        Route::post('/user/execcheckpassword', [UserCredentialsController::class, 'execCheckPassword'])->name($langslug .'web.execCheckPassword');
        Route::get('/user/execcheckpassword', [UserCredentialsController::class, 'execCheckPassword'])->name($langslug .'web.execCheckPasswordGET')->middleware('checkSignIn');

        Route::get('/user/resetpassword/{uid?}', [UserCredentialsController::class, 'resetPassword'])->name($langslug .'web.resetPassword')->middleware('checkForPassword');
        Route::post('/user/execresetpassword', [UserCredentialsController::class, 'execResetPassword'])->name($langslug .'web.execResetPassword');
        Route::get('/user/execresetpassword', [UserCredentialsController::class, 'execResetPassword'])->name($langslug .'web.execResetPasswordGET')->middleware('checkSignIn');

        Route::get('/user/validateemail/{uid?}/{email?}', [ProfileController::class, 'redirectProfile'])->name($langslug .'web.validateEmail');

        Route::get('/notification/commandform', [NotificationController::class, 'commandForm'])->name($langslug .'web.commandForm');
        Route::post('/notification/execcommandform', [NotificationController::class, 'execCommandForm'])->name($langslug .'web.execCommandForm');

        Route::get('/checkout', [OrderController::class, 'checkout'])->name($langslug .'web.checkout')->middleware('checkFront');
        Route::get('/savequantityx', [OrderController::class, 'saveQuantity'])->name($langslug .'web.saveQuantityx')->middleware('checkFront');
        Route::post('/execcheckout', [OrderController::class, 'execCheckout'])->name($langslug .'web.execCheckout')->middleware('checkFront');
        Route::post('/execmessagex', [OrderController::class, 'saveOrderMessage'])->name($langslug .'web.saveOrderMessagex')->middleware('checkFront');

        Route::get('/myorders', [MyOrdersController::class, 'myOrders'])->name($langslug .'web.myOrders')->middleware('checkFront');
        Route::get('/orderdetails/{uid?}', [MyOrdersController::class, 'orderDetails'])->name($langslug .'web.orderDetails')->middleware('checkFront');

        Route::get('/addfavorite', [FavoriteController::class, 'addFavorite'])->name($langslug .'web.addFavorite');
        Route::get('/favorite', [FavoriteController::class, 'favorite'])->name($langslug .'web.favorite')->middleware('checkFront');
        
        
        Route::post('/addcart', [CartController::class, 'addCart'])->name($langslug .'web.addCart');
        Route::post('/cleancart', [CartController::class, 'cleanCart'])->name($langslug .'web.cleanCart');
        Route::post('/deletecart', [CartController::class, 'deleteCart'])->name($langslug .'web.deleteCart');

        Route::get('/testajax', [Controller::class, 'homePageTestAjax'])->name($langslug .'web.testajax');
                                            
        Route::get('/send', [MailController::class, 'index'])->name($langslug .'web.send');

        Route::post('/search', [TopController::class, 'execsearchSection'])->name($langslug .'web.search');

        Route::get('/printorderdetails/{id?}', [PrintController::class, 'printOrderDetailsPDF'])->name($langslug .'web.printOrderDetailsPDF');

        Route::get('/product/{id?}', [ProductController::class, 'productPage'])->name($langslug .'web.product');
        Route::get('/productlist', [ProductController::class, 'productList'])->name($langslug .'web.product.list');
        Route::post('/productlistsearch', [ProductController::class, 'searchProductList'])->name($langslug .'web.product.list.search');
        Route::get('/productlistpage', [ProductController::class, 'productListPage'])->name($langslug .'web.product.listpage');
        Route::get('/loadfiltervalues/{id}', [FilterController::class, 'loadFilterValue'])->name($langslug .'web.filter.loadfiltervalues');
        Route::post('/execfiltersleftpartvalue', [FilterController::class, 'execfiltersLeftPart_Value'])->name($langslug .'web.execfiltersleftpartvalue');
        
        Route::get('/execstatusnotificationadmin', [PaymentController::class, 'execStatusNotificationAdmin'])->name($langslug .'web.execStatusNotificationAdmin');
        Route::get('/execstatusnotificationuser', [PaymentController::class, 'execStatusNotificationUser'])->name($langslug .'web.execStatusNotificationUser');
        
        Route::get('/paymentcheckpage/{id?}', [PaymentController::class, 'paymentCheckPage'])->name($langslug .'web.paymentcheckpage');
        Route::get('/orderpaynetmethod/{id?}', [PaymentController::class, 'orderPaynetMethod'])->name($langslug .'web.orderPaynetMethod')->middleware('checkFront');
        Route::get('/orderbanktransfermethod/{id?}', [PaymentController::class, 'orderBankTransferMethod'])->name($langslug .'web.orderBankTransferMethod')->middleware('checkFront');
        Route::get('/orderdeliverymethod/{id?}', [PaymentController::class, 'orderDeliveryMethod'])->name($langslug .'web.orderDeliveryMethod')->middleware('checkFront');
        
        Route::get('/successpayment/{id?}', [PaynetController::class, 'successpayment'])->name($langslug .'web.succesPayment')->middleware('checkFront');
        Route::get('/cancelpayment/{id?}', [PaynetController::class, 'cancelpayment'])->name($langslug .'web.cancelPayment')->middleware('checkFront');


        Route::post('/execchangeLg', [LangController::class, 'execchangeLg'])->name($langslug .'web.execchangeLg');

        Route::post('/execspecialfilter', [SpecialFilterController::class, 'execSpecialFilter'])->name($langslug .'web.execspecialfilter');
        Route::get('/specialfilter/homecontainer/{id?}', [SpecialFilterController::class, 'homePageSpecialFilter'])->name($langslug .'web.specialfilter.homecontainer');
        Route::get('/specialfilter/homespmaincategory/{level?}/{idparentcategory?}', [SpecialFilterController::class, 'homePageSpecialFilterMainCategory'])->name($langslug .'web.specialfilter.homespmaincategory');
        Route::get('/specialfilter/homespspecialcategory/{level?}/{idparentcategory?}', [SpecialFilterController::class, 'homePageSpecialFilterSpecialCategory'])->name($langslug .'web.specialfilter.homespspecialcategory');
        Route::get('/specialfilter/homemodel/{id?}/{idMarca}', [SpecialFilterController::class, 'homePageSpecialFilterModel'])->name($langslug .'web.specialfilter.homemodel');
        Route::get('/specialfilter/homemodel/{id?}/{idMarca}/{idModel}', [SpecialFilterController::class, 'homePageSpecialFilterModification'])->name($langslug .'web.specialfilter.homemodification');
        Route::get('/specialfilter/homecategorytype/{id?}/{idparent}', [SpecialFilterController::class, 'homePageSpecialFilterCategoryType'])->name($langslug .'web.specialfilter.homecategorytype');

        Route::post('/contacts/execcontactsForm', [PageController::class, 'execContactsForm'])->name($langslug .'web.execContactsForm');
        Route::get('/{var1?}/{var2?}/{var3?}/{var4?}/{var5?}/{var6?}/{var7?}/{var8?}/{var9?}', [Controller::class, 'generalSlag']);
    };
}

Route::group(
    [
        'middleware' => ['changeLang'],
        'prefix' => '/{langslug?}/',
        'where' => ['langslug' => '[a-z]{2}']
    ],
    function () {
        return allRoutes('langprefix|');
    }
);

allRoutes();