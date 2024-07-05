<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MainCategory extends Model
{
    use HasFactory;

    protected $table= 'main_categories';

    public function subcategory(){
        return $this->hasMany(SubCategory::class,'category_id','id');

    }
}
