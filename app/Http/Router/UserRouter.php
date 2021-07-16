<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'users',
    'as' => 'users.',
    'middleware' => ['auth:sanctum', 'verified']
], function () {
    Route::get('/', \App\Http\Livewire\Users\Index::class)
        ->name('index');
});
