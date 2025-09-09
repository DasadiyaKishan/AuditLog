<?php

use Illuminate\Support\Facades\Route;
use Kishan\AuditLog\Http\Controllers\AuditLogController;

Route::middleware(['web', 'auth']) // protect with auth
    ->prefix('audit-logs')
    ->group(function () {
        Route::get('/', [AuditLogController::class, 'index'])->name('audit-logs.index');
    });
