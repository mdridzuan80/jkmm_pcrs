<div class="alert alert-warning alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <h4><i class="icon fa fa-warning"></i> Alert!</h4>
    Maklumat login untuk pengguna tidak wujud.
</div>
<div class="table-responsive">
    <form id="frm-create-login">
        <table class="table table-bordered">
            <tbody>
                <tr>
                    <td class="col-md-3"><b>Domain</b>
                        <input type="hidden" name="txtName" value="{{ $profil->Name }}">
                    </td>
                    <td>
                        <div class="form-group">
                            <div class="radio">
                                <label>
                                <input class="rdoDomain" type="radio" name="opt-domain" id="internal" value="internal">
                                internal
                                </label>
                            </div>
                            <div class="radio">
                                <label>
                                <input class="rdoDomain" type="radio" name="opt-domain" id="ldap" value="ldap">
                                ldap
                                </label>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr class="internal">
                    <td><b>Email</b></td>
                    <td><input id="txtEmail" class="form-control input-sm" type="email" name="txtEmail" placeholder="Alamat E-mel" ></td>
                </tr>
                <tr class="internal">
                    <td><b>Katalaluan</b></td>
                    <td><input id="txtKatalaluan" class="form-control input-sm" type="password" name="txtKatalaluan" placeholder="Kataluan" ></td>
                </tr>
                <tr class="internal">
                    <td><b>Re-Katalaluan</b></td>
                    <td><input id="txtReKatalaluan" class="form-control input-sm" type="password" name="txtReKatalaluan" placeholder="Re-Kataluan" ></td>
                </tr>
                <tr class="external">
                    <td><b>Carian Pengguna</b></td>
                    <td>
                        <div class="input-group input-group-sm">
                            <input id="txt-external-pam" type="text" class="form-control input-flat">
                                <span class="input-group-btn">
                                <button id="btn-external-pam" type="button" class="btn btn-info btn-flat">Cari!</button>
                                </span>
                        </div>
                    </td>
                </tr>
                <tr class="external">
                    <td colspan="2">
                        <table id="tbl-user-ldap" class="table table-bordered table-fixed">
                            <thead>
                                <tr style="background-color: #f5f5f5;">
                                    <th class="col-xs-1" style="background-color: #f5f5f5;">&nbsp;</th>
                                    <th class="col-xs-2" style="background-color: #f5f5f5;">ID Pengguna</th>
                                    <th class="col-xs-5" style="background-color: #f5f5f5;">Nama</th>
                                    <th class="col-xs-4" style="background-color: #f5f5f5;">Email</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="col-xs-1">#</td>
                                    <td class="col-xs-2">ID Pengguna</td>
                                    <td class="col-xs-5">Nama</td>
                                    <td class="col-xs-4">Email</td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </body>
        </table>

        @can('add-login')
        <button class="btn btn-success pull-right btn-kemaskini-simpan" type="submit">SIMPAN</button>
        <button type="button" class="btn btn-link pull-right" style="color:#dd4b39;" data-dismiss="modal" aria-label="Close" >BATAL</button>
        @endcan
    </form>
</div>