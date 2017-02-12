<?php

namespace Tests\Browser;

use App\Models\Account;
use App\Models\Client;
use App\Models\Site;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\Accounts;
use Tests\DuskTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class AccountsTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * @test
     * @group accounts
     */
    public function it_can_access_accounts_page()
    {
        $this->browse(function ($browser)
        {
            $browser->loginAs(1)
                ->visit(new Accounts())
                ->assertSee('All accounts');
        });
    }

    /**
     * @test
     * @group accounts
     */
    public function it_can_create_an_account_without_a_site()
    {
        $this->browse(function (Browser $browser)
        {
            $browser->loginAs(1)
                ->visit(new Accounts())
                ->assertSeeLink('Create')
                ->clickLink('Create')
                ->waitFor('@modalForm')
                ->assertSee('Create account')
                ->select('@selectType', 'ftp')
                ->assertSelected('@selectType', 'ftp')
                ->type('@inputLogin', 'ftp_user')
                ->assertValue('@inputLogin', 'ftp_user')
                ->type('@inputPassword', 'ftp_pass')
                ->assertValue('@inputPassword', 'ftp_pass')
                ->press('Save')
                ->waitUntilMissing('@modalForm')
                ->waitFor('@table')
                ->assertSeeIn('@table', 'ftp_user')
                ->assertSeeIn('@table', 'FTP')
                ->assertSeeIn('@table', '-');
        });
    }

    /**
     * @test
     * @group accounts
     */
    public function it_can_create_an_account_with_a_site()
    {
        $client = factory(Client::class, 1)->create()->first();
        $site = factory(Site::class, 1)->create(['client_id' => $client->id])->first();

        $this->browse(function (Browser $browser) use ($site)
        {
            $browser->loginAs(1)
                ->visit(new Accounts())
                ->assertSeeLink('Create')
                ->clickLink('Create')
                ->waitFor('@modalForm')
                ->assertSee('Create account')
                ->select('@selectSite', (string)$site->id)
                ->assertSelected('@selectSite', (string)$site->id)
                ->select('@selectType', 'ssh')
                ->assertSelected('@selectType', 'ssh')
                ->type('@inputLogin', 'root')
                ->assertValue('@inputLogin', 'root')
                ->type('@inputPassword', 'toor')
                ->assertValue('@inputPassword', 'toor')
                ->press('Save')
                ->waitUntilMissing('@modalForm')
                ->waitFor('@table')
                ->assertSeeIn('@table', 'root')
                ->assertSeeIn('@table', 'SSH')
                ->assertSeeIn('@table', $site->name);
        });
    }

    /**
     * @test
     * @group accounts
     */
    public function it_can_edit_an_account()
    {
        $client = factory(Client::class, 1)->create()->first();
        $site = factory(Site::class, 1)->create(['client_id' => $client->id])->first();
        $account = $this->makeAccount();

        $this->browse(function (Browser $browser) use ($site, $account)
        {
            $browser->loginAs(1)
                ->visit(new Accounts())
                ->waitFor('@table')
                ->assertSeeIn('@table', $account->credential_login)
                ->clickLink('Edit')
                ->waitFor('@modalForm')
                ->assertSee('Edit account')
                ->assertSelected('@selectSite', '')
                ->select('@selectSite', (string)$site->id)
                ->assertSelected('@selectSite', (string)$site->id)
                ->type('@inputLogin', 'new_login')
                ->assertValue('@inputLogin', 'new_login')
                ->type('@inputPassword', 'new_pass')
                ->assertValue('@inputPassword', 'new_pass')
                ->press('Save')
                ->waitUntilMissing('@modalForm')
                ->waitFor('@table')
                ->assertSeeIn('@table', 'new_login')
                ->assertSeeIn('@table', $site->name);
        });
    }

    /**
     * @test
     * @group accounts
     */
    public function it_can_copy_a_password()
    {
        $account = $this->makeAccount();

        $this->browse(function (Browser $browser) use ($account)
        {
            $browser->loginAs(1)
                ->visit(new Accounts())
                ->waitFor('@table')
                ->assertSeeIn('@table', 'Copy')
                ->press('Copy')
                ->pause(200)
                ->clickLink('Edit')
                ->waitFor('@modalForm')
                ->type('@inputLogin', '')
                ->keys('@inputLogin', '{shift}', '{insert}')
                ->pause(200)
                ->assertValue('@inputLogin', $account->credential_password)
                ->pause(200);
        });
    }

    /**
     * @param   void
     * @return  Account
     */
    protected function makeAccount()
    {
        $account = new Account();
        $account->type = 'ftp';
        $account->credential_login = 'ftp_login';
        $account->credential_password = 'ftp_pass';
        $account->save();

        return $account;
    }
}
