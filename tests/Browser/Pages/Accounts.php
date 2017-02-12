<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;
use Laravel\Dusk\Page as BasePage;

class Accounts extends BasePage
{
    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return '/backend/accounts';
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
            '@table'         => 'div.panel-body table.table',
            '@modalForm'     => '#modal-form-account',
            '@selectSite'    => '#modal-form-account select[name=site_id]',
            '@selectType'    => '#modal-form-account select[name=type]',
            '@inputLogin'    => '#modal-form-account input#input-account-login',
            '@inputPassword' => '#modal-form-account input#input-account-password',
            '@inputComment'  => '#modal-form-account textarea[name=credential_comment]',
        ];
    }
}
