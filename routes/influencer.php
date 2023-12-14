<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmailTemplateController;
use App\Http\Controllers\Influencer\JobController;
use App\Http\Controllers\User\ListingController;
use App\Http\Controllers\Influencer\InvitationController;
use App\Http\Controllers\Influencer\HireController;
use App\Http\Controllers\Influencer\OrderController;
use App\Http\Controllers\Influencer\EscrowController;
use App\Http\Controllers\Influencer\TransferController;
use App\Http\Controllers\CronController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\User\ReportController;
use App\Http\Controllers\EmploymentController;
use App\Http\Controllers\TestimonialController;

Route::controller(JobController::class)->prefix('job')->group(function(){
	Route::get('/','jobs')->name('jobs');
	Route::get('/search','jobSearch')->name('jobs.search');
	Route::get('/skill/search/{item}','skillSearch')->name('job.skill.search');
	Route::get('/sort','sort')->name('jobs.sort');
	Route::get('/search/type','typeSearch')->name('jobs.search.type');
	Route::get('/allProposal/{id}','proposalList')->name('user.proposal.list');

//	best matching job list
	Route::get('/best-matches','bestMatches')->name('user.best.matches');

//	save job list
	Route::get('/save/list','saveList')->name('user.save.list');
	Route::get('/save/{id}','jobSave')->name('user.jobs.save');

//	proposer details
	Route::get('/mypropsals','myproposals')->name('user.myproposal.list');
	Route::get('/proposser/details/{id}','proposserDetails')->name('job.proposser.details');
	Route::get('/offers','offers')->name('job.offers');
	Route::get('/all/proposals','allProposal')->name('job.all.proposal');
	Route::get('/interview/invitation','interview')->name('job.interview.invitation');
	Route::get('/submitted','submitted')->name('job.submitted');
	Route::get('/archived','archived')->name('job.archived');

//	joblist
	Route::get('/list','jobList')->name('user.jobs.list');
	Route::get('/create','jobCreate')->name('user.job.create');
	Route::post('/create','jobStore')->name('user.job.store');

	Route::get('/{slug}/{id}','jobDetails')->name('user.jobs.details');
	Route::get('/proposal/{slug}/{id}','jobProposal')->name('user.job.proposal');
	Route::post('/proposal/{slug}/{id}','jobProposalStore')->name('user.job.proposal.store');


	// job offer...
	Route::get('/offer','jobOffer')->name('user.job.offer');

	Route::get('/send-offer','sendOffer')->name('user.job.send_offer');
	Route::get('job/offer/accept/{job_id}','jobOfferAccept')->name('user.job.accept');
	Route::post('/offer-cancel/{job_id}','jobOfferCancel')->name('user.job.cancel');

//order compeleted when job post status 2;
	Route::get('/order/completed/{j_id}','completed')->name('user.job.completed');

// hire proposser
	Route::get('/proposser/hire/{proposerId}/{jobId}/{proposal_id}','hire')->name('user.job.hire');
	Route::post('/proposser/hire','hireStore')->name('user.job.hire.store');
});

Route::get('check/service-fee',[JobController::class,'checkFee'])->name('user.job.service.fee');

// invitation freelancer
Route::controller(InvitationController::class)->name('user.')->group(function(){
	Route::get('/send/invite/{job_id}','sendInvite')->name('job.send.invite');
	Route::post('send/invitation','inviteStore')->name('invite.store');
	Route::get('receive/invite','receiveInvite')->name('receive.invite');
	Route::post('receive/invite','approve')->name('invite.approve');
	Route::post('receive/invite/cancel','cancel')->name('invite.cancel');
});

//hire freelancer
Route::get('hire/freelancer',[HireController::class,'hire'])->name('user.hire.freelancer');
Route::post('hire/freelancer',[HireController::class,'expandDate'])->name('user.hire.expand_date');

//escrow
Route::controller(EscrowController::class)->prefix('user')->name('user.')->group(function(){
	Route::get('milestone/list/{title}/{hireId}','milestoneList')->name('milestone.payment');
	Route::post('milestone/file_submit/{id}','fileSubmit')->name('escrow.file.submit');
	Route::get('except-milestone/{hireId}','exceptMilestone')->name('except.milestone.payment');
	Route::get('complete/{id}','completed')->name('completed');
	Route::get('milestone/payment','jobPayment')->name('job.payment');
});

//send money.....
Route::controller(TransferController::class)->name('transfer.')->group(function(){
//	direct payment..
	Route::get('transfer-list','index')->name('index');
	Route::get('transfer-list/search','listSearch')->name('list.search');
	Route::get('transfer-search','search')->name('search');
	Route::match(['get','post'],'transfer','initialize')->name('initialize');
	Route::match(['get','post'],'confirm-transfer/{utr}','confirmTransfer')->name('confirm');
	Route::get('transfer-check-recipient','checkRecipient')->name('checkRecipient');
	Route::get('transfer-check-amount','checkAmount')->name('checkAmount');
	Route::get('/export-transfer','exportTransfer')->name('export');


//	Job Payment from wallet
	Route::match(['get','post'],'job/transfer','initializeJob')->name('initialize.job');
	Route::match(['get','post'],'confirm-job-transfer/{utr}','confirmJobTransfer')->name('confirm.job.payment');

//	listing payment from wallet...
	Route::match(['get','post'],'listing/transfer','initializeListing')->name('initialize.listing');
	Route::match(['get','post'],'confirm-listing-transfer/{utr}','confirmListingTransfer')->name('confirm.listing');

//	gateway payment
	Route::get('gateway','gateway')->name('gateway');
	Route::post('gateway','checkoutGateway')->name('checkout.gateway');
});


//listing
Route::controller(ListingController::class)->prefix('/listing')->name('user.')->group(function(){
	Route::get('/list','listingList')->name('listing.list');
	Route::get('create','listingCreate')->name('listing.create');
	Route::post('store','listingStore')->name('listing.store');
	Route::get('/edit/{id}','listingEdit')->name('listing.edit');
	Route::post('/update/{id}','listingUpdate')->name('listing.update');
	Route::delete('/delete/{id}','listingDelete')->name('listing.delete');
	Route::post('/get/subcategory','getSubCategory')->name('get.subcategory');
	Route::get('/details/{slug}/{id}', 'listingDetails')->name('listing.details');
	Route::get('/helpful','isHelpful')->name('isHelpful');
});

//order...
Route::controller(OrderController::class)->prefix('orders')->name('user.')->group(function(){
	Route::get('/','order')->name('job.order');
	Route::post('/','orderStore')->name('order.store');
	Route::get('receive/{id}','orederReceive')->name('order.receive');
	Route::get('/completed/{id}','orderCompleted')->name('order.completed');

	Route::get('listing-order/list','listingOrderlist')->name('listing.order.list');
	Route::post('listing-order/list','listingOrderUpload')->name('listing.order.upload');
	Route::get('listing-order/details/{id}','listingOrderDetails')->name('listing.order.details');
	Route::post('listing-order/accept/{id}','listingOrderAccept')->name('listing.order.accept');
	Route::post('listing-order/cancel/{id}','listingOrderCancel')->name('listing.order.cancel');
	Route::post('listing-order/done/{id}','listingOrderDone')->name('listing.order.done');
	Route::post('listing-order/complete/{id}','listingOrderComplete')->name('listing.order.complete');

});

//review
Route::post('/review',[ReviewController::class,'review'])->name('user.review');

//Report Controll
Route::controller(ReportController::class)->prefix('report')->name('user.')->group(function(){
	Route::get('/','index')->name('report');
	Route::get('/listing/order','orderFilter')->name('listing.order.filter');
	Route::get('/type/filter','typeFilter')->name('type.filter');
	Route::get('/escrow/filter','escrowFilter')->name('escrow.filter');
	Route::get('/listing','listingReport')->name('listing.report');
	Route::get('/listing-order/export','listingOrderExport')->name('listing.order.export');
	Route::get('/escrow/export','escrowExport')->name('escrow.export');

});

Route::controller(PortfolioController::class)->prefix('portfolio')->name('user.')->group(function(){
	Route::post('/create','store')->name('portfolio.create');
	Route::post('/update','update')->name('portfolio.update');
	Route::post('/delete/{id}','cancel')->name('portfolio.delete');
});

Route::controller(EmploymentController::class)->prefix('employment')->name('user.')->group(function(){
	Route::post('/create','store')->name('employment.create');
	Route::post('/update','update')->name('employment.update');
	Route::post('/delete','remove')->name('employment.delete');

});

Route::controller(TestimonialController::class)->prefix('testimonial')->name('user.')->group(function (){
	Route::post('/create','store')->name('testimonial.create');

});



