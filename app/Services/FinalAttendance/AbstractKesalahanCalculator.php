<?php

namespace App\Services\FinalAttendance;

use App\Kehadiran;
use App\Parameter;
use Carbon\Carbon;

abstract class AbstractKesalahanCalculator
{
    //abstract protected function calcKesalahanPetang($checkIn, $checkOut, $shift);

    protected $statusLewat = false;
    protected $statusAwal = false;

    const MINIMUM = "7:30";

    public function kesalahanCalculator($tarikh, $checkIn, $checkOut, $shift, $cuti)
    {
        $kesalahan = [];

        if ($this->isCuti($tarikh, $cuti)) {
            return $kesalahan;
        }

        if (($salah = $this->calcKesalahanPagi($checkIn, $shift)) != Kehadiran::FLAG_KESALAHAN_NONE) {
            $kesalahan[] = $salah;
        }

        if (($salah = $this->calcKesalahanPetang($checkIn, $checkOut, $shift)) != Kehadiran::FLAG_KESALAHAN_NONE) {
            $kesalahan[] = $salah;
        }

        return $kesalahan;
    }

    private function calcKesalahanPagi($checkIn, $shift)
    {
        if (!$checkIn) {
            return Kehadiran::FLAG_KESALAHAN_NONEIN;
        }

        if ($this->isLate($checkIn, $shift)) {
            return Kehadiran::FLAG_KESALAHAN_LEWAT;
        }

        return Kehadiran::FLAG_KESALAHAN_NONE;
    }

    private function isLate($check_in, $shift)
    {
        if (!$check_in) {
            return $this->statusLewat;
        }

        $rulePunchIn = Carbon::parse($check_in->toDateString() . " " . $shift->check_in->toTimeString());
        $paramBenarLewat = (int) Parameter::where('kod', 'P_BENAR_LEWAT')->first()->nilai;

        return $this->statusLewat = $check_in->gte($rulePunchIn->addMinutes($paramBenarLewat));
    }

    private function isCuti(Carbon $tarikh, $cuti)
    {
        return $cuti->contains(function ($item, $key) use ($tarikh) {
            return $item->tarikh->eq($tarikh);
        }) ||
            $tarikh->dayOfWeek == Carbon::SATURDAY ||
            $tarikh->dayOfWeek == Carbon::SUNDAY;
    }

    private function calcKesalahanPetang($checkIn, $checkOut, $shift)
    {
        if (!$checkOut) {
            return Kehadiran::FLAG_KESALAHAN_NONEOUT;
        }

        if ($this->isEarly($checkIn, $checkOut, $shift)) {
            return Kehadiran::FLAG_KESALAHAN_AWAL;
        }

        return Kehadiran::FLAG_KESALAHAN_NONE;
    }

    private function isEarly($check_in, $check_out, $shift)
    {
        $rulePunchOut = Carbon::parse($check_out->toDateString() . " " . $shift->check_out->toTimeString());

        if (!$check_in || $this->statusLewat) {
            return $this->statusAwal = $check_out->lte($rulePunchOut);
        }

        $rulePunchIn = Carbon::parse($check_in->toDateString() . " " . self::MINIMUM);

        if ($check_in->lt($rulePunchIn)) {
            return $this->statusAwal = $rulePunchIn->diffInSeconds($check_out) < $this->total_hour;
        }

        return $this->statusAwal = $check_in->diffInSeconds($check_out) < $this->total_hour;
    }
}
