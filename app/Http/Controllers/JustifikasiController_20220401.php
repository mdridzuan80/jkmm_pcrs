<?php

namespace App\Http\Controllers;

use App\Services\html2pdf;
//use App\Services\pcrs_func_helper;

use Auth;
use App\Flow;
use App\Acara;
use App\Anggota;
use App\Base\BaseController;
use Illuminate\Http\Request;
use App\Repositories\Justifikasi;
use App\Jobs\JustifikasiSendingEmailJob;
use App\Http\Requests\JustifikasiRequest;


//if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class JustifikasiController extends BaseController
{
    public function index()
    {
        
		
		$permohonan = Auth::user()->xtraAnggota->kelulusanJustifikasi()->get();
		
		//$permohonan = Acara::KelulusanPermohonanAcara($kategori_acara);

        return $this->renderView('kelulusan.index', compact('permohonan'));
    }



/*
		if (!self::isOverlaped(Auth::user()->id, Carbon::parse($request->input('masaMula')), Carbon::parse($request->input('masaTamat')), date("Y-m-d", strtotime(Carbon::parse($request->input('masaMula')))), date("Y-m-d", strtotime(Carbon::parse($request->input('masaTamat')))), date("H", strtotime(Carbon::parse($request->input('masaMula')))).date("i", strtotime(Carbon::parse($request->input('masaMula')))).date("s", strtotime(Carbon::parse($request->input('masaMula')))), date("H", strtotime(Carbon::parse($request->input('masaTamat')))).date("i", strtotime(Carbon::parse($request->input('masaTamat')))).date("s", strtotime(Carbon::parse($request->input('masaTamat')))))) {
            $acara = new Acara;
            $acara->basedept_id = $profil->xtraAttr->basedept_id;
            $acara->kategori = $request->input('jenisAcara');
            $acara->perkara = $request->input('perkara');
            $acara->tarikh_mula = Carbon::parse($request->input('masaMula'));
            $acara->tarikh_tamat = Carbon::parse($request->input('masaTamat'));
            $acara->tarikh_mula_date = date("Y-m-d", strtotime(Carbon::parse($request->input('masaMula'))));
            $acara->tarikh_tamat_date = date("Y-m-d", strtotime(Carbon::parse($request->input('masaTamat'))));
            $acara->tarikh_mula_time = date("H", strtotime(Carbon::parse($request->input('masaMula')))).date("i", strtotime(Carbon::parse($request->input('masaMula')))).date("s", strtotime(Carbon::parse($request->input('masaMula'))));
            $acara->tarikh_tamat_time = date("H", strtotime(Carbon::parse($request->input('masaTamat')))).date("i", strtotime(Carbon::parse($request->input('masaTamat')))).date("s", strtotime(Carbon::parse($request->input('masaTamat'))));
            $acara->keterangan = $request->input('keterangan');
            //$acara->pelulus_id = $profil->pegawaiPenilai->pegawai_id;
			$acara->pelulus_id = Flow::pelulus($profil)->xtraAttr->anggota_id;
            $acara->user_id = Auth::user()->id;
            return $profil->acara()->save($acara);
        }
*/

    public function rpcStore(JustifikasiRequest $request, Anggota $profil)
    {
        if (Flow::pelulus($profil)) {
            $tarikh = substr($request->input('tarikh'), 0, 10);
            $dataJustifikasiPagi = [
                'finalattendance_id' => $request->input('finalAttendance'),
                'basedept_id' => $profil->xtraAttr->basedept_id,
                //'tarikh_mula' =>  $tarikh . " 07:30",
                'tarikh_mula' =>  $tarikh . " 00:00:01",
                //'tarikh_tamat' =>  $tarikh . " 09:00",
                'tarikh_tamat' =>  $tarikh . " 00:00:01",			
                'tarikh_mula_date' =>  $tarikh,			
                'tarikh_tamat_date' =>  $tarikh,				
                'tarikh_mula_time' =>  "000001",			
                'tarikh_tamat_time' =>  "000001",
                'flag_justifikasi' => $request->input('sama'),
                'alasan' => $request->input('alasan'),
                'pelulus_id' => Flow::pelulus($profil)->xtraAttr->anggota_id,
                'kategori' => Acara::KATEGORI_JUSTIFIKASI
            ];

            $dataJustifikasiPetang = [
                'finalattendance_id' => $request->input('finalAttendance'),
                'basedept_id' => $profil->xtraAttr->basedept_id,
                //'tarikh_mula' =>  $tarikh . " 13:00",
                'tarikh_mula' =>  $tarikh . " 00:00:02",
                //'tarikh_tamat' =>  $tarikh . " 18:00",
                'tarikh_tamat' =>  $tarikh . " 00:00:02",				
                'tarikh_mula_date' =>  $tarikh,			
                'tarikh_tamat_date' =>  $tarikh,					
                'tarikh_mula_time' =>  "000002",			
                'tarikh_tamat_time' =>  "000002",
                'flag_justifikasi' => $request->input('sama'),
                'alasan' => $request->input('alasan'),
                'pelulus_id' => Flow::pelulus($profil)->xtraAttr->anggota_id,
                'kategori' => Acara::KATEGORI_JUSTIFIKASI
            ];
			
			
			
			

            if ($request->input('sama') == Justifikasi::FLAG_JUSTIKASI_SAMA) {
                $justifikasiPagi = new Justifikasi;
                $dataJustifikasiPagi['medan_kesalahan'] = Justifikasi::FLAG_MEDAN_KESALAHAN_PAGI;
                //$justifikasiPagi->simpan($dataJustifikasiPagi);

                $justifikasiPetang = new Justifikasi;
                $dataJustifikasiPetang['medan_kesalahan'] = Justifikasi::FLAG_MEDAN_KESALAHAN_PETANG;
                //$justifikasiPetang->simpan($justifikasi);

                if ($justifikasiPagi->simpan($dataJustifikasiPagi) && $justifikasiPetang->simpan($dataJustifikasiPetang)) {
                    dispatch(new JustifikasiSendingEmailJob(
                        $profil,
                        $request->input('finalAttendance'),
                        $request->input('medanKesalahan')
                    ));

                    return response('Ok', 200);
                }

                return response('Data conflict', 409);
            }

            $justifikasiA = new Justifikasi;

            if ($request->input('medanKesalahan') == Justifikasi::FLAG_MEDAN_KESALAHAN_PAGI) {
                $justifikasi = $dataJustifikasiPagi;
                $justifikasi['medan_kesalahan'] = $request->input('medanKesalahan');
            }
            if ($request->input('medanKesalahan') == Justifikasi::FLAG_MEDAN_KESALAHAN_PETANG) {
                $justifikasi = $dataJustifikasiPetang;
                $justifikasi['medan_kesalahan'] = $request->input('medanKesalahan');
            }

            if ($justifikasiA->simpan($justifikasi)) {
                dispatch(new JustifikasiSendingEmailJob(
                    $profil,
                    $request->input('finalAttendance'),
                    $request->input('medanKesalahan')
                ));

                return response('Ok', 200);
            }

            return response('Data conflict', 409);
        }

        return response('Sila semak konfigurasi flow anggota atau ketua jabatan', 422);
    }

    public function rpcUpdate($justifikasi, Request $request)
    {
        $justifikasi = Acara::find($justifikasi);
        $justifikasi->flag_kelulusan = $request->input('status');
        $justifikasi->save();
    }
	
	
	public function filterKelulusan(Request $request)
    {
        $kategori_acara = $request->input('kategori_acara');
		$request->session()->put('session_ka', $kategori_acara);
		
		
		$permohonan = Auth::user()->xtraAnggota->kelulusanJustifikasi($kategori_acara)->get();
		

        return $this->renderView('kelulusan.index', compact('permohonan'));
    }
	
	
	
//TAMBAH (S) ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	

    /*
	public function kehadiranAll()
    {
        $this->load->model('mdepartment', 'department');
        $data['departments'] = pcrs_rst_to_option($this->department->getUnits(1), array
            ('DEPTID', 'DEPTNAME'), true);

        $tpl['js_plugin'] = array('timepicker');
        $tpl['js_plugin_xtra'] = array($this->load->view('laporan/v_js_plugin_xtra', '', true));
        $tpl['main_content'] = $this->load->view('laporan/v_laporan_kehadiran', $data, true);
        $this->load->view('tpl/v_main', $tpl);
    }
	*/

    public function jana_acaraAll($cetak=false)
    {
        // post data
        //$deptid = $this->input->post('deptid', true);
        //$staffid = $this->input->post('staffid', true);
        //$mula = $this->input->post('mula', true);
        //$akhir = $this->input->post('akhir', true);

        //$this->load->model('mlaporan', 'laporan');
        //$this->load->model('mcuti', 'cuti');


		if($cetak)
		{
			$data['test'] = 'test';
			
			$html = $this->renderView('kelulusan/acara_cetak', $data, true);
			$pdf_param = array('orientation' => 'P');
        		//pcrs_render_pdf_download($pdf_param, $html);
				
				
				
		}
		else
		{
			$data['test'] = 'test';
			
			$html = $this->renderView('kelulusan/acara_cetak', $data, true);
			$pdf_param = array('orientation' => 'P');
        	pcrs_render_pdf_download($pdf_param, $html);		
			
			
			
			
				
		}
    }
	
	
	function pcrs_render_pdf_download($pdf_param, $pdf_html, $pdf_nama_fail = "laporan.pdf")
{
	$CI =& get_instance();

	$CI->load->library('myhtml2pdf', $pdf_param);


	ob_start();

	try
	{
		// display the full page
		// $this->myhtml2pdf->pdf->SetDisplayMode('fullpage');

		// convert
		 $CI->myhtml2pdf->writeHTML($pdf_html, isset($_GET['vuehtml']));

		// send the PDF
		 $CI->myhtml2pdf->Output($pdf_nama_fail, 'D');
	}
	catch(HTML2PDF_exception $e) {
		echo $e;
		exit;
	}
}
	
//TAMBAH (E) ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++		
		
	
	
}
