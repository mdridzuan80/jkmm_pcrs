<div class="table-responsive">
        <table class="table table-bordered">
            <tbody>
                <tr>
                    <td class="col-md-3"><b>ID Pengguna</b></td>
                    <td>{{ $profil->user->username }}</td>
                </tr>
                <tr>
                    <td class="col-md-3"><b>Domain</b></td>
                    <td>{{ $profil->user->domain }} </td>
                </tr>
            </tbody>
        </table>

        @can('add-peranan')
        <div style="padding-bottom:5px;">
            <span><b>PADANAN PERANAN PENGGUNA</b></span>
            <form id="frm-add-peranan" class="form-inline">
                <div class="form-group">
                    <select class="form-control input-sm" name="comPeranan" style="padding-right: 5px;">
                        <option value="0" >Peranan</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}" >{{ $role->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group" style="width: 60%;">
                    <div style="position: relative;">
                        <input id="departmentDisplay" class="form-control departmentDisplay input-sm" type="text" value="{{ $profil->xtraAttr->department->deptname }}" style="width: 100%; background-color: #FFF;" readonly>
                        <input id="departmentDisplayId" name="txtDepartmentId" class="form-control departmentDisplayId input-sm" type="hidden" value="{{ $profil->xtraAttr->basedept_id }}" style="background-color: #FFF;" readonly>
                        <div id="treeDisplay" style="display:none;">
                            <div id="departmentsTree" style="position:absolute; background-color: #FFF; overflow:auto; max-height:200px; border:1px #ddd solid"></div>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-success btn-sm">Tambah</button>
            </form>
        </div>
        @endcan

        @can('view-peranan')
        <table class="table table-bordered">
            <thead>
                <tr style="background-image: linear-gradient(to bottom, #fafafa 0, #f4f4f4 100%);">
                    <th style="width: 10px">#</th>
                    <th>PERANAN</th>
                    <th>JABATAN/ UNIT</th>
                    <th style="width:1px;">OPERASI</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($profil->user->roles()->orderBy('priority')->get() as $role)
                <tr>
                    <td>{{ $loop->index + 1 }}</td>
                    <td>{{ $role->name }}</td>
                    <td>{{ $role->pivot->department->deptname }}</td>
                    <td style="width:1px;">
                        @if ($role->key !== \App\Role::PENGGUNA)
                        <a title="Hapus Peranan" class="btn btn-danger btn-xs btn-hapus-peranan" data-role_user="{{ $role->pivot->id }}" href="#" style="margin: auto; display: block;"><i class="fa fa-trash-o"></i></a>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endcan
</div>
