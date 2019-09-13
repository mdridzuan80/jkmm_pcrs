<?php
namespace App\Contracts;

interface Eventable
{
    public function scopeEvents($query);
}