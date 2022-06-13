<?php

namespace App\Http\Controllers;

use Auth;
use Flow;
use App\Acara;
use App\Anggota;
use App\Base\BaseController;
use Illuminate\Http\Request;
use App\Repositories\Justifikasi;
use App\Jobs\JustifikasiSendingEmailJob;
use App\Http\Requests\JustifikasiRequest;

class AcaraController extends BaseController
{
    /*
	public function __construct()
    {
        parent::__construct();
    }
	*/
	
	
	
	


	public function papar_acara_individu(Request $request)
		{
		  //  dd($request->all());
			
			  $acara = Acara::where('flag_kelulusan', 'MOHON')->get();
	
			return view('kelulusan.list_acara',['list_acara'=>$list_acara]);
	
	
	}
	
	
	public function acara()
    {

        $list_acara = Acara::detail_acara_individu();
		
       return $this->renderView('kelulusan.list_acara',['list_acara2'=>$list_acara]);


	}
	
	
	public function list_acara(Request $request)
    {
      //  dd($request->all());

       // $user_log = new User_log;
        //$user_log->add_user_log($request);

        $list_acara = Acara::orderBy('id', 'desc')->get();
		
		//$permohonan = Auth::user()->xtraAnggota->kelulusanJustifikasi()->get();

        //$detail_user = Brg_personal::detail_user();
        //return view('kelulusan.list_acara',['list_acara'=>$list_acara]);
		return $this->renderView('kelulusan.list_acara',['list_acara'=>$list_acara]);
		//return $this->renderView('kelulusan.list_acara', compact('list_acara'));


	}

	
	
	public function filterAcara(Request $request)
    {
        $kategori_acara = $request->input('kategori_acara');
		$request->session()->put('session_ka1', $kategori_acara);
		
		
		$permohonan = Auth::user()->xtraAnggota->kelulusanJustifikasi($kategori_acara)->get();
		

        return $this->renderView('kelulusan.list_acara', compact('permohonan'));
    }
	
}



