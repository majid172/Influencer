<?php
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FundController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SocialLinkController;
use App\Http\Controllers\PayoutController;
use App\Http\Controllers\Influencer\OrderController;
use App\Http\Controllers\DepositController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\SupportController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\FaSecurityController;
use App\Http\Controllers\khaltiPaymentController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\User\MessageController;
use App\Http\Controllers\Influencer\ListingCheckoutController;
use App\Http\Controllers\SiteNotificationController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\User\CertificationController;
use App\Http\Controllers\User\EducationInfoController;
use App\Http\Controllers\ManualRecaptchaController;

Route::get('clear', function () {
	return \Illuminate\Support\Facades\Artisan::call('optimize:clear');
});
Route::get('queue-work', function () {
	return Illuminate\Support\Facades\Artisan::call('queue:work', ['--stop-when-empty' => true]);
})->name('queue.work');

Route::get('schedule-run', function () {
	return Illuminate\Support\Facades\Artisan::call('schedule:run');
})->name('schedule:run');

Route::get('limit-cron', function () {
	return Illuminate\Support\Facades\Artisan::call('limit:cron');
})->name('limit:cron');

Route::get('removeStatus', function () {
	session()->forget('status');
})->name('removeStatus');

Route::match(['get', 'post'], 'success', [PaymentController::class, 'success'])->name('success');
Route::match(['get', 'post'], 'failed', [PaymentController::class, 'failed'])->name('failed');
Route::match(['get', 'post'], 'payment/{code}/{trx?}/{type?}', [PaymentController::class, 'gatewayIpn'])->name('ipn');
Route::post('/khalti/payment/verify/{trx}', [khaltiPaymentController::class, 'verifyPayment'])->name('khalti.verifyPayment');
Route::post('/khalti/payment/store', [khaltiPaymentController::class, 'storePayment'])->name('khalti.storePayment');


Route::group(['prefix' => 'user', 'middleware' => ['auth', 'verifyUser']], function () {

	Route::get('/dashboard', [HomeController::class, 'index'])->name('user.dashboard');
	Route::get('get-transaction-chart', [HomeController::class, 'getTransactionChart'])->name('user.get.transaction.chart');
	Route::get('transaction-chart-data',[HomeController::class, 'getTransactionData'])->name('user.transaction.chart');
	Route::post('/save-token', [HomeController::class, 'saveToken'])->name('user.save.token');

	/* Transaction List*/
	Route::get('transaction-list', [TransactionController::class, 'index'])->name('user.transaction');
	Route::get('transaction-search', [TransactionController::class, 'search'])->name('user.transaction.search');



	Route::get('push-notification-show', [SiteNotificationController::class, 'show'])->name('push.notification.show');
	Route::get('push.notification.readAll', [SiteNotificationController::class, 'readAll'])->name('push.notification.readAll');
	Route::get('push-notification-readAt/{id}', [SiteNotificationController::class, 'readAt'])->name('push.notification.readAt');

	/* PROFILE SHOW UPDATE BY USER */
	Route::get('/profile', [UserProfileController::class, 'index'])->name('user.profile');
	Route::post('/profile/information', [UserProfileController::class, 'profileInfo'])->name('user.profile.info');
	Route::post('/additional/information', [UserProfileController::class, 'additionalInfo'])->name('user.additional.info');
	Route::post('/profile/address', [UserProfileController::class, 'address'])->name('user.address');

	// country-state-city dependency dropdown

	Route::get('get-all-country', [UserProfileController::class, 'getCountry']);
	Route::post('get-states-by-country', [UserProfileController::class, 'getState'])->name('user.states');
	Route::post('get-cities-by-state', [UserProfileController::class, 'getCity'])->name('user.cities');

	// education info
	Route::post('/education/info/create', [EducationInfoController::class, 'educationInfoCreate'])->name('user.educationInfoCreate');
	Route::post('/education/info/update/{id}', [EducationInfoController::class, 'educationInfoUpdate'])->name('user.educationInfoUpdate');
	Route::post('/education/info/delete/{id}', [EducationInfoController::class, 'educationInfoDelete'])->name('user.educationInfoDelete');

	// certification info
	Route::post('/certification/info/create', [CertificationController::class, 'certificationInfoCreate'])->name('user.certificationInfoCreate');
	Route::post('/certification/info/update/{id}', [CertificationController::class, 'certificationInfoUpdate'])->name('user.certificationInfoUpdate');
	Route::post('/certification/info/delete/{id}', [CertificationController::class, 'certificationInfoDelete'])->name('user.certificationInfoDelete');

//	social info
	Route::post('/social-link',[SocialLinkController::class,'linkStore'])->name('user.socialLink.store');
	Route::post('socail-link/update/{social_link:linkId}',[SocialLinkController::class,'linkUpdate'])->name('user.socialLink.update');
	Route::post('socail-link/delete/{social_link:linkId}',[SocialLinkController::class,'linkDelete'])->name('user.socialInfo.delete');

	// change password
	Route::match(['get', 'post'], 'change-password', [UserProfileController::class, 'changePassword'])->name('user.change.password');

	Route::post('/designation',[UserProfileController::class,'designationUpdate'])->name('user.designation');
	Route::post('/profile/picture',[UserProfileController::class,'profilePicture'])->name('user.profile.picture');

	Route::post('skills',[UserProfileController::class,'skillsUpdate'])->name('user.skills.info');
	Route::post('language',[UserProfileController::class,'languageUpdate'])->name('user.language.info');
	Route::post('work/history',[UserProfileController::class,'workRemove'])->name('user.work.remove');


	// create listing
	Route::get('/listing/order', [OrderController::class, 'listingOrder'])->name('user.listing.order');
	Route::post('/listing/order', [OrderController::class, 'listingOrderStore'])->name('user.listing.order.store');

	Route::post('/select-payment-gateway', [ListingCheckoutController::class, 'selectGateway'])->name('select.payment.gateway');
	Route::post('/listing-payment', [ListingCheckoutController::class, 'payment'])->name('listing.payment');

	Route::get('get/message/show', [MessageController::class, 'show'])->name('get.message.show');
	Route::get('get/message/readAll', [MessageController::class, 'readAll'])->name('get.message.readAll');
	Route::get('get/message/readAt/{id}', [MessageController::class, 'readAt'])->name('get.message.readAt');

	// user Message
	Route::get('message', [MessageController::class, 'message'])->name('user.message');
	Route::post('send/message/{id}', [MessageController::class, 'sendNewMessage'])->name('send.message');
	Route::get('/member/profile/{id}', [MessageController::class, 'memberProfileShow'])->name('user.member.profile.show');
	Route::post('send/proposer/message', [MessageController::class, 'proposerMessage'])->name('user.proposer.message');

	// Messenger
	Route::get('chat/contacts', [MessageController::class, 'getContacts'])->name('user.chat.contact');
	Route::get('single/member/messages/{id}', [MessageController::class, 'getMessages']);
	Route::post('chat/send-message', [MessageController::class, 'sendMessage'])->name('user.chat.send-message');
	Route::put('chat/leaving/time/{id}', [MessageController::class, 'chatLeaveingTime']);
	Route::post('delete/pushnotification/{id}', [MessageController::class, 'deletePushnotification']);

	/* PAYMENT REQUEST BY USER */
	Route::get('payout-list', [PayoutController::class, 'index'])->name('payout.index');
	Route::get('payout-search', [PayoutController::class, 'search'])->name('payout.search');
	Route::match(['get', 'post'], 'request-payout', [PayoutController::class, 'payoutRequest'])->name('payout.request');
	Route::post('confirm-payout/flutterwave/{utr}', [PayoutController::class, 'flutterwavePayout'])->name('payout.flutterwave');
	Route::post('confirm-payout/paystack/{utr}', [PayoutController::class, 'paystackPayout'])->name('payout.paystack');
	Route::match(['get', 'post'], 'confirm-payout/{utr}', [PayoutController::class, 'confirmPayout'])->name('payout.confirm');
	Route::get('payout-check-limit', [PayoutController::class, 'checkLimit'])->name('payout.checkLimit');
	Route::post('payout-bank-form', [PayoutController::class, 'getBankForm'])->name('payout.getBankForm');
	Route::post('payout-bank-list', [PayoutController::class, 'getBankList'])->name('payout.getBankList');

	/* ADD MONEY BY USER */
	Route::match(['get', 'post'], 'add-fund', [FundController::class, 'initialize'])->name('fund.initialize');
	Route::get('fund-list', [FundController::class, 'index'])->name('fund.index');
	Route::get('fund-requested', [FundController::class, 'requested'])->name('fund.request');
	Route::get('fund-search', [FundController::class, 'search'])->name('fund.search');

	Route::match(['get', 'post'], 'add-fund/job/{escrow_id}', [FundController::class, 'initializeJob'])->name('fund.initialize.job');
	Route::get('job/gateway', [FundController::class, 'jobGateway'])->name('job.gateway');

	Route::match(['get', 'post'], 'add-fund/listing/{slug}/{id}', [FundController::class, 'initializeListing'])->name('fund.initialize.listing');
	Route::get('listing/gateway', [FundController::class, 'listingGateway'])->name('listing.gateway');

	/* USER SUPPORT TICKET */
	Route::controller(SupportController::class)->name('user.ticket.')->group(function () {
		Route::get('tickets', 'index')->name('list');
		Route::get('ticket-create', 'create')->name('create');
		Route::post('ticket-create', 'store')->name('store');
		Route::get('ticket-view/{ticket}', 'view')->name('view');
		Route::put('ticket-reply/{ticket}', 'reply')->name('reply');
		Route::get('ticket-download/{ticket}', 'download')->name('download');
	});


	// TWO-FACTOR SECURITY
	Route::get('/twostep-security', [FaSecurityController::class, 'twoStepSecurity'])->name('user.twostep.security');
	Route::post('twoStep-enable', [FaSecurityController::class, 'twoStepEnable'])->name('user.twoStepEnable');
	Route::post('twoStep-disable', [FaSecurityController::class, 'twoStepDisable'])->name('user.twoStepDisable');

	// PUSH NOTIFY / Firebase Notification
	Route::get('/push-notify', [HomeController::class, 'settingNotify'])->name('user.list.setting.notify');
	Route::put('/push-notify', [HomeController::class, 'settingNotifyUpdate'])->name('user.update.setting.notify');
});

Route::group(['prefix' => 'user'], function () {
	Auth::routes();
	// Payment confirm page
	Route::match(['get', 'post'], 'deposit-check-amount', [DepositController::class, 'checkAmount'])->name('deposit.checkAmount');

	Route::post('/make-payment-details', [DepositController::class, 'makePaymentDetails'])->name('makePaymentDetails');

	Route::post('payment-check-amount', [PaymentController::class, 'checkAmount'])->name('payment.checkAmount');
	Route::get('payment-process/{utr}', [PaymentController::class, 'depositConfirm'])->name('payment.process');
	Route::match(['get', 'post'], 'confirm-deposit/{utr}', [DepositController::class, 'confirmDeposit'])->name('deposit.confirm');

	Route::post('addFundConfirm/{utr}', [PaymentController::class, 'fromSubmit'])->name('addFund.fromSubmit');

	Route::get('check', [VerificationController::class, 'check'])->name('user.check');
	Route::get('resend_code', [VerificationController::class, 'resendCode'])->name('user.resendCode');
	Route::post('mail-verify', [VerificationController::class, 'mailVerify'])->name('user.mailVerify');
	Route::post('sms-verify', [VerificationController::class, 'smsVerify'])->name('user.smsVerify');
});

//--social login with socialite--
Route::get('auth/social', [\App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('social.login');
Route::get('oauth/{driver}', [\App\Http\Controllers\Auth\LoginController::class, 'redirectToProvider'])->name('social.oauth');
Route::get('oauth/{driver}/callback', [\App\Http\Controllers\Auth\LoginController::class, 'handleProviderCallback'])->name('social.callback');

Route::post('/khalti/payment/verify/{trx}', [khaltiPaymentController::class, 'verifyPayment'])->name('khalti.verifyPayment');
Route::post('/khalti/payment/store', [khaltiPaymentController::class, 'storePayment'])->name('khalti.storePayment');

//--blog--
Route::get('/blog', [FrontendController::class, 'blog'])->name('blog');
Route::get('/blog-details/{slug}/{id}', [FrontendController::class, 'blogDetails'])->name('blogDetails');
Route::get('/category/blog/{slug}/{id}', [FrontendController::class, 'CategoryWiseBlog'])->name('CategoryWiseBlog');
Route::get('/blog/search', [FrontendController::class, 'blogSearch'])->name('blogSearch');
Route::get('/category', [FrontendController::class, 'category'])->name('category');
Route::get('/', [FrontendController::class, 'home'])->name('home');
Route::get('/about', [FrontendController::class, 'about'])->name('about');
Route::get('/influencers', [FrontendController::class, 'influencers'])->name('influencers');
Route::get('/influencer/profile/{users:username}', [FrontendController::class, 'influencerProfile'])->name('influencer.profile');

//listing
Route::get('/listings', [FrontendController::class, 'allListings'])->name('allListings');
Route::get('/filter/listings', [FrontendController::class, 'filterListing'])->name('filter.listing');
Route::get('subcategory/filter/', [FrontendController::class, 'filterSubcategory'])->name('subcategory.filter');
Route::get('/listings/sort', [FrontendController::class, 'listingSort'])->name('listing.sort');

Route::get('/faq', [FrontendController::class, 'faq'])->name('faq');
Route::get('/contact', [FrontendController::class, 'contact'])->name('contact');
Route::post('/contact/send', [FrontendController::class, 'contactSend'])->name('contact.send');
Route::get('/testimonial/accept/{id}', [FrontendController::class, 'testimonialAccept'])->name('testimonial.accept');
Route::post('/testimonial/rating/{testimonial:id}', [FrontendController::class, 'testimonialRating'])->name('testimonial.rating');
Route::post('subscribe', [FrontendController::class, 'subscribe'])->name('subscribe');
Route::get('/language/switch/{code?}', [FrontendController::class, 'setLanguage'])->name('language');
Route::get('/captcha', [ManualRecaptchaController::class, 'reCaptCha'])->name('captcha');

Route::get('{content_id}/{getLink}', [FrontendController::class, 'getLink'])->name('getLink');
Route::get('/{template}', [FrontendController::class, 'getTemplate'])->name('getTemplate');



