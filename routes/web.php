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
    $referer = $request->input('url');
    $refererPath = parse_url($referer, PHP_URL_PATH);

    BlogAccessLog::create([
        'url' => $referer ?? '',
        'session_id' => $request->session()->getId(),
        'ip_address' => $request->ip(),
        'path' => $refererPath,
    ]);

    return response()->json(['message' => 'ok']);
});
