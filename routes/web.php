<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/{path?}', function () {
    return view('app'); //za svaki get request, vrati app view i daj kontrolu vue routeru
})->where('any', '.*');
