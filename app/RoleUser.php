<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class RoleUser extends Pivot
{
    protected $table = 'role_user';

    public function __construct()
    {
        $this->setDateFormat(config('pcrs.modelDateFormat'));
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'DEPTID');
    }

    public function roles()
    {
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
