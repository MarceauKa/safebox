<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\View\View;

class AccountsController extends Controller
{
    /**
     * @return  View
     */
    public function index()
    {
        return view('views.accounts.all')->with(['page_title' => trans('app.pages.accounts'), 'types' => Account::$accounts_type]);
    }
}
