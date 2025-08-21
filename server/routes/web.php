<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiDocumentationController;

Route::get('/', function () {
    return view('welcome');
});

// API Documentation web interface
Route::get('/api/docs', [ApiDocumentationController::class, 'webInterface'])->name('api.docs');

// Include email testing routes (remove in production)
if (app()->environment(['local', 'testing'])) {
    require __DIR__.'/test-emails.php';
}
