<?php

namespace Tests\Unit\Core\Domain\Notification;

use Core\Domain\Shared\NotificationPattern\Notification;
use Tests\TestCase;

class NotificationUnitTest extends TestCase
{
    public function test_get_errors()
    {
        $notification = new Notification();
        $errors = $notification->getErrors();

        $this->assertIsArray($errors);
    }

    public function test_add_errors()
    {
        $notification = new Notification();
        $notification->addError([
            'context' => 'user',
            'message' => 'user title is required',
        ]);

        $errors = $notification->getErrors();

        $this->assertCount(1, $errors);
    }

    public function test_has_errors()
    {
        $notification = new Notification();
        $hasErrors = $notification->hasErrors();
        $this->assertFalse($hasErrors);

        $notification->addError([
            'context' => 'user',
            'message' => 'user title is required',
        ]);
        $this->assertTrue($notification->hasErrors());
    }

    public function test_message()
    {
        $notification = new Notification();
        $notification->addError([
            'context' => 'user',
            'message' => 'title is required',
        ]);
        $notification->addError([
            'context' => 'user',
            'message' => 'description is required',
        ]);
        $message = $notification->messages();

        $this->assertIsString($message);
        $this->assertEquals(
            expected: 'user: title is required,user: description is required,',
            actual: $message
        );
    }

    public function test_message_filter_context()
    {
        $notification = new Notification();
        $notification->addError([
            'context' => 'user',
            'message' => 'title is required',
        ]);
        $notification->addError([
            'context' => 'category',
            'message' => 'name is required',
        ]);

        $this->assertCount(2, $notification->getErrors());

        $message = $notification->messages(
            context: 'user'
        );
        $this->assertIsString($message);
        $this->assertEquals(
            expected: 'user: title is required,',
            actual: $message
        );
    }
}
