<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(["auth:sanctum", "verified"])->get("/user", function (Request $request) {
    return $request->user();
});

Route::middleware(["auth:sanctum", "verified"])->get("/users", function (Request $request) {
    return User::all();
});
