<?php

namespace App\Transformers;

use Carbon\Carbon;
use League\Fractal\TransformerAbstract;

class ShiftTransformer extends TransformerAbstract
{
    public function transform($data)
    {
        return [
            'name' => $data->name,
            'starttime' => $data->check_in->format('h:i A'),
            'endtime' => $data->check_out->format('h:i A'),
        ];
    }
}
