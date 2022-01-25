<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected $user;

    public function signIn($user = null)
    {
        if (! $user) {
            $user = User::factory()->create();
        }

        $this->user = $user;

        $this->actingAs($this->user);

        return $this;
    }
}
