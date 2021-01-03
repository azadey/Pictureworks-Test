<?php

namespace Tests\Feature;

use Api\Modules\UserComment\Requests\UserCommentRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserCommentTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testSuccessful()
    {
        $response = $this->postJson('/api/user-comment', [
                'name' => 'Robi Jackson',
                'password' => '720DF6C2482218518FA20FDC52D4DED7ECC043AB',
                'comments' => 'This is a testing comment'
            ]);

        $response
            ->assertStatus(200);
    }

    public function testNameRequired()
    {
        $response = $this->postJson('/api/user-comment', [
            'password' => '720DF6C2482218518FA20FDC52D4DED7ECC043AB',
            'comments' => 'This is a testing comment'
        ]);

        $response
            ->assertStatus(500);
    }

    public function testPasswordValid()
    {
        $response = $this->postJson('/api/user-comment', [
            'name' => 'Robi Jackson',
            'password' => '387348957349587',
            'comments' => 'This is a testing comment'
        ]);

        $response
            ->assertStatus(500);
    }

    public function testCommentsRequired()
    {
        $response = $this->postJson('/api/user-comment', [
            'name' => 'Robi Jackson',
            'password' => '387348957349587',
            'comments' => ''
        ]);

        $response
            ->assertStatus(500);
    }
}
