<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class ClientsController extends Controller
{
    /**
     * @return  View
     */
    public function index()
    {
        return view('views.clients.all')->with(['page_title' => trans('app.pages.clients')]);
    }
}
