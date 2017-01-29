<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;
use Laravel\Dusk\Page as BasePage;

class Clients extends BasePage
{
    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return '/backend/clients';
    }

    /**
     * Assert that the browser is on the page.
     *
     * @return void
     */
    public function assert(Browser $browser)
    {
        $browser->assertPathIs($this->url());
    }

    /**
     * Get the element shortcuts for the page.
     *
     * @return array
     */
    public function elements()
    {
        return [
            '@panel' => 'div.panel',
            '@table' => 'div.panel-body table.table',
            '@linkCreateClient' => 'Create',
            '@modalForm' => 'div#modal-form-client',
            '@modalHistory' => 'div#modal-client-history',
            '@createInputName' => 'div#modal-form-client input#input-client-name',
            '@createInputEmail' => 'div#modal-form-client input[name="email"]',
            '@createButtonSave' => 'div#modal-form-client button.btn-save'
        ];
    }
}
