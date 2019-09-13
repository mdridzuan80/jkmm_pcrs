<div class="table-responsive">
    <form id="frm-xtra-attr">
        <table class="table table-bordered">
            <input id="txtDepartmentId" type="hidden" value="{{ $profil->userid }}">
            <tbody>
                <tr>
                    <td><b>BAHAGIAN/ UNIT</b></td>
                    <td>
                        <div style="position: relative;">
                            <input id="departmentDisplay" class="form-control departmentDisplay" type="text" value="{{ optional(optional($profil->xtraAttr)->baseDepartment)->deptname }}" style="background-color: #FFF;" readonly>
                            <input id="departmentDisplayId" name="txtDepartmentId" class="form-control departmentDisplayId" type="hidden" value="{{ optional($profil->xtraAttr)->basedept_id }}" style="background-color: #FFF;" readonly>
                            <div id="treeDisplay" style="display:none; position: fixed;">
                                <div id="departmentsTree" style="position:absolute; background-color: #FFF; overflow:auto; max-height:200px; border:1px #ddd solid"></div>
                            </div>
                        </div>
                    </td>
                </tr>
            </body>
        </table>

        @can('edit-base-bahagian')
        <button class="btn btn-success pull-right btn-kemaskini-simpan" type="submit">SIMPAN</button>
        <button id="btn-batal" type="button" class="btn btn-link pull-right" style="color:#dd4b39;" data-dismiss="modal" aria-label="Close" >BATAL</button>
        @endcan
    </form>
</div>