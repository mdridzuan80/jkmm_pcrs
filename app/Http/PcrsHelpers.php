<?php
use App\Utility;
use App\Department;
use Illuminate\Support\Facades\Auth;

if (! function_exists('pcrsMenuActiveCondition')) {
    function pcrsMenuActiveCondition($suppose, $resource)
    {
        return ($suppose == $resource) ? 'active' : '';
    }
}

if (! function_exists('pcrsBulan')) {
    function pcrsBulan()
    {
        return collect([
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Mac',
            4 => 'April',
            5 => 'Mei',
            6 => 'Jun',
            7 => 'Julai',
            8 => 'Ogos',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Disember'
        ]);
    }
}

if (! function_exists('relatedJabatan')) {
    function pcrsRelatedDepartment(array $elements, $parentId = 1)
    {
        $branch = [];

        foreach ($elements as $element) {
            if ($element['parent'] == $parentId) {
                $branch[] = $element['id'];
                $c = relatedJabatan($elements, $element['id']);
                if ($c) {
                    $branch[] = $c;
                }
            }
        }
        array_push($branch, $parentId);
        return $branch;
    }
}

if(! function_exists('pcrsListerDepartment')) {
    function pcrsListerDepartment($SubDepartmentOption, $departmentId)
    {
        return ($SubDepartmentOption) ? implode(',', flatten(relatedJabatan($this->getAll()->result_array(), $dept))) : $departmentId;
    }
}
