<div class="row">
    <div class="col-md-4">
        <div class="box box-widget widget-user-2">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-yellow">
                <div class="widget-user-image">
                    <img class="img-circle" src="{{ asset('dist/img/info.png') }}" alt="User Avatar">
                </div>
                <!-- /.widget-user-image -->
                <h3 class="widget-user-username">INFO</h3>
                <h5 class="widget-user-desc">Waktu Berperingkat</h5>
            </div>
            <div class="box-footer no-padding" style="max-height:500px; overflow:auto;">
                <ul class="nav nav-stacked">
                @foreach($shifts as $shift)
                <li><a href="#"><b>{{ $shift->name }}</b> <span class="pull-right badge bg-blue">{{ $shift->check_in->format('g:i A') }} - {{ $shift->check_out->format('g:i A') }}</span></a></li>
                @endforeach
                </ul>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div id="tab-wp" class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true"><i class="fa fa-calendar"></i> WBB: Bulanan</a></li>
                <li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="false"><i class="fa fa-clock-o"></i> WBB: Bulan Puasa/ Mengandung</a></li>            
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab_1">
                    <div class="row">
                        <div class="col-md-4">
                            <form id="frmWbbBulanan" method="post" role="form">
                                <div class="form-group">
                                    <label for="comTahun">TAHUN</label>
                                    <select id="comTahun" class="form-control" name="comTahun" required>
                                        <option value="<?= date('Y') ?>"><?= date('Y') ?></option>
                                        <option value="<?= date('Y')+1 ?>"><?= date('Y')+1 ?></option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <?php //lib('config')->load('pcrs', true) ?>
                                    <label for="comBulan">BULAN</label>
                                    <select multiple="" class="form-control" name="comBulan[]" size="12" required>
                                        @foreach(pcrsBulan() as $key => $bulan)
                                        <option value="{{ $key }}" {{ (date('m') == $key ) ? 'selected' : '' }}>{{ strtoupper($bulan) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="comWbb">WBB</label>
                                    <select class="form-control" name="comWbb" required>
                                        @foreach($shifts as $shift)
                                        <option value="{{ $shift->id }}">{{ $shift->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-success btn-block" title="Simpan maklumat Waktu berperingkat">SIMPAN</button>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-8">
                            <div id="jadualWbbBulanan" class="table-responsive">
                                <h4>
                                    <i class="fa fa-refresh fa-spin"></i> Janaan jadual...
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.tab-pane -->
                <div class="tab-pane" id="tab_2">
                    <div class="row">
                        <div class="col-md-4">
                            <form id="frmWbbHarian" method="post" role="form">
                                <div class="form-group">
                                    <label for="comTahun">TAHUN</label>
                                    <select id="comTahun" class="form-control" name="comTahun" required>
                                        <option value="<?= date('Y') ?>"><?= date('Y') ?></option>
                                        <option value="<?= date('Y')+1 ?>"><?= date('Y')+1 ?></option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="comBulan">TARIKH MULA</label>
                                    <input type="text" class="form-control" name="txtTarikhMula" id="txtTarikhMula" autocomplete="off" required>
                                </div>
                                <div class="form-group">
                                    <label for="comBulan">TARIKH TAMAT</label>
                                    <input type="text" class="form-control" name="txtTarikhTamat" id="txtTarikhTamat" autocomplete="off" required>
                                </div>
                                <div class="form-group">
                                    <label for="comWbb">WBB</label>
                                    <select class="form-control" name="comWbb" required>
                                        @foreach($shifts as $shift)
                                        <option value="{{ $shift->id }}">{{ $shift->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-success btn-block" title="Simpan maklumat Waktu berperingkat">SIMPAN</button>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-8">
                            <div id="jadualWbbHarian" class="table-responsive">
                                <h4>
                                    <i class="fa fa-refresh fa-spin"></i> Janaan jadual...
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.tab-content -->
        </div>
    </div>
</div>
