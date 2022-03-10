<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $product_code;
    protected $name;
    protected $price;

    protected $fillable = ['product_code', 'name', 'price'];

    public function product_code()
    {
        return $this->product_code;
    }
    public function name()
    {
        return $this->name;
    }

    public function getPrice()
    {
        return $this->price;
    }

}
