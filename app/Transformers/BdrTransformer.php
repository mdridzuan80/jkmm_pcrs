<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;

class BdrTransformer extends TransformerAbstract
{
    public function transform($item)
    {
        return [
            'id' => $item->id,
            'bahagian' => $item->department->deptname,
            'tkhmula' => $item->tkhmula,
            'tkhtamat' => $item->tkhtamat,
        ];
    }
}
