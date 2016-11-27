<?php

namespace App\Http\Controllers\Api;

use App\Models\Client;
use App\Models\Site;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SearchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function all(Request $request)
    {
        $query = $request->get('query');
        $search = ['clients' => [], 'sites' => []];

        try
        {
            $search['clients'] = Client::search($query)->take(5)->get();
        } catch (\Exception $e) {
            unset($e);
        }

        try
        {
            $search['sites'] = Site::search($query)->take(5)->get();
        } catch (\Exception $e) {
            unset($e);
        }

        return $search;
    }
}
