<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    use HasFactory;

    protected $fillable = [
        'recipe_name',
        'description',
        'prep_time',
    ];

    public function ingredients()
    {
        return $this->hasMany(Ingredient::class);
    }

    public function procedures()
    {
        return $this->hasMany(Procedure::class);
    }

}
