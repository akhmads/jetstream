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
    Route::get('/user',         App\Livewire\User\UserTable::class)->name('user');
    Route::get('/user/{id}',    App\Livewire\User\UserForm::class)->name('user.form');
    Route::get('/example',      App\Livewire\Example\ExampleTable::class)->name('example');
    Route::get('/example/{id}', App\Livewire\Example\ExampleForm::class)->name('example.form');
    Route::get('/post',         App\Livewire\Post\PostTable::class)->name('post');
    Route::get('/post/{id}',    App\Livewire\Post\PostForm::class)->name('post.form');
    Route::get('/contact',      App\Livewire\Contact\ContactTable::class)->name('contact');
    Route::get('/contact/{id}', App\Livewire\Contact\ContactForm::class)->name('contact.form');
    Route::get('/item',         App\Livewire\Item\ItemTable::class)->name('item');
    Route::get('/item/{id}',    App\Livewire\Item\ItemForm::class)->name('item.form');
    Route::get('/play',         [App\Http\Controllers\PlayController::class,'index'])->name('play');
    Route::get('/play/{page}',  [App\Http\Controllers\PlayController::class,'page'])->name('play.page');
    Route::get('/coa',          App\Livewire\Coa\CoaTable::class)->name('coa');
    Route::get('/coa/{id}',     App\Livewire\Coa\CoaForm::class)->name('coa.form');
    Route::get('/bank',         App\Livewire\Bank\BankTable::class)->name('master.bank');
    Route::get('/bank/{id}',    App\Livewire\Bank\BankForm::class)->name('master.bank.form');
    Route::get('/journal',      App\Livewire\Journal\Table::class)->name('finance.journal');
    Route::get('/journal/{id}', App\Livewire\Journal\Form::class)->name('finance.journal.form');
    Route::get('/gl',           App\Livewire\GL\GLTable::class)->name('finance.gl');
    Route::get('/trial-balance',        App\Livewire\TrialBalance\Table::class)->name('finance.trial-balance');
    Route::get('/beginning-balance',    App\Livewire\BeginningBalance\Table::class)->name('finance.beginning-balance');
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
