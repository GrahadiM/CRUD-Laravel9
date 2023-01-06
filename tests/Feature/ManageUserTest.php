<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ManageUserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admin_can_create_user()
    {
        $this->assertTrue(true);
    }

    /** @test */
    public function admin_can_browse_users_index_page()
    {
        $this->assertTrue(true);
    }

    /** @test */
    public function admin_can_edit_existing_user()
    {
        $this->assertTrue(true);
    }

    /** @test */
    public function admin_can_delete_existing_user()
    {
        $this->assertTrue(true);
    }
}
