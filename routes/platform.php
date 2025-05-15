<?php

declare(strict_types=1);

// use App\Http\Controllers\Auto\AutoController;
// use App\Http\Controllers\Category\CategoryController;
use App\Http\Controllers\Filter\FilterController;
use App\Http\Controllers\General\MyRelationController;
use App\Http\Controllers\Location\LocationController;
use App\Http\Controllers\ProductCategory\ProductCategoryController;
// use App\Models\Base\SystemMenu;
// use App\Models\ProductCategory\ProductCategory;
use App\Orchid\Screens\Examples\ExampleCardsScreen;
use App\Orchid\Screens\Examples\ExampleChartsScreen;
use App\Orchid\Screens\Examples\ExampleFieldsAdvancedScreen;
use App\Orchid\Screens\Examples\ExampleFieldsScreen;
use App\Orchid\Screens\Examples\ExampleLayoutsScreen;
use App\Orchid\Screens\Examples\ExampleScreen;
use App\Orchid\Screens\Examples\ExampleTextEditorsScreen;
use App\Orchid\Screens\PlatformScreen;
use App\Orchid\Screens\Role\RoleEditScreen;
use App\Orchid\Screens\Role\RoleListScreen;
use App\Orchid\Screens\User\UserEditScreen;
use App\Orchid\Screens\User\UserListScreen;
use App\Orchid\Screens\User\UserProfileScreen;
use Illuminate\Support\Facades\Route;
use Tabuna\Breadcrumbs\Trail;

use App\Orchid\Screens\Label\LabelEditScreen;
use App\Orchid\Screens\Label\LabelListScreen;

use App\Orchid\Screens\Lang\LangListScreen;
use App\Orchid\Screens\Lang\LangEditScreen;

use App\Orchid\Screens\Acl\AclListScreen;
use App\Orchid\Screens\Attachements\AttachementsEditScreen;
use App\Orchid\Screens\Attachements\AttachementsListScreen;
// use App\Orchid\Screens\Auto\MarcaAutoEditScreen;
// use App\Orchid\Screens\Auto\MarcaAutoListScreen;
// use App\Orchid\Screens\Auto\ModelAutoEditScreen;
// use App\Orchid\Screens\Auto\ModelAutoListScreen;
// use App\Orchid\Screens\Auto\ModificationAutoEditScreen;
// use App\Orchid\Screens\Auto\ModificationAutoListScreen;
use App\Orchid\Screens\Auto\SpecialFilterAutoEditScreen;
use App\Orchid\Screens\Auto\SpecialFilterAutoListScreen;
use App\Orchid\Screens\Benefits\BenefitsEditScreen;
use App\Orchid\Screens\Benefits\BenefitsListScreen;
use App\Orchid\Screens\Category\CategoryEditScreen;
use App\Orchid\Screens\Category\CategoryListScreen;
use App\Orchid\Screens\Config\ConfigListScreen;
use App\Orchid\Screens\Config\ConfigEditScreen;
use App\Orchid\Screens\Faq\FaqEditScreen;
use App\Orchid\Screens\Faq\FaqListScreen;
use App\Orchid\Screens\FaqResponses\FaqResponsesListScreen;
use App\Orchid\Screens\FaqResponses\FaqResponsesEditScreen;
use App\Orchid\Screens\Favorite\FavoriteEditScreen;
use App\Orchid\Screens\Favorite\FavoriteListScreen;
use App\Orchid\Screens\Filter\FilterCategoryEditScreen;
use App\Orchid\Screens\Filter\FilterCategoryListScreen;
use App\Orchid\Screens\Filter\FilterEditScreen;
use App\Orchid\Screens\Filter\FilterListScreen;
use App\Orchid\Screens\Filter\FilterProductEditScreen;
use App\Orchid\Screens\Filter\FilterProductListScreen;
use App\Orchid\Screens\Filter\FilterValueEditScreen;
use App\Orchid\Screens\Filter\FilterValueListScreen;
use App\Orchid\Screens\Gallery\GalleryEditScreen;
use App\Orchid\Screens\Gallery\GalleryListScreen;
use App\Orchid\Screens\Location\LocationEditScreen;
use App\Orchid\Screens\Location\LocationListScreen;
use App\Orchid\Screens\Maps\MapsEditScreen;
use App\Orchid\Screens\Maps\MapsListScreen;
use App\Orchid\Screens\Notification\EmailTemplateEditScreen;
use App\Orchid\Screens\Notification\EmailTemplateListScreen;
use App\Orchid\Screens\Notification\FromEmailEditScreen;
use App\Orchid\Screens\Notification\FromEmailListScreen;
use App\Orchid\Screens\Notification\MailToSendEditScreen;
use App\Orchid\Screens\Notification\MailToSendListScreen;
use App\Orchid\Screens\Notification\SmsTemplateEditScreen;
use App\Orchid\Screens\Notification\SmsTemplateListScreen;
use App\Orchid\Screens\Notification\SmsToSendEditScreen;
use App\Orchid\Screens\Notification\SmsToSendListScreen;
use App\Orchid\Screens\Notification\SubscriptionEditScreen;
use App\Orchid\Screens\Notification\SubscriptionListScreen;
use App\Orchid\Screens\Order\OfferEditScreen;
use App\Orchid\Screens\Order\OfferListScreen;
// use App\Orchid\Screens\Order\OrderDetailsEditScreen;
use App\Orchid\Screens\Order\OrderDetailsListScreen;
use App\Orchid\Screens\Order\OrderEditScreen;
use App\Orchid\Screens\Order\OrderListScreen;
use App\Orchid\Screens\Order\OrderProductEditScreen;
use App\Orchid\Screens\SystemMenu\SystemMenuEditScreen;
use App\Orchid\Screens\SystemMenu\SystemMenuListScreen;
use App\Orchid\Screens\Page\PageEditScreen;
use App\Orchid\Screens\Page\PageListScreen;
use App\Orchid\Screens\Payment\PaynetTransactionJurnalListScreen;
use App\Orchid\Screens\Payment\PaynetTransactionListScreen;
use App\Orchid\Screens\Payment\PaynetWalletEditScreen;
use App\Orchid\Screens\Payment\PaynetWalletListScreen;
use App\Orchid\Screens\Payment\TransactionListScreen;
use App\Orchid\Screens\UserInfo\UserInfoListScreen;
use App\Orchid\Screens\ProductCategory\ProductCategoryEditScreen;
use App\Orchid\Screens\ProductCategory\ProductCategoryListScreen;
use App\Orchid\Screens\Product\ProductEditScreen;
use App\Orchid\Screens\Product\ProductListScreen;
// use App\Orchid\Screens\ProductCategory\ProductMarcaAutoEditScreen;
// use App\Orchid\Screens\ProductCategory\ProductMarcaAutoListScreen;
// use App\Orchid\Screens\ProductCategory\ProductModelAutoEditScreen;
// use App\Orchid\Screens\ProductCategory\ProductModelAutoListScreen;
// use App\Orchid\Screens\ProductCategory\ProductModificationAutoEditScreen;
// use App\Orchid\Screens\ProductCategory\ProductModificationAutoListScreen;
use App\Orchid\Screens\Publicity\PublicityEditScreen;
use App\Orchid\Screens\Publicity\PublicityListScreen;
use App\Orchid\Screens\SocialMedia\SocialMediaEditScreen;
use App\Orchid\Screens\SocialMedia\SocialMediaListScreen;
use App\Orchid\Screens\SystemFile\SystemFileEditScreen;
use App\Orchid\Screens\SystemFile\SystemFileListScreen;
use App\Orchid\Screens\SystemVideo\SystemVideoEditScreen;
use App\Orchid\Screens\SystemVideo\SystemVideoListScreen;
use App\Orchid\Screens\UserInfo\UserInfoEditScreen;
use App\Orchid\Screens\Video\VideoEditScreen;
use App\Orchid\Screens\Video\VideoListScreen;

/*
|--------------------------------------------------------------------------
| Dashboard Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the need "dashboard" middleware group. Now create something great!
|
*/
// Main

Route::group(['middleware' => 'checkedAcl'], function () {
    Route::screen('/main', PlatformScreen::class)
        ->name('platform.main');

    // Platform > Profile 
    Route::screen('profile', UserProfileScreen::class)
        ->name('platform.profile')
        ->breadcrumbs(fn (Trail $trail) => $trail
            ->parent('platform.index')
            ->push(__('Profile'), route('platform.profile')));

    // Platform > System > Users
    Route::screen('users/{user}/edit', UserEditScreen::class)
        ->name('platform.systems.users.edit')
        ->breadcrumbs(fn (Trail $trail, $user) => $trail
            ->parent('platform.systems.users')
            ->push(__('User'), route('platform.systems.users.edit', $user)));

    // Platform > System > Users > Create
    Route::screen('users/create', UserEditScreen::class)
        ->name('platform.systems.users.create')
        ->breadcrumbs(fn (Trail $trail) => $trail
            ->parent('platform.systems.users')
            ->push(__('Create'), route('platform.systems.users.create')));

    // Platform > System > Users > User
    Route::screen('users', UserListScreen::class)
        ->name('platform.systems.users')
        ->breadcrumbs(fn (Trail $trail) => $trail
            ->parent('platform.index')
            ->push(__('Users'), route('platform.systems.users')));

    // Platform > System > Roles > Role
    Route::screen('roles/{role}/edit', RoleEditScreen::class)
        ->name('platform.systems.roles.edit')
        ->breadcrumbs(fn (Trail $trail, $role) => $trail
            ->parent('platform.systems.roles')
            ->push(__('Role'), route('platform.systems.roles.edit', $role)));

    // Platform > System > Roles > Create
    Route::screen('roles/create', RoleEditScreen::class)
        ->name('platform.systems.roles.create')
        ->breadcrumbs(fn (Trail $trail) => $trail
            ->parent('platform.systems.roles')
            ->push(__('Create'), route('platform.systems.roles.create')));

    // Platform > System > Roles
    Route::screen('roles', RoleListScreen::class)
        ->name('platform.systems.roles')
        ->breadcrumbs(fn (Trail $trail) => $trail
            ->parent('platform.index')
            ->push(__('Roles'), route('platform.systems.roles')));

    // Example...
    Route::screen('example', ExampleScreen::class)
        ->name('platform.example')
        ->breadcrumbs(fn (Trail $trail) => $trail
            ->parent('platform.index')
            ->push('Example screen'));

    Route::screen('example-fields', ExampleFieldsScreen::class)->name('platform.example.fields');
    Route::screen('example-layouts', ExampleLayoutsScreen::class)->name('platform.example.layouts');
    Route::screen('example-charts', ExampleChartsScreen::class)->name('platform.example.charts');
    Route::screen('example-editors', ExampleTextEditorsScreen::class)->name('platform.example.editors');
    Route::screen('example-cards', ExampleCardsScreen::class)->name('platform.example.cards');
    Route::screen('example-advanced', ExampleFieldsAdvancedScreen::class)->name('platform.example.advanced');


    // ---------------------------------------------------------------------
    Route::screen('lang', LangListScreen::class)->name('platform.lang.list')
        ->breadcrumbs(function (Trail $trail) {
            return $trail
                ->parent('platform.index')
                ->push('Lang list');
        });

    Route::screen('lang/edit/{id?}', LangEditScreen::class)->name('platform.lang.edit')
        ->breadcrumbs(function (Trail $trail) {
            return $trail
                ->parent('platform.index')
                ->push('lang list', route('platform.lang.list'))
                ->push('Edit lang');
        });

    Route::post('lang/remove/{id?}', [LangEditScreen::class, 'delete'])->name('platform.lang.remove');



    // ---------------------------------------------------------------------
    Route::screen('label', LabelListScreen::class)->name('platform.label.list')
        ->breadcrumbs(function (Trail $trail) {
            return $trail
                ->parent('platform.index')
                ->push('Label list');
        });

    Route::screen('label/edit/{id?}', LabelEditScreen::class)->name('platform.label.edit')
        ->breadcrumbs(function (Trail $trail) {
            return $trail
                ->parent('platform.index')
                ->push('Label list', route('platform.label.list'))
                ->push('Edit label');
        });

    Route::post('label/remove/{id?}', [LabelEditScreen::class, 'delete'])->name('platform.label.remove');


    // ----------------------------------------------------------------------
    Route::screen('config', ConfigListScreen::class)->name('platform.config.list')
        ->breadcrumbs(function (Trail $trail) {
            return $trail
                ->parent('platform.index')
                ->push('Config list');
        });

    Route::screen('config/edit/{id?}', ConfigEditScreen::class)->name('platform.config.edit')
        ->breadcrumbs(function (Trail $trail) {
            return $trail
                ->parent('platform.index')
                ->push('Config list', route('platform.config.list'))
                ->push('Edit configs');
        });

    Route::post('config/remove/{id?}', [ConfigEditScreen::class, 'delete'])->name('platform.config.remove');


    // ----------------------------------------------------------------------
    Route::screen('systemfile', SystemFileListScreen::class)->name('platform.systemfile.list')
        ->breadcrumbs(function (Trail $trail) {
            return $trail
                ->parent('platform.index')
                ->push('System File list');
        });

    Route::screen('systemfile/edit/{id?}', SystemFileEditScreen::class)->name('platform.systemfile.edit')
        ->breadcrumbs(function (Trail $trail) {
            return $trail
                ->parent('platform.index')
                ->push('System File list', route('platform.systemfile.list'))
                ->push('Edit system file');
        });

    Route::screen('systemfile/create', SystemFileEditScreen::class)
        ->name('platform.systems.systemfile.create')
        ->breadcrumbs(fn (Trail $trail) => $trail
            ->parent('platform.index')
            ->push(
                __('Create'),
                route('platform.systems.systemfile.create')

            ));

    Route::post('systemfile/remove/{id?}', [SystemFileEditScreen::class, 'delete'])->name('platform.systemfile.remove');


    // ----------------------------------------------------------------------
    Route::screen('page', PageListScreen::class)->name('platform.page.list')
        ->breadcrumbs(function (Trail $trail) {
            return $trail
                ->parent('platform.index')
                ->push('Page list');
        });

    Route::screen('page/edit/{id?}', PageEditScreen::class)->name('platform.page.edit')
        ->breadcrumbs(function (Trail $trail) {
            return $trail
                ->parent('platform.index')
                ->push('Page list', route('platform.page.list'))
                ->push('Edit pages');
        });

    Route::screen('page/create', PageEditScreen::class)
        ->name('platform.page.create')
        ->breadcrumbs(fn (Trail $trail) => $trail
            ->parent('platform.index')
            ->push(
                __('Create'),
                route('platform.page.create')

            ));

    Route::post('page/remove/{id?}', [PageEditScreen::class, 'delete'])->name('platform.page.remove');

    // ----------------------------------------------------------------------
    Route::screen('systemmenu', SystemMenuListScreen::class)->name('platform.systemmenu.list')
        ->breadcrumbs(function (Trail $trail) {
            return $trail
                ->parent('platform.index')
                ->push('Page list');
        });

    Route::screen('systemmenu/edit/{id?}', SystemMenuEditScreen::class)->name('platform.systemmenu.edit')
        ->breadcrumbs(function (Trail $trail) {
            return $trail
                ->parent('platform.index')
                ->push('System menu list', route('platform.systemmenu.list'))
                ->push('Edit system menu');
        });

    Route::screen('systemmenu/create', SystemMenuEditScreen::class)
        ->name('platform.systemmenu.create')
        ->breadcrumbs(fn (Trail $trail) => $trail
            ->parent('platform.index')
            ->push(
                __('Create'),
                route('platform.systemmenu.create')

            ));

    Route::post('systemmenu/remove/{id?}', [SystemMenuEditScreen::class, 'delete'])->name('platform.systemmenu.remove');


    // ----------------------------------------------------------------------
    Route::screen('gallery', GalleryListScreen::class)->name('platform.gallery.list')
        ->breadcrumbs(function (Trail $trail) {
            return $trail
                ->parent('platform.index')
                ->push('Gallery list');
        });

    Route::screen('gallery/edit/{id?}', GalleryEditScreen::class)->name('platform.gallery.edit')
        ->breadcrumbs(function (Trail $trail) {
            return $trail
                ->parent('platform.index')
                ->push('Gallery list', route('platform.gallery.list'))
                ->push('Edit gallery');
        });

    Route::screen('gallery/create', GalleryEditScreen::class)
        ->name('platform.gallery.create')
        ->breadcrumbs(fn (Trail $trail) => $trail
            ->parent('platform.index')
            ->push(
                __('Create'),
                route('platform.gallery.create')

            ));

    Route::post('gallery/remove/{id?}', [GalleryEditScreen::class, 'delete'])->name('platform.gallery.remove');


    // ----------------------------------------------------------------------
    Route::screen('systemvideo', SystemVideoListScreen::class)->name('platform.systemvideo.list')
        ->breadcrumbs(function (Trail $trail) {
            return $trail
                ->parent('platform.index')
                ->push('System video list');
        });

    Route::screen('systemvideo/edit/{id?}', SystemVideoEditScreen::class)->name('platform.systemvideo.edit')
        ->breadcrumbs(function (Trail $trail) {
            return $trail
                ->parent('platform.index')
                ->push('System video list', route('platform.systemvideo.list'))
                ->push('Edit system video');
        });

    Route::screen('systemvideo/create', SystemVideoEditScreen::class)
        ->name('platform.systems.systemvideo.create')
        ->breadcrumbs(fn (Trail $trail) => $trail
            ->parent('platform.index')
            ->push(
                __('Create'),
                route('platform.systems.systemvideo.create')

            ));

    Route::post('systemvideo/remove/{id?}', [SystemVideoEditScreen::class, 'delete'])->name('platform.systemvideo.remove');


    // ----------------------------------------------------------------------
    Route::screen('cvideo', VideoListScreen::class)->name('platform.cvideo.list')
        ->breadcrumbs(function (Trail $trail) {
            return $trail
                ->parent('platform.index')
                ->push('Video list');
        });

    Route::screen('cvideo/edit/{id?}', VideoEditScreen::class)->name('platform.cvideo.edit')
        ->breadcrumbs(function (Trail $trail) {
            return $trail
                ->parent('platform.index')
                ->push('Video list', route('platform.cvideo.list'))
                ->push('Edit video');
        });

    Route::screen('cvideo/create', VideoEditScreen::class)
        ->name('platform.cvideo.create')
        ->breadcrumbs(fn (Trail $trail) => $trail
            ->parent('platform.index')
            ->push(
                __('Create'),
                route('platform.cvideo.create')

            ));

    Route::post('cvideo/remove/{id?}', [VideoEditScreen::class, 'delete'])->name('platform.cvideo.remove');

    // ----------------------------------------------------------------------
    Route::screen('attachements', AttachementsListScreen::class)->name('platform.attachements.list')
        ->breadcrumbs(function (Trail $trail) {
            return $trail
                ->parent('platform.index')
                ->push('Attachements list');
        });

    Route::screen('attachements/edit/{id?}', AttachementsEditScreen::class)->name('platform.attachements.edit')
        ->breadcrumbs(function (Trail $trail) {
            return $trail
                ->parent('platform.index')
                ->push('Attachements list', route('platform.attachements.list'))
                ->push('Edit attachements');
        });

    Route::screen('_attachements/create', AttachementsEditScreen::class)
        ->name('platform.attachements.create')
        ->breadcrumbs(fn (Trail $trail) => $trail
            ->parent('platform.index')
            ->push(
                __('Create'),
                route('platform.attachements.create')

            ));

    Route::post('attachements/remove/{id?}', [AttachementsEditScreen::class, 'delete'])->name('platform.attachements.remove');


    // ----------------------------------------------------------------------
    Route::screen('faq', FaqListScreen::class)->name('platform.faq.list')
        ->breadcrumbs(function (Trail $trail) {
            return $trail
                ->parent('platform.index')
                ->push('Faq list');
        });

    Route::screen('faq/edit/{id?}', FaqEditScreen::class)->name('platform.faq.edit')
        ->breadcrumbs(function (Trail $trail) {
            return $trail
                ->parent('platform.index')
                ->push('faq list', route('platform.faq.list'))
                ->push('Edit faqs');
        });

    Route::screen('faq/create', FaqEditScreen::class)
        ->name('platform.faq.create')
        ->breadcrumbs(fn (Trail $trail) => $trail
            ->parent('platform.index')
            ->push(
                __('Create'),
                route('platform.faq.create')

            ));

    Route::post('faq/remove/{id?}', [FaqEditScreen::class, 'delete'])->name('platform.faq.remove');


    // ----------------------------------------------------------------------
    Route::screen('faqresponses', FaqResponsesListScreen::class)->name('platform.faqresponses.list')
        ->breadcrumbs(function (Trail $trail) {
            return $trail
                ->parent('platform.index')
                ->push('Faq responses list');
        });

    Route::screen('faqresponses/edit/{id?}', FaqResponsesEditScreen::class)->name('platform.faqresponses.edit')
        ->breadcrumbs(function (Trail $trail) {
            return $trail
                ->parent('platform.index')
                ->push('faqresponses list', route('platform.faqresponses.list'))
                ->push('Edit faq responsess');
        });

    Route::screen('faqresponses/create', FaqResponsesEditScreen::class)
        ->name('platform.faqresponses.create')
        ->breadcrumbs(fn (Trail $trail) => $trail
            ->parent('platform.index')
            ->push(
                __('Create'),
                route('platform.faqresponses.create')

            ));

    Route::post('faqresponses/remove/{id?}', [FaqResponsesEditScreen::class, 'delete'])->name('platform.faqresponses.remove');

    // ----------------------------------------------------------------------
    Route::screen('publicity', PublicityListScreen::class)->name('platform.publicity.list')
        ->breadcrumbs(function (Trail $trail) {
            return $trail
                ->parent('platform.index')
                ->push('Publicity list');
        });

    Route::screen('ppublicity/edit/{id?}', PublicityEditScreen::class)->name('platform.publicity.edit')
        ->breadcrumbs(function (Trail $trail) {
            return $trail
                ->parent('platform.index')
                ->push('Publicity list', route('platform.publicity.list'))
                ->push('Edit publicity');
        });

    Route::screen('ppublicity/create', PublicityEditScreen::class)
        ->name('platform.publicity.create')
        ->breadcrumbs(fn (Trail $trail) => $trail
            ->parent('platform.index')
            ->push(
                __('Create'),
                route('platform.publicity.create')

            ));

    Route::post('publicity/remove/{id?}', [PublicityEditScreen::class, 'delete'])->name('platform.publicity.remove');


    // ----------------------------------------------------------------------
    Route::screen('socialmedia', SocialMediaListScreen::class)->name('platform.socialmedia.list')
        ->breadcrumbs(function (Trail $trail) {
            return $trail
                ->parent('platform.index')
                ->push('socialmedia list');
        });

    Route::screen('socialmedia/edit/{id?}', SocialMediaEditScreen::class)->name('platform.socialmedia.edit')
        ->breadcrumbs(function (Trail $trail) {
            return $trail
                ->parent('platform.index')
                ->push('socialmedia list', route('platform.socialmedia.list'))
                ->push('Edit socialmedia');
        });

    Route::screen('socialmedia/create', SocialMediaEditScreen::class)
        ->name('platform.socialmedia.create')
        ->breadcrumbs(fn (Trail $trail) => $trail
            ->parent('platform.index')
            ->push(
                __('Create'),
                route('platform.socialmedia.create')

            ));

    Route::post('socialmedia/remove/{id?}', [SocialMediaEditScreen::class, 'delete'])->name('platform.socialmedia.remove');


    // ----------------------------------------------------------------------
    Route::screen('fromemail', FromEmailListScreen::class)->name('platform.fromemail.list')
        ->breadcrumbs(function (Trail $trail) {
            return $trail
                ->parent('platform.index')
                ->push('Fromemail list');
        });

    Route::screen('fromemail/edit/{id?}', FromEmailEditScreen::class)->name('platform.fromemail.edit')
        ->breadcrumbs(function (Trail $trail) {
            return $trail
                ->parent('platform.index')
                ->push('fromemail list', route('platform.fromemail.list'))
                ->push('Edit from email ');
        });

    Route::screen('fromemail/create', FromEmailEditScreen::class)
        ->name('platform.fromemail.create')
        ->breadcrumbs(fn (Trail $trail) => $trail
            ->parent('platform.index')
            ->push(
                __('Create'),
                route('platform.fromemail.create')

            ));

    Route::post('fromemail/remove/{id?}', [FromEmailEditScreen::class, 'delete'])->name('platform.fromemail.remove');


    // ----------------------------------------------------------------------
    Route::screen('emailtemplate', EmailTemplateListScreen::class)->name('platform.emailtemplate.list')
        ->breadcrumbs(function (Trail $trail) {
            return $trail
                ->parent('platform.index')
                ->push('emailtemplate list');
        });

    Route::screen('emailtemplate/edit/{id?}', EmailTemplateEditScreen::class)->name('platform.emailtemplate.edit')
        ->breadcrumbs(function (Trail $trail) {
            return $trail
                ->parent('platform.index')
                ->push('emailtemplate list', route('platform.emailtemplate.list'))
                ->push('Edit from email ');
        });

    Route::screen('emailtemplate/create', EmailTemplateEditScreen::class)
        ->name('platform.emailtemplate.create')
        ->breadcrumbs(fn (Trail $trail) => $trail
            ->parent('platform.index')
            ->push(
                __('Create'),
                route('platform.emailtemplate.create')

            ));

    Route::post('emailtemplate/remove/{id?}', [EmailTemplateEditScreen::class, 'delete'])->name('platform.emailtemplate.remove');


    // ----------------------------------------------------------------------
    Route::screen('smstemplate', SmsTemplateListScreen::class)->name('platform.smstemplate.list')
        ->breadcrumbs(function (Trail $trail) {
            return $trail
                ->parent('platform.index')
                ->push('Smstemplate list');
        });

    Route::screen('smstemplate/edit/{id?}', SmsTemplateEditScreen::class)->name('platform.smstemplate.edit')
        ->breadcrumbs(function (Trail $trail) {
            return $trail
                ->parent('platform.index')
                ->push('Smstemplate list', route('platform.smstemplate.list'))
                ->push('Edit sms template');
        });

    Route::screen('smstemplate/create', SmsTemplateEditScreen::class)
        ->name('platform.smstemplate.create')
        ->breadcrumbs(fn (Trail $trail) => $trail
            ->parent('platform.index')
            ->push(
                __('Create'),
                route('platform.smstemplate.create')

            ));

    Route::post('smstemplate/remove/{id?}', [SmsTemplateEditScreen::class, 'delete'])->name('platform.smstemplate.remove');


    // ----------------------------------------------------------------------
    Route::screen('subscription', SubscriptionListScreen::class)->name('platform.subscription.list')
        ->breadcrumbs(function (Trail $trail) {
            return $trail
                ->parent('platform.index')
                ->push('Subscription list');
        });

    Route::screen('subscription/edit/{id?}', SubscriptionEditScreen::class)->name('platform.subscription.edit')
        ->breadcrumbs(function (Trail $trail) {
            return $trail
                ->parent('platform.index')
                ->push('Subscription list', route('platform.subscription.list'))
                ->push('Edit subscriptions');
        });

    Route::screen('subscription/create', SubscriptionEditScreen::class)
        ->name('platform.subscription.create')
        ->breadcrumbs(fn (Trail $trail) => $trail
            ->parent('platform.index')
            ->push(
                __('Create'),
                route('platform.subscription.create')

            ));

    Route::post('subscription/remove/{id?}', [SubscriptionEditScreen::class, 'delete'])->name('platform.subscription.remove');


    // ----------------------------------------------------------------------
    Route::screen('mailtosend', MailToSendListScreen::class)->name('platform.mailtosend.list')
        ->breadcrumbs(function (Trail $trail) {
            return $trail
                ->parent('platform.index')
                ->push('Mail to send list');
        });

    Route::screen('mailtosend/create', MailToSendEditScreen::class)
        ->name('platform.mailtosend.create')
        ->breadcrumbs(fn (Trail $trail) => $trail
            ->parent('platform.index')
            ->push(
                __('Create'),
                route('platform.mailtosend.create')

            ));

    Route::post('mailtosend/remove/{id?}', [MailToSendEditScreen::class, 'delete'])->name('platform.mailtosend.remove');


    // ----------------------------------------------------------------------
    Route::screen('smstosend', SmsToSendListScreen::class)->name('platform.smstosend.list')
        ->breadcrumbs(function (Trail $trail) {
            return $trail
                ->parent('platform.index')
                ->push('Sms to send list');
        });

    Route::screen('smstosend/create', SmsToSendEditScreen::class)
        ->name('platform.smstosend.create')
        ->breadcrumbs(fn (Trail $trail) => $trail
            ->parent('platform.index')
            ->push(
                __('Create'),
                route('platform.smstosend.create')

            ));

    Route::post('smstosend/remove/{id?}', [SmsToSendEditScreen::class, 'delete'])->name('platform.smstosend.remove');


    // ----------------------------------------------------------------------
    Route::screen('category', CategoryListScreen::class)->name('platform.category.list')
        ->breadcrumbs(function (Trail $trail) {
            return $trail
                ->parent('platform.index')
                ->push('category list');
        });

    Route::screen('category/edit/{id?}', CategoryEditScreen::class)->name('platform.category.edit')
        ->breadcrumbs(function (Trail $trail) {
            return $trail
                ->parent('platform.index')
                ->push('category list', route('platform.category.list'))
                ->push('Edit categorys');
        });

    Route::screen('category/create', CategoryEditScreen::class)
        ->name('platform.category.create')
        ->breadcrumbs(fn (Trail $trail) => $trail
            ->parent('platform.index')
            ->push(
                __('Create'),
                route('platform.category.create')

            ));

    Route::post('category/remove/{id?}', [CategoryEditScreen::class, 'delete'])->name('platform.category.remove');


    // ----------------------------------------------------------------------
    Route::screen('product', ProductListScreen::class)->name('platform.product.list')
        ->breadcrumbs(function (Trail $trail) {
            return $trail
                ->parent('platform.index')
                ->push('Product list');
        });

    Route::screen('product/edit/{id?}', ProductEditScreen::class)->name('platform.product.edit')
        ->breadcrumbs(function (Trail $trail) {
            return $trail
                ->parent('platform.index')
                ->push('Product list', route('platform.product.list'))
                ->push('Edit products');
        });

    Route::screen('product/create', ProductEditScreen::class)
        ->name('platform.product.create')
        ->breadcrumbs(fn (Trail $trail) => $trail
            ->parent('platform.index')
            ->push(
                __('Create'),
                route('platform.product.create')

            ));

    Route::post('product/remove/{id?}', [ProductEditScreen::class, 'delete'])->name('platform.product.remove');

    // ----------------------------------------------------------------------
    Route::screen('productcategory', ProductCategoryListScreen::class)->name('platform.productcategory.list')
        ->breadcrumbs(function (Trail $trail) {
            return $trail
                ->parent('platform.index')
                ->push('Product category list');
        });

    Route::screen('productcategory/edit/{id?}', ProductCategoryEditScreen::class)->name('platform.productcategory.edit')
        ->breadcrumbs(function (Trail $trail) {
            return $trail
                ->parent('platform.index')
                ->push('Product category list', route('platform.productcategory.list'))
                ->push('Edit Product category');
        });

    Route::screen('productcategory/create', ProductCategoryEditScreen::class)
        ->name('platform.productcategory.create')
        ->breadcrumbs(fn (Trail $trail) => $trail
            ->parent('platform.index')
            ->push(
                __('Create'),
                route('platform.productcategory.create')

            ));

    Route::post('productcategory/remove/{id?}', [ProductCategoryEditScreen::class, 'delete'])->name('platform.productcategory.remove');



    // ----------------------------------------------------------------------
    Route::screen('infouser', UserInfoListScreen::class)->name('platform.infouser.list')
        ->breadcrumbs(function (Trail $trail) {
            return $trail
                ->parent('platform.index')
                ->push('User info list');
        });

    Route::screen('infouser/edit/{id?}', UserInfoEditScreen::class)->name('platform.infouser.edit')
        ->breadcrumbs(function (Trail $trail) {
            return $trail
                ->parent('platform.index')
                ->push('User info list', route('platform.infouser.edit'))
                ->push('Edit user info');
        });

    Route::screen('infouser/create', UserInfoEditScreen::class)
        ->name('platform.infouser.create')
        ->breadcrumbs(fn (Trail $trail) => $trail
            ->parent('platform.index')
            ->push(
                __('Create'),
                route('platform.infouser.create')

            ));

    Route::post('infouser/remove/{id?}', [UserInfoEditScreen::class, 'delete'])->name('platform.infouser.remove');


    // ----------------------------------------------------------------------
    Route::screen('order', OrderListScreen::class)->name('platform.order.list')
        ->breadcrumbs(function (Trail $trail) {
            return $trail
                ->parent('platform.index')
                ->push('New Order list');
        });


    Route::screen('order/edit/{id?}', OrderEditScreen::class)->name('platform.order.edit')
        ->breadcrumbs(function (Trail $trail) {
            return $trail
                ->parent('platform.index')
                ->push('New Order list', route('platform.order.list'))
                ->push('Edit new order');
        });

    Route::screen('order/create', OrderEditScreen::class)
        ->name('platform.order.create')
        ->breadcrumbs(fn (Trail $trail) => $trail
            ->parent('platform.index')
            ->push(
                __('Create'),
                route('platform.order.create')

            ));

    Route::post('order/remove/{id?}', [OrderEditScreen::class, 'delete'])->name('platform.order.remove');


    // ----------------------------------------------------------------------
    Route::screen('orderdetails', OrderDetailsListScreen::class)->name('platform.orderdetails.list')
        ->breadcrumbs(function (Trail $trail) {
            return $trail
                ->parent('platform.index')
                ->push('Order Details list');
        });

    // ----------------------------------------------------------------------
    Route::screen('orderproduct', OrderListScreen::class)->name('platform.orderproduct.list')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.index')
            ->push('Order product list');
    });

    // ----------------------------------------------------------------------
    Route::screen('orderproduct/edit/{id?}', OrderProductEditScreen::class)->name('platform.orderproduct.edit')
        ->breadcrumbs(function (Trail $trail) {
            return $trail
                ->parent('platform.index')
                ->push('Order product list', route('platform.orderproduct.list'))
                ->push('Edit order product');
        });

    Route::screen('orderproduct/create', OrderProductEditScreen::class)
        ->name('platform.orderproduct.create')
        ->breadcrumbs(fn (Trail $trail) => $trail
            ->parent('platform.index')
            ->push(
                __('Create'),
                route('platform.orderproduct.create')

            ));

    Route::post('orderproduct/remove/{id?}', [OrderProductEditScreen::class, 'delete'])->name('platform.orderproduct.remove');


    // ----------------------------------------------------------------------
    Route::screen('offer', OfferListScreen::class)->name('platform.offer.list')
        ->breadcrumbs(function (Trail $trail) {
            return $trail
                ->parent('platform.index')
                ->push('Offer list');
        });

    Route::screen('offer/edit/{id?}', OfferEditScreen::class)->name('platform.offer.edit')
        ->breadcrumbs(function (Trail $trail) {
            return $trail
                ->parent('platform.index')
                ->push('Offer list', route('platform.offer.list'))
                ->push('Edit offer');
        });

    Route::screen('offer/create', OfferEditScreen::class)
        ->name('platform.offer.create')
        ->breadcrumbs(fn (Trail $trail) => $trail
            ->parent('platform.index')
            ->push(
                __('Create'),
                route('platform.offer.create')

            ));

    Route::post('offer/remove/{id?}', [OfferEditScreen::class, 'delete'])->name('platform.offer.remove');


    // ----------------------------------------------------------------------
    Route::screen('location', LocationListScreen::class)->name('platform.location.list')
        ->breadcrumbs(function (Trail $trail) {
            return $trail
                ->parent('platform.index')
                ->push('Location list');
        });

    Route::screen('location/edit/{id?}', LocationEditScreen::class)->name('platform.location.edit')
        ->breadcrumbs(function (Trail $trail) {
            return $trail
                ->parent('platform.index')
                ->push('Location list', route('platform.location.list'))
                ->push('Edit location');
        });

    Route::screen('location/create', LocationEditScreen::class)
        ->name('platform.location.create')
        ->breadcrumbs(fn (Trail $trail) => $trail
            ->parent('platform.index')
            ->push(
                __('Create'),
                route('platform.location.create')

            ));

    Route::post('location/remove/{id?}', [LocationEditScreen::class, 'delete'])->name('platform.location.remove');


    // ----------------------------------------------------------------------
    Route::screen('maps', MapsListScreen::class)->name('platform.maps.list')
        ->breadcrumbs(function (Trail $trail) {
            return $trail
                ->parent('platform.index')
                ->push('Maps list');
        });

    Route::screen('maps/edit/{id?}', MapsEditScreen::class)->name('platform.maps.edit')
        ->breadcrumbs(function (Trail $trail) {
            return $trail
                ->parent('platform.index')
                ->push('Maps list', route('platform.maps.list'))
                ->push('Edit maps');
        });

    Route::screen('maps/create', MapsEditScreen::class)
        ->name('platform.maps.create')
        ->breadcrumbs(fn (Trail $trail) => $trail
            ->parent('platform.index')
            ->push(
                __('Create'),
                route('platform.maps.create')

            ));

    Route::post('maps/remove/{id?}', [MapsEditScreen::class, 'delete'])->name('platform.maps.remove');

    // // ----------------------------------------------------------------------
    // Route::screen('modelauto', ModelAutoListScreen::class)->name('platform.modelauto.list')
    //     ->breadcrumbs(function (Trail $trail) {
    //         return $trail
    //             ->parent('platform.index')
    //             ->push('Model Auto list');
    //     });

    // Route::screen('modelauto/edit/{id?}', ModelAutoEditScreen::class)->name('platform.modelauto.edit')
    //     ->breadcrumbs(function (Trail $trail) {
    //         return $trail
    //             ->parent('platform.index')
    //             ->push('Model Auto list', route('platform.modelauto.list'))
    //             ->push('Edit modelauto');
    //     });

    // Route::screen('modelauto/create', ModelAutoEditScreen::class)
    //     ->name('platform.modelauto.create')
    //     ->breadcrumbs(fn (Trail $trail) => $trail
    //         ->parent('platform.index')
    //         ->push(
    //             __('Create'),
    //             route('platform.modelauto.create')

    //         ));

    // Route::post('modelauto/remove/{id?}', [ModelAutoEditScreen::class, 'delete'])->name('platform.modelauto.remove');


    // // ----------------------------------------------------------------------
    // Route::screen('marcaauto', MarcaAutoListScreen::class)->name('platform.marcaauto.list')
    //     ->breadcrumbs(function (Trail $trail) {
    //         return $trail
    //             ->parent('platform.index')
    //             ->push('Marca Auto list');
    //     });

    // Route::screen('marcaauto/edit/{id?}', MarcaAutoEditScreen::class)->name('platform.marcaauto.edit')
    //     ->breadcrumbs(function (Trail $trail) {
    //         return $trail
    //             ->parent('platform.index')
    //             ->push('Marca Auto list', route('platform.marcaauto.list'))
    //             ->push('Edit marcaauto');
    //     });

    // Route::screen('marcaauto/create', MarcaAutoEditScreen::class)
    //     ->name('platform.marcaauto.create')
    //     ->breadcrumbs(fn (Trail $trail) => $trail
    //         ->parent('platform.index')
    //         ->push(
    //             __('Create'),
    //             route('platform.marcaauto.create')

    //         ));

    // Route::post('marcaauto/remove/{id?}', [MarcaAutoEditScreen::class, 'delete'])->name('platform.marcaauto.remove');



    // // ----------------------------------------------------------------------
    // Route::screen('modificationauto', ModificationAutoListScreen::class)->name('platform.modificationauto.list')
    //     ->breadcrumbs(function (Trail $trail) {
    //         return $trail
    //             ->parent('platform.index')
    //             ->push('Modification list');
    //     });

    // Route::screen('modificationauto/edit/{id?}', ModificationAutoEditScreen::class)->name('platform.modificationauto.edit')
    //     ->breadcrumbs(function (Trail $trail) {
    //         return $trail
    //             ->parent('platform.index')
    //             ->push('Modification list', route('platform.modificationauto.list'))
    //             ->push('Edit Modification');
    //     });

    // Route::screen('modificationauto/create', ModificationAutoEditScreen::class)
    //     ->name('platform.modificationauto.create')
    //     ->breadcrumbs(fn (Trail $trail) => $trail
    //         ->parent('platform.index')
    //         ->push(
    //             __('Create'),
    //             route('platform.modificationauto.create')

    //         ));

    // Route::post('modificationauto/remove/{id?}', [ModificationAutoEditScreen::class, 'delete'])->name('platform.modificationauto.remove');


    // ----------------------------------------------------------------------
    Route::screen('specialfilterauto', SpecialFilterAutoListScreen::class)->name('platform.specialfilterauto.list')
        ->breadcrumbs(function (Trail $trail) {
            return $trail
                ->parent('platform.index')
                ->push('Special Filter list');
        });

    Route::screen('specialfilterauto/edit/{id?}', SpecialFilterAutoEditScreen::class)->name('platform.specialfilterauto.edit')
        ->breadcrumbs(function (Trail $trail) {
            return $trail
                ->parent('platform.index')
                ->push('Modification list', route('platform.specialfilterauto.list'))
                ->push('Edit Special Filter');
        });

    Route::screen('specialfilterauto/create', SpecialFilterAutoEditScreen::class)
        ->name('platform.specialfilterauto.create')
        ->breadcrumbs(fn (Trail $trail) => $trail
            ->parent('platform.index')
            ->push(
                __('Create'),
                route('platform.specialfilterauto.create')
            ));

    Route::post('specialfilterauto/remove/{id?}', [SpecialFilterAutoEditScreen::class, 'delete'])->name('platform.specialfilterauto.remove');


    // // ----------------------------------------------------------------------
    // Route::screen('productmarcaauto', ProductMarcaAutoListScreen::class)->name('platform.productmarcaauto.list')
    //     ->breadcrumbs(function (Trail $trail) {
    //         return $trail
    //             ->parent('platform.index')
    //             ->push('Product Marca list');
    //     });

    // Route::screen('productmarcaauto/edit/{id?}', ProductMarcaAutoEditScreen::class)->name('platform.productmarcaauto.edit')
    //     ->breadcrumbs(function (Trail $trail) {
    //         return $trail
    //             ->parent('platform.index')
    //             ->push('Modification list', route('platform.productmarcaauto.list'))
    //             ->push('Edit Product Marca ');
    //     });

    // Route::screen('productmarcaauto/create', ProductMarcaAutoEditScreen::class)
    //     ->name('platform.productmarcaauto.create')
    //     ->breadcrumbs(fn (Trail $trail) => $trail
    //         ->parent('platform.index')
    //         ->push(
    //             __('Create'),
    //             route('platform.productmarcaauto.create')

    //         ));

    // Route::post('productmarcaauto/remove/{id?}', [ProductMarcaAutoEditScreen::class, 'delete'])->name('platform.productmarcaauto.remove');


    // // ----------------------------------------------------------------------
    // Route::screen('productmodelauto', ProductModelAutoListScreen::class)->name('platform.productmodelauto.list')
    //     ->breadcrumbs(function (Trail $trail) {
    //         return $trail
    //             ->parent('platform.index')
    //             ->push('Product Model list');
    //     });

    // Route::screen('productmodelauto/edit/{id?}', ProductModelAutoEditScreen::class)->name('platform.productmodelauto.edit')
    //     ->breadcrumbs(function (Trail $trail) {
    //         return $trail
    //             ->parent('platform.index')
    //             ->push('Modification list', route('platform.productmodelauto.list'))
    //             ->push('Edit Product Model ');
    //     });

    // Route::screen('productmodelauto/create', ProductModelAutoEditScreen::class)
    //     ->name('platform.productmodelauto.create')
    //     ->breadcrumbs(fn (Trail $trail) => $trail
    //         ->parent('platform.index')
    //         ->push(
    //             __('Create'),
    //             route('platform.productmodelauto.create')

    //         ));

    // Route::post('productmodelauto/remove/{id?}', [ProductModelAutoEditScreen::class, 'delete'])->name('platform.productmodelauto.remove');


    // // ----------------------------------------------------------------------
    // Route::screen('productmodificationauto', ProductModificationAutoListScreen::class)->name('platform.productmodificationauto.list')
    //     ->breadcrumbs(function (Trail $trail) {
    //         return $trail
    //             ->parent('platform.index')
    //             ->push('Product Modification list');
    //     });

    // Route::screen('productmodificationauto/edit/{id?}', ProductModificationAutoEditScreen::class)->name('platform.productmodificationauto.edit')
    //     ->breadcrumbs(function (Trail $trail) {
    //         return $trail
    //             ->parent('platform.index')
    //             ->push('Modification list', route('platform.productmodificationauto.list'))
    //             ->push('Edit Product Modification ');
    //     });

    // Route::screen('productmodificationauto/create', ProductModificationAutoEditScreen::class)
    //     ->name('platform.productmodificationauto.create')
    //     ->breadcrumbs(fn (Trail $trail) => $trail
    //         ->parent('platform.index')
    //         ->push(
    //             __('Create'),
    //             route('platform.productmodificationauto.create')

    //         ));

    // Route::post('productmodificationauto/remove/{id?}', [ProductModificationAutoEditScreen::class, 'delete'])->name('platform.productmodificationauto.remove');


    // // ----------------------------------------------------------------------
    // Route::screen('productmodificationauto', ProductModificationAutoListScreen::class)->name('platform.productmodificationauto.list')
    //     ->breadcrumbs(function (Trail $trail) {
    //         return $trail
    //             ->parent('platform.index')
    //             ->push('Product Modification list');
    //     });

    // Route::screen('productmodificationauto/edit/{id?}', ProductModificationAutoEditScreen::class)->name('platform.productmodificationauto.edit')
    //     ->breadcrumbs(function (Trail $trail) {
    //         return $trail
    //             ->parent('platform.index')
    //             ->push('Modification list', route('platform.productmodificationauto.list'))
    //             ->push('Edit Product Modification ');
    //     });

    // Route::screen('productmodificationauto/create', ProductModificationAutoEditScreen::class)
    //     ->name('platform.productmodificationauto.create')
    //     ->breadcrumbs(fn (Trail $trail) => $trail
    //         ->parent('platform.index')
    //         ->push(
    //             __('Create'),
    //             route('platform.productmodificationauto.create')

    //         ));

    // Route::post('productmodificationauto/remove/{id?}', [ProductModificationAutoEditScreen::class, 'delete'])->name('platform.productmodificationauto.remove');


    // ----------------------------------------------------------------------
    Route::screen('benefits', BenefitsListScreen::class)->name('platform.benefits.list')
        ->breadcrumbs(function (Trail $trail) {
            return $trail
                ->parent('platform.index')
                ->push('Benefits list');
        });

    Route::screen('benefits/edit/{id?}', BenefitsEditScreen::class)->name('platform.benefits.edit')
        ->breadcrumbs(function (Trail $trail) {
            return $trail
                ->parent('platform.index')
                ->push('Modification list', route('platform.benefits.list'))
                ->push('Edit benefits ');
        });

    Route::screen('benefits/create', BenefitsEditScreen::class)
        ->name('platform.benefits.create')
        ->breadcrumbs(fn (Trail $trail) => $trail
            ->parent('platform.index')
            ->push(
                __('Create'),
                route('platform.benefits.create')

            ));

    Route::post('benefits/remove/{id?}', [BenefitsEditScreen::class, 'delete'])->name('platform.benefits.remove');


    // ----------------------------------------------------------------------
    Route::screen('favorite', FavoriteListScreen::class)->name('platform.favorite.list')
        ->breadcrumbs(function (Trail $trail) {
            return $trail
                ->parent('platform.index')
                ->push('Favorite list');
        });

    Route::screen('favorite/edit/{id?}', FavoriteEditScreen::class)->name('platform.favorite.edit')
        ->breadcrumbs(function (Trail $trail) {
            return $trail
                ->parent('platform.index')
                ->push('Favorite list', route('platform.favorite.list'))
                ->push('Edit favorite ');
        });

    Route::screen('favorite/create', FavoriteEditScreen::class)
        ->name('platform.favorite.create')
        ->breadcrumbs(fn (Trail $trail) => $trail
            ->parent('platform.index')
            ->push(
                __('Create'),
                route('platform.favorite.create')

            ));

    Route::post('favorite/remove/{id?}', [FavoriteEditScreen::class, 'delete'])->name('platform.favorite.remove');


    // ----------------------------------------------------------------------
    Route::screen('filter', FilterListScreen::class)->name('platform.filter.list')
        ->breadcrumbs(function (Trail $trail) {
            return $trail
                ->parent('platform.index')
                ->push('Filter list');
        });

    Route::screen('filter/edit/{id?}', FilterEditScreen::class)->name('platform.filter.edit')
        ->breadcrumbs(function (Trail $trail) {
            return $trail
                ->parent('platform.index')
                ->push('Filter list', route('platform.filter.list'))
                ->push('Edit filter ');
        });

    Route::screen('filter/create', FilterEditScreen::class)
        ->name('platform.filter.create')
        ->breadcrumbs(fn (Trail $trail) => $trail
            ->parent('platform.index')
            ->push(
                __('Create'),
                route('platform.filter.create')

            ));

    Route::post('filter/remove/{id?}', [FilterEditScreen::class, 'delete'])->name('platform.filter.remove');


    // ----------------------------------------------------------------------
    Route::screen('filtervalue', FilterValueListScreen::class)->name('platform.filtervalue.list')
        ->breadcrumbs(function (Trail $trail) {
            return $trail
                ->parent('platform.index')
                ->push('Filter value list');
        });

    Route::screen('filtervalue/edit/{id?}', FilterValueEditScreen::class)->name('platform.filtervalue.edit')
        ->breadcrumbs(function (Trail $trail) {
            return $trail
                ->parent('platform.index')
                ->push('Filter value list', route('platform.filtervalue.list'))
                ->push('Edit filter value ');
        });

    Route::screen('filtervalue/create', FilterValueEditScreen::class)
        ->name('platform.filtervalue.create')
        ->breadcrumbs(fn (Trail $trail) => $trail
            ->parent('platform.index')
            ->push(
                __('Create'),
                route('platform.filtervalue.create')

            ));

    Route::post('filtervalue/remove/{id?}', [FilterValueEditScreen::class, 'delete'])->name('platform.filtervalue.remove');


    // ----------------------------------------------------------------------
    Route::screen('filterproduct', FilterProductListScreen::class)->name('platform.filterproduct.list')
        ->breadcrumbs(function (Trail $trail) {
            return $trail
                ->parent('platform.index')
                ->push('Filter product list');
        });

    Route::screen('filterproduct/edit/{id?}', FilterProductEditScreen::class)->name('platform.filterproduct.edit')
        ->breadcrumbs(function (Trail $trail) {
            return $trail
                ->parent('platform.index')
                ->push('Filter product list', route('platform.filterproduct.list'))
                ->push('Edit filter product ');
        });

    Route::screen('filterproduct/create', FilterProductEditScreen::class)
        ->name('platform.filterproduct.create')
        ->breadcrumbs(fn (Trail $trail) => $trail
            ->parent('platform.index')
            ->push(
                __('Create'),
                route('platform.filterproduct.create')

            ));

    Route::post('filterproduct/remove/{id?}', [FilterProductEditScreen::class, 'delete'])->name('platform.filterproduct.remove');


    // ----------------------------------------------------------------------
    Route::screen('filtercategory', FilterCategoryListScreen::class)->name('platform.filtercategory.list')
        ->breadcrumbs(function (Trail $trail) {
            return $trail
                ->parent('platform.index')
                ->push('Filter category list');
        });

    Route::screen('filtercategory/edit/{id?}', FilterCategoryEditScreen::class)->name('platform.filtercategory.edit')
        ->breadcrumbs(function (Trail $trail) {
            return $trail
                ->parent('platform.index')
                ->push('Filter category list', route('platform.filtercategory.list'))
                ->push('Edit filter category ');
        });

    Route::screen('filtercategory/create', FilterCategoryEditScreen::class)
        ->name('platform.filtercategory.create')
        ->breadcrumbs(fn (Trail $trail) => $trail
            ->parent('platform.index')
            ->push(
                __('Create'),
                route('platform.filtercategory.create')

            ));

    Route::post('filtercategory/remove/{id?}', [FilterCategoryEditScreen::class, 'delete'])->name('platform.filtercategory.remove');


    // ----------------------------------------------------------------------
    Route::screen('paynetwallet', PaynetWalletListScreen::class)->name('platform.paynetwallet.list')
        ->breadcrumbs(function (Trail $trail) {
            return $trail
                ->parent('platform.index')
                ->push('Paynet Wallet list');
        });

    Route::screen('paynetwallet/edit/{id?}', PaynetWalletEditScreen::class)->name('platform.paynetwallet.edit')
        ->breadcrumbs(function (Trail $trail) {
            return $trail
                ->parent('platform.index')
                ->push('Paynet Wallet list', route('platform.paynetwallet.list'))
                ->push('Edit paynet wallet ');
        });

    Route::screen('paynetwallet/create', PaynetWalletEditScreen::class)
        ->name('platform.paynetwallet.create')
        ->breadcrumbs(fn (Trail $trail) => $trail
            ->parent('platform.index')
            ->push(
                __('Create'),
                route('platform.paynetwallet.create')

            ));

    Route::post('paynetwallet/remove/{id?}', [PaynetWalletEditScreen::class, 'delete'])->name('platform.paynetwallet.remove');


    // ----------------------------------------------------------------------
    Route::screen('transaction', TransactionListScreen::class)->name('platform.transaction.list')
        ->breadcrumbs(function (Trail $trail) {
            return $trail
                ->parent('platform.index')
                ->push('Transaction list');
        });

    // ----------------------------------------------------------------------
    Route::screen('paynettransaction', PaynetTransactionListScreen::class)->name('platform.paynettransaction.list')
        ->breadcrumbs(function (Trail $trail) {
            return $trail
                ->parent('platform.index')
                ->push('Paynet Transaction list');
        });

    // ----------------------------------------------------------------------
    Route::screen('paynettransactionjurnal', PaynetTransactionJurnalListScreen  ::class)->name('platform.paynettransactionjurnal.list')
        ->breadcrumbs(function (Trail $trail) {
            return $trail
                ->parent('platform.index')
                ->push('Paynet Transaction Journal list');
        });


    // ---------------------------------------------------------------------
    Route::screen('acl', AclListScreen::class)->name('platform.acl.list')
        ->breadcrumbs(function (Trail $trail) {
            return $trail
                ->parent('platform.index')
                ->push('acl list');
        });


    Route::get('label/editcl/{id?}', [LabelEditScreen::class, 'changeLang'])->name('platform.label.editcl');

    Route::get('page/editcl/{id?}', [PageEditScreen::class, 'changeLang'])->name('platform.page.editcl');

    Route::get('gallery/editcl/{id?}', [GalleryEditScreen::class, 'changeLang'])->name('platform.gallery.editcl');

    Route::get('video/editcl/{id?}', [VideoEditScreen::class, 'changeLang'])->name('platform.video.editcl');

    Route::get('systemmenu/editcl/{id?}', [SystemMenuEditScreen::class, 'changeLang'])->name('platform.systemmenu.editcl');

    Route::get('attachements/editcl/{id?}', [AttachementsEditScreen::class, 'changeLang'])->name('platform.attachements.editcl');

    Route::get('faq/editcl/{id?}', [FaqEditScreen::class, 'changeLang'])->name('platform.faq.editcl');

    Route::get('faqresponses/editcl/{id?}', [FaqResponsesEditScreen::class, 'changeLang'])->name('platform.faqresponses.editcl');

    Route::get('publicity/editcl/{id?}', [PublicityEditScreen::class, 'changeLang'])->name('platform.publicity.editcl');

    Route::get('socialmedia/editcl/{id?}', [SocialMediaEditScreen::class, 'changeLang'])->name('platform.socialmedia.editcl');

    Route::get('fromemail/editcl/{id?}', [FromEmailEditScreen::class, 'changeLang'])->name('platform.fromemail.editcl');

    Route::get('emailtemplate/editcl/{id?}', [EmailTemplateEditScreen::class, 'changeLang'])->name('platform.emailtemplate.editcl');

    Route::get('smstemplate/editcl/{id?}', [SmsTemplateEditScreen::class, 'changeLang'])->name('platform.smstemplate.editcl');

    Route::get('subscription/editcl/{id?}', [SubscriptionEditScreen::class, 'changeLang'])->name('platform.subscription.editcl');

    Route::get('mailtosend/editcl/{id?}', [MailToSendEditScreen::class, 'changeLang'])->name('platform.mailtosend.editcl');

    Route::get('smstosend/editcl/{id?}', [SmsToSendEditScreen::class, 'changeLang'])->name('platform.smstosend.editcl');

    Route::get('category/editcl/{id?}', [CategoryEditScreen::class, 'changeLang'])->name('platform.category.editcl');

    Route::get('product/editcl/{id?}', [ProductEditScreen::class, 'changeLang'])->name('platform.product.editcl');

    Route::get('productcategory/editcl/{id?}', [ProductCategoryEditScreen::class, 'changeLang'])->name('platform.productcategory.editcl');

    Route::get('infouser/editcl/{id?}', [UserInfoEditScreen::class, 'changeLang'])->name('platform.infouser.editcl');

    Route::get('order/editcl/{id?}', [OrderEditScreen::class, 'changeLang'])->name('platform.order.editcl');

    // Route::get('orderdetails/editcl/{id?}', [OrderDetailsEditScreen::class, 'changeLang'])->name('platform.orderdetails.editcl');
    
    Route::get('orderproduct/editcl/{id?}', [OrderProductEditScreen::class, 'changeLang'])->name('platform.orderproduct.editcl');

    Route::get('offer/editcl/{id?}', [OfferEditScreen::class, 'changeLang'])->name('platform.offer.editcl');

    Route::get('location/editcl/{id?}', [LocationEditScreen::class, 'changeLang'])->name('platform.location.editcl');
    
    // Route::get('modelauto/editcl/{id?}', [ModelAutoEditScreen::class, 'changeLang'])->name('platform.modelauto.editcl');
    // Route::get('marcaauto/editcl/{id?}', [MarcaAutoEditScreen::class, 'changeLang'])->name('platform.marcaauto.editcl');
    // Route::get('modificationauto/editcl/{id?}', [ModificationAutoEditScreen::class, 'changeLang'])->name('platform.modificationauto.editcl');
    // Route::get('productmarcaauto/editcl/{id?}', [ProductMarcaAutoEditScreen::class, 'changeLang'])->name('platform.productmarcaauto.editcl');
    // Route::get('productmodelauto/editcl/{id?}', [ProductModelAutoEditScreen::class, 'changeLang'])->name('platform.productmodelauto.editcl');

    Route::get('maps/editcl/{id?}', [MapsEditScreen::class, 'changeLang'])->name('platform.maps.editcl');

    Route::get('specialfilterauto/editcl/{id?}', [SpecialFilterAutoEditScreen::class, 'changeLang'])->name('platform.specialfilterauto.editcl');

    Route::get('benefits/editcl/{id?}', [BenefitsEditScreen::class, 'changeLang'])->name('platform.benefits.editcl');

    Route::get('filter/editcl/{id?}', [FilterEditScreen::class, 'changeLang'])->name('platform.filter.editcl');

    Route::get('filtervalue/editcl/{id?}', [FilterValueEditScreen::class, 'changeLang'])->name('platform.filtervalue.editcl');
    Route::get('filterproduct/editcl/{id?}', [FilterProductEditScreen::class, 'changeLang'])->name('platform.filterproduct.editcl');
    Route::get('systemmenu/editcl/{id?}', [SystemMenuEditScreen::class, 'changePage'])->name('platform.systemmenu.editcl');

    Route::get('/execselectadmin', [ProductCategoryController::class, 'execSelectCategory'])->name('platform.execselectadmin');

    Route::get('/execselectadminorder', [LocationController::class, 'execSelectLocation'])->name('platform.execselectadminorder');

    Route::get('/execselectadminfiltervalue', [FilterController::class, 'execSelectFilterValue'])->name('platform.execselectadminfiltervalue');

    // Route::get('/execselectmodelauto', [AutoController::class, 'execSelectModelAuto'])->name('platform.execselectmodelauto');

    // Route::get('/execselectmodificationauto', [AutoController::class, 'execSelectModificationAuto'])->name('platform.execselectmodificationauto');
    
    // ORDER STATUS ================================================================================
    Route::get('/setnew', [OrderDetailsListScreen::class, 'setNew'])->name('platform.setNew');
    Route::get('/setpending', [OrderDetailsListScreen::class, 'setPending'])->name('platform.setPending');
    Route::get('/setverified', [OrderDetailsListScreen::class, 'setVerified'])->name('platform.setVerified');
    Route::get('/setinprocess', [OrderDetailsListScreen::class, 'setInProcess'])->name('platform.setInProcess');
    Route::get('/setprocessed', [OrderDetailsListScreen::class, 'setProcessed'])->name('platform.setProcessed');
    Route::get('/setontransit', [OrderDetailsListScreen::class, 'setOnTransit'])->name('platform.setOnTransit');
    Route::get('/setondelivery', [OrderDetailsListScreen::class, 'setOnDelivery'])->name('platform.setOnDelivery');
    Route::get('/setdelivered', [OrderDetailsListScreen::class, 'setDelivered'])->name('platform.setDelivered');
    Route::get('/setconfirmed', [OrderDetailsListScreen::class, 'setConfirmed'])->name('platform.setConfirmed');
    Route::get('/setarhived', [OrderDetailsListScreen::class, 'setArhived'])->name('platform.setArhived');
    Route::get('/setcanceled', [OrderDetailsListScreen::class, 'setCanceled'])->name('platform.setCanceled');
    
    // ORDER PAYMENT STATUTS ================================================================================
    Route::get('/setunpaid', [OrderDetailsListScreen::class, 'setUnpaid'])->name('platform.setUnpaid');
    Route::get('/setpaid', [OrderDetailsListScreen::class, 'setPaid'])->name('platform.setPaid');
    Route::get('/setneedreturn', [OrderDetailsListScreen::class, 'setNeedReturn'])->name('platform.setNeedReturn');
    Route::get('/setreturned', [OrderDetailsListScreen::class, 'setReturned'])->name('platform.setReturned');
    Route::get('/setpaymentcanceled', [OrderDetailsListScreen::class, 'setPaymentCanceled'])->name('platform.setPaymentCanceled');
    
    Route::post('/systemrelation', [MyRelationController::class, 'view'])->name('platform.systemsAdmin.relation');
    
    
    Route::post('/ordermessage', [OrderDetailsListScreen::class, 'execOrderMessage'])->name('platform.ordermessage');
    
    Route::get('acl/editcl', [AclListScreen::class, 'saveACL'])->name('platform.acl.editcl');
    Route::get('execdeleteorderproduct', [OrderDetailsListScreen::class, 'deleteOrderProduct'])->name('platform.deleteOrderProduct');
});
