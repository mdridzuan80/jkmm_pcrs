<?php

namespace App\Services;

use App\Flow;
use App\RoleUser;
use App\Abstraction\Flowly;
use App\Abstraction\Flowable;
use Carbon\Carbon;
use Illuminate\Support\Collection;

function pcrs_rst_to_array($query, $field)
{
	$array = array();
	foreach($query->result_array() as $row)
	{
		$array[] = $row[$field];
	}
	return $array;
}

function pcrs_rst_to_option($query, $field, $pilih=FALSE)
{
	$array = array();
	if($pilih)
		$array[-1] = '[sila pilih]';
	foreach($query->result_array() as $row)
	{
		$array[$row[$field[0]]] = $row[$field[1]];
	}
	return $array;
}

function pcrs_render_pdf_tmp($pdf_param, $pdf_html, $filename)
{
	include_once("application/libraries/html2pdf/Html2pdf.php");
	$html2pdf = new HTML2PDF('P', 'A4', 'en', true, 'UTF-8', array(20,10,20,10));
	$CI =& get_instance();

	//$CI->load->library('myhtml2pdf', $pdf_param);

	ob_start();

	try
	{
		// display the full page
		// $this->myhtml2pdf->pdf->SetDisplayMode('fullpage');

		// convert
		 $html2pdf->writeHTML($pdf_html, isset($_GET['vuehtml']));

		// send the PDF
		$tmp_path = $CI->config->item('pcrs_tmp_file');
		return $html2pdf->Output($tmp_path . '/' . $filename, 'F');
	}
	catch(HTML2PDF_exception $e) {
		echo $e;
		exit;
	}

	ob_end_flush();
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

function pcrs_total_hour_day($kategori_id, $mula, $akhir)
{
	switch($kategori_id)
	{
		case 1:
			$mula = strtotime(date('Y-m-d',strtotime($mula)));
			$akhir = strtotime(date('Y-m-d',strtotime($akhir)));
			return datediff('d', $mula, $akhir, TRUE);

		break;
		default:
			$mula = strtotime(date('Y-m-d h:i a',strtotime($mula)));
			$akhir = strtotime(date('Y-m-d h:i a',strtotime($akhir)));
			return datediff('h', $mula, $akhir, TRUE);
		break;
	}
}

#---------------------------------------------------------------------------------------
# FUNCTION: datediff($interval, $datefrom, $dateto, $using_timestamps = false)
# DATE CREATED: Mar 31, 2005
# AUTHOR: I Love Jack Daniels
# PURPOSE: Just like the DateDiff function found in Visual Basic
# $interval can be:
# yyyy - Number of full years
# q - Number of full quarters
# m - Number of full months
# y - Difference between day numbers (eg 1st Jan 2004 is "1", the first day. 2nd Feb 2003 is "33". The datediff is "-32".)
# d - Number of full days
# w - Number of full weekdays
# ww - Number of full weeks
# h - Number of full hours
# n - Number of full minutes
# s - Number of full seconds (default)
#---------------------------------------------------------------------------------------
function pcrs_datediff($interval, $datefrom, $dateto, $using_timestamps = false) {
  if (!$using_timestamps) {
	$datefrom = strtotime($datefrom, 0);
	$dateto = strtotime($dateto, 0);
  }
  $difference = $dateto - $datefrom; // Difference in seconds
  switch($interval) {
	case 'yyyy': $years_difference = floor($difference / 31536000);
				if (mktime(date("H", $datefrom), date("i", $datefrom), date("s", $datefrom), date("n", $datefrom), date("j", $datefrom), date("Y", $datefrom)+$years_difference) > $dateto) {
					$years_difference--;
				}
				if (mktime(date("H", $dateto), date("i", $dateto), date("s", $dateto), date("n", $dateto), date("j", $dateto), date("Y", $dateto)-($years_difference+1)) > $datefrom) {
					$years_difference++;
				}
				$datediff = $years_difference;
				break;
	case "q": $quarters_difference = floor($difference / 8035200);
				while (mktime(date("H", $datefrom), date("i", $datefrom), date("s", $datefrom), date("n", $datefrom)+($quarters_difference*3), date("j", $dateto), date("Y", $datefrom)) < $dateto) {
					$months_difference++;
				}
				$quarters_difference--;
				$datediff = $quarters_difference;
				break;
	case "m": $months_difference = floor($difference / 2678400);
				while (mktime(date("H", $datefrom), date("i", $datefrom), date("s", $datefrom), date("n", $datefrom)+($months_difference), date("j", $dateto), date("Y", $datefrom)) < $dateto) {
					$months_difference++;
				}
				$months_difference--;
				$datediff = $months_difference;
				break;
	case 'y': $datediff = date("z", $dateto) - date("z", $datefrom); break;
	case "d": $datediff = floor($difference / 86400); break;
	case "w": $days_difference = floor($difference / 86400);
				$weeks_difference = floor($days_difference / 7); // Complete weeks
				$first_day = date("w", $datefrom);
				$days_remainder = floor($days_difference % 7);
				$odd_days = $first_day + $days_remainder; // Do we have a Saturday or Sunday in the remainder?
				if ($odd_days > 7) { $days_remainder--; }
				if ($odd_days > 6) { $days_remainder--; }
				$datediff = ($weeks_difference * 5) + $days_remainder;
				break;
	case "ww": $datediff = floor($difference / 604800); break;
	case "h": $datediff = floor($difference / 3600); break;
	case "n": $datediff = floor($difference / 60); break;
	default: $datediff = $difference; break;
  }
  return $datediff;
}

if ( ! function_exists('pcrs_seconds_to_hms'))
{
	function pcrs_seconds_to_hms($seconds)
	{

	$days = floor($seconds/86400);
	$hrs = floor($seconds/3600);
	$mins = intval(($seconds / 60) % 60);
	$sec = intval($seconds % 60);

	if($days>0){
		//echo $days;exit;
		$hrs = str_pad($hrs,2,'0',STR_PAD_LEFT);
		$hours=$hrs-($days*24);
		$return_days = $days." Days ";
		$hrs = str_pad($hours,2,'0',STR_PAD_LEFT);
	}else{
		$return_days="";
		$hrs = str_pad($hrs,2,'0',STR_PAD_LEFT);
	}

	$mins = str_pad($mins,2,'0',STR_PAD_LEFT);
	$sec = str_pad($sec,2,'0',STR_PAD_LEFT);

	return $return_days.$hrs.":".$mins.":".$sec;
	}
}

if ( ! function_exists('pcrs_chk_wbb_current_month'))
{
	function pcrs_chk_wbb_current_month($user_id, $month, $year)
	{
		$fields = array();
		$fields['USERID'] = $user_id;
		$fields['MONTH'] = $month;
		$fields['YEAR'] = $year;

		$CI =& get_instance();
		$CI->load->model('muserinfo');
		return $CI->muserinfo->getWBB2($fields);
	}
}

if ( ! function_exists('pcrs_post_to_url'))
{
	function pcrs_post_to_url($url, $data) {
	   $fields = '';
	   foreach($data as $key => $value) {
		  $fields .= $key . '=' . $value . '&';
	   }
	   rtrim($fields, '&');

	   $post = curl_init();

	   curl_setopt($post, CURLOPT_URL, $url);
	   curl_setopt($post, CURLOPT_POST, count($data));
	   curl_setopt($post, CURLOPT_POSTFIELDS, $fields);
	   curl_setopt($post, CURLOPT_RETURNTRANSFER, 1);

	   $result = curl_exec($post);

	   curl_close($post);
	   return $result;
	}
}

if ( ! function_exists('pcrs_jumlah_lewat'))
{
	function pcrs_jumlah_lewat($user_id, $month, $year)
	{
		$CI =& get_instance();
		$CI->load->model('muserlewat');
		$rst = $CI->muserlewat->jumlah_lewat($user_id, $month, $year);
		return $rst->num_rows();
	}
}

if ( ! function_exists('pcrs_get_punch_in'))
{
	function pcrs_get_punch_in($user_id, $tarikh)
	{
		$CI =& get_instance();
		$CI->load->model('mlaporan');
		return $CI->mlaporan->rpt_kehadiran_in($user_id, $tarikh);
	}
}

if ( ! function_exists('pcrs_get_punch_out'))
{
	function pcrs_get_punch_out($user_id, $tarikh)
	{
		$check_out;
		$CI =& get_instance();
		$CI->load->model('mlaporan');
		$check_out = $CI->mlaporan->rpt_kehadiran_out($user_id, $tarikh);
		if($check_out == "")
		{
			$check_out = $CI->mlaporan->rpt_kehadiran_out_over_midnight($user_id, $tarikh);
		}

		return $check_out;
	}
}

if ( ! function_exists('pcrs_send_email') )
{
	function pcrs_send_email($rcpt_to, $title, $message, $rcpt_cc = array(), $rcpt_bcc = array(), $attachment = NULL)
	{
		$CI =& get_instance();
		$CI->load->library('email');
		$CI->email->clear(TRUE);
		$CI->email->from($CI->config->item('pcrs_email_from'), $CI->config->item('pcrs_email_name'));
		$CI->email->to($rcpt_to);
		if(count($rcpt_cc) != 0)
			$CI->email->cc($rcpt_cc);
		if(count($rcpt_bcc) != 0)
			$CI->email->bcc($rcpt_bcc);

		$CI->email->subject($title);
		$CI->email->message($message);
		if($attachment)
		{
			$CI->email->attach($attachment);
		}
		$CI->email->send();
	}
}

if ( ! function_exists('pcrs_send_phpmailer') )
{
	function pcrs_send_phpmailer($rcpt_to, $title, $message, $rcpt_cc = array(), $rcpt_bcc = array(), $attachment = NULL)
	{
		$CI =& get_instance();
		$CI->load->library('myphpmailer');

		//setting
		switch($CI->config->item('pcrs_email_protocol'))
		{
			case 'smtp':
				$CI->myphpmailer->isSMTP();
				break;
		}
		$CI->myphpmailer->SMTPDebug = $CI->config->item('pcrs_email_smtp_debug_level');
		$CI->myphpmailer->Host = $CI->config->item('pcrs_email_smtp_host');
		$CI->myphpmailer->SMTPAuth = $CI->config->item('pcrs_email_smtp_auth');
		$CI->myphpmailer->Username = $CI->config->item('pcrs_email_smtp_user');
		$CI->myphpmailer->Password = $CI->config->item('pcrs_email_smtp_pass');
		$CI->myphpmailer->SMTPSecure = $CI->config->item('pcrs_email_smtp_secure');
		$CI->myphpmailer->Port = $CI->config->item('pcrs_email_smtp_port');
		$CI->myphpmailer->isHTML($CI->config->item('pcrs_email_mailtype_html'));
		//End Setting

		$CI->myphpmailer->clearAllRecipients();
		$CI->myphpmailer->clearAttachments();

		$CI->myphpmailer->setFrom($CI->config->item('pcrs_email_from'), $CI->config->item('pcrs_email_name'));

		if(is_array($rcpt_to))
		{
			if(count($rcpt_to)!=0)
			{
				foreach($rcpt_to as $val)
				{
					$CI->myphpmailer->addAddress($val);
				}
			}
		}
		else
		{
			$CI->myphpmailer->addAddress($rcpt_to);
		}

		if(is_array($rcpt_cc))
		{
			if(count($rcpt_cc)!=0)
			{
				foreach($rcpt_cc as $val)
				{
					$CI->myphpmailer->addCC($val);
				}
			}
		}
		else
		{
			$CI->myphpmailer->addCC($rcpt_cc);
		}

		if(is_array($rcpt_bcc))
		{
			if(count($rcpt_bcc)!=0)
			{
				foreach($rcpt_bcc as $val)
				{
					$CI->myphpmailer->addBCC($val);
				}
			}
		}
		else
		{
			$CI->myphpmailer->addBCC($rcpt_bcc);
		}

		$CI->myphpmailer->Subject = $title;
		$CI->myphpmailer->Body = $message;

		if($attachment)
		{
			$CI->myphpmailer->addAttachment($attachment);
		}
		if($CI->myphpmailer->send())
		{
			return true;
		}
		else
		{
			return false;
		}
	}
}

if ( ! function_exists('pcrs_get_stat_lewat') )
{
	function pcrs_get_stat_lewat($user_id, $bulan, $tahun)
	{
		$CI =& get_instance();
		$CI->load->model('mlaporan');
		return $CI->mlaporan->get_staff_late($user_id, $bulan, $tahun);
	}
}

if ( ! function_exists('pcrs_chk_ppp'))
{
	function pcrs_chk_ppp($user_id)
	{
		$CI =& get_instance();
		$CI->load->model('muserinfo');
		$rst = $CI->muserinfo->getPPP($user_id);
		return $rst->num_rows();
	}
}

if ( ! function_exists('pcrs_chk_profil'))
{
	function pcrs_chk_profil($user_id)
	{
		$CI =& get_instance();
		$CI->load->model('muserinfo');
		$rst = $CI->muserinfo->chk_profil_info($user_id);
		return $rst->num_rows();
	}
}

if ( ! function_exists('pcrs_get_kod_warna_kad'))
{
	function pcrs_get_kod_warna_kad($user_id)
	{
		$CI =& get_instance();
		$CI->load->model('muserinfo');
		$rst = $CI->muserinfo->get_kod_warna_kad($user_id);
		$kod = $rst->row();
		return $kod->kw_kod;
	}
}

if ( ! function_exists('pcrs_get_arkib_kod_warna_kad'))
{
	function pcrs_get_arkib_kod_warna_kad($user_id)
	{
		$CI =& get_instance();
		$CI->load->model('muserinfo');
		$rst = $CI->muserinfo->get_arkib_kod_warna_kad($user_id);
		$kod = $rst->row();
		return $kod->kw_kod;
	}
}

if ( ! function_exists('pcrs_get_recursive_department'))
{
	function pcrs_get_recursive_department($arrs, $parent_id=0, $level=0)
	{
		$bhg = array();

		foreach ($arrs as $arr)
		{
			if ($arr['SUPDEPTID'] == $parent_id)
			{
				$children = pcrs_get_recursive_department($arrs, $arr['DEPTID'], $level+1);
				if ($children) {
                	$arr[] = $children;
            	}
				$bhg[]= $arr;
			}
		}

		return $bhg;
	}
}

if ( ! function_exists('pcrs_wbb_by_date'))
{
	function pcrs_wbb_by_date($user_id, $tarikh)
	{
		$CI =& get_instance();
		$CI->load->model('muserinfo');
		return $CI->muserinfo->get_wbb_by_date($user_id, $tarikh);
	}
}

if ( ! function_exists('pcrs_wbb_starttime'))
{
	function pcrs_wbb_starttime($user_id, $tarikh)
	{
		$CI =& get_instance();
		$CI->load->model('mwbb');
		return $CI->mwbb->get_start_shift_by_user_wbb($user_id, $tarikh);
	}
}

if ( ! function_exists('pcrs_wbb_desc'))
{
	function pcrs_wbb_desc($id)
	{
		$CI =& get_instance();
		$CI->load->model('mwbb');
		return $CI->mwbb->get_wbb_desc($id);
	}
}

if ( ! function_exists('pcrs_has_child'))
{
	function pcrs_has_child($id)
	{
		$CI =& get_instance();
		$CI->load->model('mdepartment');
    	$rs = $CI->mdepartment->getUnitsPPP($id);
    	//$row = $rs->result_array();
    	return $rs->num_rows() > 0 ? true : false;
	}
}

if (!function_exists('pcrs_flatten'))
{
	function pcrs_flatten(array $array)
	{
    	//$return = array();
    	//array_walk_recursive($array, function($a) use (&$return) { $return[] = $a; });
    	return pcrs_flat_an_array($array);
	}
}

function pcrs_flat_an_array($a)
{
    $na = array();

	foreach($a as $i)
    {
        if(is_array($i))
        {
            if($na) $na = array_merge($na,pcrs_flat_an_array($i));
            else $na = pcrs_flat_an_array($i);
        }
        else $na[] = $i;
    }
    return $na;
}

function pcrs_check_cuti($user_id, $tarikh)
{
		$CI =& get_instance();
		$CI->load->model('mmohon');
    	$rs = $CI->mmohon->chk_cuti($user_id, $tarikh);
    	return $rs;
}

function pcrs_check_timeslip($user_id, $tarikh)
{
		$CI =& get_instance();
		$CI->load->model('mtimeslip');
    	$rs = $CI->mtimeslip->chk_timeslip($user_id, $tarikh);
    	return $rs;
}

function pcrs_get_akses_priv($user_id, $modul, $priv = array())
{
		$CI =& get_instance();
		$CI->load->model('mprivileges');
    	$rs = $CI->mprivileges->get_akses_priv($user_id, $modul, $priv);
    	return $rs;
}

function pcrs_get_parent_dept_privileges($user_id, $modul)
{
		$CI =& get_instance();
		$CI->load->model('mprivileges');
    	$rs = $CI->mprivileges->get_parent_dept_privileges($user_id, $modul);
    	return $rs;
}

function pcrs_get_pelulus_dept($user_id)
{
		$CI =& get_instance();
		$CI->load->model('mpelulus','pelulus');
    	$rs = $CI->pelulus->get_jabatan_view($user_id);
    	return $rs;
}

function pcrs_pembanci($user_id)
{
		$CI =& get_instance();
		$CI->load->model('muserinfo','userinfo');
    	$status = $CI->userinfo->get_pembanci($user_id);
    	return $status;
}

function pcrs_pembanci_arkib($user_id)
{
		$CI =& get_instance();
		$CI->load->model('muserinfo','userinfo');
    	$status = $CI->userinfo->get_pembanci_arkib($user_id);
    	return $status;
}

if( !function_exists('pcrs_validate_date'))
{
	function pcrs_validate_date($date)
	{
	    if($date=='')return '';
	    $expl=explode('/',$date);
	    if(count($expl)==3)
	    {
	        $d=ltrim($expl[1],'0');
	        $m=ltrim($expl[0],'0');
	        $y=$expl[2];
	    }
	    else
	    {
	        $expl=explode('-',$date);
	        if(count($expl)==3)
	        {
	            if(strlen($expl[0])==4)
	            {
	                $d=ltrim($expl[2],'0');
	                $m=ltrim($expl[1],'0');
	                $y=$expl[0];
	            }
	            elseif(strlen($expl[0])==2&&strlen($expl[1])==2&&strlen($expl[2])==2)
	            {
	                $d=ltrim($expl[1],'0');
	                $m=ltrim($expl[0],'0');
	                $y=$expl[2];
	            }
	            else
	            {
	                $d=ltrim($expl[0],'0');
	                $m=ltrim($expl[1],'0');
	                $y=$expl[2];
	            }
	        }
	        else
	        {
	            //uncomment this line when using with codeigniter
	            //$this->form_validation->set_message('_valid_date',"Invalid date format $date supplied.");
	            return false;
	        }
	    }


	    if(!is_numeric($y))$msg="Invalid year $y";
	    elseif($m<1||$m>12)$msg="Invalid month $m";
	    elseif($d<1||$d>31)$msg="Invalid day $d";
	    elseif(($m==4||$m==6||$m==9||$m==11)&&$d>30)$msg="Invalid day for the specified month";
	    elseif($m==2&&$d>29)$msg="Invalid day for the month of feburary.";
	    else $msg="";

	    if($msg=="")
	    {
	        if($d<10)$d="0$d";
	        if($m<10)$m="0$m";
	        return "$y-$m-$d";
	    }
	    else
	    {
	        //uncomment this line when using with codeigniter
	        //$this->form_validation->set_message('_valid_date',$msg);
	        return false;
	    }
	}

	if( !function_exists('pcrs_get_warna_kad'))
	{
		function pcrs_get_warna_kad($user_id, $bulan, $tahun)
		{
			$CI =& get_instance();
			$CI->load->model('mkodwarna');

			$record = $CI->mkodwarna->get_kod_warna_kad($user_id, $bulan, $tahun);
			if($record->num_rows)
			{
				$row = $record->row();
				return $row->kod_warna;
			}
			else
			{
				return 1;
			}
		}
	}

	if( !function_exists('dd'))
	{
		function dd($var)
		{
			die(var_dump($var));
		}
	}
}
