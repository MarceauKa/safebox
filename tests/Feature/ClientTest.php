<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\User;
use Tests\TestCase;

class ClientTest extends TestCase
{
    /** @var User */
    public $user;

    public function setUp()
    {
        parent::setUp();

        $this->artisan('migrate:refresh');

        $this->user = User::first();
        $this->actingAs($this->user, 'api');
    }

    /** @test */
    public function it_fetches_clients()
    {
        // Test the endpoint without any clients
        $this->json('GET', '/api/clients')
            ->assertJson(['total' => 0]);

        // Creating 50 clients
        $clients = factory(Client::class, 50)->create();

        // Test the endpoint when hydrated
        $this->json('GET', '/api/clients')
            ->assertJson(['total' => 50]);

        // Test the other client endpoint
        $response = $this->json('GET', '/api/clients/list')->decodeResponseJson();
        $this->assertCount(50, $response);

        // Test if the endpoint show returns client data
        $client = $clients->first();
        $this->json('GET', '/api/clients/' . $client->id)
            ->assertJson([
                'name' => $client->name
            ]);
    }

    /** @test */
    public function it_creates_client()
    {
        // Sending wrong data to the endpoint
        $this->json('POST', '/api/clients', ['name' => 'Joe'])->assertSee('The email field is required.');
        $this->json('POST', '/api/clients', ['email' => 'email@example.com'])->assertSee('The name field is required.');

        // Sending valid data to the endpoint
        $data = [
            'name' => 'Joe',
            'email' => 'joe@example.com',
            'phone' => '0102030405',
            'address' => 'the address',
            'note' => 'the note',
            'facebook' => 'the facebook',
            'twitter' => 'the twitter'
        ];

        $this->json('POST', '/api/clients', $data)->assertJson($data);

        $client = Client::latest()->first();

        $this->assertEquals($data['email'], $client->email);
        $this->assertEquals($data['name'], $client->name);
        $this->assertEquals($data['phone'], $client->phone);
        $this->assertEquals($data['address'], $client->address);
        $this->assertEquals($data['note'], $client->note);
        $this->assertEquals($data['facebook'], $client->facebook);
        $this->assertEquals($data['twitter'], $client->twitter);
    }

    /** @test */
    public function it_updates_client()
    {
        // Trying to update an unexisting client
        $update_data = [
            'name' => 'John',
            'email' => 'john@example.com'
        ];

        $this->json('PUT', '/api/clients/9000', $update_data)
            ->assertStatus(404);


        // Updating with invalid data
        $client = factory(Client::class, 1)->create()->first();

        $this->json('PUT', '/api/clients/' . $client->id, ['email' => ''])
            ->assertSee('The email field is required.');

        // Updating with valid data
        $update_data = [
            'name' => 'Jane',
            'email' => 'jane@example.com'
        ];

        $this->json('PUT', '/api/clients/' . $client->id, $update_data)
            ->assertJson($update_data);
    }

    /** @test */
    public function it_deletes_client()
    {
        // Trying to delete an unexisting user
        $this->json('DELETE', '/api/clients/9000')
            ->assertStatus(404);

        // Trying to delete an existing user
        $client = factory(Client::class, 1)->create()->first();
        $this->json('DELETE', '/api/clients/' . $client->id)->assertStatus(200);
    }
}
