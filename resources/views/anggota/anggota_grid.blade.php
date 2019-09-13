<table class="table table-bordered table-hover">
    <thead>
        <tr style="background-image: linear-gradient(to bottom, #fafafa 0, #f4f4f4 100%);">
            <th style="width:1px;">#</th>
            <th>&nbsp;</th>
            <th>NO. BADGE</th>
            <th>NAMA</th>
            <th>NO. KP</th>
            <th>JAWATAN</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($senAnggota as $anggota)
            <tr class="row-user" data-userid="{{ $anggota->userid }}" data-nama="{{ $anggota->nama }}" data-deptid="{{ $anggota->dept_id }}">
                <td>{{ ($senAnggota->currentpage()-1) * $senAnggota->perpage() + $loop->index + 1 }}</td>
                <td>{!! ($anggota->user) ? '<i title="Login" class="fa"><img src="'.asset('images/icons/icon_key.gif').'"></i>' : '' !!}</td>
                <td>{{ $anggota->badgenumber }}</td>
                <td><a id="detail-info" href="#">{{ $anggota->nama }}</a></td>
                <td>{{ $anggota->nokp }}</td>
                <td>{{ $anggota->jawatan }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="6">Rekod tidak wujud!</td>
            </tr>
        @endforelse
    </tbody>
</table>

@if ($senAnggota->total())
    <div class="clearfix">
        <span style="display: inline-block; vertical-align: middle; line-height: normal;">Papar {{ ($senAnggota->currentPage() * $senAnggota->perpage()) - ($senAnggota->perpage() - 1) }}  hingga {{ ($senAnggota->hasMorePages()) ? ($senAnggota->currentPage() * $senAnggota->perpage()) : $senAnggota->total() }}  daripada {{ $senAnggota->total() }} rekod</span>
        {{ $senAnggota->links() }}
    </div>
@endif
