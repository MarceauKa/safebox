<?php

namespace App\Http\Controllers\Api;

use App\Models\Client;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ClientsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Client::latest()->paginate(20);
    }

    /**
     * @return  JsonResponse
     */
    public function lists()
    {
        $clients = Client::orderBy('name', 'asc')->get(['id', 'name']);

        if (!$clients->isEmpty())
        {
            return $clients->toArray();
        }

        return [];
    }

    /**
     * @param   int $id
     * @return  JsonResponse
     */
    public function show($id)
    {
        $client = Client::findOrFail($id);

        return $client;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'  => 'required|max:255',
            'email' => 'required|email',
            'phone' => 'max:20',
        ]);

        $client = new Client();
        $client->name = $request->get('name');
        $client->email = $request->get('email');
        $client->phone = $request->get('phone');
        $client->save();

        return response('ok', 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int                      $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name'  => 'required|max:255',
            'email' => 'required|email',
            'phone' => 'max:20',
        ]);

        $client = Client::findOrFail($id);
        $client->name = $request->get('name');
        $client->email = $request->get('email');
        $client->phone = $request->get('phone');
        $client->save();

        return response('ok', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $client = Client::with('sites')->findOrFail($id);

        $client->sites()->delete();
        $client->delete();

        return response('ok', 200);
    }

    /**
     * @param   int $id
     * @return  JsonResponse
     */
    public function history($id)
    {
        $client = Client::with('revisionHistory')->findOrFail($id);
        $history = [];

        if (!$client->revisionHistory->isEmpty())
        {
            $history = $client->revisionHistory->groupBy(function ($item, $key) {
                return substr($item->created_at, 0, 10);
            })->map(function($item, $key) {
                return collect(['date' => $key, 'entries' => $item]);
            })->values();
        }

        return new JsonResponse([
            'client'  => $client,
            'history' => $history
        ]);
    }
}
