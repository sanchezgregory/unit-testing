<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReverseArray extends Model
{
    use HasFactory;
    protected $string = '';

    public function __construct(string $string)
    {
        $this->string = $string;
    }

    public function reverse(): string
    {
        $array = str_split($this->string, 1);
        $newString = '';

        for($i=count($array); $i > 0; $i--)
        {
            $newString .= $array[$i-1];
        }
        return $newString;
    }
}
