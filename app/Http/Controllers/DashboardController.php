<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use App\User;
use App\Aduan;
use App\StatusAduan;
use App\JuruteknikBertugas;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $aduan = DB::table('cms_status_aduan as tblStatus')
        ->select('tblStatus.kod_status','tblStatus.color','tblStatus.nama_status', DB::raw('COUNT(tblAduan.status_aduan) as count'))
        ->leftjoin('cms_aduan as tblAduan','tblAduan.status_aduan','=','tblStatus.kod_status')
        ->groupBy('tblStatus.kod_status','tblStatus.color','tblStatus.nama_status')
        ->orderBy('count')
        ->get();

        $list = DB::table('cms_juruteknik as tblJuru')
        ->select('tblJuru.juruteknik_bertugas','tblUser.name', DB::raw('COUNT(tblAduan.status_aduan) as count'))
        ->leftJoin('cms_aduan as tblAduan','tblAduan.id','=','tblJuru.id_aduan')
        ->leftJoin('auth.users as tblUser','tblUser.id','=','tblJuru.juruteknik_bertugas')
        ->groupBy('tblJuru.juruteknik_bertugas','tblUser.name')
        ->get();

        $data = DB::table('cms_juruteknik as tblJuru')
        ->select('tblJuru.juruteknik_bertugas','tblAduan.status_aduan','tblStatus.nama_status', DB::raw('COUNT(tblAduan.status_aduan) as count'))
        ->leftJoin('cms_aduan as tblAduan','tblAduan.id','=','tblJuru.id_aduan')
        ->leftJoin('cms_status_aduan as tblStatus','tblStatus.kod_status','=','tblAduan.status_aduan')
        ->groupBy('tblJuru.juruteknik_bertugas','tblAduan.status_aduan','tblStatus.nama_status')
        ->get();

        $juruteknik = $data->where('juruteknik_bertugas', Auth::user()->id)->toArray();
        
        $result[] = ['Status','Jumlah'];
        foreach ($aduan as $key => $value) {
            $result[++$key] = [$value->nama_status, (int)$value->count];
        }

        $results[] = ['Juruteknik','Aduan'];
        foreach ($list as $key => $value) {
            $results[++$key] = [$value->name, (int)$value->count];
        }

        $res[] = ['Status','Jumlah'];
        foreach ($juruteknik as $key => $value) {
            $res[++$key] = [$value->nama_status, (int)$value->count];
        }

        $senarai = User::whereHas('roles', function($query){
            $query->where('id', 'CMS002');
        })->with(['staff'])->get();
        
        return view('home', compact('senarai'))->with('aduan',json_encode($result))->with('list',json_encode($results))->with('juruteknik',json_encode($res))->with('no', '1');
    }
    
}
