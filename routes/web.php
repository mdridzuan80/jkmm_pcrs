<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Auth::routes();

Route::get('/logout', 'Auth\LoginController@logout');
Route::get('/pdfexample', 'LaporanController@pdfexample')->name('pdfexample');
Route::get('/datatable88', 'LaporanController@datatable88')->name('datatable88');

Route::middleware('auth:internal,ldap')->group(function () {
    Route::get('/', 'KalendarController@index');

    Route::get('/dashboard', 'KalendarController@index')->name('dashboard');
    Route::get('/kalendar', 'KalendarController@index')->name('kalendar');

    Route::middleware('can:view-anggota')->group(function () {
        Route::get('/anggota', 'AnggotaController@index')->name('anggota');
    });

    Route::middleware('can:view-pengguna')->group(function () {
        Route::get('/pengguna', 'PenggunaController@index')->name('pengguna');
    });

    Route::middleware('can:view-permohonan_jtc')->group(function () {
        //Route::get('/permohonan_jtc', 'LaporanController@permohonanJTC')->name("permohonan_jtc.permohonan_jtc");
        Route::get('/permohonan_jtc', 'LaporanController@filterPermohonan_jtc')->name("permohonan_jtc.permohonan_jtc");				
	    Route::post('/permohonan_jtc', 'LaporanController@filterPermohonan_jtc')->name('post.permohonan_jtc');
		Route::post('/permohonan_jtc/pdf', 'LaporanController@permohonan_jtc_pdf')->name('pdf.permohonan_jtc');
		
		
		//MANUAL
        Route::get('/manual', 'LaporanController@manual_sistem')->name("manual");
		
    });

    Route::middleware('can:view-kelulusan')->group(function () {
        Route::get('/kelulusan', 'JustifikasiController@index')->name('kelulusan');
	    Route::post('/kelulusan', 'JustifikasiController@filterKelulusan')->name('post.kelulusan');
	    Route::post('/kelulusan/cetak', 'JustifikasiController@jana_acaraAll')->name('cetak.kelulusan');
		
    });

   // Route::middleware('can:view-acara')->group(function () {
       //Acara
		Route::get('/kelulusan/list_acara','AcaraController@acara')->name('kelulusan.list_acara');
		Route::post('/kelulusan/list_acara','AcaraController@filterAcara')->name('post.kelulusan.list_acara');
		
    //});
	
	
		
		
		

    Route::middleware('can:view-laporan')->group(function () {
        Route::get('/laporan', 'LaporanController@index')->name('laporan');
        Route::prefix('laporan')->group(function () {
            Route::get('/harian', 'LaporanController@harian')->name("laporan.harian");
            Route::get('/bulanan', 'LaporanController@bulanan')->name("laporan.bulanan");
            Route::get('/rekodkehadiran', 'LaporanController@laporan_rekodkehadiran')->name("laporan.rekodkehadiran");
			
	    	
			Route::post('/harian', 'LaporanController@laporan_papar_harian')->name('post.laporan.harian');
			Route::post('/harian/pdf', 'LaporanController@laporan_harian_pdf')->name('pdf.laporan.harian');
			
			Route::post('/rekodkehadiran', 'LaporanController@laporan_papar_rekodkehadiran')->name('post.laporan.rekodkehadiran');
			Route::post('/rekodkehadiran/pdf', 'LaporanController@laporan_rekodkehadiran_pdf')->name('pdf.laporan.rekodkehadiran');
			
			Route::post('/bulanan', 'LaporanController@laporan_papar_bulanan')->name('post.laporan.bulanan');
			Route::post('/bulanan/pdf', 'LaporanController@laporan_bulanan_pdf')->name('pdf.laporan.bulanan');
			
            //Route::get('/pdfexample', 'LaporanController@pdfexample')->name('pdfexample');
			
			
		
			
        });
    });

    Route::middleware('can:view-setting')->group(function () {
        Route::get('/konfigurasi', 'KonfigurasiController@index')->name('konfigurasi');
    });

    //Local API
    Route::prefix('rpc')->middleware('ajax')->group(function () {
        Route::get('/switch_role/{role}', 'RoleController@switchRole');

        // Department
        Route::get('/department_tree', 'DepartmentController@departmentTree');

        // Waktu bekerja
        Route::get('/waktu_bekerja', 'WaktuBerperingkatController@rcpGridWaktuBekerja')->middleware('can:view-shift');
        Route::post('/waktu_bekerja', 'WaktuBerperingkatController@rcpTambahWaktuBekerja')->middleware('can:add-shift');
        Route::get('/waktu_bekerja/{shift}', 'WaktuBerperingkatController@rcpWaktuBekerja')->middleware('can:view-shift');
        Route::post('/waktu_bekerja/{shift}', 'WaktuBerperingkatController@rcpUpdateWaktuBekerja')->middleware('can:edit-shift');
        //Route::patch('/waktu_bekerja/{shift}', 'WaktuBerperingkatController@rcpHapusWaktuBekerja')->middleware('can:edit-shift');
        Route::delete('/waktu_bekerja/{shift}', 'WaktuBerperingkatController@rcpHapusWaktuBekerja')->middleware('can:delete-shift');

        // Cuti
        Route::post('/cuti', 'KonfigurasiController@rcpGridCuti')->middleware('can:view-cuti');
        Route::post('/cuti/add', 'KonfigurasiController@rpcCutiStore')->middleware('can:add-cuti');
        Route::delete('/cuti', 'KonfigurasiController@rcpCutiDestroy')->middleware('can:delete-shift');


        // Anggota
        Route::post('/anggota_grid', 'AnggotaController@rpcAnggotaGrid')->middleware('can:view-anggota');
        Route::post('/anggota_penilai_grid', 'AnggotaController@rpcAnggotaPenilaiGrid')->middleware('can:view-anggota');

        Route::prefix('anggota')->group(function () {
            Route::get('/{profil}', 'AnggotaController@rpcShow')->middleware('can:view-profil');
            Route::post('/{profil}', 'AnggotaController@rpcUpdate')->middleware('can:edit-profil');

            // Waktu Berperingkat
            Route::get('/waktu_bekerja/{profil}', 'WaktuBerperingkatController@rpcIndex')->middleware('can:view-waktu_bekerja');
            Route::get('/waktu_bekerja_bulanan/{profil}/{tahun}', 'WaktuBerperingkatController@rpcBulanan')->middleware('can:view-waktu_bekerja');
            Route::post('/waktu_bekerja_bulanan/{profil}', 'WaktuBerperingkatController@rpcBulananCreate')->middleware('can:add-waktu_bekerja');
            Route::delete('/waktu_bekerja_bulanan/{profil}/{id}', 'WaktuBerperingkatController@rpcDelete')->middleware('can:delete-waktu_bekerja');
            Route::get('/waktu_bekerja_harian/{profil}/{tahun}', 'WaktuBerperingkatController@rpcBulanan')->middleware('can:view-waktu_bekerja');
            Route::post('/waktu_bekerja_harian/{profil}', 'WaktuBerperingkatController@rpcHarianCreate')->middleware('can:add-waktu_bekerja');
            Route::delete('/waktu_bekerja_harian/{profil}/{id}', 'WaktuBerperingkatController@rpcDelete')->middleware('can:delete-waktu_bekerja');

            Route::get('/puasa_conf/{profil}', 'AnggotaController@rpcPuasaConf');
            Route::post('/puasa_conf/{profil}', 'AnggotaController@rpcPuasaConfStore');

            Route::get('/mengandung_conf/{profil}', 'AnggotaController@rpcMengandungConf');
            Route::post('/mengandung_conf/{profil}', 'AnggotaController@rpcMengandungConfStore');
            Route::delete('/{profil}/mengandung_conf/{shiftConf}', 'AnggotaController@rpcMengandungConfDelete');

            // Pegawai Penilai
            Route::get('/{profil}/penilai', 'AnggotaController@rpcPenilaiIndex')->middleware('can:view-penilai');
            Route::post('/{profil}/penilai', 'AnggotaController@rpcPenilaiUpdate')->middleware('can:edit-penilai');

            //Base Bahagian
            Route::get('/{profil}/basebahagian', 'AnggotaController@rpcBaseBahagianShow')->middleware('can:view-base-bahagian');
            Route::post('/{profil}/basebahagian', 'AnggotaController@rpcBaseBahagianStore')->middleware('can:edit-base-bahagian');

            //Flow Profil
            Route::get('/{profil}/flow', 'AnggotaController@rpcFlowShow')->middleware('can:view-flow-profil');
            Route::post('/{profil}/flow', 'AnggotaController@rpcFlowUpdate')->middleware('can:edit-flow-profil');
        });

        Route::prefix('pengguna')->group(function () {
            Route::get('/{profil}/login', 'PenggunaController@rpcLoginIndex')->middleware('can:view-login');
            Route::post('/{profil}/login', 'PenggunaController@rpcLoginStore')->middleware('can:add-login');
            Route::post('/ldap', 'PenggunaController@rpcSearchLdap')->middleware('can:view-login');

            Route::post('/{profil}/peranan', 'PenggunaController@rpcPerananStore')->middleware('can:add-peranan');
            Route::delete('/peranan/{roleUser}', 'PenggunaController@rpcPerananDestroy')->middleware('can:delete-peranan');
        });

        Route::prefix('kalendar')->group(function () {
            Route::get('/{profil}', 'KalendarController@rpcEventAnggotaIndex');
            Route::get('/{profil}/acara/create', 'KalendarController@rpcEventAnggotaCreate');
            Route::get('/{profil}/acara/create_timeslip', 'KalendarController@rpcEventAnggotaCreate_timeslip');
            Route::get('/{profil}/acara/create_catatan', 'KalendarController@rpcEventAnggotaCreate_catatan');
            Route::post('/{profil}/acara', 'KalendarController@rpcEventAnggotaStore');
            Route::get('/{profil}/acara/{tarikh}', 'KalendarController@rpcEventAnggotaShow2');
            //Route::get('/{profil}/acara2/{tarikh}', 'KalendarController@checkAcaraPagiPetang');
            Route::get('/{profil}/checkinout', 'KalendarController@rpcCheckInOut');
            Route::post('/{profil}/checkingin', 'KalendarController@rpcCheckingIn');
            Route::post('/{profil}/checkingout', 'KalendarController@rpcCheckingOut');
        });

        Route::prefix('laporan')->group(function () {
            //Route::post('/harian', 'LaporanController@rpcHarian')->middleware('can:view-laporan');
            //Route::post('/bulanan', 'LaporanController@rpcBulanan')->middleware('can:view-laporan');
            //Route::post('/rekodkehadiran', 'LaporanController@rpcRekodkehadiran')->middleware('can:view-laporan');
        });
		
		Route::put('/permohonan_jtc/{permohonan_jtc}', 'LaporanController@rpcUpdate');

        Route::prefix('konfigurasi')->group(function () {
            Route::get('/flow_bahagian/{department}', 'KonfigurasiController@rpcFlowBahagianShow')->middleware('can:edit-flow-bahagian-setting');
            Route::post('/flow_bahagian/{department}', 'KonfigurasiController@rpcFlowBahagianUpdate')->middleware('can:edit-flow-bahagian-setting');
        });

        Route::get('/bdr', 'BdrController@index')->name('bdr.index');
        Route::post('/bdr', 'BdrController@store')->name('bdr.store');
        Route::delete('/bdr/{bdr}', 'BdrController@destroy')->name('bdr.destroy');

        Route::get('/puasa', 'PuasaController@index')->middleware('can:view-puasa');
        Route::post('/puasa', 'PuasaController@store')->middleware('can:add-puasa');
        Route::delete('/puasa/{puasa}', 'PuasaController@destroy')->middleware('can:delete-puasa');

        // Justifikasi
        Route::post('/justifikasi/{profil}', 'JustifikasiController@rpcStore');
        Route::put('/justifikasi/{justifikasi}', 'JustifikasiController@rpcUpdate');
		
		
        	

        //Warna Kad Semasa
        Route::get('/warnakad/{profil}/{bulan}/{tahun}', 'WarnaKadAnggotaController@show');
		
		
		
    });
});
