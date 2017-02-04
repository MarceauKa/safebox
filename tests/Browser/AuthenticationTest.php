<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class AuthenticationTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * @test
     * @group login
     */
    public function it_can_login_and_access_the_dashboard()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->assertSee('Login')
                ->type('email', 'admin@safebox.com')
                ->type('password', 'password')
                ->press('Login')
                ->assertPathIs('/home')
                ->assertSee('Dashboard');
        });
    }

    /**
     * @test
     * @group login
     */
    public function it_can_logout()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(1)
                ->visit('/home')
                ->clickLink('Logout')
                ->assertPathIs('/');
        });
    }

    /**
     * @test
     * @group login
     */
    public function it_cant_login_when_typing_wrong_credentials()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->assertSee('Login')
                ->type('email', 'admin@safebox.com')
                ->type('password', 'BACON4EVER')
                ->press('Login')
                ->assertPathIs('/')
                ->assertSee('These credentials do not match our records.');
        });
    }
}
