<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'common_name', 'description', 'player_id'
    ];

    protected $table = 'products';

    public static function all_products(){
        $products = DB::table('products')->selectRaw('common_name, count(*) as hits')->groupBy('common_name')->orderBy('common_name')->limit(10)->get();
        return $products;
    }
}
