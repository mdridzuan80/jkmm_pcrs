<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;

class LdapAttr extends TransformerAbstract
{
    public function transform($ldapSrc)
    {
        return [
            'username' => $ldapSrc->samaccountname[0],
            'cn' => $ldapSrc->cn[0],
            'email' => $ldapSrc->mail[0],
        ];
    }
}