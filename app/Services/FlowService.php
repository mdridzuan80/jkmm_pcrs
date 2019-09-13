<?php

namespace App\Services;

use App\Flow;
use App\RoleUser;
use App\Abstraction\Flowly;
use App\Abstraction\Flowable;

class FlowService
{
    public function getFlowAnggota(Flowable $flowable)
    {
        $flow = $flowable->flow;

        if (!$flow || $this->getFlow($flow) == Flow::INHERIT) {
            return $this->getFlowBahagian($flowable->xtraAttr->baseDepartment);
        }

        return $this->getFlow($flow);
    }

    public function getFlowBahagian(Flowable $flowable)
    {
        $flow = $flowable->flow;

        if ($flow) {
            return $this->getFlow($flow);
        }

        return Flow::BIASA;
    }

    public function getFlow(Flowly $flowly)
    {
        return $flowly->flag;
    }

    public function pelulus(Flowable $profil)
    {
        if ($this->getFlowAnggota($profil) == Flow::KETUA) {
            return RoleUser::where('department_id', $profil->xtraAttr->basedept_id)
                ->where('role_id', 3)->first()->user->anggota;
        }

        return optional($profil->pegawaiYangMenilai()->where('pegawai_flag', 1)->first())->penilai;
    }
}
