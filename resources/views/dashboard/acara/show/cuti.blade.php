<div class="table-responsive">
    <form id="frm-profil-kemaskini">
        <table class="table table-bordered">
            <tbody>
                <tr>
                    <td class="col-md-3"><b>PERKARA</b></td>
                    <td>{{ $event->title }}</td>
                </tr>
                <tr>
                    <td class="col-md-3"><b>TARIKH MULA</b></td>
                    <td>{{ \Carbon\Carbon::parse($event->start)->format('d-m-Y') }}</td>
                </tr>
                <tr>
                    <td class="col-md-3"><b>TARIKH TAMAT</b></td>
                    <td>{{ \Carbon\Carbon::parse($event->end)->format('d-m-Y') }}</td>
                </tr>
            </body>
        </table>

        <button id="btn-batal" type="button" class="btn btn-link pull-right" style="color:#dd4b39;">TUTUP</button>
    </form>
</div>