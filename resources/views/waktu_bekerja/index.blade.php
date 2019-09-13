<div class="pull-right" style="padding-bottom:5px;">
    <table>
        <tbody><tr>
            <td style="margin:0;padding:0;">
                &nbsp;<button id="top-btn-wp-add" class="btn btn-default btn-flat btn-sm"><i class="fa fa-pencil-square-o"></i> Tambah</button>
            </td>
            <td style="margin:0;padding:0;">
                &nbsp;<button id="top-btn-wp-edit" class="btn btn-default btn-flat btn-sm" disabled=""><i class="fa fa-edit"></i> Kemaskini</button>
            </td>
            <td style="margin:0;padding:0;">
                &nbsp;<button id="top-btn-wp-delete" class="btn btn-default btn-flat btn-sm" disabled=""><i class="fa fa-trash"></i> Hapus</button>
            </td>
        </tr>
    </tbody></table>
</div>
<div class="clearfix"></div>
<div class="table-responsive">
    <table class="table table-bordered table-hover">
        <tbody>
            <tr style="background-image: linear-gradient(to bottom, #fafafa 0, #f4f4f4 100%);">
                <th width="1"><b>#</b></th>
                <th>KETERANGAN</th>
                <th>WAKTU CHECK-IN</th>
                <th>WAKTU CHECK-OUT</th>
            </tr>
            @foreach ($shifts as $shift)
                <tr class="row-shift" data-shiftid="{{ $shift->id }}">
                    <td width="1">{{ $shift->id }}</td>
                    <td>{{ $shift->name }} </td>
                    <td>{{ $shift->check_in->format('g:i a') }} </td>
                    <td>{{ $shift->check_out->format('g:i a') }} </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    @if ($shifts->total())
    <div class="clearfix">
        <span style="display: inline-block; vertical-align: middle; line-height: normal;">Papar {{ ($shifts->currentPage() * $shifts->perpage()) - ($shifts->perpage() - 1) }}  hingga {{ ($shifts->hasMorePages()) ? ($shifts->currentPage() * $shifts->perpage()) : $shifts->total() }}  daripada {{ $shifts->total() }} rekod</span>
        {{ $shifts->links() }}
    </div>
    @endif
</div>
