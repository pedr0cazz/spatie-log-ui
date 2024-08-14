<?php

use Pedr0cazz\SpatieLogUi\Controllers\ActivityController;
use Illuminate\Support\Facades\Route;

Route::middleware(['web', 'auth'])->group(function () {
    Route::get('spatie-ui', [ActivityController::class, 'index'])->name('spatie_log_ui.index');
    Route::get('spatie-ui/get-ajax-log-data', [ActivityController::class, 'getLogsAjax'])->name('spatie_log_ui.get_ajax_log_data');
    Route::post('spatie-ui/get-ajax-log-details', [ActivityController::class, 'getLogDetailsAjax'])->name('spatie_log_ui.get_ajax_log_details');
});
