<?php

namespace App\Models;

class BladeDirective
{
    protected $cache;

    public function __construct(RussianCache $cache)
    {
        $this->cache = $cache;
    }

    public function setUp($key)
    {
        $this->cache->has($key);
    }

    public function foo()
    {
    }
}
