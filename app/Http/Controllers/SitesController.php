<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class SitesController extends Controller
{
    /**
     * @return  View
     */
    public function index()
    {
        return view('views.sites.all')->with(['page_title' => 'All sites']);
    }
}
