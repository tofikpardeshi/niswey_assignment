<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ContactController;

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

Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::GET('/home',[ContactController::class, 'index'])->name('home');
Route::GET('/add-contact-page', [ContactController::class, 'createContactsPage'])->name('add.contact.page');
Route::POST('/contacts/importXml', [ContactController::class, 'importXml'])->name('contacts.importXml');
Route::POST('/add-contact', [ContactController::class, 'add'])->name('add.contact');
Route::GET('/edit-contact/{id}', [ContactController::class, 'edit'])->name('edit.contact');
Route::POST('/update-contact/{id}', [ContactController::class, 'update'])->name('update.contact');
Route::GET('/delete-contact/{id}', [ContactController::class, 'delete'])->name('delete.contact');
