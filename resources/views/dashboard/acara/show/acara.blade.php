@inject('Utility', 'App\Utility')
@inject('Kehadiran', 'App\Kehadiran')
@inject('Justifikasi', 'App\Justifikasi')

<div class="table-responsive">
    @foreach ($events as $event)
        @if ($event instanceof App\Cuti)
        <div class="callout callout-warning" title="Cuti Umum">
            <h4>CUTI UMUM : {{ $event->title }}</h4>
        </div>
        @endif

        @if ($tarikh->lessThanOrEqualTo(today()) && ($event instanceof App\FinalAttendance || $event instanceof App\Kehadiran || gettype($event) == 'array'))
            <div class="box box-success box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">CHECK-IN/ OUT</h3>                    
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="box-body no-padding">
                    <table class="table table-bordered">
                        <tr>
                            <th>CHECK-IN</th>
                            <th>CHECK-OUT</th>
                        </tr>
                        <tr>
                            <td>{{ (preg_split('/\r\n|\r|\n/', optional($Utility::array2object($event))->title)[0]) ? explode(':', preg_split('/\r\n|\r|\n/', optional($Utility::array2object($event))->title)[0], 2)[1] : explode(':', preg_split('/\r\n|\r|\n/', $Utility::array2object($event)->title)[0], 2)[1] }}</td>
                            <td>{{ (isset(preg_split('/\r\n|\r|\n/', optional($Utility::array2object($event))->title)[1])) ? explode(':', preg_split('/\r\n|\r|\n/', optional($Utility::array2object($event))->title)[1], 2)[1] : explode(':', preg_split('/\r\n|\r|\n/', $Utility::array2object($event)->title)[1], 2)[1] }}</td>
                        </tr>

                        @php
                            $kesalahan = json_decode($event->kesalahan, true);
                            $pagi = $event->justifikasi->where('medan_kesalahan', $Justifikasi::FLAG_MEDAN_KESALAHAN_PAGI)->first();
                            $petang = $event->justifikasi->where('medan_kesalahan', $Justifikasi::FLAG_MEDAN_KESALAHAN_PETANG)->first();
                        @endphp
                        
                        @if ($event->tatatertib_flag == $Kehadiran::FLAG_TATATERTIB_TUNJUK_SEBAB)
                            <tr>
                                <td style="width: 50%;">
                                    @if (!$pagi && $Utility::kesalahanCheckIn($event->kesalahan) != $Kehadiran::FLAG_KESALAHAN_NONE)
                                        <form id="frm-mohon-justifikasi-pagi" class="form-horizontal">
                                            <input type="hidden" name="txt-final-attendance-id" value="{{ $event->id }}">
                                            <input type="hidden" name="txt-tarikh" class="txt-tarikh">
                                            <input type="hidden" name="txt-medan-kesalahan" value="{{ $Justifikasi::FLAG_MEDAN_KESALAHAN_PAGI }}">

                                            @if (!$petang && sizeof($kesalahan) == 2)
                                                <div class="col-sm-12">
                                                    <input type="checkbox" name="chk-sama-petang" id="chk-sama-petang" value="SAMA">
                                                    Justifikasi sama untuk kedua-dua kesalahan
                                                </div>
                                            @endif
                                            <div class="col-sm-12">
                                                <textarea class="form-control" name="txt-justifikasi" id="txt-justifikasi-pagi" cols="30" rows="10"></textarea>
                                            </div>
                                            <div class="col-sm-12">
                                                <button id="btn-justifikasi-pagi" class="btn btn-justifikasi btn-default btn-flat" type="submit"><i class="fa fa-send "></i> Justifikasi {{ $Kehadiran::BUTTON_TEXT[$Utility::kesalahanCheckIn($event->kesalahan)] }} </button>
                                            </div>
                                        </form>
                                    @else
                                        @if ($Utility::kesalahanCheckIn($event->kesalahan) != $Kehadiran::FLAG_KESALAHAN_NONE)
                                            <div>Kesalahan : {{ $Kehadiran::BUTTON_TEXT[$Utility::kesalahanCheckIn($event->kesalahan)] }}</div>
                                            <div class="show-read-more">Alasan : {{ optional($pagi)->keterangan }}  </div>
                                            <div>Status : {{ optional($pagi)->flag_kelulusan }}</div>
                                        @endif
                                    @endif
                                </td>
                                <td style="width: 50%;">
                                    @if (!$petang && $Utility::kesalahanCheckOut($event->kesalahan) != $Kehadiran::FLAG_KESALAHAN_NONE)
                                        <form id="frm-mohon-justifikasi-petang" class="form-horizontal">
                                            <input type="hidden" name="txt-final-attendance-id" value="{{ $event->id }}">
                                            <input type="hidden" name="txt-tarikh" class="txt-tarikh">
                                            <input type="hidden" name="txt-medan-kesalahan" value="{{ $Justifikasi::FLAG_MEDAN_KESALAHAN_PETANG }}">
                                            @if (!$pagi && sizeof($kesalahan) == 2)
                                                <div class="col-sm-12">
                                                    <input type="checkbox" name="chk-sama-pagi" id="chk-sama-pagi" value="SAMA">
                                                    Justifikasi sama untuk kedua-dua kesalahan
                                                </div>
                                            @endif
                                            <div class="col-sm-12">
                                                <textarea class="form-control" name="txt-justifikasi" id="txt-justifikasi-petang" cols="30" rows="10"></textarea>
                                            </div>
                                            <div class="col-sm-12">
                                                <button id="btn-justifikasi-petang" class="btn btn-justifikasi btn-default btn-flat" type="submit"><i class="fa fa-send "></i> Justifikasi {{ $Kehadiran::BUTTON_TEXT[$Utility::kesalahanCheckOut($event->kesalahan)] }} </button>
                                            </div>
                                        </form>
                                    @else
                                        @if ($Utility::kesalahanCheckOut($event->kesalahan) != $Kehadiran::FLAG_KESALAHAN_NONE)
                                            <div>Kesalahan : {{ $Kehadiran::BUTTON_TEXT[$Utility::kesalahanCheckOut($event->kesalahan)] }}</div>
                                            <div class="show-read-more">Alasan : {{ optional($petang)->keterangan }}</div>
                                            <div>Status : {{ optional($petang)->flag_kelulusan }}</div>
                                        @endif
                                    @endif
                                </td>
                            </tr>
                        @endif
                    </table>
                    </div>
                </div>
                <!-- /.box-body -->
            </div>
        @endif

        @if ($event instanceof App\Acara)
            <div class="box box-info box-solid">
                <div class="box-header with-border">
                <h3 class="box-title">Acara : {{ $event->title }}</h3>

                <!-- /.box-tools -->
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="box-body table-responsive no-padding">
                    <table class="table table-hover">
                        <tr>
                            <td>JENIS ACARA</td>
                            <td>{{ $event->jenis_acara }}</td>
                        </tr>
                        <tr>
                            <td>MASA MULA</td>
                            <td>{{ $event->start }}</td>
                        </tr>
                        <tr>
                            <td>MASA TAMAT</td>
                            <td>{{ $event->end }}</td>
                        </tr>
                        <tr>
                            <td>KETERANGAN</td>
                            <td>{{ $event->keterangan }}</td>
                        </tr>
                    </table>
                    </div>
                </div>
                <!-- /.box-body -->
            </div>
        @endif
    @endforeach
</div>