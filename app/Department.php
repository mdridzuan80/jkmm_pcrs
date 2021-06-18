<?php

namespace App;

use Auth;
use Carbon\Carbon;
use App\Base\BaseModel;
use App\Abstraction\Flowable;

class Department extends BaseModel implements Flowable
{
    public function __construct()
    {
        $this->table = 'departments';
        $this->setDateFormat(config('pcrs.modelDateFormat'));
        $this->primaryKey = 'deptid';
    }

    public function anggota()
    {
        return $this->hasMany(Anggota::class, 'defaultdeptid');
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_user');
    }

    public function flow()
    {
        return $this->hasOne(FlowBahagian::class, 'dept_id');
    }

    public function bdr()
    {
        return $this->hasMany(BdrSetting::class, 'bahagian_id');
    }

    public static function senaraiDepartment()
    {
        return SELF::when(Auth::user()->username !== env('PCRS_DEFAULT_USER_ADMIN', 'admin'), function ($query) {
            $query->authorize();
        })
            ->orderBy('deptname')->get();
    }

    static public function scopeAuthorize($query)
    {
        $related = [];
        $effectedDept = Auth::user()->roles()->where('key', Auth::user()->perananSemasa()->key)->get()->map(function ($item, $key) {
            return $item->pivot->department_id;
        })->flatten()->unique()->toArray();

        foreach ($effectedDept as $dept) {
            $related = array_merge($related, array_flatten(Utility::pcrsRelatedDepartment(Department::all(), $dept)));
        }

        $query->whereIn('deptid', array_merge($effectedDept, $related));
    }

    public function updateFlow($request)
    {
        $this->flow()->updateOrCreate([], ['flag' => $request->input('flag'), 'ubah_user_id' => Auth::user()->username]);
    }

    public function isActiveBdr($from = false, $to = false): bool
    {
        if (!$from) {
            $from = Carbon::now()->format('Y-m-d');
        }

        if (!$to) {
            $from = Carbon::now()->format('Y-m-d');
        }

        return 0 < $this->bdr()
            ->betweenDates($from, $to)
            ->count();
    }
}
