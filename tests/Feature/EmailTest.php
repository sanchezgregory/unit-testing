<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Mail;
use Tests\MailTracking;
use Tests\TestCase;

class EmailTest extends TestCase
{
    use MailTracking;

    public function test_example()
    {
         $this->get('/');

        // test sending more than one
        $this->seeEmailWasSent()
            ->seeEmailsSent(1)
            ->seeEmailTo('foo@bar.com')
            ->seeEmailFrom('bar@foo.com')
            ->seeEmailEquals('Hello world')
            ->seeEmailContains('Hello');
            //->seeEmailWasNotSent();
    }
}
