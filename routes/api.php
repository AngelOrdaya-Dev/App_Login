<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('auth.basic')->get('/basic-auth-test', function (Request $request) {
    return response()->json(['message' => 'Autenticación básica exitosa.', 'user' => $request->user()]);
});
