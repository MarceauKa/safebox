<?php

namespace Tests\Browser;

use App\Models\Client;
use App\Models\Site;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\Sites;
use Tests\DuskTestCase;

class SitesTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * @test
     * @group sites
     */
    public function it_can_access_sites_page()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(1)
                    ->visit(new Sites())
                    ->assertSee('All sites')
                    ->assertSee('You have not created any sites.');
        });
    }

    /**
     * @test
     * @group sites
     */
    public function it_can_create_a_site()
    {
        $client = factory(Client::class, 1)->create()->first();

        $this->browse(function (Browser $browser) use($client) {
            $browser->loginAs(1)
                ->visit(new Sites())
                ->clickLink('Create')
                ->waitFor('@modalForm')
                ->assertSee('Create a site')
                ->assertSeeIn('@inputClient', $client->name)
                ->type('@inputName', 'My blog')
                ->type('@inputSite', 'http://www.google.fr')
                ->press('Save')
                ->waitForText('The client id field is required.')
                ->select('@inputClient', (string)$client->id)
                ->press('Save')
                ->waitUntilMissing('@modalForm')
                ->waitFor('@table')
                ->assertSeeIn('@table', 'My blog');
        });
    }

    /**
     * @test
     * @group sites
     */
    public function it_can_show_a_site()
    {
        $client = factory(Client::class, 1)->create()->first();
        $site = factory(Site::class, 1)->create(['client_id' => $client->id])->first();

        $this->browse(function (Browser $browser) use($client, $site) {
            $browser->loginAs(1)
                ->visit(new Sites())
                ->waitFor('@table')
                ->clickLink('See')
                ->waitFor('@modalShow')
                ->assertSeeIn('@modalShow', 'Visit')
                ->assertSeeIn('@modalShow', $site->url)
                ->assertSeeIn('@modalShow', $site->name)
                ->assertSeeIn('@modalShow', $client->name)
                ->assertSeeIn('@modalShow', 'You have not created any accounts.')
                ->press('Edit')
                ->waitFor('@modalForm')
                ->assertSeeIn('@modalForm', $site->name);
        });
    }

    /**
     * @test
     * @group sites
     */
    public function it_can_update_a_site()
    {
        $client = factory(Client::class, 1)->create()->first();
        $site = factory(Site::class, 1)->create(['client_id' => $client->id])->first();

        $this->browse(function (Browser $browser) use($client, $site) {
            $browser->loginAs(1)
                ->visit(new Sites())
                ->waitFor('@table')
                ->assertSeeIn('@table', $site->name)
                ->clickLink('Edit')
                ->waitFor('@modalForm')
                ->assertSeeIn('@modalForm', 'Edit site - ' . $site->name)
                ->assertInputValue('@inputName', $site->name)
                ->assertInputValue('@inputSite', $site->url)
                ->assertSelected('@inputClient', (string)$site->client_id)
                ->type('@inputName', 'Edited name')
                ->press('Save')
                ->waitUntilMissing('@modalForm')
                ->waitFor('@table')
                ->assertSeeIn('@table', 'Edited name');
        });
    }

    /**
     * @test
     * @group sites
     */
    public function it_can_show_site_history()
    {
        $client = factory(Client::class, 1)->create()->first();
        $site = factory(Site::class, 1)->create(['client_id' => $client->id])->first();
        $original_name = $site->name;
        $site->name = 'Got it!';
        $site->save();

        $this->browse(function (Browser $browser) use($client, $site, $original_name) {
            $browser->loginAs(1)
                ->visit(new Sites())
                ->waitFor('@table')
                ->clickLink('Edit')
                ->waitFor('@modalForm')
                ->press('History')
                ->waitFor('@modalHistory')
                ->assertSeeIn('@modalHistory', $site->name)
                ->assertSeeIn('@modalHistory', $original_name);
        });
    }

    /**
     * @test
     * @group sites
     */
    public function it_can_navigate_in_pagination()
    {
        $this->runDatabaseMigrations();

        $client = factory(Client::class, 1)->create()->first();
        $sites = factory(Site::class, 50)->create(['client_id' => $client->id]);

        $this->browse(function (Browser $browser) {
            $browser->loginAs(1)
                ->visit(new Sites())
                ->waitFor('@table')
                ->assertSee('Next');

            $value = $browser->text('table.table tbody tr td');

            $browser->clickLink('Next')
                    ->pause(1000)
                    ->assertDontSeeIn('@table', $value);
        });
    }
}
