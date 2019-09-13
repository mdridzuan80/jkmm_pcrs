<div class="table-responsive">
    <form id="frm-acara">
        <table class="table table-bordered">
            <tbody>
                <tr>
                    <td class="col-md-3"><b>JENIS</b></td>
                    <td>
                        <div class="form-group" style="margin-bottom: 0;">
                            <table style="width: 100%">
                                <tr>
                                    <td>
                                        <div class="radio" style="margin: 0;">
                                            <label>
                                            <input type="radio" name="jenis_acara" value="{{ \App\Acara::JENIS_ACARA_RASMI}}" required>
                                            Rasmi
                                            </label>
                                            
                                        </div>
                                    </td>
                                    <td>
                                        <div class="radio" style="margin: 0;">
                                            <label>
                                            <input type="radio" name="jenis_acara" value="{{ \App\Acara::JENIS_ACARA_TIDAK_RASMI}}" required>
                                            Tidak Rasmi
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="col-md-3"><b>PERKARA</b></td>
                    <td><input id="txtPerkara" class="form-control" type="text" name="txtPerkara" placeholder="Perkara"  required></td>
                </tr>
                <tr>
                    <td><b>MASA</b></td>
                    <td>
                        <table style="width: 100%">
                            <tr>
                                <td style="padding-right: 5px">
                                    <input id="txtMasaMula" class="form-control" type="text" name="txtMasaMula" placeholder="Masa Mula"  required>
                                </td>
                                <td>
                                    <input id="txtMasaTamat" class="form-control" type="text" name="txtMasaTamat" placeholder="Masa Tamat"  required>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td><b>KETERANGAN</b></td>
                    <td><textarea id="txtKeterangan" class="form-control" rows="3" name="txtKeterangan" placeholder="Perkara..." required></textarea></td>
                </tr>
            </body>
        </table>
        <br>
        <button class="btn btn-success pull-right btn-acara-simpan" type="submit">SIMPAN</button>
        <button id="btn-batal" type="button" class="btn btn-link pull-right" style="color:#dd4b39;" data-dismiss="modal" >BATAL</button>
    </form>
</div>
