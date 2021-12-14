<?php

use Illuminate\Support\Facades\Route;

// ~Add all class
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CategoryController;

// ~Add all model
use App\Models\User; // ~Eloquent method

// ~Add db 
use Illuminate\Support\Facades\DB; // ~Query builder method

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', function () {
    return view('home');
});

// ~Add all controller
Route::get('/contact', [ContactController::class, 'index']);

// ~Category Controller
Route::get('/category/all', [CategoryController::class, 'AllCat'])->name('all.category');
Route::post('/category/add', [CategoryController::class, 'AddCat'])->name('store.category'); // ~Add Category or inserting data
Route::get('/category/edit/{id}', [CategoryController::class, 'Edit']); // ~Edit Category route after clicking the edit button
Route::post('/category/update/{id}', [CategoryController::class, 'Update']); // ~Update Category
Route::get('/softdelete/category/{id}', [CategoryController::class, 'SoftDelete']); // ~SoftDelete Category
Route::get('/category/restore/{id}', [CategoryController::class, 'Restore']); // ~Restore Category
Route::get('/delete/category/{id}', [CategoryController::class, 'Delete']); // ~Delete Category

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    // ~fetch users table data
    $users = User::all(); //~Eloquent method
    // $users = DB::table('users')->get(); // ~Query builder method
    return view('dashboard', compact('users'));
})->name('dashboard');