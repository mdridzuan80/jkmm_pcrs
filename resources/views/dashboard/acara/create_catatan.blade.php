@inject('Acara', 'App\Acara')
<div class="table-responsive">
    <form id="frm-acara">
        <input type="hidden" name="hddJenisAcara" value="{{ $Acara::KATEGORI_CATATAN }}">
        <table class="table table-bordered">
            <tbody>
                <tr>
                    <td class="col-md-3"><b>PERKARA</b></td>
                    <td>

                        <!--<input id="txtPerkara" class="form-control" type="text" name="txtPerkara" placeholder="Perkara"  required autocomplete="off">-->

                        <select id="txtPerkaraC" class="form-control" type="text" name="txtPerkara" required
                            autocomplete="off">
                            <option value="0">Sila pilih...</option>
                            <option {{ old('txtPerkara') === 'Mesyuarat' ? 'selected' : '' }}>Mesyuarat</option>
                            <option {{ old('txtPerkara') === 'Kursus' ? 'selected' : '' }}>Kursus</option>
                            <option {{ old('txtPerkara') === 'Tugasan Luar' ? 'selected' : '' }}>Tugasan Luar</option>
                            <option {{ old('txtPerkara') === 'Bercuti' ? 'selected' : '' }}>Bercuti</option>
                            <option {{ old('txtPerkara') === 'Lain-Lain' ? 'selected' : '' }}>Lain-Lain</option>
                        </select>

                    </td>
                </tr>
                <tr>
                    <td><b>MASA</b></td>
                    <td>
                        <table style="width: 100%">
                            <tr>
                                <td style="padding-right: 5px">
                                    <input id="txtMasaMulaC" class="form-control" type="text" name="txtMasaMula"
                                        placeholder="Masa Mula" required autocomplete="off">
                                </td>
                                <td>
                                    <input id="txtMasaTamatC" class="form-control" type="text" name="txtMasaTamat"
                                        placeholder="Masa Tamat" required autocomplete="off">
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td><b>KETERANGAN</b></td>
                    <td>
                        <textarea id="txtKeteranganC" class="form-control" rows="3" name="txtKeterangan" placeholder="Perkara..." required
                            autocomplete="off"></textarea>
                    </td>
                </tr>
                </body>
        </table>
        <br>
        <button class="btn btn-success pull-right btn-acara-simpan" type="submit">SIMPAN</button>
        <button id="btn-batalC" type="button" class="btn btn-link pull-right" style="color:#dd4b39;"
            data-dismiss="modal">BATAL</button>
    </form>
</div>
