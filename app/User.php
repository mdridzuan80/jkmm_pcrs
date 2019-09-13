<?php

namespace App;

use App\Traits\HasPermissionTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable, HasPermissionTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'anggota_id', 'name', 'username', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function __construct()
    {
        $this->setDateFormat(config('pcrs.modelDateFormat'));
    }

    public function username()
    {
        return 'email';
    }

    public function anggota()
    {
        return $this->belongsTo(Anggota::class, 'anggota_id');
    }

    public function xtraAnggota()
    {
        return $this->belongsTo(XtraAnggota::class, 'anggota_id');
    }

    public function scopeRefsAnggota($query)
    {
        return $query->whereNotNull('anggota_id');
    }

    public function perananSemasa($peranan = null)
    {
        if ($peranan)
            Session::put('perananSemasa', $peranan);

        return Role::where('key', Session::get('perananSemasa'))->first();
    }

    public function scopeAuthorize($query)
    {
        $related = [];
        $effectedDept = Auth::user()->roles()->where('key', Auth::user()->perananSemasa()->key)->get()->map(function ($item, $key) {
            return $item->departments->map(function ($item, $key) {
                return $item->DEPTID;
            });
        })->flatten()->unique()->toArray();

        foreach ($effectedDept as $dept) {
            $related = array_merge($related, array_flatten(Utility::pcrsRelatedDepartment(Department::all(), $dept)));
        }

        $query->whereIn('DEFAULTDEPTID', array_merge($effectedDept, $related));
    }

    public static function scopeSenaraiPengguna($query, $search)
    {
        return $query->join(env('APP_DB_SCHEMA') . 'USERINFO', env('APP_DB_SCHEMA') . 'USERINFO.USERID', '=', 'users.anggota_id')
            ->whereRaw('DEFAULTDEPTID IN(' . $search->get('dept') . ')')
            ->when($search->get('key'), function ($query) use ($search) {
                $query->whereRaw("Badgenumber+" . env('APP_DB_SCHEMA') . "USERINFO.Name+SSN+TITLE LIKE '%" . $search->get('key') . "%'");
            })
            ->when(Auth::user()->username !== env('PCRS_DEFAULT_USER_ADMIN', 'admin'), function ($query) {
                $query->authorize();
            });
    }

    public function simpanLogin($request, $profil)
    {
        $this->anggota_id = $profil->userid;
        $this->name = $profil->xtraAttr->nama;
        $this->username = $request->input('txtEmail');
        $this->domain = 'internal';
        $this->password = bcrypt($request->input('txtKatalaluan'));
        $this->email = $request->input('txtEmail');
        $this->save();
        $this->roles()->attach(Role::where('key', Role::PENGGUNA)->first(), ['department_id' => $profil->xtraAttr->basedept_id]);
    }

    public static function setupLogin($profil, $password)
    {
        $user = self::updateOrCreate(
            ['email' => $profil->email],
            [
                'name' => $profil->name,
                'password' => bcrypt($password),
            ]
        );

        $user->roles()->syncWithoutDetaching([Role::where('key', Role::PENGGUNA)->first()->id => ['department_id' => $profil->dept_id]]);

        return $user;
    }
}
