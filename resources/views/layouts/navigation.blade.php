  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MENU UTAMA</li>
        <li class="{{ pcrsMenuActiveCondition('dashboardcontroller_index', $collection->get('activeMenu')) }}">
          <a href="{{ route('dashboard') }}">
            <i class="fa fa-dashboard"></i></i> <span>Dashboard</span>
          </a>
        </li>
        @can('view-kelulusan')
        <li class="{{ pcrsMenuActiveCondition('kelulusancontroller_index', $collection->get('activeMenu')) }}">
          <a href="{{ route('kelulusan') }}">
            <i class="fa fa-commenting"></i></i> <span>Kelulusan Permohonan</span>
          </a>
        </li>
        @endcan
        <!--
        @can('view-acara')
        <li class="{{ pcrsMenuActiveCondition('acaracontroller_index', $collection->get('activeMenu')) }}">
          <a href="{{ route('kelulusan.list_acara') }}">
            <i class="fa fa-list"></i></i> <span>Senarai Acara</span>
          </a>
        </li>
        @endcan
        -->
        @can('view-permohonan_jtc')
        <li class="{{ pcrsMenuActiveCondition('permohonan_jtccontroller_index', $collection->get('activeMenu')) }}">
          <a href="{{ route('permohonan_jtc.permohonan_jtc') }}">
            <i class="fa fa-list"></i></i> <span>Senarai Permohonan</span>
          </a>
        </li>
        @endcan
        @can('view-anggota')
        <li class="{{ pcrsMenuActiveCondition('anggotacontroller_index', $collection->get('activeMenu')) }}">
          <a href="{{ route('anggota') }}">
            <i class="fa fa-user"></i></i> <span>Maklumat Pegawai</span>
          </a>
        </li>
        @endcan
        @can('view-laporan')
        <li class="{{ pcrsMenuActiveCondition('laporancontroller_index', $collection->get('activeMenu')) }}">
          <a href="{{ route('laporan') }}">
            <i class="fa fa-book"></i></i> <span>Laporan</span>
          </a>
        </li>
        @endcan
        @can('view-setting')
        <li class="{{ pcrsMenuActiveCondition('konfigurasicontroller_index', $collection->get('activeMenu')) }}">
          <a href="{{ route('konfigurasi') }}">
            <i class="fa fa-gear"></i> <span>Konfigurasi</span>
          </a>
        </li>
        @endcan
      </ul>
      
      <br />
      
      <div class="row">
          <div class="col-md-12" align="center">
          
          	<a class="btn btn-primary" href="{{ route('manual') }}">MANUAL SISTEM</a>
          
          </div>
      </div>
      
      
    </section>
    <!-- /.sidebar -->
  </aside>
