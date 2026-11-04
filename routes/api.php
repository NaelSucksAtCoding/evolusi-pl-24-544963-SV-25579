<?php

use App\Models\Item;
use Illuminate\Support\Facades\Route;

Route::get('/items', function () {
    return response()->json([
        'data' => Item::latest()->get(['id', 'name', 'description', 'created_at']),
    ]);
})->name('api.items.index');
