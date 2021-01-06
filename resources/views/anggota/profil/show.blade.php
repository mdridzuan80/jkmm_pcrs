<div class="table-responsive">
    <form id="frm-profil-kemaskini">
        <table class="table table-bordered">
            <input id="txtAnggotaId" type="hidden" name="txtAnggotaId" value="{{ $profil->userid }}">
            <tbody>
                <tr>
                    <td class="col-md-3"><b>NAMA</b></td>
                    <td><input class="form-control" type="text" name="txtNama" placeholder="Nama" value="{{ optional($profil->xtraAttr)->nama }}" required></td>
                </tr>
                <tr>
                    <td><b>NO. KP</b></td>
                    <td><input class="form-control" type="text" name="txtNoKP" placeholder="No. Kad Pengenalan" value="{{ optional($profil->xtraAttr)->nokp }}" required></td>
                </tr>
                <tr>
                    <td><b>JAWATAN</b></td>
                    <td><input class="form-control" type="text" name="txtJawatan" placeholder="Jawatan" value="{{ optional($profil->xtraAttr)->jawatan }}" required></td>
                </tr>
                <tr>
                    <td><b>BAHAGIAN/ UNIT</b></td>
                    <td>
                        <div style="position: relative;">
                            <input id="departmentDisplay" class="form-control departmentDisplay" type="text" value="{{ optional($profil->xtraAttr->department)->deptname }}" style="background-color: #FFF;" readonly>
                            <input id="departmentDisplayId" name="txtDepartmentId" class="form-control departmentDisplayId" type="hidden" value="{{ optional($profil->xtraAttr)->dept_id }}" style="background-color: #FFF;" readonly>
                            <div id="treeDisplay" style="display:none;">
                                <div id="departmentsTree" style="position:absolute; background-color: #FFF; overflow:auto; max-height:200px; border:1px #ddd solid"></div>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td><b>E-MAIL</b></td>
                    <td><input class="form-control" type="text" name="txtEmail" placeholder="Alamat Emel" value="{{ optional($profil->xtraAttr)->email }}" required></td>
                </tr>
                <tr>
                    <td><b>TELEFON BIMBIT</b></td>
                    <td><input class="form-control" type="text" name="txtTelefon" placeholder="No Telefon Bimbit" value="{{ optional($profil->xtraAttr)->nohp }}" required></td>
                </tr>
            </body>
        </table>

        @can('edit-profil')
        <button class="btn btn-success pull-right btn-kemaskini-simpan" type="submit">SIMPAN</button>
        <button id="btn-batal" type="button" class="btn btn-link pull-right" style="color:#dd4b39;" >BATAL</button>
        @endcan
    </form>
</div>