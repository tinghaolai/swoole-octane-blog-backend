<?php

use App\Models\BlogAccessLog;
use Illuminate\Http\Request;
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

Route::get('/', function (Request $request) {
    BlogAccessLog::create([
        'url' => $request->getUri(),
        'session_id' => $request->session()->getId(),
        'ip_address' => $request->ip(),
        'path' => $request->path(),
    ]);

    return response()->json('ok');
});
