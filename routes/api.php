<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\api\AnimalsController;
use App\Http\Controllers\api\ActiveAnimalsController;

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::prefix('animals')->group(function () {
    Route::get('/kinds',  [AnimalsController::class,'index'])->name('animal.index');
    Route::get('/kinds/:{kind}',  [AnimalsController::class,'show'])->name('animal.show');

    Route::get('/active',  [ActiveAnimalsController::class,'index'])->name('animalactive.index');
    Route::get('/active/:{name}',  [ActiveAnimalsController::class,'show'])->name('animalactive.show');
    Route::post('/active',  [ActiveAnimalsController::class,'create'])->name('animalactive.create');
    Route::post('/active/age',  [ActiveAnimalsController::class,'update'])->name('animalactive.update');
    Route::post('/active/delete',  [ActiveAnimalsController::class,'deleteAll'])->name('animalactive.deleteAll');
    //Route::post('/active/delete',  [ActiveAnimalsController::class,'deleteByName'])->name('animalactive.deleteByName');
});
