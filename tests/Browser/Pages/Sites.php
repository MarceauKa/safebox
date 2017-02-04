<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;
use Laravel\Dusk\Page as BasePage;

class Sites extends BasePage
{
    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return '/backend/sites';
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
            '@modalShow' => 'div#modal-show-site',
            '@modalForm' => 'div#modal-form-site',
            '@modalHistory' => 'div#modal-site-history',
            '@inputName' => 'div#modal-form-site input#input-site-name',
            '@inputSite' => 'div#modal-form-site input[name="url"]',
            '@inputClient' => 'div#modal-form-site select',
        ];
    }
}
