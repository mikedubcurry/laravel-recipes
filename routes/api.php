<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Recipe;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/recipes', function (Request $request) {
    return Recipe::all();
});

Route::post('/recipes', function (Request $request) {
    // create a new recipe
    return Recipe::create();
});

Route::post('/recipes/{recipe_id}/ingredients', function (Request $request, $recipe_id) {
    $recipe = Recipe::findIfExists($recipe_id);
    if(!$recipe) {
        // warn user theyre trying to add ingredients to a nonexistant recipe
    }
    // create ingredients
    return Recipe::addIngredient($recipe_id); 
})->whereNumber('recipe_id');


Route::post('/recipes/{recipe_id}/procedures', function (Request $request, $recipe_id) {
    $recipe = Recipe::findIfExists($recipe_id);
    if(!$recipe ) {
        // warn user theyre trying to add procedure to a nonexistant recipe
    }
    // create procedure
    return Recipe::addProcedure($recipe_id);
});