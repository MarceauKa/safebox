<?php

namespace App\Http\Controllers\Api;

use App\Jobs\TakeSiteScreenshot;
use App\Models\Site;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;

class SitesController extends Controller
{
    /** @var string Regex to validate GA id */
    const GAID_REGEX = '/^[A-Z]{2}-[0-9]{4,}-[0-9]{1,}$/';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Site::latest()->with('client')->paginate(25);
    }

    /**
     * @param   int $id
     * @return  JsonResponse
     */
    public function show($id)
    {
        $site = Site::with('client')->findOrFail($id);

        return $site;
    }

    /**
     * @return  JsonResponse
     */
    public function lists()
    {
        $sites = Site::orderBy('name', 'asc')->get();

        if (!$sites->isEmpty())
        {
            return $sites->pluck('name', 'id')->toArray();
        }

        return [];
    }

    /**
     * @param   $id
     * @return  JsonResponse
     */
    public function accounts($id)
    {
        $site = Site::with('accounts.accountable')->findOrFail($id);
        $accounts = new LengthAwarePaginator($site->accounts, $site->accounts->count(), 25);

        return $accounts;
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
            'name'             => 'required|max:255',
            'url'              => 'required|url',
            'repo_url'         => 'url',
            'google_analytics' => 'regex:' . self::GAID_REGEX,
            'client_id'        => 'required|exists:clients,id'
        ]);

        $site = new Site();
        $site->forceFill([
            'name'             => $request->get('name'),
            'url'              => $request->get('url'),
            'repo_url'         => $request->get('repo_url'),
            'google_analytics' => $request->get('google_analytics'),
            'client_id'        => $request->get('client_id')
        ])->save();

        $this->dispatch(new TakeSiteScreenshot($site));

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
        $site = Site::findOrFail($id);
        $old_url = $site->url;

        $this->validate($request, [
            'name'             => 'required|max:255',
            'url'              => 'required|url',
            'repo_url'         => 'url',
            'google_analytics' => 'regex:' . self::GAID_REGEX,
            'client_id'        => 'required|exists:clients,id'
        ]);

        $site->forceFill([
            'name'             => $request->get('name'),
            'url'              => $request->get('url'),
            'repo_url'         => $request->get('repo_url'),
            'google_analytics' => $request->get('google_analytics'),
            'client_id'        => $request->get('client_id')
        ])->save();

        // Take the picture only if site URL changed.
        if ($old_url != $site->url)
        {
            $this->dispatch(new TakeSiteScreenshot($site));
        }

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
        $site = Site::with('accounts')->findOrFail($id);

        $site->accounts()->delete();
        $site->delete();

        return response('ok', 200);
    }

    /**
     * @param   int $id
     * @return  JsonResponse
     */
    public function history($id)
    {
        $site = Site::with('revisionHistory')->findOrFail($id);
        $history = [];

        if (!$site->revisionHistory->isEmpty())
        {
            $history = $site->revisionHistory->groupBy(function ($item, $key)
            {
                return substr($item->created_at, 0, 10);
            })->map(function ($item, $key)
            {
                return collect([
                    'date'    => $key,
                    'entries' => $item
                ]);
            })->values();
        }

        return new JsonResponse([
            'site'    => $site,
            'history' => $history
        ]);
    }
}
