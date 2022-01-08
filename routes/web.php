<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentController;

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

Route::get('/', 'IndexController@index');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/wallet', 'HomeController@wallet')->name('wallet');
Route::post('/wallet', 'HomeController@loadWallet')->name('wallet.load');
Route::post('/wallet-withdraw', 'HomeController@withdrawWallet')->name('wallet.withdraw');

Route::get('/download/{jobProposal}', 'HomeController@download')->name('download');
Route::get('/down/{job}', 'HomeController@downloadJob')->name('down');

Route::get('/job-apply/{job}', 'JobController@apply')->name('job.apply');
Route::get('/job-applied', 'JobController@applied')->name('jobs.applied');
Route::post('/job-apply/{job}', 'JobController@applyStore')->name('job.apply.post');

Route::resource('job','JobController');
Route::resource('jobProposal','JobProposalController');
Route::get('/job-proposal-accept/{jobProposal}', 'JobProposalController@acceptProposal')->name('jobProposal.accept');
Route::post('/job-accept-delivery/{jobProposal}', 'JobProposalController@acceptResult')->name('accept.delivery');

Route::post('/comment/store', 'CommentController@store')->name('comment.add');
Route::post('/reply/store', 'CommentController@replyStore')->name('reply.add');

Route::resource('users','UserController');




//Route::get('paywithpaypal', array('as' => 'paywithpaypal','uses' => 'PaypalController@payWithPaypal',));
//Route::post('paypal', array('as' => 'paypal','uses' => 'PaypalController@postPaymentWithpaypal',));
//Route::get('paypal', array('as' => 'status','uses' => 'PaypalController@getPaymentStatus',));


Route::get('/', function () {
    return view('welcome');
});

Route::get('/paypal',function(){
    return view('myOrder');
});

// route for processing payment
Route::post('/paypal', [PaymentController::class, 'payWithpaypal'])->name('paypal');

// route for check status of the payment
Route::get('/status', [PaymentController::class, 'getPaymentStatus'])->name('status');