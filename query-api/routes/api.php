<?php

use App\Http\Controllers\StatsController;
use Illuminate\Support\Facades\Route;


Route::any("/", function () {
    return response()->json([
        'status' => true,
    ]);
});


Route::prefix("stats")->name("stats.")->group(function () {
    Route::get("/top-users", [StatsController::class, 'getTopUsersStats'])->name('topUsers');
    Route::get("/hourly", [StatsController::class, 'getHourlyStats'])->name('hourly');
});


