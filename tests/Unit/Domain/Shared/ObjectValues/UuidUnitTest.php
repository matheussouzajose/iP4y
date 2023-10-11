<?php

namespace Tests\Unit\Domain\Shared\ObjectValues;

use Core\Domain\Shared\ObjectValues\Uuid;
use Ramsey\Uuid\Uuid as RamseyUuid;
use Tests\TestCase;

class UuidUnitTest extends TestCase
{
    public function test_random_uuid()
    {
        $uuid = Uuid::random();

        $this->assertNotEmpty($uuid);
    }

    public function test_throws_uuid_error()
    {
        $this->expectExceptionObject(new \InvalidArgumentException('Invalid Uuid'));

        new Uuid('invalid');
    }

    public function test_new_uuid_success()
    {
        $uuid = RamseyUuid::uuid4();
        $newUuid = new Uuid($uuid);

        $this->assertEquals($uuid, (string) $newUuid);
    }
}
