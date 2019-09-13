<?php

namespace App\Http\Controllers;

use App\Department;
use App\Base\BaseController;

class DepartmentController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function departmentTree()
    {
        $data = [];

        $selected = Auth()->user()->roles()->where('key', session('perananSemasa'))->first()->pivot->department_id;
        $parentDeptId = Department::find($selected)->supdeptid;

        $departments = Department::senaraiDepartment();

        foreach ($departments as $department) {
            $data[] = [
                'id' => $department->deptid,
                'parent' => ($department->supdeptid != $parentDeptId ? $department->supdeptid : '#'),
                'text' => $department->deptname,
                'state' => [
                    'opened' => ($department->deptid == $selected) ? true : false,
                    'selected' => ($department->deptid == $selected) ? true : false
                ]
            ];
        }

        return $data;
    }
}
