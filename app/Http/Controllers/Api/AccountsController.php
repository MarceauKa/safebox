<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Site;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Validator;

class AccountsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Account::latest()->with('accountable')->paginate(25);
    }

    /**
     * @param   int $id
     * @return  JsonResponse
     */
    public function show($id)
    {
        return Account::with('accountable')->findOrFail($id);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return Model
     */
    public function store(Request $request)
    {
        /** @var Validator $validation */
        $validation = \Validator::make($request->all(), [
            'type' => 'required|in:' . implode(',', array_keys(Account::$accounts_type)),
        ]);

        $validation->sometimes('site_id', 'required|exists:sites,id', function ($input) {
            return $input->site_id > 0;
        });

        if ($validation->fails()) {
            return response($validation->messages(), 422);
        }

        $account = new Account();
        $account->forceFill([
            'type' => $request->get('type'),
            'credentials' => $request->get('credentials', [])
        ]);

        if ($request->get('site_id')) {
            $site = Site::findOrFail($request->get('site_id'));
            $site->accounts()->save($account);
        } else {
            $account->save();
        }

        return $account;
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
        $account = Account::findOrFail($id);

        /** @var Validator $validation */
        $validation = \Validator::make($request->all(), [
            'type' => 'required|in:' . implode(',', array_keys(Account::$accounts_type))
        ]);

        $validation->sometimes('site_id', 'required|exists:sites,id', function ($input) {
            return $input->site_id > 0;
        });

        if ($validation->fails()) {
            return response($validation->messages(), 422);
        }

        $account->forceFill([
            'type' => $request->get('type'),
            'credentials' => $request->get('credentials', [])
        ]);

        if (
            (true === is_null($account->accountable) && $request->get('site_id') > 0)
            || (false === is_null($account->accountable) && $request->get('site_id') > 0 && $request->get('site_id') != $account->accountable->id)
        ) {
            $id = $request->get('site_id');
            $site = Site::findOrFail($id);
            $site->accounts()->save($account);
        } elseif (false === is_null($account->accountable) && $request->get('site_id') != $account->accountable->id) {
            $account->accountable_type = null;
            $account->accountable_id = null;
        }

        $account->save();

        return $account;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $account = Account::findOrFail($id);

        $account->delete();

        return response('ok', 200);
    }

    /**
     * @param   int $id
     * @return  JsonResponse
     */
    public function history($id)
    {
        $account = Account::with([
            'revisionHistory',
            'accountable'
        ])->findOrFail($id);
        $history = [];

        if (!$account->revisionHistory->isEmpty()) {
            $history = $account->revisionHistory->groupBy(function ($item, $key) {
                return substr($item->created_at, 0, 10);
            })->map(function ($item, $key) {
                $item->transform(function ($item) {
                    switch ($item->key) {
                        case 'credential_login':
                        case 'credential_password':
                            $item->old_value = decrypt($item->old_value);
                            $item->new_value = decrypt($item->new_value);
                            break;

                        default:
                            break;
                    }

                    return $item;
                });

                return collect([
                    'date' => $key,
                    'entries' => $item
                ]);
            })->values();
        }

        return new JsonResponse([
            'account' => $account,
            'history' => $history
        ]);
    }
}
