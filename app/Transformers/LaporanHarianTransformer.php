<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;

class LaporanHarianTransformer extends TransformerAbstract
{
    public function transform($item)
    {
        return [
            'badgenumber' => $item->badgenumber,
            'nama' => $item->nama,
            'shift' => $item->shift_name,
            'check_in' => $item->check_in,
            'check_out' => $item->check_out,
            'kesalahan' => $item->kesalahan,
            'tatatertib_flag' => $item->tatatertib_flag,
        ];
    }
}
