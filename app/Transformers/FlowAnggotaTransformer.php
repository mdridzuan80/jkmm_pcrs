<?php

namespace App\Transformers;

use App\Flow;
use App\FlowAnggota;
use League\Fractal\TransformerAbstract;

class FlowAnggotaTransformer extends TransformerAbstract
{
    public function transform($flowAnggota)
    {
        return [
            'flow' => ($flowAnggota) ? $flowAnggota->flag : Flow::INHERIT,
        ];
    }
}