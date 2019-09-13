@inject('PegawaiPenilai', 'App\PegawaiPenilai')

<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-body">
                <table class="table table-bordered">
                    <thead>
                        <tr style="background-color: #f5f5f5;">
                            <th class="col-md-6"><i class="fa fa-fw fa-user"></i> PEGAWAI PENILAI PERTAMA</th>
                            <th class="col-md-5">JAWATAN</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="col-md-6">{{ ($penilai->isNotEmpty()) ? (($penilai->hasPegawaiPenilaiPertama()) ? optional(optional($penilai[$PegawaiPenilai::FLAG_PEGAWAI_PERTAMA][0])->xtraAttr)->nama : 'Tiada') : 'Tiada' }}</td>
                            <td class="col-md-5">{{ ($penilai->isNotEmpty()) ? (($penilai->hasPegawaiPenilaiPertama()) ? optional(optional($penilai[$PegawaiPenilai::FLAG_PEGAWAI_PERTAMA][0])->xtraAttr)->jawatan : 'Tiada') : 'Tiada' }}</td>
                            <td>
                            <button id="btn-ppp1-edit" type="button" class="btn btn-primary btn-block btn-sm pull-right btn-ppp-edit" title="Kemaskini maklumat pegawai penilai pertama" data-pegawai_flag="{{ $PegawaiPenilai::FLAG_PEGAWAI_PERTAMA }}" data-pegawai_id="{{ ($penilai->isNotEmpty()) ? (($penilai->hasPegawaiPenilaiPertama()) ? optional($penilai[$PegawaiPenilai::FLAG_PEGAWAI_PERTAMA][0])->userid : '') : '' }}">{{ ($penilai->isNotEmpty() && $penilai->hasPegawaiPenilaiPertama()) ? 'KEMASKINI' : 'TAMBAH'}}</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <br>
                <table class="table table-bordered">
                    <thead>
                        <tr style="background-color: #f5f5f5;">
                            <th class="col-md-6"><i class="fa fa-fw fa-user"></i> PEGAWAI PENILAI KEDUA</th>
                            <th class="col-md-5">JAWATAN</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="col-md-6">{{ ($penilai->isNotEmpty()) ? (($penilai->hasPegawaiPenilaiKedua()) ? optional(optional($penilai[$PegawaiPenilai::FLAG_PEGAWAI_KEDUA][0])->xtraAttr)->nama : 'Tiada') : 'Tiada' }}</td>
                            <td class="col-md-5">{{ ($penilai->isNotEmpty()) ? (($penilai->hasPegawaiPenilaiKedua()) ? optional(optional($penilai[$PegawaiPenilai::FLAG_PEGAWAI_KEDUA][0])->xtraAttr)->jawatan : 'Tiada') : 'Tiada' }}</td>
                            <td>
                                <button id="btn-ppp2-edit" type="button" class="btn btn-primary btn-block btn-sm pull-right btn-ppp-edit" title="Kemaskini maklumat pegawai penilai kedua" data-pegawai_flag="{{ $PegawaiPenilai::FLAG_PEGAWAI_KEDUA }}" data-pegawai_id="{{ ($penilai->isNotEmpty()) ? (($penilai->hasPegawaiPenilaiKedua()) ? optional($penilai[$PegawaiPenilai::FLAG_PEGAWAI_KEDUA][0])->userid : '') : '' }}">{{ ($penilai->isNotEmpty() && $penilai->hasPegawaiPenilaiKedua()) ? 'KEMASKINI' : 'TAMBAH' }}</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
