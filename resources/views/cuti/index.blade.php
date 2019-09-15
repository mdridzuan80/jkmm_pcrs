<div class="pull-left" style="padding-bottom:5px;">
    <table>
        <tbody><tr>
            <td>
                TAHUN&nbsp;
            </td>
            <td style="margin:0;padding:0;">
                <select id="comTahun" class="form-control" name="comTahun">
                    @foreach ($years as $item)
                        <option value="{{ $item->year }}" {{ ($item->year == $year ) ? 'selected':'' }}>{{ $item->year }}</option>
                    @endforeach
                </select>
            </td>
        </tr>
    </tbody></table>
</div>
<div class="pull-right" style="padding-bottom:5px;">
    <table>
        <tbody><tr>
            <td style="margin:0;padding:0;">
                &nbsp;<button id="top-btn-cuti-add" class="btn btn-default btn-flat btn-sm"><i class="fa fa-pencil-square-o"></i> Tambah</button>
            </td>
            <td style="margin:0;padding:0;">
                &nbsp;<button id="top-btn-cuti-edit" class="btn btn-default btn-flat btn-sm" disabled=""><i class="fa fa-edit"></i> Kemaskini</button>
            </td>
            <td style="margin:0;padding:0;">
                &nbsp;<button id="top-btn-cuti-delete" class="btn btn-default btn-flat btn-sm" disabled=""><i class="fa fa-trash"></i> Hapus</button>
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
                <th>TARIKH</th>
                <th>KETERANGAN</th>
            </tr>
            @foreach ($cuti as $c)
                <tr class="row-item" data-id="{{ $c->id }}" data-tarikh="{{ $c->tarikh->format('d-m-Y') }}" data-perihal="{{ $c->perihal }}">
                    <td width="1">{{ $c->id }}</td>
                    <td>{{ $c->tarikh->format('d-m-Y') }}</td>
                    <td>{{ $c->perihal }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    @if ($cuti->total())
    <div class="clearfix">
        <span style="display: inline-block; vertical-align: middle; line-height: normal;">Papar {{ ($cuti->currentPage() * $cuti->perpage()) - ($cuti->perpage() - 1) }}  hingga {{ ($cuti->hasMorePages()) ? ($cuti->currentPage() * $cuti->perpage()) : $cuti->total() }}  daripada {{ $cuti->total() }} rekod</span>
        {{ $cuti->links() }}
    </div>
    @endif
</div>
