<?php

namespace Tests;

use Swift_Message;

trait MailTracking
{
    protected $emails = [];

    /** @before */
    public function setUpMailTracking():void
    {
        parent::setUp();
        app()->make('mailer')->getSwiftMailer()->registerPlugin(new TestingMailEventListener($this));
    }

    private function seeEmailWasSent()
    {
        $this->assertNotEmpty(
            $this->emails,
            'No emails have been sent'
        );

        return $this;
    }

    private function seeEmailWasNotSent()
    {
        $this->assertEmpty(
            $this->emails, 'Did not expect any emails to have been sent.'
        );

        return $this;
    }

    private function seeEmailEquals($body, Swift_Message $message = null)
    {
        $this->assertEquals($body, $this->getEmail($message)->getBody(),
        'No email with the provided body was sent');

        return $this;
    }

    private function seeEmailContains($excerpt, Swift_Message $message = null)
    {
        $this->assertContains($excerpt, explode(' ', $this->getEmail($message)->getBody()),
            'No email containing the provided body was sent');

        return $this;
    }

    private function seeEmailsSent($count)
    {
        $emailsSent = count($this->emails);
        $this->assertCount(
            $count, $this->emails,
            "Expected $count emails to have been send, but emails sent were $emailsSent"
        );

        return $this;
    }

    private function seeEmailFrom($sender, Swift_Message $message = null)
    {
        $this->assertArrayHasKey(
            $sender, $this->getEmail($message)->getFrom(),
            "No email was sent from $sender.");

        return $this;
    }

    private function seeEmailTo($recipient, Swift_Message $message = null)
    {
        $this->assertArrayHasKey(
            $recipient, $this->getEmail($message)->getTo(),
            "No email was sent to $recipient.");

        return $this;
    }

    public function addEmail(Swift_Message $email)
    {
        $this->emails[] = $email;
    }

    protected function getEmail(Swift_Message  $message = null)
    {
        $this->seeEmailWasSent();

        return $message ?: $this->lastEmail();
    }

    protected function lastEmail()
    {
        return end($this->emails);
    }
}

class TestingMailEventListener implements \Swift_Events_EventListener
{
    protected $test;

    public function __construct($test)
    {
        $this->test = $test;
    }
    public function beforeSendPerformed($event)
    {
        // $message = $event->getMessage();
        // $message->getTo()
        // $message->getBody()
        // $message->getFrom()

        $this->test->addEmail($event->getMessage());
    }
}
