<?php

namespace App\Http\Controllers\Api;

use App\Models\Account;
use App\Models\Site;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AccountsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Account::latest()->with('accountable')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'type' => 'required|in:'.implode(',', array_keys(Account::$accounts_type)),
            'site_id' => 'required|exists:sites,id',
            'credential_login' => 'required',
            'credential_password' => 'required'
        ]);

        $site = Site::findOrFail($request->get('site_id'));

        $account = new Account();
        $account->forceFill([
            'type' => $request->get('type'),
            'credential_login' => $request->get('credential_login'),
            'credential_password' => $request->get('credential_password')
        ]);

        $site->accounts()->save($account);

        return response('ok', 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $account = Account::findOrFail($id);

        $this->validate($request, [
            'type' => 'required|in:'.implode(',', array_keys(Account::$accounts_type)),
            'credential_login' => 'required',
            'credential_password' => 'required'
        ]);

        $account->forceFill([
            'type' => $request->get('type'),
            'credential_login' => $request->get('credential_login'),
            'credential_password' => $request->get('credential_password')
        ])->save();

        return response('ok', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $account = Account::findOrFail($id);

        $account->delete();

        return response('ok', 200);
    }
}
