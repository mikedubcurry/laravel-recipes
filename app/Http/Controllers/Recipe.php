<?php



/*

need to figure out a good exception handling workflow for creating and updating entities
findOrFail, try/catch, what to return if theres an issue

*/



namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipe as RecipeModel;
use App\Models\Ingredient as IngredientModel;
use App\Models\Procedure as ProcedureModel;
use Illuminate\Log\Logger;

class Recipe extends Controller
{
    //
    public static function all()
    {
        return collect(RecipeModel::all())->map(function ($recipe) {
            $recipe->ingredients = $recipe->ingredients()->get();
            $recipe->procedure = $recipe->procedures()->get();
            return $recipe;
        });
    }

    public static function findIfExists($id)
    {
        // find by id if exists
        return RecipeModel::find($id);
    }

    public static function create()
    {
        // read and validat4e all input,
        //      recipe_name, prep_time, description
        //     
        // ingredients and procedure are added next
        $data = json_decode(file_get_contents("php://input"));
        $recipe_name = $data->recipe_name;
        $desciption = $data->description;
        $prep_time = $data->prep_time;

        if (!$recipe_name || !$desciption || !$prep_time) {
            // return warning to user that they need to provide name and description
        }
        // good to go!
        $recipe = new RecipeModel;
        $recipe->recipe_name = $recipe_name;
        $recipe->description = $desciption;
        $recipe->prep_time = $prep_time;
        $recipe->save();

        return $recipe;
    }

    public static function addIngredient($recipe_id)
    {
        // after creatig a recipe, add ingredients one by one for now
        $data = json_decode(file_get_contents("php://input"));
        $ingredient_name = $data->ingredient_name;
        $amount = $data->amount;
        $unit = $data->unit;

        if (!$ingredient_name || !$amount || !$unit || !$recipe_id) {
            // warn user to include all input
        }

        // should be good to go
        $ingredient = new IngredientModel;
        $ingredient->ingredient_name = $ingredient_name;
        $ingredient->amount = $amount;
        $ingredient->unit = $unit;
        $ingredient->recipe_id = $recipe_id;

        $ingredient->save();

        return $ingredient;
    }

    public static function addProcedure($recipe_id)
    {
        $data = json_decode(file_get_contents("php://input"));
        $step = $data->step;

        if (!$step || !$recipe_id) {
            // warn user to include step
        }

        $procedure = new ProcedureModel;
        $procedure->step = $step;
        $procedure->recipe_id = $recipe_id;

        $procedure->save();

        return $procedure;
    }
}
