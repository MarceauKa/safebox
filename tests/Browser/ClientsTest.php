<?php

namespace Tests\Browser;

use App\Models\Client;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\Clients;
use Tests\DuskTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ClientsTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * @test
     * @group clients
     */
    public function it_can_access_clients_page()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(1)
                    ->visit(new Clients())
                    ->assertSee('All clients')
                    ->assertSee('You have not created any clients.');
        });
    }

    /**
     * @test
     * @group clients
     */
    public function it_can_create_a_client()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(1)
                ->visit(new Clients())
                ->clickLink('@linkCreateClient')
                ->waitFor('@modalForm')
                ->assertSee('Create client')
                ->type('@createInputName', 'Test client')
                ->type('@createInputEmail', 'email@example.com')
                ->press('@createButtonSave')
                ->waitFor('@table')
                ->assertSee('email@example.com');
        });
    }

    /**
     * @test
     * @group clients
     */
    public function it_can_edit_a_client()
    {
        $client = factory(Client::class, 1)->create()->first();

        $this->browse(function (Browser $browser) use($client) {
            $browser->loginAs(1)
                ->visit(new Clients())
                ->waitFor('@table')
                ->assertSee($client->name)
                ->clickLink('Edit')
                ->waitFor('@modalForm')
                ->assertSeeIn('@modalForm', $client->name)
                ->type('@createInputName', 'New client name')
                ->press('@createButtonSave')
                ->waitUntilMissing('@modalForm')
                ->assertSeeIn('@table', 'New client name');
        });
    }

    /**
     * @test
     * @group clients
     */
    public function it_can_show_a_client_history()
    {
        $client = factory(Client::class, 1)->create()->first();

        $this->browse(function (Browser $browser) use($client) {
            $browser->loginAs(1)
                ->visit(new Clients())
                ->waitFor('@table')
                ->clickLink('Edit')
                ->waitFor('@modalForm')
                ->type('@createInputName', 'New client name')
                ->press('@createButtonSave')
                ->waitUntilMissing('@modalForm')
                ->clickLink('Edit')
                ->waitFor('@modalForm')
                ->clickLink('History')
                ->waitFor('@modalHistory')
                ->assertSeeIn('@modalHistory', $client->name);
        });
    }
}
