<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Abstraction\Eventable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class Acara extends Eventable
{
    protected $table = 'acara';

    public $timestamps = true;

    protected $dates = [
        'tarikh_mula',
        'tarikh_tamat',
    ];

    const JENIS_ACARA_CHECKIN = 'IN';
    const JENIS_ACARA_CHECKOUT = 'OUT';

    const STATUS_PERMOHONAN_MOHON = 'MOHON';
    const STATUS_PERMOHONAN_BATAL = 'BATAL';
    const STATUS_PERMOHONAN_LULUS = 'LULUS';
    const STATUS_PERMOHONAN_TOLAK = 'TOLAK';

    const KATEGORI_JUSTIFIKASI = 'J';
    const KATEGORI_TIMESLIP = 'T';
    const KATEGORI_CATATAN = 'C';

    /* public function __construct()
    {
        $this->setDateFormat(config('pcrs.modelDateFormat'));
    }*/

    public function finalAttendance()
    {
        return $this->belongsTo(FinalAttendance::class);
    }

    public function scopeEvents($query)
    {
        return $query->select(
            DB::raw('kategori'),
            DB::raw('perkara as \'title\''),
            DB::raw('tarikh_mula as \'start\''),
            DB::raw('tarikh_tamat as \'end\''),
            DB::raw('\'false\' as \'allDay\''),
            DB::raw('\'#00c0ef\' as \'color\''),
            DB::raw('\'black\' as \'textColor\''),
            DB::raw('id'),
            DB::raw('keterangan'),
            DB::raw('\'' . Eventable::ACARA . '\' as \'table_name\'')
        );
    }

    public function scopeGetByDateRange($query, $start, $end)
    {
        $acaraMula = clone $query;

        return $query->where('tarikh_tamat', '>=', $start)
            ->where('tarikh_tamat', '<', $end)
            ->union($acaraMula->where('tarikh_mula', '>=', $start)->where('tarikh_mula', '<', $end));
    }

    public function scopeGetEventablesByDate($query, Carbon $tarikh)
    {
        $acaraMula = clone $query;
        $acaraMula2 = clone $query;
        $tarikMulaTamat2 = clone $tarikh;
        $tarikhTamatMula2 = clone $tarikh;


        return $query->events()
            ->where('tarikh_mula', '>=', $tarikh)
            ->where('tarikh_mula', '<', $tarikMulaTamat2->addDay()->subMinute()->toDateTimeString())
            ->union($acaraMula->events()
                ->where('tarikh_tamat', '>', $tarikh)
                ->Where('tarikh_tamat', '<', $tarikhTamatMula2->addDay()))
            ->union($acaraMula2->events()
                ->where('tarikh_mula', '<', $tarikh)
                ->where('tarikh_tamat', '>', $tarikh));
    }

    public static function storeAcara(Anggota $profil, Request $request)
    {
        if (!self::isOverlaped(Auth::user()->id, Carbon::parse($request->input('masaMula')), Carbon::parse($request->input('masaTamat')))) {
            $acara = new Acara;
            $acara->basedept_id = $profil->xtraAttr->basedept_id;
            $acara->kategori = $request->input('jenisAcara');
            $acara->perkara = $request->input('perkara');
            $acara->tarikh_mula = Carbon::parse($request->input('masaMula'));
            $acara->tarikh_tamat = Carbon::parse($request->input('masaTamat'));
            $acara->keterangan = $request->input('keterangan');
            $acara->user_id = Auth::user()->id;
            return $profil->acara()->save($acara);
        }
        return [];
    }

    public function eventableItem()
    {
        return collect([
            'title' => $this->perkara,
            'start' => $this->tarikh_mula->toDateTimeString(),
            'end' => $this->tarikh_tamat->toDateTimeString(),
            'allDay' => false,
            'color' => '#e74c3c',
            'textColor' => '#FFF',
            'id' => $this->id,
            'table_name' => 'acara'
        ]);
    }

    public function descKategori()
    {
        if ($this->kategori === self::KATEGORI_JUSTIFIKASI) {
            return 'justifikasi';
        }
        if ($this->kategori === self::KATEGORI_TIMESLIP) {
            return 'timeslip';
        }
        if ($this->kategori === self::KATEGORI_CATATAN) {
            return 'catatan';
        }
    }

    static public function isOverlaped($user_id, $masa_mula, $masa_tamat)
    {
        return self::where('user_id', $user_id)
            ->where(function ($query) use ($masa_mula, $masa_tamat) {
                $query->where(function ($query) use ($masa_mula, $masa_tamat) {
                    $query->where('tarikh_mula', '<=', $masa_mula)
                        ->where('tarikh_tamat', '>=', $masa_mula);
                })->orWhere(function ($query) use ($masa_mula, $masa_tamat) {
                    $query->where('tarikh_mula', '<=', $masa_tamat)
                        ->where('tarikh_tamat', '>=', $masa_tamat);
                })->orWhere(function ($query) use ($masa_mula, $masa_tamat) {
                    $query->where('tarikh_mula', '>=', $masa_mula)
                        ->where('tarikh_tamat', '<=', $masa_tamat);
                });
            })->count();
    }

    public function isJustified()
    {
        return $this->flag_kelulusan == self::STATUS_PERMOHONAN_MOHON ||
            $this->flag_kelulusan == self::STATUS_PERMOHONAN_TOLAK ||
            $this->flag_kelulusan == self::STATUS_PERMOHONAN_BATAL;
    }

    /* public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value);
    } */
}
