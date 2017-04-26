<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class LoginTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->artisan('migrate:refresh');
    }

    /** @test */
    public function it_logins_with_valid_credentials()
    {
        $user = factory(User::class, 1)->create([
            'password' => bcrypt('secret')
        ])->first();

        $response = $this->get('/');
        $response->assertSee('Login');

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'secret'
        ])->assertRedirect('/home');
    }

    /** @test */
    public function it_not_logins_with_invalid_credentials()
    {
        $user = factory(User::class, 1)->create([
            'password' => bcrypt('secret')
        ])->first();

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'foobar'
        ])->assertRedirect('/');
    }

    /** @test */
    public function it_protects_api_and_app()
    {
        $this->get('/home')
            ->assertRedirect('/login');

        $this->json('GET', '/api/user')
            ->assertStatus(401);
    }

    /** @test */
    public function it_gets_user_info_from_api()
    {
        $user = factory(User::class, 1)->create()->first();

        $this->actingAs($user, 'api');
        $this->json('GET', '/api/user')->assertJson([
            'id' => $user->id,
            'name' => $user->name,
        ]);
    }
}
