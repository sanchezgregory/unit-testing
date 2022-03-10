<?php

namespace App\Models;


class Checkout
{
    protected $subTotal = 0;
    protected $rules = [];
    protected $items = [];

    public function __construct(array $rules)
    {
        $this->rules = $rules;
    }

    public function scan(string $product_code)
    {
        $product = Product::where('product_code', $product_code)->first();

        if ($product) {
            $this->items[] = $product->product_code;
        }
    }

    public function getFinalCost()
    {
        $total = 0;
        info('\n');
        foreach ($this->getItems() as $item) {
            $product = Product::where('product_code', $item)->first();
            info($item . ': ' . $this->getQtyPerProduct($product->product_code) . ' | ' . $product->price);
            $totalItems[$item] = [$this->getQtyPerProduct($product->product_code), $product->price];
        }

        foreach ($totalItems as $key => $item) {

            $rule = $this->rules[$key][0] ?? NULL;
            if (! is_null($rule)) {
                $total += $this->{$rule}($key, $item[0], $item[1], $this->rules[$key][1] ?? null, $this->rules[$key][2] ?? null);
            } else {
                $total += $this->getQtyPerProduct($key) * $item[1];
            }

        }
        info('###############');
        return $total;
    }

    public function getItems():array
    {
        return $this->items;
    }

    public function getQtyPerProduct($product)
    {
        return array_count_values($this->getItems())[$product];
    }

    private function getOneFree($code, $qty, $price, $rule1, $rule2)
    {
        $qty = floor($qty / 2) + $qty % 2;
        return $qty * $price;
    }

    private function bulk_discount($code, $qty, $price, $rule1, $rule2)
    {
        if ($qty >= $rule1) {
            return $rule2 * $qty;
        }
        return $price * $qty;
    }
}
