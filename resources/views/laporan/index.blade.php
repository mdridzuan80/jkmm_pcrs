@extends('layouts.master')

@section('content')
    <section class="content-header">
        <h1>
            <i class="fa fa-book"></i></i> Laporan
        </h1>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-fw fa-list-ul"></i> Senarai Laporan</h3>
                        <div class="box-tools pull-right">
                            <!-- Buttons, labels, and many other things can be placed here! -->
                            <!-- Here is a label for example -->
                            <span id='petunjuk'><i class="fa fa-fw fa-info"></i></span>
                        </div><!-- /.box-tools -->
                    </div>
                    <div class="box-body table-responsive">
                        <table class="table table-bordered table-hover table-striped">
                            <tr>
                                <td width="1">1.</td>
                                <td><a href="/laporan/harian"> Laporan Harian</a></td>
                            </tr>
                            <tr>
                                <td width="1">2.</td>
                                <td><a href="#"> Laporan Bulanan</a></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
@endsection

