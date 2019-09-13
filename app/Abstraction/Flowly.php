<?php

namespace App\Abstraction;

use App\Base\BaseModel;

abstract class Flowly extends BaseModel
{
    protected $fillable = ['flag', 'ubah_user_id'];
}
