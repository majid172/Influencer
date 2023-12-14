<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\NotifyController;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\TemplateController;
use App\Http\Controllers\SubscribeController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\SmsControlController;
use App\Http\Controllers\Admin\LevelController;
use App\Http\Controllers\SmsTemplateController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\AdminProfileController;
use App\Http\Controllers\BasicControlController;
use App\Http\Controllers\PayoutMethodController;
use App\Http\Controllers\Admin\CountryController;
use App\Http\Controllers\Admin\AdminJobController;
use App\Http\Controllers\Admin\AdminListingController;
use App\Http\Controllers\EmailTemplateController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\SkillController;
use App\Http\Controllers\Admin\DeadlineController;
use App\Http\Controllers\Admin\AdminFundController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\PaymentLogController;
use App\Http\Controllers\Admin\PushNotifyController;
use App\Http\Controllers\SiteNotificationController;
use App\Http\Controllers\Admin\AdminPayoutController;
use App\Http\Controllers\Admin\AdminTicketController;
use App\Http\Controllers\Admin\SubCategoryController;
use App\Http\Controllers\Admin\MessengerController;
use App\Http\Controllers\Admin\AddDayController;
use App\Http\Controllers\Admin\AdminDepositController;
use App\Http\Controllers\Admin\AdminStorageController;
use App\Http\Controllers\Admin\ManualGatewayController;
use App\Http\Controllers\Admin\AdminTransactionController;
use App\Http\Controllers\Admin\Auth\ResetPasswordController;
use App\Http\Controllers\Admin\Auth\ForgotPasswordController;
use App\Http\Controllers\Admin\ListingOrderController;

Route::group(['prefix' => 'admin'], function () {
	/* Authentication Routes */
	Route::get('/', [LoginController::class, 'showLoginForm'])->name('admin.login');
	Route::post('login', [LoginController::class, 'login'])->name('admin.auth.login');

	/* Password Reset Routes */
	Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('admin.password.request');
	Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('admin.password.email');
	Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('admin.password.reset')->middleware('guest');
	Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('admin.password.reset.update');
});


Route::group(['prefix' => 'admin', 'middleware' => ['auth:admin', 'demo']], function () {

	Route::post('/save-token', [AdminController::class, 'saveToken'])->name('admin.save.token');

	/* ===== ADMIN STORAGE ===== */
	Route::get('storage', [AdminStorageController::class, 'index'])->name('storage.index');
	Route::any('storage/edit/{id}', [AdminStorageController::class, 'edit'])->name('storage.edit');
	Route::post('storage/set-default/{id}', [AdminStorageController::class, 'setDefault'])->name('storage.setDefault');

	/* USER LIST */
	Route::get('user-list', [UserController::class, 'index'])->name('user-list');
	Route::get('inactive-user-list', [UserController::class, 'inactiveUserList'])->name('inactive.user.list');

	Route::get('user-search', [UserController::class, 'search'])->name('user.search');
	Route::get('inactive-user-search', [UserController::class, 'inactiveUserSearch'])->name('inactive.user.search');

	Route::match(['get', 'post'], 'user-edit/{user}', [UserController::class, 'edit'])->name('user.edit');
	Route::post('user-balance/update/{id}', [UserController::class, 'userBalanceUpdate'])->name('user.balance.update');
	Route::match(['get', 'post'], 'user-asLogin/{user}', [UserController::class, 'asLogin'])->name('user.asLogin');
	Route::match(['get', 'post'], 'send-mail-user/{user?}', [UserController::class, 'sendMailUser'])->name('send.mail.user');

	/* PROFILE SHOW UPDATE BY USER */
	Route::match(['get', 'post'], 'profile', [AdminProfileController::class, 'index'])->name('admin.profile');
	Route::match(['get', 'post'], 'change-password', [AdminController::class, 'changePassword'])->name('admin.change.password');

	/* PAYMENT METHOD MANAGE BY ADMIN*/
	Route::get('payment-methods', [PaymentMethodController::class, 'index'])->name('payment.methods');
	Route::get('edit-payment-methods/{id}', [PaymentMethodController::class, 'edit'])->name('edit.payment.methods');
	Route::put('update-payment-methods/{id}', [PaymentMethodController::class, 'update'])->name('update.payment.methods');
	Route::post('sort-payment-methods', [PaymentMethodController::class, 'sortPaymentMethods'])->name('sort.payment.methods');

	Route::get('push-notification-show', [SiteNotificationController::class, 'showByAdmin'])->name('admin.push.notification.show');
	Route::get('push.notification.readAll', [SiteNotificationController::class, 'readAllByAdmin'])->name('admin.push.notification.readAll');
	Route::get('push-notification-readAt/{id}', [SiteNotificationController::class, 'readAt'])->name('admin.push.notification.readAt');

	/* PAYOUT METHOD MANAGE BY ADMIN */
	Route::get('payout-method-list', [PayoutMethodController::class, 'index'])->name('payout.method.list');
	Route::match(['get', 'put'], 'payout-method/{payoutMethod}', [PayoutMethodController::class, 'edit'])->name('payout.method.edit');
	Route::match(['get', 'post'], 'payout-method-add', [PayoutMethodController::class, 'addMethod'])->name('payout.method.add');

	/* ===== DEPOSIT VIEW MANAGE BY ADMIN ===== */
	Route::match(['get', 'post'], 'add-balance-user/{userId}', [AdminDepositController::class, 'addBalanceUser'])->name('admin.user.add.balance');

	/* ===== FUND ADD VIEW MANAGE BY ADMIN ===== */
	Route::get('fund-add-list', [AdminFundController::class, 'index'])->name('admin.fund.add.index');
	Route::get('fund-add-search', [AdminFundController::class, 'search'])->name('admin.fund.add.search');
	Route::get('fund-add-list/{userId}', [AdminFundController::class, 'showByUser'])->name('admin.user.fund.add.show');
	Route::get('fund-add-search/{userId}', [AdminFundController::class, 'searchByUser'])->name('admin.user.fund.add.search');

	// Manual Methods
	Route::get('payment-methods/manual', [ManualGatewayController::class, 'index'])->name('admin.deposit.manual.index');
	Route::get('payment-methods/manual/new', [ManualGatewayController::class, 'create'])->name('admin.deposit.manual.create');
	Route::post('payment-methods/manual/new', [ManualGatewayController::class, 'store'])->name('admin.deposit.manual.store');
	Route::get('payment-methods/manual/edit/{id}', [ManualGatewayController::class, 'edit'])->name('admin.deposit.manual.edit');
	Route::put('payment-methods/manual/update/{id}', [ManualGatewayController::class, 'update'])->name('admin.deposit.manual.update');

	Route::get('payment/pending', [PaymentLogController::class, 'pending'])->name('admin.payment.pending');
	Route::put('payment/action/{id}', [PaymentLogController::class, 'action'])->name('admin.payment.action');
	Route::get('payment/log', [PaymentLogController::class, 'index'])->name('admin.payment.log');
	Route::get('payment/search', [PaymentLogController::class, 'search'])->name('admin.payment.search');

	/* ===== PAYOUT VIEW MANAGE BY ADMIN ===== */
	Route::get('payout-list', [AdminPayoutController::class, 'index'])->name('admin.payout.index');
	Route::get('payout-search', [AdminPayoutController::class, 'search'])->name('admin.payout.search');
	Route::get('payout-list/{userId}', [AdminPayoutController::class, 'showByUser'])->name('admin.user.payout.show');
	Route::get('payout-search/{userId}', [AdminPayoutController::class, 'searchByUser'])->name('admin.user.payout.search');
	Route::get('details-payout/{utr}', [AdminPayoutController::class, 'show'])->name('payout.details');
	Route::post('confirm-payout/{utr}', [AdminPayoutController::class, 'confirmPayout'])->name('admin.user.payout.confirm');
	Route::post('cancel-payout/{utr}', [AdminPayoutController::class, 'cancelPayout'])->name('admin.user.payout.cancel');

	/* ===== BASIC CONTROL MANAGE BY ADMIN ===== */
	Route::get('settings/{settings?}', [BasicControlController::class, 'index'])->name('settings');

	Route::match(['get', 'post'], 'basic-control', [BasicControlController::class, 'basic_control'])->name('basic.control');
	Route::match(['get', 'post'], 'service-control', [BasicControlController::class, 'serviceControl'])->name('service.control');
	Route::match(['get', 'post'], 'pusher-config', [BasicControlController::class, 'pusherConfig'])->name('pusher.config');
	Route::match(['get', 'post'], 'email-config', [BasicControlController::class, 'emailConfig'])->name('email.config');
	Route::match(['get', 'post'], 'sms-config', [SmsControlController::class, 'smsConfig'])->name('sms.config');
	Route::match(['get', 'post'], 'firebase-config', [BasicControlController::class, 'firebaseConfig'])->name('firebase.config');

	Route::get('plugin-config', [BasicControlController::class, 'pluginConfig'])->name('plugin.config');
	Route::match(['get', 'post'], 'tawk-config', [BasicControlController::class, 'tawkConfig'])->name('tawk.control');
	Route::match(['get', 'post'], 'fb-messenger-config', [BasicControlController::class, 'fbMessengerConfig'])->name('fb.messenger.control');
	Route::match(['get', 'post'], 'google-recaptcha', [BasicControlController::class, 'googleRecaptchaConfig'])->name('google.recaptcha.control');
	Route::match(['get', 'post'], 'manual-recaptcha', [BasicControlController::class, 'manualRecaptchaConfig'])->name('manual.recaptcha.control');
	Route::match(['get', 'post'], 'google-analytics', [BasicControlController::class, 'googleAnalyticsConfig'])->name('google.analytics.control');

	Route::get( 'active-recaptcha', [BasicControlController::class, 'captchaControl'])->name('active.recaptcha');
	Route::get('active-manual-captcha',[BasicControlController::class,'manualCaptcha'])->name('active.manual.recaptch');

	Route::get('social-login', [BasicControlController::class, 'sociaLoginConfig'])->name('social.login.config');
	Route::match(['get', 'post'], 'google-login-config', [BasicControlController::class, 'googleLoginConfig'])->name('google.login.control');
	Route::match(['get', 'post'], 'facebook-login-config', [BasicControlController::class, 'facebookLoginConfig'])->name('facebook.login.control');
	Route::match(['get', 'post'], 'github-login-config', [BasicControlController::class, 'githubLoginConfig'])->name('github.login.control');
	Route::match(['get', 'post'], 'twitter-login-config', [BasicControlController::class, 'twitterLoginConfig'])->name('twitter.login.control');
	Route::match(['get', 'post'], 'linkedin-login-config', [BasicControlController::class, 'linkedinLoginConfig'])->name('linkedin.login.control');


	/* ===== ADMIN EMAIL-CONFIGURATION SETTINGS ===== */
	Route::get('email-templates', [EmailTemplateController::class, 'index'])->name('email.template.index');
	Route::match(['get', 'post'], 'default-template', [EmailTemplateController::class, 'defaultTemplate'])->name('email.template.default');
	Route::get('email-template/edit/{id}', [EmailTemplateController::class, 'edit'])->name('email.template.edit');
	Route::post('email-template/update/{id}', [EmailTemplateController::class, 'update'])->name('email.template.update');
	Route::post('testEmail', [EmailTemplateController::class, 'testEmail'])->name('testEmail');

	/* ===== ADMIN SMS-CONFIGURATION SETTINGS ===== */
	Route::get('sms-template', [SmsTemplateController::class, 'index'])->name('sms.template.index');
	Route::get('sms-template/edit/{id}', [SmsTemplateController::class, 'edit'])->name('sms.template.edit');
	Route::post('sms-template/update/{id}', [SmsTemplateController::class, 'update'])->name('sms.template.update');

	/* ===== ADMIN NOTIFICATION-CONFIGURATION SETTINGS ===== */
	Route::get('notify-template', [NotifyController::class, 'index'])->name('notify.template.index');
	Route::get('notify-template/edit/{id}', [NotifyController::class, 'edit'])->name('notify.template.edit');
	Route::post('notify-template/update/{id}', [NotifyController::class, 'update'])->name('notify.template.update');

	/* ===== ADMIN FIREBASE NOTIFICATION-CONFIGURATION SETTINGS ===== */
	Route::get('push/notify-template', [PushNotifyController::class, 'show'])->name('push.notify.template.index');
	Route::get('push/notify-template/edit/{id}', [PushNotifyController::class, 'edit'])->name('push.notify.template.edit');
	Route::post('push/notify-template/update/{id}', [PushNotifyController::class, 'update'])->name('push.notify.template.update');


	/* ===== ADMIN LANGUAGE SETTINGS ===== */
	Route::get('languages', [LanguageController::class, 'index'])->name('language.index');
	Route::get('language/create', [LanguageController::class, 'create'])->name('language.create');
	Route::post('language/create', [LanguageController::class, 'store'])->name('language.store');
	Route::get('language/{language}', [LanguageController::class, 'edit'])->name('language.edit');
	Route::put('language/{language}', [LanguageController::class, 'update'])->name('language.update');
	Route::delete('language-delete/{language}', [LanguageController::class, 'destroy'])->name('language.delete');

	Route::get('language-keyword/{language}', [LanguageController::class, 'keywordEdit'])->name('language.keyword.edit');
	Route::put('language-keyword/{language}', [LanguageController::class, 'keywordUpdate'])->name('language.keyword.update');
	Route::post('language-import-json', [LanguageController::class, 'importJson'])->name('language.import.json');
	Route::post('store-key/{language}', [LanguageController::class, 'storeKey'])->name('language.store.key');
	Route::put('update-key/{language}', [LanguageController::class, 'updateKey'])->name('language.update.key');
	Route::delete('delete-key/{language}', [LanguageController::class, 'deleteKey'])->name('language.delete.key');


	/* ===== ADMIN SUPPORT TICKET ===== */
	Route::get('tickets', [AdminTicketController::class, 'tickets'])->name('admin.ticket');
	Route::get('tickets-search', [AdminTicketController::class, 'ticketSearch'])->name('admin.ticket.search');
	Route::get('tickets-view/{id}', [AdminTicketController::class, 'ticketReply'])->name('admin.ticket.view');
	Route::put('ticket-reply/{id}', [AdminTicketController::class, 'ticketReplySend'])->name('admin.ticket.reply');
	Route::get('ticket-download/{ticket}', [AdminTicketController::class, 'ticketDownload'])->name('admin.ticket.download');
	Route::post('ticket-delete', [AdminTicketController::class, 'ticketDelete'])->name('admin.ticket.delete');

//	Admin Listing
	Route::controller(AdminListingController::class)->prefix('/listing')->name('admin.listing.')->group(function(){
		Route::get('/list','list')->name('list');
		Route::get('search','listSearch')->name('search');
		Route::post('/approve/{id}','approve')->name('approve');
		Route::post('/cancel/{id}','cancel')->name('cancel');
		Route::get('/service-fee','serviceFee')->name('service.fee');
		Route::get('/service-fee/status/{id}','serviceStatus')->name('service.fee.status');
		Route::post('/service-fee','feeStore')->name('fee.store');
		Route::post('/service-fee/update','feeUpdate')->name('fee.update');

	});

	// admin order listing
	Route::controller(ListingOrderController::class)->prefix('/listing/order/')->name('admin.listing.order.')->group(function(){
		Route::get('/list','list')->name('list');
		Route::get('search','orderSearch')->name('search');
		Route::post('/remove','remove')->name('remove');

	});

//	Conversation.
	Route::controller(MessengerController::class)->prefix('conversation')->name('admin.conversation.')->group(function(){
		Route::get('/list','conversationList')->name('list');
	});

	// ADMIN JOB POST APPROVE
	Route::get('jobs', [AdminJobController::class, 'jobs'])->name('admin.jobs');
	Route::get('job/search',[AdminJobController::class,'jobSearch'])->name('admin.jobs.search');
	Route::post('jobs/approve/{id}', [AdminJobController::class, 'approve'])->name('admin.jobs.approve');
	Route::get('jobs/details/{id}',[AdminJobController::class,'jobDetails'])->name('admin.jobs.details');
	Route::get('job/hire/lists',[AdminJobController::class,'hireList'])->name('admin.jobs.hire');
	Route::get('job/hire/search',[AdminJobController::class,'hireSearch'])->name('admin.jobs.hire.search');
	Route::get('job/hire/escrows/{hire_id:hire_id}',[AdminJobController::class,'escrow'])->name('admin.jobs.escrow');
	Route::get('jobs/service-fee', [AdminJobController::class, 'serviceFee'])->name('admin.jobs.service.fee');
	Route::post('jobs/service-fee', [AdminJobController::class, 'serviceFeeStore'])->name('admin.jobs.service.store');
	Route::post('jobs/service-fee/update', [AdminJobController::class, 'serviceFeeUpdate'])->name('admin.jobs.service.update');
	Route::post('jobs/service-fee/{type}', [AdminJobController::class, 'changeStatus'])->name('admin.jobs.service.status');
	Route::get('job/dislike-reason', [AdminJobController::class, 'dislikeReason'])->name('admin.jobs.dislike.reason');
	Route::post('job/dislike-reason', [AdminJobController::class, 'reasonStore'])->name('admin.jobs.dislike.reason.store');
	Route::get('job/dislike_reason/edit/{id}',[AdminJobController::class,'reasonEdit'])->name('admin.jobs.dislike.edit');
	Route::post('job/dislike_reason/edit/{id}',[AdminJobController::class,'reasonUpdate'])->name('admin.jobs.dislike.update');
	Route::get('job/dislike-reason/remove/{id}', [AdminJobController::class, 'reasonRemove'])->name('admin.jobs.dislike.reason.remove');

	/* ===== ADMIN TEMPLATE SETTINGS ===== */
	Route::get('template/{section}', [TemplateController::class, 'show'])->name('template.show');
	Route::put('template/{section}/{language}', [TemplateController::class, 'update'])->name('template.update');

	Route::get('contents/{content}', [ContentController::class, 'index'])->name('content.index');
	Route::get('content-create/{content}', [ContentController::class, 'create'])->name('content.create');
	Route::put('content-create/{content}/{language?}', [ContentController::class, 'store'])->name('content.store');
	Route::get('content-show/{content}', [ContentController::class, 'show'])->name('content.show');
	Route::put('content-update/{content}/{language?}', [ContentController::class, 'update'])->name('content.update');
	Route::delete('content-delete/{id}', [ContentController::class, 'destroy'])->name('content.delete');

	Route::match(['get', 'post'], 'logo-settings', [FrontendController::class, 'logoUpdate'])->name('logo.update');
	Route::match(['get', 'post'], 'breadcrumb-settings', [FrontendController::class, 'breadcrumbUpdate'])->name('breadcrumb.update');
	Route::match(['get', 'post'], 'seo-settings', [FrontendController::class, 'seoUpdate'])->name('seo.update');

	/* ===== SUBSCRIBER VIEW MANAGE BY ADMIN ===== */
	Route::get('subscriber-list', [SubscribeController::class, 'index'])->name('subscribe.index');
	Route::get('subscriber-search', [SubscribeController::class, 'search'])->name('subscribe.search');
	Route::match(['get', 'post'], 'send-mail-subscriber/{subscribe?}', [SubscribeController::class, 'sendMailSubscribe'])->name('send.mail.subscribe');

	/* Transaction List*/
	Route::get('transaction-list', [AdminTransactionController::class, 'index'])->name('admin.transaction.index');
	Route::get('transaction-search', [AdminTransactionController::class, 'search'])->name('admin.transaction.search');
	Route::get('transaction-list/{userId}', [AdminTransactionController::class, 'showByUser'])->name('admin.user.transaction.show');
	Route::get('transaction-search/{userId}', [AdminTransactionController::class, 'searchByUser'])->name('admin.user.transaction.search');

	Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.home');
	Route::post('logout', [LoginController::class, 'logout'])->name('admin.logout');


	/* ===== Admin Blog Management ===== */
	Route::get('/blog/category', [BlogController::class, 'categoryList'])->name('admin.blogCategory');
	Route::get('/blog/category/create', [BlogController::class, 'blogCategoryCreate'])->name('admin.blogCategoryCreate');
	Route::post('/blog/category/store/{language?}', [BlogController::class, 'blogCategoryStore'])->name('admin.blogCategoryStore');
	Route::get('/blog/category/edit/{id}', [BlogController::class, 'blogCategoryEdit'])->name('admin.blogCategoryEdit');
	Route::put('/blog/category/update/{id}/{language?}', [BlogController::class, 'blogCategoryUpdate'])->name('admin.blogCategoryUpdate');
	Route::delete('/blog/category/delete/{id}', [BlogController::class, 'blogCategoryDelete'])->name('admin.blogCategoryDelete');

	Route::get('/blog/list', [BlogController::class, 'blogList'])->name('admin.blogList');
	Route::get('/blog/create', [BlogController::class, 'blogCreate'])->name('admin.blogCreate');
	Route::post('/blog/store/{language?}', [BlogController::class, 'blogStore'])->name('admin.blogStore');
	Route::get('/blog/edit/{id}', [BlogController::class, 'blogEdit'])->name('admin.blogEdit');
	Route::put('/blog/update/{id}/{language?}', [BlogController::class, 'blogUpdate'])->name('admin.blogUpdate');
	Route::delete('/blog/delete/{id}', [BlogController::class, 'blogDelete'])->name('admin.blogDelete');


	/* ===== Admin Category Management ===== */
	Route::get('/category', [CategoryController::class, 'categoryList'])->name('admin.category.index');
	Route::get('/category/create', [CategoryController::class, 'categoryCreate'])->name('admin.category.create');
	Route::post('/category/store/{language?}', [CategoryController::class, 'categoryStore'])->name('admin.category.store');
	Route::get('/category/edit/{id}', [CategoryController::class, 'categoryEdit'])->name('admin.category.edit');
	Route::put('/category/update/{id}/{language?}', [CategoryController::class, 'categoryUpdate'])->name('admin.category.update');
	Route::delete('/category/delete/{id}', [CategoryController::class, 'categoryDelete'])->name('admin.category.delete');

	/* ===== Admin Sub-Category Management ===== */
	Route::get('/subCategory', [SubCategoryController::class, 'subCategoryList'])->name('admin.subCategory.index');
	Route::get('/subCategory/create', [SubCategoryController::class, 'subCategoryCreate'])->name('admin.subCategory.create');
	Route::post('/subCategory/store/{language?}', [SubCategoryController::class, 'subCategoryStore'])->name('admin.subCategory.store');
	Route::get('/subCategory/edit/{id}', [SubCategoryController::class, 'subCategoryEdit'])->name('admin.subCategory.edit');
	Route::get('/subCategory/edit/{id}', [SubCategoryController::class, 'subCategoryEdit'])->name('admin.subCategory.edit');
	Route::put('/subCategory/update/{id}/{language?}', [SubCategoryController::class, 'subCategoryUpdate'])->name('admin.subCategory.update');
	Route::delete('/subCategory/delete/{id}', [SubCategoryController::class, 'subCategoryDelete'])->name('admin.subCategory.delete');


	//  ====== Admin skill management ======
	Route::get('skill', [SkillController::class, 'list'])->name('admin.skill.list');
	Route::post('skill', [SkillController::class, 'skillStore'])->name('admin.skill.store');
	Route::get('skill/edit/{id}', [SkillController::class, 'skillEdit'])->name('admin.skill.edit');
	Route::post('skill/update/{id}', [SkillController::class, 'skillUpdate'])->name('admin.skill.update');
	Route::post('skill/delete/{id}', [SkillController::class, 'skillDelete'])->name('admin.skill.delete');

	// ===== Admin project deadline
	Route::get('deadline', [DeadlineController::class, 'index'])->name('admin.deadline');
	Route::post('deadline', [DeadlineController::class, 'store'])->name('admin.deadline.store');
	Route::post('deadline/delete/{id}', [DeadlineController::class, 'deadlineDelete'])->name('admin.deadline.delete');


	/* ===== Admin Rank-Level Management ===== */
	Route::get('/rank/level', [LevelController::class, 'levelList'])->name('admin.level.index');
	Route::get('/rank/level/create', [LevelController::class, 'levelCreate'])->name('admin.level.create');
	Route::post('/rank/level/store/{language?}', [LevelController::class, 'levelStore'])->name('admin.level.store');
	Route::get('/rank/level/edit/{id}', [LevelController::class, 'levelEdit'])->name('admin.level.edit');
	Route::put('/rank/level/update/{id}/{language?}', [LevelController::class, 'levelUpdate'])->name('admin.level.update');
	Route::delete('/rank/level/delete/{id}', [LevelController::class, 'levelDelete'])->name('admin.level.delete');

	/* ===== Admin Country Manage ===== */
	Route::get('/country/List', [CountryController::class, 'countryList'])->name('admin.countryList');
	Route::get('/country/create', [CountryController::class, 'countryCreate'])->name('admin.countryCreate');
	Route::post('/country/store', [CountryController::class, 'countryStore'])->name('admin.countryStore');
	Route::get('/country/edit/{id}', [CountryController::class, 'countryEdit'])->name('admin.countryEdit');
	Route::put('/country/update/{id}', [CountryController::class, 'countryUpdate'])->name('admin.countryUpdate');
	Route::delete('/country/delete/{id}', [CountryController::class, 'countryDelete'])->name('admin.countryDelete');

	/* ===== Admin State Manage ===== */
	Route::get('/state/List', [CountryController::class, 'stateList'])->name('admin.stateList');
	Route::get('/state/create', [CountryController::class, 'stateCreate'])->name('admin.stateCreate');
	Route::post('/state/store', [CountryController::class, 'stateStore'])->name('admin.stateStore');
	Route::get('/state/edit/{id}', [CountryController::class, 'stateEdit'])->name('admin.stateEdit');
	Route::put('/state/update/{id}', [CountryController::class, 'stateUpdate'])->name('admin.stateUpdate');
	Route::delete('/state/delete/{id}', [CountryController::class, 'stateDelete'])->name('admin.stateDelete');
	Route::get('/state/search', [CountryController::class, 'stateSearch'])->name('admin.state.search');

	/* ===== Admin City Manage ===== */
	Route::get('/city/List', [CountryController::class, 'cityList'])->name('admin.cityList');
	Route::get('/city/create', [CountryController::class, 'cityCreate'])->name('admin.cityCreate');
	Route::post('/city/store', [CountryController::class, 'cityStore'])->name('admin.cityStore');
	Route::get('/city/edit/{id}', [CountryController::class, 'cityEdit'])->name('admin.cityEdit');
	Route::put('/city/update/{id}', [CountryController::class, 'cityUpdate'])->name('admin.cityUpdate');
	Route::delete('/city/delete/{id}', [CountryController::class, 'cityDelete'])->name('admin.cityDelete');
	Route::get('/city/search', [CountryController::class, 'citySearch'])->name('admin.city.search');

	// user profile make approve/pending
	Route::put('/users/profile/approve/{id}', [AdminController::class, 'profileApprove'])->name('admin.profile-approve');
	Route::put('/users/profile/pending/{id}', [AdminController::class, 'profilePending'])->name('admin.profile-pending');

});
