<?php

namespace App\Transformers;

use App\Utility;
use App\Kehadiran;
use Carbon\Carbon;
use App\Justifikasi;
use League\Fractal\TransformerAbstract;

class Event extends TransformerAbstract
{
    private $event;

    private $startTag = '<div>';

    private $endTag = '</div>';

    const FLAG_KELULUSAN_ICON = [
        'DEFAULT' => 'images/icons/user--exclamation.png',
        'MOHON' => 'images/icons/user--pencil.png',
        'LULUS' => 'images/icons/user--plus.png',
        'TOLAK' => 'images/icons/user--minus.png',
        'BATAL' => 'images/icons/user--exclamation.png',
    ];

    public function transform($event)
    {
        $this->event = $event;

        return [
            'title' => $this->getTitle(),
            'start' => $event['start'],
            'end' => $event['end'],
            'allDay' => ($event['allDay'] === 'true') ? true : false,
            'color' => $this->colorTS(),
            'textColor' => $event['textColor'],
            'scheme_id' => $event['id'],
            'scheme' => $event['table_name'],
            'kesalahan' => $event['kesalahan'] ?? json_encode([]),
            'tatatertib_flag' => $event['tatatertib_flag'] ?? Kehadiran::FLAG_TATATERTIB_CLEAR,
            'checkIn' => $event['check_in'] ?? null,
            'checkOut' => $event['check_out'] ?? null,
            'table' => $event['table_name'],
            'justifikasi' => $event['justifikasi'] ?? null,
            'cuti' => $event['cuti'] ?? null,
        ];
    }

    private function colorTS()
    {
        if (isset($this->event['tatatertib_flag']) && $this->event['tatatertib_flag'] == Kehadiran::FLAG_TATATERTIB_TUNJUK_SEBAB) {
            return 'Red';
        }

        return $this->event['color'];
    }

    private function getTitle()
    {
        if ($this->event['table_name'] == 'final') {
            $checkin = $this->subTitleCheckin($this->chkJustifikasiStatusIcon($this->event['justifikasi'], Justifikasi::FLAG_MEDAN_KESALAHAN_PAGI));
            $checkout = $this->subTitleCheckout($this->chkJustifikasiStatusIcon($this->event['justifikasi'], Justifikasi::FLAG_MEDAN_KESALAHAN_PETANG));

            return $checkin . $checkout;
        }

        return $this->event['title'];
    }

    private function subTitleCheckin($icon = '')
    {
        if ($this->event['tatatertib_flag'] == Kehadiran::FLAG_TATATERTIB_TUNJUK_SEBAB && !$this->event['cuti']) {
            if ($this->event['check_in']) {
                if (Utility::kesalahanCheckIn($this->event['kesalahan']) == Kehadiran::FLAG_KESALAHAN_LEWAT) {
                    return $this->startTag . '<img src="' . $icon . '"/>IN:' . Carbon::parse($this->event['check_in'])->format('g:i:s A') . $this->endTag;
                } else {
                    return $this->startTag . 'IN:' . Carbon::parse($this->event['check_in'])->format('g:i:s A') . $this->endTag;
                }
            }

            if ($icon) {
                return $this->startTag . '<img src="' . $icon . '"/>IN:-' . $this->endTag;
            }
        } else {
            if ($this->event['check_in']) {
                return $this->startTag . 'IN:' . Carbon::parse($this->event['check_in'])->format('g:i:s A') . $this->endTag;
            }
        }

        return $this->startTag . 'IN:-' . $this->endTag;
    }

    private function subTitleCheckout($icon = '')
    {
        if ($this->event['tatatertib_flag'] == Kehadiran::FLAG_TATATERTIB_TUNJUK_SEBAB && !$this->event['cuti']) {
            if ($this->event['check_out']) {
                if (Utility::kesalahanCheckOut($this->event['kesalahan']) == Kehadiran::FLAG_KESALAHAN_AWAL) {
                    return $this->startTag . '<img src="' . $icon . '"/>OUT:' . Carbon::parse($this->event['check_out'])->format('g:i:s A') . $this->endTag;
                } else {
                    return $this->startTag . 'OUT:' . Carbon::parse($this->event['check_out'])->format('g:i:s A') . $this->endTag;
                }
            }

            if ($icon) {
                return $this->startTag . '<img src="' . $icon . '"/>OUT:-' . $this->endTag;
            }
        } else {
            if ($this->event['check_out']) {
                return $this->startTag . 'OUT:' . Carbon::parse($this->event['check_out'])->format('g:i:s A') . $this->endTag;
            }
        }

        return $this->startTag . 'OUT:-' . $this->endTag;
    }

    private function chkJustifikasiStatusIcon($justifikasi, $medan)
    {
        $justifikasi = collect($justifikasi);

        if ($justifikasi->isNotEmpty()) {
            $justifikasi = $justifikasi->where('medan_kesalahan', $medan)->first();

            if ($justifikasi) {
                return asset(Self::FLAG_KELULUSAN_ICON[$justifikasi['flag_kelulusan']]);
            }
        }

        return asset(Self::FLAG_KELULUSAN_ICON['DEFAULT']);
    }
}
