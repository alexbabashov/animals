<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\api\AnimalsController;
use App\Http\Controllers\api\ActiveAnimalsController;

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::prefix('animals')->group(function () {
    Route::get('/',  [AnimalsController::class,'index'])->name('animal.index');
    Route::post('/kind',  [AnimalsController::class,'show'])->name('animal.show');

    Route::get('/active',  [ActiveAnimalsController::class,'index'])->name('animalactive.index');
    Route::post('/name',  [ActiveAnimalsController::class,'show'])->name('animalactive.show');
    Route::post('/add',  [ActiveAnimalsController::class,'create'])->name('animalactive.create');
    Route::post('/age',  [ActiveAnimalsController::class,'update'])->name('animalactive.update');
    Route::get('/delete',  [ActiveAnimalsController::class,'deleteAll'])->name('animalactive.deleteAll');
    Route::post('/delete',  [ActiveAnimalsController::class,'deleteByName'])->name('animalactive.deleteByName');
});
