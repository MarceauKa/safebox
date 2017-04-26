<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ClientsController extends Controller
{
    /**
     * @return array
     */
    public function index()
    {
        return Client::latest()->paginate(20);
    }

    /**
     * @return array
     */
    public function lists()
    {
        $clients = Client::orderBy('name', 'asc')->get([
            'id',
            'name'
        ]);

        if (!$clients->isEmpty()) {
            return $clients->toArray();
        }

        return [];
    }

    /**
     * @param   int $id
     * @return  array
     */
    public function show($id)
    {
        $client = Client::findOrFail($id);

        return $client;
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return Client
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'email' => 'required|email',
            'phone' => 'max:20',
            'address' => 'max:255',
            'note' => 'max:255',
            'facebook' => 'max:255',
            'twitter' => 'max:255',
        ]);

        $client = new Client();
        $client->name = $request->get('name');
        $client->email = $request->get('email');
        $client->phone = $request->get('phone');
        $client->address = $request->get('address');
        $client->note = $request->get('note');
        $client->facebook = $request->get('facebook');
        $client->twitter = $request->get('twitter');
        $client->save();

        return $client;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int                      $id
     * @return Client
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'email' => 'required|email',
            'phone' => 'max:20',
            'address' => 'max:255',
            'note' => 'max:255',
            'facebook' => 'max:255',
            'twitter' => 'max:255',
        ]);

        $client = Client::findOrFail($id);
        $client->name = $request->get('name');
        $client->email = $request->get('email');
        $client->phone = $request->get('phone');
        $client->address = $request->get('address');
        $client->note = $request->get('note');
        $client->facebook = $request->get('facebook');
        $client->twitter = $request->get('twitter');
        $client->save();

        return $client;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        $client = Client::findOrFail($id);

        $client->sites()->delete();
        $client->delete();

        return new JsonResponse($client->id, 200);
    }

    /**
     * @param   int $id
     * @return  JsonResponse
     */
    public function history($id)
    {
        $client = Client::with('revisionHistory')->findOrFail($id);
        $history = [];

        if (!$client->revisionHistory->isEmpty()) {
            $history = $client->revisionHistory->groupBy(function ($item, $key) {
                return substr($item->created_at, 0, 10);
            })->map(function ($item, $key) {
                return collect([
                    'date' => $key,
                    'entries' => $item
                ]);
            })->values();
        }

        return new JsonResponse([
            'client' => $client,
            'history' => $history
        ]);
    }
}
