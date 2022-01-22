<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PhpParser\Node\Expr\Cast\Object_;

class Order extends Model
{
    use HasFactory;
    protected $products = [];

    public function add(Product $product)
    {
        $this->products[] = $product;
    }

    public function products(): array
    {
        return $this->products;
    }

    public function total()
    {
        return array_reduce($this->products, function ($suma, $product) {
           return $suma + $product->cost();
        });
    }
}
