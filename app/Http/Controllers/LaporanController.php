<?php

namespace App\Http\Controllers;

use App\Anggota;
use App\Cuti;
use App\Shift;
use App\XtraAnggota;
use App\FinalAttendance;
use Carbon\Carbon;
use App\Department;
use League\Fractal\Manager;
use App\Transformers\Event;
use Illuminate\Support\Arr;
use App\Base\BaseController;
use League\Fractal\Resource\Collection;
use App\Repositories\LaporanRepository;
use App\Http\Requests\LaporanHarianRequest;
use App\Http\Requests\LaporanBulananRequest;
use App\Http\Requests\LaporanRekodkehadiranRequest;
use App\Http\Requests\LaporanPermohonan_jtcRequest;
use App\Transformers\LaporanHarianTransformer;
use App\Transformers\LaporanRekodkehadiranTransformer;
use App\Transformers\LaporanPermohonan_jtcTransformer;

use App\Services\html2pdf;



use Auth;
use Flow;
use App\Acara;
use App\Checkinout;
use Illuminate\Http\Request;
use App\Repositories\Justifikasi;
use App\Jobs\JustifikasiSendingEmailJob;
use App\Http\Requests\JustifikasiRequest;

class LaporanController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        return $this->renderView('laporan.index');
		
    }


    public function harian()
    {
        return $this->renderView('laporan.harian');
    }

    public function rpcHarian(LaporanHarianRequest $request, Manager $fractal, LaporanHarianTransformer $LaporanHariantransformer)
    {
        $bahagian = Department::find($request->input('txtDepartmentId'));
        $rekod = (new LaporanRepository)->laporanHarian($request->input('txtDepartmentId'), $request->input('txtTarikh'));

        $resource = new Collection($rekod, $LaporanHariantransformer);
        $transform = $fractal->createData($resource);

        return response()->json(Arr::add($transform->toArray(), 'bahagian', $bahagian->deptname));
    }

    public function bulanan()
    {
        return $this->renderView('laporan.bulanan');
    }

    public function rpcBulanan(LaporanBulananRequest $request, Manager $fractal, Event $event)
    {
        $records = [];
        $mula = Carbon::parse($request->input('txtTarikh'));
        $bulanSebelum = (clone $mula)->subMonth();
        $tamat = (clone $mula)->addMonth();
        $officers = Anggota::whereIn('userid', $request->input('comPegawai'))->get();

        foreach ($officers as $officer) {

            $events = (new LaporanRepository)->laporanBulanan($officer, $mula, $tamat);
            $resource = new Collection($events, $event);
            $transform = $fractal->createData($resource);

            array_push($records, [
                'userid' => $officer->userid,
                'name' => $officer->xtraAttr->nama,
                'deptname' => $officer->xtraAttr->department->deptname,
                'bulan' => $mula->englishMonth . "-" . $mula->year,
                'warna' => $officer->xtraAttr->warnaKadByBulan($bulanSebelum->month, $bulanSebelum->year),
                'events' => $transform->toArray(),
            ]);
        }

        return response()->json($records);
    }
	


public function rekodkehadiran($userid)
    {
      //  dd($request->all());

        //$user_log = new User_log;
       // $user_log->add_user_log($request);

        $list_checkinout = Checkinout::detail_checkinout($userid);
		
        return view('laporan.rekodkehadiran',['list_checkinout'=>$list_checkinout]);


}	
	
	

    public function rpcUpdate($permohonan_jtc, Request $request)
    {
        $permohonan_jtc = Acara::find($permohonan_jtc);
        $permohonan_jtc->flag_kelulusan = $request->input('status');
        $permohonan_jtc->save();
    }
	
	
	
public function manual_sistem()
    {
        return $this->renderView('manual.index');
    }


    public function permohonanJTC()
    {
        return $this->renderView('permohonan_jtc.permohonan_jtc');
    }
	
	public function filterPermohonan_jtc(Request $request)
    {
        $kategori_acara = $request->input('kategori_acara');
		//$request->session()->put('session_ka_ljtc', $kategori_acara);
		
		$txtTarikhMula = $request->input('txtTarikhMula');
		//$request->session()->put('session_tm_ljtc', $txtTarikhMula);
		
		$txtTarikhAkhir = $request->input('txtTarikhAkhir');
		//$request->session()->put('session_ta_ljtc', $txtTarikhAkhir);
		
		
		$permohonan = Auth::user()->xtraAnggota->permohonan_jtc($kategori_acara,$txtTarikhMula,$txtTarikhAkhir)->get();
		

        return $this->renderView('permohonan_jtc.permohonan_jtc', compact('permohonan'));
		
		//return view('permohonan_jtc.permohonan_jtc_table', compact('permohonan'));
		//return view('permohonan_jtc.permohonan_jtc_table',['permohonan'=>$permohonan,'kategori_acara'=>$kategori_acara,'txtTarikhMula'=>$txtTarikhMula,'txtTarikhAkhir'=>$txtTarikhAkhir]);
		
    }


	public function permohonan_jtc_pdf(Request $request)
    {	
        $kategori_acara = $request->input('kategori_acara');
		//$request->session()->put('session_ka_ljtc', $kategori_acara);
		
		$txtTarikhMula = $request->input('txtTarikhMula');
		//$request->session()->put('session_tm_ljtc', $txtTarikhMula);
		
		$txtTarikhAkhir = $request->input('txtTarikhAkhir');
		//$request->session()->put('session_ta_ljtc', $txtTarikhAkhir);
		
		
		$permohonan = Auth::user()->xtraAnggota->permohonan_jtc($kategori_acara,$txtTarikhMula,$txtTarikhAkhir)->get();
		
		
		$html2pdf = new \Spipu\Html2Pdf\Html2Pdf('P', 'A4', 'en');
		$html2pdf->writeHTML(view('permohonan_jtc.permohonan_jtc_pdf',['permohonan'=>$permohonan,'kategori_acara'=>$kategori_acara,'txtTarikhMula'=>$txtTarikhMula,'txtTarikhAkhir'=>$txtTarikhAkhir])->render());
		//$html2pdf->writeHTML('<h1>HelloWorld</h1>This is my first page');
		$html2pdf->output();
		
    }

	
	public function laporan_rekodkehadiran(Request $request)
    	{
		$comSenPPP = $request->input('comSenPPP');
		$txtTarikh = $request->input('txtTarikh');
		$txtTarikhHingga = $request->input('txtTarikhHingga');
		
		$list_checkinout = Checkinout::detail_checkinout_individu($comSenPPP,$txtTarikh,$txtTarikhHingga);
		
       		return $this->renderView('laporan.rekodkehadiran', compact('list_checkinout'));

	}
	
	
	
	
	
	public function laporan_papar_harian(Request $request)
    	{
		$departmentDisplayId = $request->input('departmentDisplayId');
		$comSenPPP = $request->input('comSenPPP');
		$txtTarikh = $request->input('txtTarikh');
		$txtTarikhHingga = $request->input('txtTarikhHingga');
		
		$list_checkinout = Checkinout::detail_checkinout_individu($departmentDisplayId,$comSenPPP,$txtTarikh,$txtTarikhHingga);
		//$list_namastaf_department = 'oit';
		$list_namastaf_department = XtraAnggota::list_nama_ikutdepartment($departmentDisplayId,$comSenPPP);
		//dd($list_namastaf_department);
		
       		//return view('laporan.rekodkehadiran_table', compact('list_checkinout'));
			return view('laporan.harian_table',['list_namastaf_department'=>$list_namastaf_department,'list_checkinout'=>$list_checkinout,'departmentDisplayId'=>$departmentDisplayId,'comSenPPP'=>$comSenPPP,'txtTarikh'=>$txtTarikh,'txtTarikhHingga'=>$txtTarikhHingga]);
		

	}
	
	
	// mdridzuan 3-3-2022		
	public function laporan_harian_pdf(Request $request)
    	{
		
		$departmentDisplayId = $request->input('departmentDisplayId');
		$comSenPPP = $request->input('comSenPPP');
		$txtTarikh = $request->input('txtTarikh');
		$txtTarikhHingga = $request->input('txtTarikhHingga');
		
		$list_checkinout = Checkinout::detail_checkinout_individu($departmentDisplayId,$comSenPPP,$txtTarikh,$txtTarikhHingga);
		$list_namastaf_department = XtraAnggota::list_nama_ikutdepartment($departmentDisplayId,$comSenPPP);
		
       	$html2pdf = new \Spipu\Html2Pdf\Html2Pdf('P', 'A4', 'en');
		$html2pdf->writeHTML(view('laporan.harian_pdf', ['list_namastaf_department'=>$list_namastaf_department,'list_checkinout'=>$list_checkinout,'departmentDisplayId'=>$departmentDisplayId,'comSenPPP'=>$comSenPPP,'txtTarikh'=>$txtTarikh,'txtTarikhHingga'=>$txtTarikhHingga])->render());
		$html2pdf->output();

	}






	
	
	
	
	
	public function laporan_papar_bulanan(Request $request)
    	{
			
		$departmentDisplayId = $request->input('departmentDisplayId');
		$comSenPPP = $request->input('comSenPPP');
		$txtTarikh = $request->input('txtTarikh');
		//$txtTarikhHingga = $request->input('txtTarikhHingga');
		
		//$list_finalattendance = FinalAttendance::detail_finalattendance_individu($departmentDisplayId,$comSenPPP,$txtTarikh);
		$list_finalattendance = FinalAttendance::detail_finalattendance_individu($departmentDisplayId,$comSenPPP,$txtTarikh)->whereIn('anggota_id', $request->input('comSenPPP'));
		$list_acara_department = Acara::detail_acara_ikutdepartment($departmentDisplayId,$comSenPPP,$txtTarikh)->whereIn('anggota_id', $request->input('comSenPPP'));
		$list_cuti = Cuti::detail_list_cuti($txtTarikh);
		//$list_cuti = '';
		
		$list_wbb_bulanan = Shift::detail_wbb_bulanan_ikutdepartment($departmentDisplayId,$comSenPPP,$txtTarikh)->whereIn('anggota_id', $request->input('comSenPPP'));
		
		$list_wbb_puasa_mengandung = Shift::detail_wbb_puasa_mengandung_ikutdepartment($departmentDisplayId,$comSenPPP,$txtTarikh)->whereIn('anggota_id', $request->input('comSenPPP'));
		
		//$officers = Anggota::whereIn('userid', $request->input('comPegawai'))->get();
		
		
		//$list_finalattendance = 'oit';
		$list_namastaf_department = XtraAnggota::list_nama_ikutdepartmentALL($departmentDisplayId,$comSenPPP)->whereIn('anggota_id', $request->input('comSenPPP'));
		//dd($list_namastaf_department);
		
       		//return view('laporan.rekodkehadiran_table', compact('list_checkinout'));
			return view('laporan.bulanan_table',['list_wbb_bulanan'=>$list_wbb_bulanan,'list_wbb_puasa_mengandung'=>$list_wbb_puasa_mengandung,'list_namastaf_department'=>$list_namastaf_department,'list_acara_department'=>$list_acara_department,'list_cuti'=>$list_cuti,'list_finalattendance'=>$list_finalattendance,'departmentDisplayId'=>$departmentDisplayId,'comSenPPP'=>$comSenPPP,'txtTarikh'=>$txtTarikh]);
			//return view('laporan.bulanan_table',['list_namastaf_department'=>$list_namastaf_department,'departmentDisplayId'=>$departmentDisplayId,'comSenPPP'=>$comSenPPP,'txtTarikh'=>$txtTarikh]);
		

	}
	
	
	// mdridzuan 3-3-2022		
	public function laporan_bulanan_pdf(Request $request)
    	{
			
			
		$departmentDisplayId = $request->input('departmentDisplayId');
		$comSenPPP = $request->input('comSenPPP');
		$txtTarikh = $request->input('txtTarikh');
		//$txtTarikhHingga = $request->input('txtTarikhHingga');
		
		//$list_finalattendance = FinalAttendance::detail_finalattendance_individu($departmentDisplayId,$comSenPPP,$txtTarikh);
		$list_finalattendance = FinalAttendance::detail_finalattendance_individu($departmentDisplayId,$comSenPPP,$txtTarikh)->whereIn('anggota_id', $request->input('comSenPPP'));
		$list_acara_department = Acara::detail_acara_ikutdepartment($departmentDisplayId,$comSenPPP,$txtTarikh)->whereIn('anggota_id', $request->input('comSenPPP'));
		$list_cuti = Cuti::detail_list_cuti($txtTarikh);
		//$list_cuti = '';
		
		$list_wbb_bulanan = Shift::detail_wbb_bulanan_ikutdepartment($departmentDisplayId,$comSenPPP,$txtTarikh)->whereIn('anggota_id', $request->input('comSenPPP'));
		
		$list_wbb_puasa_mengandung = Shift::detail_wbb_puasa_mengandung_ikutdepartment($departmentDisplayId,$comSenPPP,$txtTarikh)->whereIn('anggota_id', $request->input('comSenPPP'));
		
		//$officers = Anggota::whereIn('userid', $request->input('comPegawai'))->get();
		
		
		//$list_finalattendance = 'oit';
		$list_namastaf_department = XtraAnggota::list_nama_ikutdepartmentALL($departmentDisplayId,$comSenPPP)->whereIn('anggota_id', $request->input('comSenPPP'));
		//dd($list_namastaf_department);
		

       		$html2pdf = new \Spipu\Html2Pdf\Html2Pdf('P', 'A4', 'en');
		$html2pdf->writeHTML(view('laporan.bulanan_pdf', ['list_wbb_bulanan'=>$list_wbb_bulanan,'list_wbb_puasa_mengandung'=>$list_wbb_puasa_mengandung,'list_namastaf_department'=>$list_namastaf_department,'list_acara_department'=>$list_acara_department,'list_cuti'=>$list_cuti,'list_finalattendance'=>$list_finalattendance,'departmentDisplayId'=>$departmentDisplayId,'comSenPPP'=>$comSenPPP,'txtTarikh'=>$txtTarikh])->render());
		$html2pdf->output();

	}

	
	
	
	// mdridzuan 3-3-2022		
	public function laporan_papar_rekodkehadiran(Request $request)
    	{
		$departmentDisplayId = $request->input('departmentDisplayId');
		$comSenPPP = $request->input('comSenPPP');
		$txtTarikh = $request->input('txtTarikh');
		$txtTarikhHingga = $request->input('txtTarikhHingga');
		
		$list_checkinout = Checkinout::detail_checkinout_individu($departmentDisplayId,$comSenPPP,$txtTarikh,$txtTarikhHingga);
		//$list_namastaf_department = 'oit';
		$list_namastaf_department = XtraAnggota::list_nama_ikutdepartment($departmentDisplayId,$comSenPPP);
		//dd($list_namastaf_department);
		
       		//return view('laporan.rekodkehadiran_table', compact('list_checkinout'));
			return view('laporan.rekodkehadiran_table',['list_namastaf_department'=>$list_namastaf_department,'list_checkinout'=>$list_checkinout,'departmentDisplayId'=>$departmentDisplayId,'comSenPPP'=>$comSenPPP,'txtTarikh'=>$txtTarikh,'txtTarikhHingga'=>$txtTarikhHingga]);
		

	}
	
	
	// mdridzuan 3-3-2022		
	public function laporan_rekodkehadiran_pdf(Request $request)
    	{
		
		$departmentDisplayId = $request->input('departmentDisplayId');
		$comSenPPP = $request->input('comSenPPP');
		$txtTarikh = $request->input('txtTarikh');
		$txtTarikhHingga = $request->input('txtTarikhHingga');
		
		$list_checkinout = Checkinout::detail_checkinout_individu($departmentDisplayId,$comSenPPP,$txtTarikh,$txtTarikhHingga);
		$list_namastaf_department = XtraAnggota::list_nama_ikutdepartment($departmentDisplayId,$comSenPPP);
		
       		$html2pdf = new \Spipu\Html2Pdf\Html2Pdf('P', 'A4', 'en');
		$html2pdf->writeHTML(view('laporan.rekodkehadiran_pdf', ['list_namastaf_department'=>$list_namastaf_department,'list_checkinout'=>$list_checkinout,'departmentDisplayId'=>$departmentDisplayId,'comSenPPP'=>$comSenPPP,'txtTarikh'=>$txtTarikh,'txtTarikhHingga'=>$txtTarikhHingga])->render());
		$html2pdf->output();

	}
		
	
	

public function pdfexample()
{
	$html2pdf = new \Spipu\Html2Pdf\Html2Pdf('P', 'A4', 'en');
	$html2pdf->writeHTML('<h1>HelloWorld</h1>This is my first page');
	$html2pdf->output();
}



public function datatable88()
{
       		
			//return view('laporan.datatable');
			return view('laporan.datatable');

}


		
	

}
