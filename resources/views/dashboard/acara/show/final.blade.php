<div class="table-responsive">
    <form id="frm-profil-kemaskini">
        <table class="table table-bordered">
            <tbody>
                <tr>
                    <td class="col-md-3"><b>CHECK-IN</b></td>
                <td><input class="form-control" type="text" name="txtCheckIn" placeholder="Check-In" value="{{ optional($event)->eventCheckIn() }}" required></td>
                </tr>
                <tr>
                    <td class="col-md-3"><b>CHECK-OUT</b></td>
                    <td><input class="form-control" type="text" name="txtCheckOut" placeholder="Check-Out" value="{{ optional($event)->eventCheckOut() }}" required></td>
                </tr>
            </body>
        </table>

        <button class="btn btn-success pull-right btn-kemaskini-simpan" type="submit">SIMPAN</button>
        <button id="btn-batal" type="button" class="btn btn-link pull-right" style="color:#dd4b39;" >BATAL</button>
    </form>
</div>