<?php

namespace Tests\Unit;

use App\Enums\Role;
use PHPUnit\Framework\TestCase;

class BaseUnitTest extends TestCase
{
    public function test_that_role_enum_has_four_cases(): void
    {
        // act
        $admin = Role::ADMIN;
        $author = Role::AUTHOR;
        $guest = Role::GUEST;
        $user = Role::USER;

        // assert
        $this->assertEquals(Role::ADMIN, $admin);
        $this->assertEquals(Role::AUTHOR, $author);
        $this->assertEquals(Role::GUEST, $guest);
        $this->assertEquals(Role::USER, $user);

        $this->assertNotEquals(Role::ADMIN, $author);
        $this->assertNotEquals(Role::ADMIN, $guest);
        $this->assertNotEquals(Role::ADMIN, $user);

        $this->assertNotEquals(Role::AUTHOR, $admin);
        $this->assertNotEquals(Role::AUTHOR, $guest);
        $this->assertNotEquals(Role::AUTHOR, $user);

        $this->assertNotEquals(Role::GUEST, $admin);
        $this->assertNotEquals(Role::GUEST, $author);
        $this->assertNotEquals(Role::GUEST, $user);

        $this->assertNotEquals(Role::USER, $author);
        $this->assertNotEquals(Role::USER, $guest);
        $this->assertNotEquals(Role::USER, $admin);
    }
}
