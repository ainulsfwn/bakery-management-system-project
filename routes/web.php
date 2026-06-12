<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;

/*
|--------------------------------------------------------------------------
| HOME ROUTES
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'my_home']);
Route::get('/home', [HomeController::class, 'index']);

/*
|--------------------------------------------------------------------------
| ADMIN FOOD ROUTES
|--------------------------------------------------------------------------
*/
Route::get('/add_product', [AdminController::class, 'add_product']);
Route::post('/upload_food', [AdminController::class, 'upload_food']);
Route::get('/view_product', [AdminController::class, 'view_product']);
Route::get('/delete_product/{id}', [AdminController::class, 'delete_product']);
Route::get('/update_product/{id}', [AdminController::class, 'update_product']);
Route::post('/edit_product/{id}', [AdminController::class, 'edit_product']);

/*
|--------------------------------------------------------------------------
| USER CART & ORDER ROUTES
|--------------------------------------------------------------------------
*/
Route::post('/add_cart/{id}', [HomeController::class, 'add_cart']);
Route::get('/my_cart', [HomeController::class, 'my_cart']);

// Route to handle removing an item from the cart
Route::get('/remove_cart/{id}', [HomeController::class, 'remove_cart']);

// Route to process moving cart data into the orders table (Tutorial #14)
Route::post('/confirm_order', [HomeController::class, 'confirm_order']);

// Route for the adminPage (Tutorial 16)
Route::get('/orders', [AdminController::class, 'orders']);

// Route adminPage for on the way (Tutorial 17)
Route::get('on_the_way/{id}', [AdminController::class, 'on_the_way']);

// Route adminPage for delivered(Tutorial 17)
Route::get('delivered/{id}', [AdminController::class, 'delivered']);

// Route adminPage for cancel(Tutorial 17)
Route::get('cancel/{id}', [AdminController::class, 'cancel']);

// Route for the userPage (Tutorial 18)
Route::post('/book_table', [HomeController::class, 'book_table']);

// Route for the adminPage (Tutorial 19)
Route::get('/reservations', [AdminController::class, 'reservations']);