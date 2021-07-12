<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'users',
    'as' => 'users.',
    'middleware' => ['auth:sanctum', 'verified']
], function () {
    Route::get('/create', [\App\Http\Controllers\Users\CreateController::class, 'create'])
        ->name('create');

    Route::post('/', [\App\Http\Controllers\Users\CreateController::class, 'store'])
        ->name('store');

    Route::get('/', [\App\Http\Controllers\Users\ReadController::class, 'index'])
        ->name('index');

    Route::get('/{user}', [\App\Http\Controllers\Users\ReadController::class, 'show'])
        ->name('show');

    Route::get('/{user}/edit', [\App\Http\Controllers\Users\UpdateController::class, 'edit'])
        ->name('edit');

    Route::match(['put', 'patch'], '/{user}', [\App\Http\Controllers\Users\UpdateController::class, 'update'])
        ->name('update');

    Route::delete('/{user}', \App\Http\Controllers\Users\DeleteController::class)
        ->name('destroy');
});
