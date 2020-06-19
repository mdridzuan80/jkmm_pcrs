<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;

class PuasaTransformer extends TransformerAbstract
{
    public function transform($item)
    {
        return [
            'id' => $item->id,
            'tkhmula' => $item->tkhmula,
            'tkhtamat' => $item->tkhtamat,
        ];
    }
}
