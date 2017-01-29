<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\Browser\Pages\Clients;
use Tests\DuskTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ClientsTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
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
                ->waitFor('@modalCreation')
                ->assertSee('Create client')
                ->type('@createInputName', 'Test client')
                ->type('@createInputEmail', 'email@example.com')
                ->press('@createButtonSave')
                ->waitFor('@table')
                ->assertSee('email@example.com');
        });
    }
}
