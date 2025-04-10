<?php

use App\Http\Controllers\StoreIncidentController;
use Illuminate\Support\Facades\Route;

Route::post('/incidents', StoreIncidentController::class);
