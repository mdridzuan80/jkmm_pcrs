<?php

namespace App\Http\Controllers;

use App\User;
use App\Role;
use App\Anggota;
use App\Utility;
use App\RoleUser;
use League\Fractal\Manager;
use App\Base\BaseController;
use Illuminate\Http\Request;
use Adldap\Laravel\Facades\Adldap;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use League\Fractal\Resource\Collection;
use App\Transformers\LdapAttr as LdapAttrTransformer;

class PenggunaController extends BaseController
{
    public function rpcLoginIndex(Anggota $profil)
    {
        $view = 'pengguna.login.create';
        $roles = null;

        if ($profil->user) {
            $view = 'pengguna.login.index';
            $roles = Role::where('key', '<>', Role::PENGGUNA)
                ->where('priority', '>=', Auth::user()->perananSemasa()->priority)
                ->get();
        }

        return response()->view($view, compact('profil', 'roles'), 200);
    }

    public function rpcLoginStore(Anggota $profil, Request $request)
    {
        DB::transaction(function () use ($profil, $request) {
            $login = User::firstOrNew([
                'username' => $request->input('opt-user'),
                'anggota_id' => $profil->USERID
            ]);
            $login->simpanLogin($request, $profil);
        });

        return $this->rpcLoginIndex($profil);
    }

    public function rpcPerananStore(Request $request, Anggota $profil)
    {
        $role = Role::find($request->input('comPeranan'));
        $profil->user->roles()->attach($role, ['department_id' => $request->input('txtDepartmentId')]);
    }

    public function rpcPerananDestroy(RoleUser $roleUser)
    {
        if ($roleUser->roles()->where('key', Role::PENGGUNA)->get()->isNotEmpty())
            return response('Operasi tidak berjaya', 403);

        $roleUser->delete();
    }

    public function rpcSearchLdap(Request $request, Manager $fractal, LdapAttrTransformer $ldapAttrTransformer)
    {
        $user = Adldap::search()->where('objectClass', 'user')->where('anr', $request->input('txt-external-pam'))->get();

        $resource = new Collection($user, $ldapAttrTransformer);
        $transform = $fractal->createData($resource);

        return response()->json($transform->toArray());
    }
}
