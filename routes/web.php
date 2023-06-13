<?php

use Illuminate\Support\Facades\Route;

// All the SAP urls will come here
Route::get('/{vue_capture?}', function() {
    return view('index');
})->where('vue_capture', '[\/\w\.-]*');
