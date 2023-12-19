<?php

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

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/change-profile',       App\Livewire\Auth\ChangeProfile::class)->name('auth.change-profile');
    Route::get('/change-password',      App\Livewire\Auth\ChangePassword::class)->name('auth.change-password');
    Route::get('/user',                 App\Livewire\User\UserTable::class)->name('user');
    Route::get('/user/{id}',            App\Livewire\User\UserForm::class)->name('user.form');
    Route::get('/example',              App\Livewire\Example\ExampleTable::class)->name('example');
    Route::get('/example/{id}',         App\Livewire\Example\ExampleForm::class)->name('example.form');
    Route::get('/post',                 App\Livewire\Post\PostTable::class)->name('post');
    Route::get('/post/{id}',            App\Livewire\Post\PostForm::class)->name('post.form');
    Route::get('/contact',              App\Livewire\Contact\ContactTable::class)->name('master.contact');
    Route::get('/contact/{id}',         App\Livewire\Contact\ContactForm::class)->name('master.contact.form');
    Route::get('/salesman',             App\Livewire\Salesman\SalesmanTable::class)->name('salesman');
    Route::get('/salesman/{id}',        App\Livewire\Salesman\SalesmanForm::class)->name('salesman.form');
    Route::get('/item',                 App\Livewire\Item\ItemTable::class)->name('item');
    Route::get('/item/{id}',            App\Livewire\Item\ItemForm::class)->name('item.form');
    Route::get('/play',                 [App\Http\Controllers\PlayController::class,'index'])->name('play');
    Route::get('/play/{page}',          [App\Http\Controllers\PlayController::class,'page'])->name('play.page');
    Route::get('/coa',                  App\Livewire\Coa\CoaTable::class)->name('coa');
    Route::get('/coa/{id}',             App\Livewire\Coa\CoaForm::class)->name('coa.form');
    Route::get('/bank',                 App\Livewire\Bank\BankTable::class)->name('master.bank');
    Route::get('/bank/{id}',            App\Livewire\Bank\BankForm::class)->name('master.bank.form');
    Route::get('/bank-account',         App\Livewire\BankAccount\BankAccountTable::class)->name('master.bank-account');
    Route::get('/bank-account/{id}',    App\Livewire\BankAccount\BankAccountForm::class)->name('master.bank-account.form');
    Route::get('/cash-account',         App\Livewire\CashAccount\CashAccountTable::class)->name('master.cash-account');
    Route::get('/cash-account/{id}',    App\Livewire\CashAccount\CashAccountForm::class)->name('master.cash-account.form');
    Route::get('/currency',             App\Livewire\Currency\CurrencyTable::class)->name('master.currency');
    Route::get('/currency/{id}',        App\Livewire\Currency\CurrencyForm::class)->name('master.currency.form');
    Route::get('/res-code',             App\Livewire\ResCode\ResCodeTable::class)->name('master.res-code');
    Route::get('/res-code/{id}',        App\Livewire\ResCode\ResCodeForm::class)->name('master.res-code.form');
    Route::get('/journal',              App\Livewire\Journal\Table::class)->name('finance.journal');
    Route::get('/journal/{id}',         App\Livewire\Journal\Form::class)->name('finance.journal.form');
    Route::get('/gl',                   App\Livewire\GL\GLTable::class)->name('finance.gl');
    Route::get('/trial-balance',        App\Livewire\TrialBalance\Table::class)->name('finance.trial-balance');
    Route::get('/beginning-balance',    App\Livewire\BeginningBalance\Table::class)->name('finance.beginning-balance');
    Route::get('/cash-in',              App\Livewire\CashTransIn\CashTransInTable::class)->name('cash_bank.cash-in');
    Route::get('/cash-in/{id}',         App\Livewire\CashTransIn\CashTransInForm::class)->name('cash_bank.cash-in.form');
    Route::get('/setting/common',       App\Livewire\Setting\Common::class)->name('setting.common');
});


// Clear all cache
// ------------------------------------
Route::get('/sys/clear', function () {
    Artisan::call('view:clear');
    dump(Artisan::output());
    Artisan::call('cache:clear');
    dump(Artisan::output());
    Artisan::call('config:clear');
    dump(Artisan::output());
    Artisan::call('event:clear');
    dump(Artisan::output());
    Artisan::call('route:clear');
    dump(Artisan::output());
});
