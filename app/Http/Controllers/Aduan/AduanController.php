<?php

namespace App\Http\Controllers\Aduan;

use DB;
use Auth;
use File;
use Session;
use Response;
use App\User;
use App\Aduan;
use Carbon\Carbon;
use App\Staff;
use App\ImejAduan;
use App\AlatGanti;
use App\ResitAduan;
use App\StatusAduan;
use App\TahapKategori;
use App\ImejPembaikan;
use App\KategoriAduan;
use App\SebabKerosakan;
use App\JenisKerosakan;
use App\AlatanPembaikan;
use App\JuruteknikBertugas;
use Illuminate\Http\Request;
use App\Exports\AduanExport;
use App\Exports\JuruteknikExport;
use App\Exports\IndividuExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\StoreAduanRequest;
use App\Http\Requests\StoreEditAduanRequest;
use App\Http\Requests\StorePembaikanRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;

use App\Exports\eAduanExport;

class AduanController extends Controller
{
    // Aduan Individu

    public function borangAduan()
    {
        $kategori = KategoriAduan::all();

        $jenis = JenisKerosakan::all();

        $sebab = SebabKerosakan::all();

        $aduan = new Aduan();

        $user = Auth::user();

        return view('aduan.borang-aduan', compact('kategori', 'jenis', 'sebab', 'aduan', 'user'));
    }

    public function cariJenis(Request $request)
    {
        $data = JenisKerosakan::select('jenis_kerosakan', 'id')
                ->where('kategori_aduan', $request->id)
                ->take(100)->get();

        return response()->json($data);
    }

    public function cariSebab(Request $request)
    {
        $data2 = SebabKerosakan::select('sebab_kerosakan', 'id')
                ->where('kategori_aduan', $request->id)
                ->take(100)->get();

        return response()->json($data2);
    }

    public function simpanAduan(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'lokasi_aduan'       => 'required',
            'blok_aduan'         => 'required',
            'aras_aduan'         => 'required',
            'nama_bilik'         => 'required',
            'kategori_aduan'     => 'required',
            'jenis_kerosakan'    => 'required',
            'sebab_kerosakan'    => 'required',
            'upload_image'       => 'required', //|mimes:jpeg,jpg,png
            // 'resit_file'         => 'nullable|mimes:pdf,doc,dot,docx',
        ]);

        $aduan = Aduan::create([
            'nama_pelapor'              => strtoupper($user->name),
            'emel_pelapor'              => $user->email,
            'id_pelapor'                => $user->id,
            'no_tel_pelapor'            => $request->no_tel_pelapor,
            'lokasi_aduan'              => $request->lokasi_aduan,
            'blok_aduan'                => $request->blok_aduan,
            'aras_aduan'                => $request->aras_aduan,
            'nama_bilik'                => $request->nama_bilik,
            'kategori_aduan'            => $request->kategori_aduan,
            'jenis_kerosakan'           => $request->jenis_kerosakan,
            'jk_penerangan'             => $request->jk_penerangan,
            'sebab_kerosakan'           => $request->sebab_kerosakan,
            'sk_penerangan'             => $request->sk_penerangan,
            'kuantiti_unit'             => $request->kuantiti_unit,
            'maklumat_tambahan'         => $request->maklumat_tambahan,
            'pengesahan_aduan'          => 'Y',
            'tarikh_laporan'            => Carbon::now()->toDateTimeString(),
            'bulan_laporan'             => Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now()->toDateTimeString())->month,
            'status_aduan'              => 'BS',
        ]);

        $image = $request->upload_image;
        $paths = storage_path()."/aduan/";

        if (isset($image)) {
            for($y = 0; $y < count($image); $y++)
            {
                $originalsName = $image[$y]->getClientOriginalName();
                $fileSizes = $image[$y]->getSize();
                $fileNames = $originalsName;
                $image[$y]->storeAs('/aduan', date('dmyhi').' - '.$fileNames);
                ImejAduan::create([
                    'id_aduan'      => $aduan->id,
                    'upload_image'  => date('dmyhi').' - '.$originalsName,
                    'web_path'      =>"app/aduan/".date('dmyhi').' - '.$fileNames,
                ]);
            }
        }

        $file = $request->resit_file;
        $path=storage_path()."/resit/";

        if (isset($file)) {

            for($x = 0; $x < count($file) ; $x ++)
            {
                $originalName = $file[$x]->getClientOriginalName();
                $fileSize = $file[$x]->getSize();
                $fileName = $originalName;
                $file[$x]->storeAs('/resit', date('dmyhi').' - '.$fileName);
                ResitAduan::create([
                    'id_aduan'  => $aduan->id,
                    'nama_fail' => date('dmyhi').' - '.$originalName,
                    'saiz_fail' => $fileSize,
                    'web_path'  => "app/resit/".date('dmyhi').' - '.$fileName,
                ]);
            }
        }

        $admin = User::whereHas('roles', function($query){
            $query->where('id', 'CMS001');
        })->pluck('id');


        if($aduan->kategori_aduan == 'IITU-HDWR' || $aduan->kategori_aduan == 'IITU-NTWK' || $aduan->kategori_aduan == 'IITU-SYS' || $aduan->kategori_aduan == 'IITU-OPR' || $aduan->kategori_aduan == 'IITU-OPR_EMEL' || $aduan->kategori_aduan == 'IITU-OPR_SFWR' || $aduan->kategori_aduan == 'IITU-NTWK WIRELESS'){

            $admin_staff = Staff::whereIn('staff_id', $admin)->where('staff_code', 'IITU')->get();
        }

        if($aduan->kategori_aduan == 'AWM' || $aduan->kategori_aduan == 'ELK' || $aduan->kategori_aduan == 'MKL' || $aduan->kategori_aduan == 'PKH' || $aduan->kategori_aduan == 'TKM'){

            $admin_staff = Staff::whereIn('staff_id', $admin)->whereIn('staff_code', ['OFM','AA'])->get();
        }

        foreach($admin_staff as $value)
        {
            $admin_email = $value->staff_email;

            $data = [
                'nama_penerima' => 'Assalamualaikum wbt & Salam Sejahtera, Tuan/Puan/Encik/Cik ' . $value->staff_name,
                'penerangan' => 'Anda telah menerima aduan baru daripada '.$aduan->nama_pelapor.' pada '.date(' d/m/Y ', strtotime(Carbon::now()->toDateTimeString())).'. Sila log masuk sistem IDS untuk tindakan selanjutnya',
            ];

            Mail::send('aduan.emel-aduan', $data, function ($message) use ($user, $admin_email) {
                $message->subject('EADUAN: ADUAN BAHARU');
                $message->from($user->email);
                $message->to($admin_email);
            });
        }

        $datas = [
            'nama_penerima' => 'Assalamualaikum wbt & Salam Sejahtera, Tuan/Puan/Encik/Cik ' . $aduan->nama_pelapor,
            'penerangan' => 'Anda telah membuat aduan pada '.date(' d/m/Y ', strtotime(Carbon::now()->toDateTimeString())).'. Tiket aduan anda ialah : #'.$aduan->id.'. Tiket boleh digunakan untuk menyemak maklum balas atau tahap aduan anda diproses
                             di dalam sistem IDS. Sila log masuk sistem IDS untuk menyemak aduan anda',
        ];

        Mail::send('aduan.emel-aduan', $datas, function ($message) use ($aduan) {
            $message->subject('EADUAN: ADUAN BAHARU');
            $message->to($aduan->emel_pelapor);
        });

        Session::flash('message');
        return redirect('/borang-aduan');
    }

    public function aduan()
    {
        $status = StatusAduan::all();

        return view('aduan.aduan', compact('status'));
    }

    public function data_aduan()
    {
        $aduan = Aduan::where('id_pelapor', Auth::user()->id)->select('cms_aduan.*');

        return datatables()::of($aduan)
        ->addColumn('action', function ($aduan) {

            if($aduan->status_aduan != 'AB' && $aduan->status_aduan == 'BS'){
                return '<div class="btn-group"><a href="/maklumat-aduan/' . $aduan->id.'" class="btn btn-sm btn-primary mr-2"><i class="fal fa-eye"></i></a>
                <a href="" data-target="#crud-modal" data-toggle="modal" data-id="'.$aduan->id.'" class="btn btn-sm btn-danger mr-1"><i class="fal fa-trash"></i></a></div>';
            } else {
                return '<div class="btn-group"><a href="/maklumat-aduan/' . $aduan->id.'" class="btn btn-sm btn-primary mr-2"><i class="fal fa-eye"></i></a></div>';
            }

        })

        ->addColumn('id', function ($aduan) {

            return '#'.$aduan->id;
        })

        ->addColumn('tarikh', function ($aduan) {

            return date(' Y/m/d ', strtotime($aduan->tarikh_laporan));
        })

        ->addColumn('masa', function ($aduan) {

            return date(' h:i:s A ', strtotime($aduan->tarikh_laporan));
        })

        ->editColumn('lokasi_aduan', function ($aduan) {

            return '<div>' .strtoupper($aduan->nama_bilik). ', ARAS ' .strtoupper($aduan->aras_aduan). ', BLOK ' .strtoupper($aduan->blok_aduan). ', ' .strtoupper($aduan->lokasi_aduan).'</div>' ;
        })

        ->editColumn('kategori_aduan', function ($aduan) {

            return '<div> Kategori : <b>' .strtoupper($aduan->kategori->nama_kategori). '</b></div word-break: break-all><div> Jenis : <b>' .strtoupper($aduan->jenis->jenis_kerosakan). '</b></div word-break: break-all><div> Sebab : <b>' .strtoupper($aduan->sebab->sebab_kerosakan). '</b></div>' ;
        })

        ->editColumn('juruteknik_bertugas', function ($aduan) {

            $data = JuruteknikBertugas::where('id_aduan', $aduan->id)->with(['juruteknik'])->get();

            if(isset($data->first()->id_aduan))
            {
                $all = '';

                foreach($data as $test){
                    $staff = Staff::where('staff_id', $test->juruteknik_bertugas)->first();

                    $all .= isset($test->juruteknik->name) ? '<div word-break: break-all>'.$test->juruteknik->name.'<br>[ '.$staff->staff_phone.' ]</div>' : '--';
                }
                return $all;

            } else {

                return '<div style="color:red">TIADA JURUTEKNIK DITUGASKAN</div>';
            }

        })

        ->editColumn('status_aduan', function ($aduan) {

                if($aduan->status_aduan=='BS')
                {
                    return '<span class="badge badge-new">' . strtoupper($aduan->status->nama_status) . '</span>';
                }
                elseif($aduan->status_aduan=='DJ')
                {
                    return '<span class="badge badge-sent">' . strtoupper($aduan->status->nama_status) . '</span>';
                }
                elseif($aduan->status_aduan=='TD')
                {
                    return '<span class="badge badge-done">' . strtoupper($aduan->status->nama_status) . '</span>';
                }
                elseif($aduan->status_aduan=='AS')
                {
                    return '<span class="badge badge-success">' . strtoupper($aduan->status->nama_status) . '</span>';
                }
                elseif($aduan->status_aduan=='LK')
                {
                    return '<span class="badge badge-success2">' . strtoupper($aduan->status->nama_status) . '</span>';
                }
                elseif($aduan->status_aduan=='LU')
                {
                    return '<span class="badge badge-success2">' . strtoupper($aduan->status->nama_status) . '</span>';
                }
                elseif($aduan->status_aduan=='AK')
                {
                    return '<span class="badge badge-kiv">' . strtoupper($aduan->status->nama_status) . '</span>';
                }
                else
                {
                    return '<span class="badge badge-duplicate">' . strtoupper($aduan->status->nama_status) . '</span>';
                }
        })

        ->editColumn('pengesahan_pembaikan', function ($aduan) {

            if($aduan->pengesahan_pembaikan=='Y')
            {
                return '<span class="low" data-toggle="tooltip" data-placement="top" title="DISAHKAN">' . '</span>';
            }
            else
            {
                return '<span class="high" data-toggle="tooltip" data-placement="top" title="BELUM DISAHKAN">' . '</span>';
            }
        })

        ->rawColumns(['action', 'status_aduan', 'lokasi_aduan', 'kategori_aduan', 'juruteknik_bertugas', 'tarikh', 'masa', 'pengesahan_pembaikan', 'id', 'pdf'])
        ->make(true);
    }

    public function batalAduan(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'sebab_pembatalan'       => 'required',
        ]);

        Aduan::where('id', $request->aduan_id)->update([
            'sebab_pembatalan'         => $request->sebab_pembatalan,
            'status_aduan'             => 'AB',
        ]);

        $aduan = Aduan::where('id', $request->aduan_id)->first();

        $admin = User::whereHas('roles', function($query){
            $query->where('id', 'CMS001');
        })->pluck('id');


        if($aduan->kategori_aduan == 'IITU-HDWR' || $aduan->kategori_aduan == 'IITU-NTWK' || $aduan->kategori_aduan == 'IITU-SYS' || $aduan->kategori_aduan == 'IITU-OPR' || $aduan->kategori_aduan == 'IITU-OPR_EMEL' || $aduan->kategori_aduan == 'IITU-OPR_SFWR' || $aduan->kategori_aduan == 'IITU-NTWK WIRELESS'){

            $admin_staff = Staff::whereIn('staff_id', $admin)->where('staff_code', 'IITU')->get();
        }

        if($aduan->kategori_aduan == 'AWM' || $aduan->kategori_aduan == 'ELK' || $aduan->kategori_aduan == 'MKL' || $aduan->kategori_aduan == 'PKH' || $aduan->kategori_aduan == 'TKM'){

            $admin_staff = Staff::whereIn('staff_id', $admin)->whereIn('staff_code', ['OFM','AA'])->get();
        }

        foreach($admin_staff as $value)
        {
            $admin_email = $value->staff_email;

            $data = [
                'nama_penerima' => 'Assalamualaikum wbt & Salam Sejahtera, Tuan/Puan/Encik/Cik ' . $value->staff_name,
                'penerangan' => 'Aduan daripada '.$aduan->nama_pelapor.' pada '.date(' d/m/Y ', strtotime(Carbon::now()->toDateTimeString())).' telah dibatalkan atas sebab '.$request->sebab_pembatalan,
            ];

            Mail::send('aduan.emel-aduan', $data, function ($message) use ($admin_email) {
                $message->subject('EADUAN: PEMBATALAN ADUAN');
                $message->to($admin_email);
            });
        }

        Session::flash('message','Aduan telah berjaya dibatalkan. Aduan yang dibatalkan boleh dilihat dalam senarai anda.');
        return redirect('/aduan');
    }

    public function maklumatAduan($id)
    {
        $aduan = Aduan::where('id', $id)->first();
        $resit = ResitAduan::where('id_aduan', $id)->get();
        $imej = ImejAduan::where('id_aduan', $id)->get();

        return view('aduan.maklumat-aduan', compact('aduan', 'resit', 'imej'));
    }

    public function getImej($file)
    {
        return Storage::response('aduan/'.$file);
    }

    public function failResit($filename,$type)
    {
        return Storage::response('resit/'.$filename);
    }

    public function simpanPengesahan(Request $request)
    {
        $user = Auth::user();
        $aduan = Aduan::where('id', $request->id)->where('id_pelapor', $user->id)->first();

        $aduan->update([
            'pengesahan_pembaikan'    => 'Y',
        ]);

        Session::flash('simpanPengesahan', 'Pengesahan telah berjaya dihantar.');
        return redirect('maklumat-aduan/'.$request->id);
    }

    public function failPembaikan($filename,$type)
    {
        return Storage::response('pembaikan/'.$filename);
    }

    public function manualAduan()
    {
        $file = "E-ADUAN MANUAL PENGGUNA (STAF & PELAJAR).pdf";

        $path = storage_path().'/eaduan/'.$file;

        $form = File::get($path);
        $filetype = File::mimeType($path);

        $response = Response::make($form, 200);
        $response->header("Content-Type", $filetype);

        return $response;
    }

    // Senarai Aduan Admin

    public function senaraiAduan(Request $request)
    {
        $status = StatusAduan::whereIn('kod_status', ['AS', 'LK', 'LU'])->get();

        return view('aduan.senarai-aduan', compact('status'));
    }

    public function data_senarai()
    {
        $stf = User::where('category','STF')->pluck('id');

        $staff = Staff::where('staff_id', Auth::user()->id)->first();

        if($staff->staff_code == 'IITU') {

            $list = Aduan::whereIn('status_aduan', ['BS','DJ','TD'])->whereIn('id_pelapor', $stf)->with(['kategori','status','tahap'])->whereIn('kategori_aduan', ['IITU-HDWR','IITU-NTWK','IITU-SYS','IITU-OPR_EMEL','IITU-OPR_SFWR','IITU-NTWK WIRELESS'])->select('cms_aduan.*');
        } elseif($staff->staff_code == 'OFM' || $staff->staff_code == 'AA') {

            $list = Aduan::whereIn('status_aduan', ['BS','DJ','TD'])->whereIn('id_pelapor', $stf)->with(['kategori','status','tahap'])->whereIn('kategori_aduan', ['AWM','ELK','MKL','PKH','TKM'])->select('cms_aduan.*');
        } else {

            $list = Aduan::whereIn('status_aduan', ['BS','DJ','TD'])->whereIn('id_pelapor', $stf)->with(['kategori','status','tahap'])->select('cms_aduan.*');
        }

        return datatables()::of($list)
        ->addColumn('action', function ($list) {

            if($list->status_aduan == 'DJ') {
                return '<div class="btn-group"><a href="/info-aduan/' . $list->id.'" class="btn btn-sm btn-info mr-2"><i class="fal fa-pencil"></i></a>
                        <a data-page="/download/' . $list->id.'" class="btn btn-sm btn-primary text-white mr-2" onclick="Print(this)"><i class="fal fa-file"></i></a></div>';
            } else {
                return '<div class="btn-group"><a href="/info-aduan/' . $list->id.'" class="btn btn-sm btn-info mr-2"><i class="fal fa-pencil"></i></a></div>';
            }
        })

        ->editColumn('id', function ($list) {

            return '#'.$list->id;
        })

        ->editColumn('nama_pelapor', function ($list) {

            return $list->nama_pelapor;
        })

        ->editColumn('tarikh_laporan', function ($list) {

            return date(' Y-m-d ', strtotime($list->tarikh_laporan) );
        })

        ->editColumn('kategori_aduan', function ($list) {

            return $list->kategori->nama_kategori ?? '';
        })

        ->editColumn('status_aduan', function ($list) {

            if($list->status_aduan=='BS')
            {
                return '<span class="badge badge-new">' . strtoupper($list->status->nama_status) . '</span>
                <a href="" data-target="#crud-modals" data-toggle="modal" data-id="'. $list->id.'"><i class="fal fa-pencil" style="color: red"></i></a>';

            }
            if($list->status_aduan=='DJ')
            {
                return '<span class="badge badge-sent">' . strtoupper($list->status->nama_status) . '</span>
                <a href="" data-target="#crud-modals" data-toggle="modal" data-id="'. $list->id.'"><i class="fal fa-pencil" style="color: red"></i></a>';
            }
            else
            {
                return '<span class="badge badge-done">' . strtoupper($list->status->nama_status) . '</span>
                <a href="" data-target="#crud-modals" data-toggle="modal" data-id="'. $list->id.'"><i class="fal fa-pencil" style="color: red"></i></a>';
            }
        })

        ->editColumn('tempoh', function ($list) {

            if(isset($list->tarikh_selesai_aduan))
            {
                $tempoh = Carbon::parse($list->tarikh_laporan)->diffInDays($list->tarikh_selesai_aduan);

            } else {

                $tempoh = Carbon::parse($list->tarikh_laporan)->diffInDays(Carbon::now());
            }

            return $tempoh.' hari';

        })

        ->editColumn('tahap_kategori', function ($list) {

            if($list->tahap_kategori=='B')
            {
                return '<span class="low" data-toggle="tooltip" data-placement="top" title="BIASA">' . '</span>';
            }
            elseif($list->tahap_kategori=='S')
            {
                return '<span class="medium" data-toggle="tooltip" data-placement="top" title="SEGERA">' . '</span>';
            }
            else
            {
                return '<span class="none" data-toggle="tooltip" data-placement="top" title="BELUM DITENTUKAN">' . '</span>';
            }
        })

        ->rawColumns(['id', 'action', 'tahap_kategori', 'status_aduan', 'kategori_aduan', 'nama_pelapor', 'tempoh', 'tarikh_laporan'])
        ->make(true);
    }

    public function data_senarai_pelajar()
    {
        $std = User::where('category','STD')->pluck('id');

        $staff = Staff::where('staff_id', Auth::user()->id)->first();

        if($staff->staff_code == 'IITU') {

            $list = Aduan::whereIn('status_aduan', ['BS','DJ','TD'])->with(['kategori','status','tahap'])->whereIn('id_pelapor', $std)->whereIn('kategori_aduan', ['IITU-HDWR','IITU-NTWK','IITU-SYS','IITU-OPR_EMEL','IITU-OPR_SFWR','IITU-NTWK WIRELESS'])->select('cms_aduan.*');
        } elseif($staff->staff_code == 'OFM' || $staff->staff_code == 'AA') {

            $list = Aduan::whereIn('status_aduan', ['BS','DJ','TD'])->with(['kategori','status','tahap'])->whereIn('id_pelapor', $std)->whereIn('kategori_aduan', ['AWM','ELK','MKL','PKH','TKM'])->select('cms_aduan.*');
        } else {

            $list = Aduan::whereIn('status_aduan', ['BS','DJ','TD'])->with(['kategori','status','tahap'])->whereIn('id_pelapor', $std)->select('cms_aduan.*');
        }

        return datatables()::of($list)
        ->addColumn('action', function ($list) {

            if($list->status_aduan == 'DJ') {
                return '<div class="btn-group"><a href="/info-aduan/' . $list->id.'" class="btn btn-sm btn-info mr-2"><i class="fal fa-pencil"></i></a>
                        <a data-page="/download/' . $list->id.'" class="btn btn-sm btn-primary text-white mr-2" onclick="Print(this)"><i class="fal fa-file"></i></a></div>';
            } else {
                return '<div class="btn-group"><a href="/info-aduan/' . $list->id.'" class="btn btn-sm btn-info mr-2"><i class="fal fa-pencil"></i></a></div>';
            }
        })

        ->editColumn('id', function ($list) {

            return '#'.$list->id;
        })

        ->editColumn('nama_pelapor', function ($list) {

            return $list->nama_pelapor;
        })

        ->editColumn('tarikh_laporan', function ($list) {

            return date(' Y-m-d ', strtotime($list->tarikh_laporan) );
        })

        ->editColumn('kategori_aduan', function ($list) {

            return $list->kategori->nama_kategori ?? '';
        })

        ->editColumn('status_aduan', function ($list) {

            if($list->status_aduan=='BS')
            {
                return '<span class="badge badge-new">' . strtoupper($list->status->nama_status) . '</span>
                <a href="" data-target="#crud-modals" data-toggle="modal" data-id="'. $list->id.'"><i class="fal fa-pencil" style="color: red"></i></a>';

            }
            if($list->status_aduan=='DJ')
            {
                return '<span class="badge badge-sent">' . strtoupper($list->status->nama_status) . '</span>
                <a href="" data-target="#crud-modals" data-toggle="modal" data-id="'. $list->id.'"><i class="fal fa-pencil" style="color: red"></i></a>';
            }
            else
            {
                return '<span class="badge badge-done">' . strtoupper($list->status->nama_status) . '</span>
                <a href="" data-target="#crud-modals" data-toggle="modal" data-id="'. $list->id.'"><i class="fal fa-pencil" style="color: red"></i></a>';
            }
        })

        ->editColumn('tempoh', function ($list) {

            if(isset($list->tarikh_selesai_aduan))
            {
                $tempoh = Carbon::parse($list->tarikh_laporan)->diffInDays($list->tarikh_selesai_aduan);

            } else {

                $tempoh = Carbon::parse($list->tarikh_laporan)->diffInDays(Carbon::now());
            }

            return $tempoh.' hari';
        })

        ->editColumn('tahap_kategori', function ($list) {

            if($list->tahap_kategori=='B')
            {
                return '<span class="low" data-toggle="tooltip" data-placement="top" title="BIASA">' . '</span>';
            }
            elseif($list->tahap_kategori=='S')
            {
                return '<span class="medium" data-toggle="tooltip" data-placement="top" title="SEGERA">' . '</span>';
            }
            else
            {
                return '<span class="none" data-toggle="tooltip" data-placement="top" title="BELUM DITENTUKAN">' . '</span>';
            }
        })

        ->rawColumns(['id', 'action', 'tahap_kategori', 'status_aduan', 'kategori_aduan', 'nama_pelapor', 'tempoh', 'tarikh_laporan'])
        ->make(true);
    }

    public function infoAduan($id)
    {
        $aduan = Aduan::where('id', $id)->first();

        $tahap = TahapKategori::all();

        $status = StatusAduan::select('*')->whereIn('kod_status', ['TD', 'AK', 'DP'])->get();

        $tukarStatus = StatusAduan::select('*')->whereIn('kod_status', ['AS', 'LK', 'LU'])->get();

        $exist = JuruteknikBertugas::where('id_aduan', $id)->get();

        $juruteknik_exist = array_column($exist->toArray(), 'juruteknik_bertugas');

        $juruteknik = User::whereHas('roles', function($query){
            $query->where('id', 'CMS002');
        })->whereNotIn('id', $juruteknik_exist)->get();

        $resit = ResitAduan::where('id_aduan', $id)->get();

        $imej = ImejAduan::where('id_aduan', $id)->get();

        $gambar = ImejPembaikan::where('id_aduan', $id)->get();

        $alatan = AlatGanti::orderBy('alat_ganti')->get();

        $alatan_ganti = AlatanPembaikan::where('id_aduan', $id)->get();

        $data = array_column($alatan_ganti->toArray(), 'alat_ganti');

        $senarai_alat =  AlatGanti::whereNotIn('id', $data)->get();

        $senarai_juruteknik = JuruteknikBertugas::where('id_aduan', $id)->get();

        $juru = JuruteknikBertugas::where('id_aduan', $id)->where('juruteknik_bertugas', Auth::user()->id)->first();

        $pengadu = User::where('id', $aduan->id_pelapor)->first();

        return view('aduan.info-aduan', compact('pengadu', 'aduan', 'juru', 'tahap', 'juruteknik', 'status', 'tukarStatus', 'resit', 'imej', 'senarai_juruteknik', 'alatan', 'alatan_ganti', 'senarai_alat', 'gambar'))->with('no', 1)->with('urutan', 1);
    }

    public function kemaskiniTahap(Request $request)
    {
        $aduan = Aduan::where('id', $request->ids)->first();

        if($request->input('juruteknik_bertugas') != null) {

            $aduan->update([
                'tahap_kategori'         => $request->tahap_kategori,
                'status_aduan'           => 'DJ',
                'caj_kerosakan'          => $request->caj_kerosakan,
                'tarikh_serahan_aduan'   => Carbon::now()->toDateTimeString(),
            ]);

            foreach($request->input('juruteknik_bertugas') as $key => $value) {

                $juruteknik = JuruteknikBertugas::create([
                    'id_aduan'              => $request->ids,
                    'juruteknik_bertugas'   => $value,
                    'jenis_juruteknik'      => $request->jenis_juruteknik[$key],
                ]);

                $data = [
                    'nama_penerima' => 'Assalamualaikum wbt & Salam Sejahtera, Tuan/Puan/Encik/Cik ' . $juruteknik->juruteknik->name,
                    'penerangan' => 'Anda telah ditugaskan dengan aduan baru pada '.date(' d/m/Y ', strtotime(Carbon::now()->toDateTimeString())).'. Sila log masuk sistem IDS untuk tindakan selanjutnya',
                ];

                $email = $juruteknik->juruteknik->email;

                Mail::send('aduan.emel-aduan', $data, function ($message) use ($email, $juruteknik) {
                    $message->subject('EADUAN: PENYERAHAN ADUAN');
                    $message->from(Auth::user()->email);
                    $message->to($email);
                });
            }

            $datas = [
                'nama_penerima' => 'Assalamualaikum wbt & Salam Sejahtera, Tuan/Puan/Encik/Cik ' . $aduan->nama_pelapor,
                'penerangan' => 'Aduan anda bertarikh '.date(' d/m/Y ', strtotime(Carbon::now()->toDateTimeString())).' telah diserahkan kepada juruteknik. Anda boleh berkomunikasi dengan juruteknik yang
                                ditugaskan untuk sebarang maklumbalas atau pertanyaan. Sila log masuk sistem IDS untuk menyemak status aduan anda',
            ];

            Mail::send('aduan.emel-aduan', $datas, function ($message) use ($aduan) {
                $message->subject('EADUAN: PENYERAHAN ADUAN');
                $message->from(Auth::user()->email);
                $message->to($aduan->emel_pelapor);
            });

        } else {

            $aduan->update([
                'tahap_kategori'         => $request->tahap_kategori,
                'caj_kerosakan'          => $request->caj_kerosakan,
            ]);
        }

        Session::flash('kemaskiniTahap', 'Maklumat penyerahan aduan telah berjaya dihantar dan direkodkan.');
        return redirect('info-aduan/'.$request->ids);
    }

    public function tukarStatus(Request $request)
    {
        $request->validate([
            'kod_status'         => 'required',
            'sebab_tukar_status' => 'required',
        ]);

        $id = Auth::user()->id;

        $aduan = Aduan::where('id', $request->status_id)->update([
            'status_aduan'          => $request->kod_status,
            'tukar_status'          => $id,
            'sebab_tukar_status'    => $request->sebab_tukar_status,
            'tarikh_selesai_aduan'  => Carbon::now()->toDateTimeString(),
        ]);

        Session::flash('status', 'Status aduan telah berjaya ditukar. Sila semak aduan dibahagian Pengurusan Aduan > Selesai');
        return redirect('/senarai-aduan');
    }

    public function kemaskiniPenambahbaikan(Request $request)
    {
        $aduan = Aduan::where('id', $request->idp)->first();

        $request->validate([
            'laporan_pembaikan'       => 'required',
            'tarikh_selesai_aduan'    => 'required',
            'status_aduan'            => 'required',
        ]);

        $aduan->update([
            'laporan_pembaikan'       => $request->laporan_pembaikan,
            'ak_upah'                 => $request->ak_upah,
            'ak_bahan_alat'           => $request->ak_bahan_alat,
            'jumlah_kos'              => $request->jumlah_kos,
            'tarikh_selesai_aduan'    => $request->tarikh_selesai_aduan,
            'status_aduan'            => $request->status_aduan,
        ]);

        if (isset($request->bahan_alat)) {
            foreach($request->bahan_alat as $value) {
                $fields = [
                    'id_aduan' => $aduan->id,
                    'alat_ganti' => $value
                ];

                AlatanPembaikan::create($fields);
            }
        }

        if (isset($request->upload_image)) {

            $image = $request->upload_image;
            $paths = storage_path()."/pembaikan/";

            for($y = 0; $y < count($image); $y++)
            {
                $originalsName = $image[$y]->getClientOriginalName();
                $fileSizes = $image[$y]->getSize();
                $fileNames = $originalsName;
                $image[$y]->storeAs('/pembaikan', date('dmyhi').' - '.$fileNames);
                ImejPembaikan::create([
                    'id_aduan'      => $aduan->id,
                    'upload_image'  => date('dmyhi').' - '.$originalsName,
                    'web_path'      => "app/pembaikan/".date('dmyhi').' - '.$fileNames,
                ]);
            }
        }

        $admin = User::whereHas('roles', function($query){
            $query->where('id', 'CMS001');
        })->pluck('id');


        if($aduan->kategori_aduan == 'IITU-HDWR' || $aduan->kategori_aduan == 'IITU-NTWK' || $aduan->kategori_aduan == 'IITU-SYS' || $aduan->kategori_aduan == 'IITU-OPR' || $aduan->kategori_aduan == 'IITU-OPR_EMEL' || $aduan->kategori_aduan == 'IITU-OPR_SFWR' || $aduan->kategori_aduan == 'IITU-NTWK WIRELESS'){

            $admin_staff = Staff::whereIn('staff_id', $admin)->where('staff_code', 'IITU')->get();
        }

        if($aduan->kategori_aduan == 'AWM' || $aduan->kategori_aduan == 'ELK' || $aduan->kategori_aduan == 'MKL' || $aduan->kategori_aduan == 'PKH' || $aduan->kategori_aduan == 'TKM'){

            $admin_staff = Staff::whereIn('staff_id', $admin)->whereIn('staff_code', ['OFM','AA'])->get();
        }

        foreach($admin_staff as $value)
        {
            $admin_email = $value->staff_email;

            $data = [
                'nama_penerima' => 'Assalamualaikum wbt & Salam Sejahtera, Tuan/Puan/Encik/Cik ' . $value->staff_name,
                'penerangan'    => 'Aduan yang dilaporkan pada '.date(' d/m/Y ', strtotime($aduan->tarikh_laporan)).
                                    ' telah dilaksanakan pembaikan oleh juruteknik bertarikh '.date(' d/m/Y ', strtotime($aduan->tarikh_selesai_aduan)).
                                    'Sila log masuk sistem IDS untuk tindakan selanjutnya',
            ];

            Mail::send('aduan.emel-aduan', $data, function ($message) use ($admin_email) {
                $message->subject('EADUAN: PELAKSANAAN PENAMBAHBAIKAN ADUAN');
                $message->from(Auth::user()->email);
                $message->to($admin_email);
            });
        }

        Session::flash('kemaskiniPembaikan', 'Maklumat penambahbaikan telah dihantar dan direkodkan.');
        return redirect('info-aduan/'.$aduan->id);
    }

    public function padamAlatan($id, $id_aduan)
    {
        $aduan = Aduan::where('id',$id_aduan)->first();
        $alat = AlatanPembaikan::find($id);
        $alat->delete($aduan);

        return redirect()->back()->with('message', 'Bahan/Alat Ganti Berjaya Dipadam');
    }

    public function padamJuruteknik($id, $id_aduan)
    {
        $aduan = Aduan::where('id',$id_aduan)->first();
        $alat = JuruteknikBertugas::find($id);
        $alat->delete($aduan);

        return redirect()->back()->with('messageJr', 'Juruteknik Berjaya Dipadam');
    }

    public function getGambar($file)
    {
        return Storage::response('pembaikan/'.$file);
    }

    public function senaraiSelesai(Request $request)
    {
        $aduan = Aduan::all();

        $juruteknik = User::whereHas('roles', function($query){
            $query->where('id', 'CMS002');
        })->get();

        return view('aduan.senarai-aduan-selesai', compact('aduan', 'juruteknik'))->with('no', 1);
    }

    public function data_selesai()
    {
        $stf = User::where('category','STF')->pluck('id');

        $staff = Staff::where('staff_id', Auth::user()->id)->first();

        if($staff->staff_code == 'IITU') {

            $list = Aduan::whereIn('status_aduan', ['AS','LK','LU'])->whereIn('id_pelapor', $stf)->with(['kategori','status','tahap'])->whereIn('kategori_aduan', ['IITU-HDWR','IITU-NTWK','IITU-SYS','IITU-OPR_EMEL','IITU-OPR_SFWR','IITU-NTWK WIRELESS'])->select('cms_aduan.*');
        } elseif($staff->staff_code == 'OFM' || $staff->staff_code == 'AA') {

            $list = Aduan::whereIn('status_aduan', ['AS','LK','LU'])->whereIn('id_pelapor', $stf)->with(['kategori','status','tahap'])->whereIn('kategori_aduan', ['AWM','ELK','MKL','PKH','TKM'])->select('cms_aduan.*');
        } else {

            $list = Aduan::whereIn('status_aduan', ['AS','LK','LU'])->whereIn('id_pelapor', $stf)->with(['kategori','status','tahap'])->select('cms_aduan.*');
        }

        return datatables()::of($list)
        ->addColumn('action', function ($list) {

            if($list->status_aduan == 'DJ') {
                return '<div class="btn-group"><a href="/info-aduan/' . $list->id.'" class="btn btn-sm btn-info mr-2"><i class="fal fa-pencil"></i></a>
                        <a data-page="/download/' . $list->id.'" class="btn btn-sm btn-primary text-white mr-2" onclick="Print(this)"><i class="fal fa-file"></i></a></div>';
            } else {
                return '<div class="btn-group"><a href="/info-aduan/' . $list->id.'" class="btn btn-sm btn-info mr-2"><i class="fal fa-pencil"></i></a></div>';
            }
        })

        ->editColumn('id', function ($list) {

            return '#'.$list->id;
        })

        ->editColumn('nama_pelapor', function ($list) {

            return $list->nama_pelapor;
        })

        ->editColumn('tarikh_laporan', function ($list) {

            return date(' Y-m-d ', strtotime($list->tarikh_laporan) );
        })

        ->editColumn('kategori_aduan', function ($list) {

            return $list->kategori->nama_kategori ?? '';
        })

        ->editColumn('status_aduan', function ($list) {

            if($list->status_aduan=='AS')
            {
                return '<span class="badge badge-success">' . strtoupper($list->status->nama_status) . '</span>';

            }
            if($list->status_aduan=='LK')
            {
                return '<span class="badge badge-success2">' . strtoupper($list->status->nama_status) . '</span>';
            }
            else
            {
                return '<span class="badge badge-success2">' . strtoupper($list->status->nama_status) . '</span>';
            }
        })

        ->editColumn('tahap_kategori', function ($list) {

            if($list->tahap_kategori=='B')
            {
                return '<span class="low" data-toggle="tooltip" data-placement="top" title="BIASA">' . '</span>';
            }
            elseif($list->tahap_kategori=='S')
            {
                return '<span class="medium" data-toggle="tooltip" data-placement="top" title="SEGERA">' . '</span>';
            }
            else
            {
                return '<span class="none" data-toggle="tooltip" data-placement="top" title="BELUM DITENTUKAN">' . '</span>';
            }
        })

        ->rawColumns(['id', 'action', 'tahap_kategori', 'status_aduan', 'kategori_aduan', 'nama_pelapor', 'tarikh_laporan'])
        ->make(true);
    }

    public function data_selesai_pelajar()
    {
        $std = User::where('category','STD')->pluck('id');

        $staff = Staff::where('staff_id', Auth::user()->id)->first();

        if($staff->staff_code == 'IITU') {

            $list = Aduan::whereIn('status_aduan', ['AS','LK','LU'])->whereIn('id_pelapor', $std)->with(['kategori','status','tahap'])->whereIn('kategori_aduan', ['IITU-HDWR','IITU-NTWK','IITU-SYS','IITU-OPR_EMEL','IITU-OPR_SFWR','IITU-NTWK WIRELESS'])->select('cms_aduan.*');
        } elseif($staff->staff_code == 'OFM' || $staff->staff_code == 'AA') {

            $list = Aduan::whereIn('status_aduan', ['AS','LK','LU'])->whereIn('id_pelapor', $std)->with(['kategori','status','tahap'])->whereIn('kategori_aduan', ['AWM','ELK','MKL','PKH','TKM'])->select('cms_aduan.*');
        } else {

            $list = Aduan::whereIn('status_aduan', ['AS','LK','LU'])->whereIn('id_pelapor', $std)->with(['kategori','status','tahap'])->select('cms_aduan.*');
        }

        return datatables()::of($list)
        ->addColumn('action', function ($list) {

            if($list->status_aduan == 'DJ') {
                return '<div class="btn-group"><a href="/info-aduan/' . $list->id.'" class="btn btn-sm btn-info mr-2"><i class="fal fa-pencil"></i></a>
                        <a data-page="/download/' . $list->id.'" class="btn btn-sm btn-primary text-white mr-2" onclick="Print(this)"><i class="fal fa-file"></i></a></div>';
            } else {
                return '<div class="btn-group"><a href="/info-aduan/' . $list->id.'" class="btn btn-sm btn-info mr-2"><i class="fal fa-pencil"></i></a></div>';
            }
        })

        ->editColumn('id', function ($list) {

            return '#'.$list->id;
        })

        ->editColumn('nama_pelapor', function ($list) {

            return $list->nama_pelapor;
        })

        ->editColumn('tarikh_laporan', function ($list) {

            return date(' Y-m-d ', strtotime($list->tarikh_laporan) );
        })

        ->editColumn('kategori_aduan', function ($list) {

            return $list->kategori->nama_kategori ?? '';
        })

        ->editColumn('status_aduan', function ($list) {

            if($list->status_aduan=='AS')
            {
                return '<span class="badge badge-success">' . strtoupper($list->status->nama_status) . '</span>';

            }
            if($list->status_aduan=='LK')
            {
                return '<span class="badge badge-success2">' . strtoupper($list->status->nama_status) . '</span>';
            }
            else
            {
                return '<span class="badge badge-success2">' . strtoupper($list->status->nama_status) . '</span>';
            }
        })

        ->editColumn('tahap_kategori', function ($list) {

            if($list->tahap_kategori=='B')
            {
                return '<span class="low" data-toggle="tooltip" data-placement="top" title="BIASA">' . '</span>';
            }
            elseif($list->tahap_kategori=='S')
            {
                return '<span class="medium" data-toggle="tooltip" data-placement="top" title="SEGERA">' . '</span>';
            }
            else
            {
                return '<span class="none" data-toggle="tooltip" data-placement="top" title="BELUM DITENTUKAN">' . '</span>';
            }
        })

        ->rawColumns(['id', 'action', 'tahap_kategori', 'status_aduan', 'kategori_aduan', 'nama_pelapor', 'tarikh_laporan'])
        ->make(true);
    }

    public function senaraiKiv(Request $request)
    {
        return view('aduan.senarai-aduan-kiv');
    }

    public function data_kiv()
    {
        $stf = User::where('category','STF')->pluck('id');

        $staff = Staff::where('staff_id', Auth::user()->id)->first();

        if($staff->staff_code == 'IITU') {

            $list = Aduan::whereIn('status_aduan', ['AK'])->whereIn('id_pelapor', $stf)->with(['kategori','status','tahap'])->whereIn('kategori_aduan', ['IITU-HDWR','IITU-NTWK','IITU-SYS','IITU-OPR_EMEL','IITU-OPR_SFWR','IITU-NTWK WIRELESS'])->select('cms_aduan.*');
        } elseif($staff->staff_code == 'OFM' || $staff->staff_code == 'AA') {

            $list = Aduan::whereIn('status_aduan', ['AK'])->whereIn('id_pelapor', $stf)->with(['kategori','status','tahap'])->whereIn('kategori_aduan', ['AWM','ELK','MKL','PKH','TKM'])->select('cms_aduan.*');
        } else {

            $list = Aduan::whereIn('status_aduan', ['AK'])->whereIn('id_pelapor', $stf)->with(['kategori','status','tahap'])->select('cms_aduan.*');
        }

        return datatables()::of($list)
        ->addColumn('action', function ($list) {

            if($list->status_aduan == 'DJ') {
                return '<div class="btn-group"><a href="/info-aduan/' . $list->id.'" class="btn btn-sm btn-info mr-2"><i class="fal fa-pencil"></i></a>
                        <a data-page="/download/' . $list->id.'" class="btn btn-sm btn-primary text-white mr-2" onclick="Print(this)"><i class="fal fa-file"></i></a></div>';
            } else {
                return '<div class="btn-group"><a href="/info-aduan/' . $list->id.'" class="btn btn-sm btn-info mr-2"><i class="fal fa-pencil"></i></a></div>';
            }
        })

        ->editColumn('id', function ($list) {

            return '#'.$list->id;
        })

        ->editColumn('nama_pelapor', function ($list) {

            return $list->nama_pelapor;
        })

        ->editColumn('tarikh_laporan', function ($list) {

            return date(' Y-m-d ', strtotime($list->tarikh_laporan) );
        })

        ->editColumn('kategori_aduan', function ($list) {

            return $list->kategori->nama_kategori ?? '';
        })

        ->editColumn('status_aduan', function ($list) {

            return '<span class="badge badge-kiv">' . strtoupper($list->status->nama_status) . '</span>';
        })

        ->editColumn('tahap_kategori', function ($list) {

            if($list->tahap_kategori=='B')
            {
                return '<span class="low" data-toggle="tooltip" data-placement="top" title="BIASA">' . '</span>';
            }
            elseif($list->tahap_kategori=='S')
            {
                return '<span class="medium" data-toggle="tooltip" data-placement="top" title="SEGERA">' . '</span>';
            }
            else
            {
                return '<span class="none" data-toggle="tooltip" data-placement="top" title="BELUM DITENTUKAN">' . '</span>';
            }
        })

        ->rawColumns(['id', 'action', 'tahap_kategori', 'status_aduan', 'kategori_aduan', 'nama_pelapor', 'tarikh_laporan'])
        ->make(true);
    }

    public function data_kiv_pelajar()
    {
        $std = User::where('category','STD')->pluck('id');

        $staff = Staff::where('staff_id', Auth::user()->id)->first();

        if($staff->staff_code == 'IITU') {

            $list = Aduan::whereIn('status_aduan', ['AK'])->whereIn('id_pelapor', $std)->with(['kategori','status','tahap'])->whereIn('kategori_aduan', ['IITU-HDWR','IITU-NTWK','IITU-SYS','IITU-OPR_EMEL','IITU-OPR_SFWR','IITU-NTWK WIRELESS'])->select('cms_aduan.*');
        } elseif($staff->staff_code == 'OFM' || $staff->staff_code == 'AA') {

            $list = Aduan::whereIn('status_aduan', ['AK'])->whereIn('id_pelapor', $std)->with(['kategori','status','tahap'])->whereIn('kategori_aduan', ['AWM','ELK','MKL','PKH','TKM'])->select('cms_aduan.*');
        } else {

            $list = Aduan::whereIn('status_aduan', ['AK'])->whereIn('id_pelapor', $std)->with(['kategori','status','tahap'])->select('cms_aduan.*');
        }

        return datatables()::of($list)
        ->addColumn('action', function ($list) {

            if($list->status_aduan == 'DJ') {
                return '<div class="btn-group"><a href="/info-aduan/' . $list->id.'" class="btn btn-sm btn-info mr-2"><i class="fal fa-pencil"></i></a>
                        <a data-page="/download/' . $list->id.'" class="btn btn-sm btn-primary text-white mr-2" onclick="Print(this)"><i class="fal fa-file"></i></a></div>';
            } else {
                return '<div class="btn-group"><a href="/info-aduan/' . $list->id.'" class="btn btn-sm btn-info mr-2"><i class="fal fa-pencil"></i></a></div>';
            }
        })

        ->editColumn('id', function ($list) {

            return '#'.$list->id;
        })

        ->editColumn('nama_pelapor', function ($list) {

            return $list->nama_pelapor;
        })

        ->editColumn('tarikh_laporan', function ($list) {

            return date(' Y-m-d ', strtotime($list->tarikh_laporan) );
        })

        ->editColumn('kategori_aduan', function ($list) {

            return $list->kategori->nama_kategori ?? '';
        })

        ->editColumn('status_aduan', function ($list) {

            return '<span class="badge badge-kiv">' . strtoupper($list->status->nama_status) . '</span>';
        })

        ->editColumn('tahap_kategori', function ($list) {

            if($list->tahap_kategori=='B')
            {
                return '<span class="low" data-toggle="tooltip" data-placement="top" title="BIASA">' . '</span>';
            }
            elseif($list->tahap_kategori=='S')
            {
                return '<span class="medium" data-toggle="tooltip" data-placement="top" title="SEGERA">' . '</span>';
            }
            else
            {
                return '<span class="none" data-toggle="tooltip" data-placement="top" title="BELUM DITENTUKAN">' . '</span>';
            }
        })

        ->rawColumns(['id', 'action', 'tahap_kategori', 'status_aduan', 'kategori_aduan', 'nama_pelapor', 'tarikh_laporan'])
        ->make(true);
    }

    public function senaraiBertindih(Request $request)
    {
        return view('aduan.senarai-aduan-bertindih');
    }

    public function data_bertindih()
    {
        $stf = User::where('category','STF')->pluck('id');

        $staff = Staff::where('staff_id', Auth::user()->id)->first();

        if($staff->staff_code == 'IITU') {

            $list = Aduan::whereIn('status_aduan', ['DP'])->whereIn('id_pelapor', $stf)->with(['kategori','status','tahap'])->whereIn('kategori_aduan', ['IITU-HDWR','IITU-NTWK','IITU-SYS','IITU-OPR_EMEL','IITU-OPR_SFWR','IITU-NTWK WIRELESS'])->select('cms_aduan.*');
        } elseif($staff->staff_code == 'OFM' || $staff->staff_code == 'AA') {

            $list = Aduan::whereIn('status_aduan', ['DP'])->whereIn('id_pelapor', $stf)->with(['kategori','status','tahap'])->whereIn('kategori_aduan', ['AWM','ELK','MKL','PKH','TKM'])->select('cms_aduan.*');
        } else {

            $list = Aduan::whereIn('status_aduan', ['DP'])->whereIn('id_pelapor', $stf)->with(['kategori','status','tahap'])->select('cms_aduan.*');
        }

        return datatables()::of($list)
        ->addColumn('action', function ($list) {

            if($list->status_aduan == 'DJ') {
                return '<div class="btn-group"><a href="/info-aduan/' . $list->id.'" class="btn btn-sm btn-info mr-2"><i class="fal fa-pencil"></i></a>
                        <a data-page="/download/' . $list->id.'" class="btn btn-sm btn-primary text-white mr-2" onclick="Print(this)"><i class="fal fa-file"></i></a></div>';
            } else {
                return '<div class="btn-group"><a href="/info-aduan/' . $list->id.'" class="btn btn-sm btn-info mr-2"><i class="fal fa-pencil"></i></a></div>';
            }
        })

        ->editColumn('id', function ($list) {

            return '#'.$list->id;
        })

        ->editColumn('nama_pelapor', function ($list) {

            return $list->nama_pelapor;
        })

        ->editColumn('tarikh_laporan', function ($list) {

            return date(' Y-m-d ', strtotime($list->tarikh_laporan) );
        })

        ->editColumn('kategori_aduan', function ($list) {

            return $list->kategori->nama_kategori ?? '';
        })

        ->editColumn('status_aduan', function ($list) {

            return '<span class="badge badge-duplicate">' . strtoupper($list->status->nama_status) . '</span>';
        })

        ->editColumn('tahap_kategori', function ($list) {

            if($list->tahap_kategori=='B')
            {
                return '<span class="low" data-toggle="tooltip" data-placement="top" title="BIASA">' . '</span>';
            }
            elseif($list->tahap_kategori=='S')
            {
                return '<span class="medium" data-toggle="tooltip" data-placement="top" title="SEGERA">' . '</span>';
            }
            else
            {
                return '<span class="none" data-toggle="tooltip" data-placement="top" title="BELUM DITENTUKAN">' . '</span>';
            }
        })

        ->rawColumns(['id', 'action', 'tahap_kategori', 'status_aduan', 'kategori_aduan', 'nama_pelapor', 'tarikh_laporan'])
        ->make(true);
    }

    public function data_bertindih_pelajar()
    {
        $std = User::where('category','STD')->pluck('id');

        $staff = Staff::where('staff_id', Auth::user()->id)->first();

        if($staff->staff_code == 'IITU') {

            $list = Aduan::whereIn('status_aduan', ['DP'])->whereIn('id_pelapor', $std)->with(['kategori','status','tahap'])->whereIn('kategori_aduan', ['IITU-HDWR','IITU-NTWK','IITU-SYS','IITU-OPR_EMEL','IITU-OPR_SFWR','IITU-NTWK WIRELESS'])->select('cms_aduan.*');
        } elseif($staff->staff_code == 'OFM' || $staff->staff_code == 'AA') {

            $list = Aduan::whereIn('status_aduan', ['DP'])->whereIn('id_pelapor', $std)->with(['kategori','status','tahap'])->whereIn('kategori_aduan', ['AWM','ELK','MKL','PKH','TKM'])->select('cms_aduan.*');
        } else {

            $list = Aduan::whereIn('status_aduan', ['DP'])->whereIn('id_pelapor', $std)->with(['kategori','status','tahap'])->select('cms_aduan.*');
        }

        return datatables()::of($list)
        ->addColumn('action', function ($list) {

            if($list->status_aduan == 'DJ') {
                return '<div class="btn-group"><a href="/info-aduan/' . $list->id.'" class="btn btn-sm btn-info mr-2"><i class="fal fa-pencil"></i></a>
                        <a data-page="/download/' . $list->id.'" class="btn btn-sm btn-primary text-white mr-2" onclick="Print(this)"><i class="fal fa-file"></i></a></div>';
            } else {
                return '<div class="btn-group"><a href="/info-aduan/' . $list->id.'" class="btn btn-sm btn-info mr-2"><i class="fal fa-pencil"></i></a></div>';
            }
        })

        ->editColumn('id', function ($list) {

            return '#'.$list->id;
        })

        ->editColumn('nama_pelapor', function ($list) {

            return $list->nama_pelapor;
        })

        ->editColumn('tarikh_laporan', function ($list) {

            return date(' Y-m-d ', strtotime($list->tarikh_laporan) );
        })

        ->editColumn('kategori_aduan', function ($list) {

            return $list->kategori->nama_kategori ?? '';
        })

        ->editColumn('status_aduan', function ($list) {

            return '<span class="badge badge-duplicate">' . strtoupper($list->status->nama_status) . '</span>';
        })

        ->editColumn('tahap_kategori', function ($list) {

            if($list->tahap_kategori=='B')
            {
                return '<span class="low" data-toggle="tooltip" data-placement="top" title="BIASA">' . '</span>';
            }
            elseif($list->tahap_kategori=='S')
            {
                return '<span class="medium" data-toggle="tooltip" data-placement="top" title="SEGERA">' . '</span>';
            }
            else
            {
                return '<span class="none" data-toggle="tooltip" data-placement="top" title="BELUM DITENTUKAN">' . '</span>';
            }
        })

        ->rawColumns(['id', 'action', 'tahap_kategori', 'status_aduan', 'kategori_aduan', 'nama_pelapor', 'tarikh_laporan'])
        ->make(true);
    }

    public function simpanStatus(Request $request)
    {
        $aduan = Aduan::where('id', $request->ide)->first();

        $aduan->update([
            'status_aduan'           => $request->status_aduan,
            'catatan_pembaikan'      => $request->catatan_pembaikan,
        ]);

        $emel = $aduan->emel_pelapor;

        $data2 = [
            'nama_penerima' => 'Assalamualaikum wbt & Salam Sejahtera, Tuan/Puan/Encik/Cik ' . $aduan->nama_pelapor,
            'penerangan' => 'Aduan yang dilaporkan bertarikh '.$aduan->tarikh_laporan. ' telah selesai dilakukan penambahbaikan. Sila log masuk sistem IDS untuk melakukan pengesahan.',
        ];

        Mail::send('aduan.emel-aduan', $data2, function ($message) use ($emel, $aduan) {
            $message->subject('EADUAN: PENGESAHAN PENAMBAHBAIKAN ADUAN');
            $message->from(Auth::user()->email);
            $message->to($emel);
        });

        Session::flash('simpanCatatan', 'Maklumat pengesahan penambahbaikan telah dihantar dan direkodkan.');
        return redirect('info-aduan/'.$aduan->id);
    }

    public function padamGambar($id, $id_aduan)
    {
        $aduan = Aduan::where('id',$id_aduan)->first();
        $imej = ImejPembaikan::find($id);
        $imej->delete($aduan);

        return redirect()->back()->with('messages', 'Imej Pembaikan Berjaya Dipadam');
    }

    // Senarai Aduan Juruteknik

    public function hantarNotis(Request $request)
    {
        $request->validate([
            'notis_juruteknik'         => 'required',
        ]);

        $aduan = Aduan::where('id', $request->ids)->update([
            'notis_juruteknik'          => $request->notis_juruteknik,
        ]);

        Session::flash('notis', 'Notis aduan telah berjaya ditukar. Notis akan dipaparkan dalam senarai aduan pengadu.');
        return redirect('/senarai-aduan-juruteknik');
    }

    public function senaraiAduanJuruteknik()
    {
        $status = StatusAduan::whereIn('kod_status', ['AS', 'LK', 'LU'])->get();

        return view('aduan.senarai-aduan-juruteknik', compact('status'));
    }

    public function data_senarai_juruteknik()
    {
        $stf = User::where('category','STF')->pluck('id');

        $list = JuruteknikBertugas::where('juruteknik_bertugas', Auth::user()->id)->whereHas('aduan', function($query) use($stf){
            $query->whereIn('id_pelapor', $stf)->whereIn('status_aduan', ['DJ','TD']);
        })->with(['juruteknik','aduan.kategori','aduan.tahap','aduan.status','aduan'])->get();

        return datatables()::of($list)
        ->addColumn('action', function ($list) {

            if($list->aduan->status_aduan=='DJ') {
                return '<div class="btn-group"><a href="/info-aduan/' . $list->id_aduan.'" class="btn btn-sm btn-info mr-2"><i class="fal fa-pencil"></i></a>
                        <a data-page="/download/' . $list->id_aduan.'" class="btn btn-sm btn-primary text-white" onclick="Print(this)"><i class="fal fa-file"></i></a></div>';
            } else {
                return '<a href="/info-aduan/' . $list->id_aduan.'" class="btn btn-sm btn-info"><i class="fal fa-pencil"></i></a>';
            }
        })

        ->editColumn('id', function ($list) {

            return '#'.$list->id_aduan;
        })

        ->editColumn('nama_pelapor', function ($list) {

            return $list->aduan->nama_pelapor;
        })

        ->editColumn('tarikh_laporan', function ($list) {

            return date(' Y-m-d ', strtotime($list->aduan->tarikh_laporan) );
        })

        ->editColumn('kategori_aduan', function ($list) {

            return $list->aduan->kategori->nama_kategori ?? '';
        })

        ->editColumn('status_aduan', function ($list) {

            if($list->aduan->status_aduan=='BS')
            {
                return '<span class="badge badge-new">' . strtoupper($list->aduan->status->nama_status) . '</span>';
            }
            if($list->aduan->status_aduan=='DJ')
            {
                return '<span class="badge badge-sent">' . strtoupper($list->aduan->status->nama_status) . '</span>';
            }
            else
            {
                return '<span class="badge badge-done">' . strtoupper($list->aduan->status->nama_status) . '</span>';
            }

        })

        ->editColumn('tempoh', function ($list) {

            if(isset($list->aduan->tarikh_selesai_aduan))
            {
                $tempoh = Carbon::parse($list->aduan->tarikh_laporan)->diffInDays($list->aduan->tarikh_selesai_aduan);

            } else {

                $tempoh = Carbon::parse($list->aduan->tarikh_laporan)->diffInDays(Carbon::now());
            }

            return $tempoh.' hari';
        })

        ->editColumn('tahap_kategori', function ($list) {

            if($list->aduan->tahap_kategori=='B')
            {
                return '<span class="low" data-toggle="tooltip" data-placement="top" title="BIASA">' . '</span>';
            }
            elseif($list->aduan->tahap_kategori=='S')
            {
                return '<span class="medium" data-toggle="tooltip" data-placement="top" title="SEGERA">' . '</span>';
            }
            else
            {
                return '<span class="none" data-toggle="tooltip" data-placement="top" title="BELUM DITENTUKAN">' . '</span>';
            }
        })

        ->addColumn('notis', function ($list) {

            return '<a href="" class="btn btn-sm btn-warning" data-target="#crud-modals" data-toggle="modal" data-id="'. $list->id_aduan.'" data-notis="'. $list->aduan->notis_juruteknik.'"><i class="fal fa-pencil"></i></a>';
        })

        ->rawColumns(['id', 'action', 'tahap_kategori', 'status_aduan', 'kategori_aduan', 'nama_pelapor', 'tempoh', 'tarikh_laporan','notis'])
        ->make(true);
    }

    public function data_senarai_juruteknik_pelajar()
    {
        $std = User::where('category','STD')->pluck('id');

        $list = JuruteknikBertugas::where('juruteknik_bertugas', Auth::user()->id)->whereHas('aduan', function($query) use($std) {
            $query->whereIn('id_pelapor', $std)->whereIn('status_aduan', ['DJ','TD']);
        })->with(['juruteknik','aduan.kategori','aduan.tahap','aduan.status','aduan'])->get();

        return datatables()::of($list)
        ->addColumn('action', function ($list) {

            if($list->aduan->status_aduan=='DJ') {
                return '<div class="btn-group"><a href="/info-aduan/' . $list->id_aduan.'" class="btn btn-sm btn-info mr-2"><i class="fal fa-pencil"></i></a>
                        <a data-page="/download/' . $list->id_aduan.'" class="btn btn-sm btn-primary text-white" onclick="Print(this)"><i class="fal fa-file"></i></a></div>';
            } else {
                return '<a href="/info-aduan/' . $list->id_aduan.'" class="btn btn-sm btn-info"><i class="fal fa-pencil"></i></a>';
            }

        })

        ->editColumn('id', function ($list) {

            return '#'.$list->id_aduan;
        })

        ->editColumn('nama_pelapor', function ($list) {

            return $list->aduan->nama_pelapor;
        })

        ->editColumn('tarikh_laporan', function ($list) {

            return date(' Y-m-d ', strtotime($list->aduan->tarikh_laporan) );
        })

        ->editColumn('kategori_aduan', function ($list) {

            return $list->aduan->kategori->nama_kategori ?? '';
        })

        ->editColumn('status_aduan', function ($list) {

            if($list->aduan->status_aduan=='BS')
            {
                return '<span class="badge badge-new">' . strtoupper($list->aduan->status->nama_status) . '</span>';
            }
            if($list->aduan->status_aduan=='DJ')
            {
                return '<span class="badge badge-sent">' . strtoupper($list->aduan->status->nama_status) . '</span>';
            }
            else
            {
                return '<span class="badge badge-done">' . strtoupper($list->aduan->status->nama_status) . '</span>';
            }

        })

        ->editColumn('tempoh', function ($list) {

            if(isset($list->aduan->tarikh_selesai_aduan))
            {
                $tempoh = Carbon::parse($list->aduan->tarikh_laporan)->diffInDays($list->aduan->tarikh_selesai_aduan);

            } else {

                $tempoh = Carbon::parse($list->aduan->tarikh_laporan)->diffInDays(Carbon::now());
            }

            return $tempoh.' hari';
        })

        ->editColumn('tahap_kategori', function ($list) {

            if($list->aduan->tahap_kategori=='B')
            {
                return '<span class="low" data-toggle="tooltip" data-placement="top" title="BIASA">' . '</span>';
            }
            elseif($list->aduan->tahap_kategori=='S')
            {
                return '<span class="medium" data-toggle="tooltip" data-placement="top" title="SEGERA">' . '</span>';
            }
            else
            {
                return '<span class="none" data-toggle="tooltip" data-placement="top" title="BELUM DITENTUKAN">' . '</span>';
            }
        })

        ->addColumn('notis', function ($list) {

            return '<a href="" class="btn btn-sm btn-warning" data-target="#crud-modals" data-toggle="modal" data-id="'. $list->id.'" data-notis="'. $list->aduan->notis_juruteknik.'"><i class="fal fa-pencil"></i></a>';
        })

        ->rawColumns(['id', 'action', 'tahap_kategori', 'status_aduan', 'kategori_aduan', 'nama_pelapor', 'tempoh', 'tarikh_laporan','notis'])
        ->make(true);
    }

    public function senaraiSelesaiJuruteknik()
    {
        $aduan = Aduan::all();

        $juruteknik = User::whereHas('roles', function($query){
            $query->where('id', 'CMS002');
        })->get();

        return view('aduan.senarai-aduan-selesai-juruteknik', compact('aduan', 'juruteknik'))->with('no', 1);
    }

    public function data_selesai_juruteknik()
    {
        $stf = User::where('category','STF')->pluck('id');

        $list = JuruteknikBertugas::where('juruteknik_bertugas', Auth::user()->id)->whereHas('aduan', function($query) use($stf) {
            $query->whereIn('id_pelapor', $stf)->whereIn('status_aduan', ['AS','LK','LU']);
        })->with(['juruteknik','aduan.kategori','aduan.tahap','aduan.status','aduan'])->get();

        return datatables()::of($list)
        ->addColumn('action', function ($list) {

            if($list->aduan->status_aduan=='DJ') {
                return '<div class="btn-group"><a href="/info-aduan/' . $list->id_aduan.'" class="btn btn-sm btn-info mr-2"><i class="fal fa-pencil"></i></a>
                        <a data-page="/download/' . $list->id_aduan.'" class="btn btn-sm btn-primary text-white" onclick="Print(this)"><i class="fal fa-file"></i></a></div>';
            } else {
                return '<a href="/info-aduan/' . $list->id_aduan.'" class="btn btn-sm btn-info"><i class="fal fa-pencil"></i></a>';
            }

        })

        ->editColumn('id', function ($list) {

            return '#'.$list->id_aduan;
        })

        ->editColumn('nama_pelapor', function ($list) {

            return $list->aduan->nama_pelapor;
        })

        ->editColumn('tarikh_laporan', function ($list) {

            return date(' Y-m-d ', strtotime($list->aduan->tarikh_laporan) );
        })

        ->editColumn('kategori_aduan', function ($list) {

            return $list->aduan->kategori->nama_kategori ?? '';
        })

        ->editColumn('status_aduan', function ($list) {

            if($list->aduan->status_aduan=='AS')
            {
                return '<span class="badge badge-success">' . strtoupper($list->aduan->status->nama_status) . '</span>';
            }
            if($list->aduan->status_aduan=='LK')
            {
                return '<span class="badge badge-success2">' . strtoupper($list->aduan->status->nama_status) . '</span>';
            }
            else
            {
                return '<span class="badge badge-success2">' . strtoupper($list->aduan->status->nama_status) . '</span>';
            }

        })

        ->editColumn('tahap_kategori', function ($list) {

            if($list->aduan->tahap_kategori=='B')
            {
                return '<span class="low" data-toggle="tooltip" data-placement="top" title="BIASA">' . '</span>';
            }
            elseif($list->aduan->tahap_kategori=='S')
            {
                return '<span class="medium" data-toggle="tooltip" data-placement="top" title="SEGERA">' . '</span>';
            }
            else
            {
                return '<span class="none" data-toggle="tooltip" data-placement="top" title="BELUM DITENTUKAN">' . '</span>';
            }
        })

        ->rawColumns(['id', 'action', 'tahap_kategori', 'status_aduan', 'kategori_aduan', 'nama_pelapor', 'tarikh_laporan'])
        ->make(true);
    }

    public function data_selesai_juruteknik_pelajar()
    {
        $std = User::where('category','STD')->pluck('id');

        $list = JuruteknikBertugas::where('juruteknik_bertugas', Auth::user()->id)->whereHas('aduan', function($query) use($std) {
            $query->whereIn('id_pelapor', $std)->whereIn('status_aduan', ['AS','LK','LU']);
        })->with(['juruteknik','aduan.kategori','aduan.tahap','aduan.status','aduan'])->get();

        return datatables()::of($list)
        ->addColumn('action', function ($list) {

            if($list->aduan->status_aduan=='DJ') {
                return '<div class="btn-group"><a href="/info-aduan/' . $list->id_aduan.'" class="btn btn-sm btn-info mr-2"><i class="fal fa-pencil"></i></a>
                        <a data-page="/download/' . $list->id_aduan.'" class="btn btn-sm btn-primary text-white" onclick="Print(this)"><i class="fal fa-file"></i></a></div>';
            } else {
                return '<a href="/info-aduan/' . $list->id_aduan.'" class="btn btn-sm btn-info"><i class="fal fa-pencil"></i></a>';
            }
        })

        ->editColumn('id', function ($list) {

            return '#'.$list->id_aduan;
        })

        ->editColumn('nama_pelapor', function ($list) {

            return $list->aduan->nama_pelapor;
        })

        ->editColumn('tarikh_laporan', function ($list) {

            return date(' Y-m-d ', strtotime($list->aduan->tarikh_laporan) );
        })

        ->editColumn('kategori_aduan', function ($list) {

            return $list->aduan->kategori->nama_kategori ?? '';
        })

        ->editColumn('status_aduan', function ($list) {

            if($list->aduan->status_aduan=='AS')
            {
                return '<span class="badge badge-success">' . strtoupper($list->aduan->status->nama_status) . '</span>';
            }
            if($list->aduan->status_aduan=='LK')
            {
                return '<span class="badge badge-success2">' . strtoupper($list->aduan->status->nama_status) . '</span>';
            }
            else
            {
                return '<span class="badge badge-success2">' . strtoupper($list->aduan->status->nama_status) . '</span>';
            }
        })

        ->editColumn('tahap_kategori', function ($list) {

            if($list->aduan->tahap_kategori=='B')
            {
                return '<span class="low" data-toggle="tooltip" data-placement="top" title="BIASA">' . '</span>';
            }
            elseif($list->aduan->tahap_kategori=='S')
            {
                return '<span class="medium" data-toggle="tooltip" data-placement="top" title="SEGERA">' . '</span>';
            }
            else
            {
                return '<span class="none" data-toggle="tooltip" data-placement="top" title="BELUM DITENTUKAN">' . '</span>';
            }
        })

        ->rawColumns(['id', 'action', 'tahap_kategori', 'status_aduan', 'kategori_aduan', 'nama_pelapor', 'tarikh_laporan'])
        ->make(true);
    }

    public function senaraiKivJuruteknik()
    {
        return view('aduan.senarai-aduan-kiv-juruteknik');
    }

    public function data_kiv_juruteknik()
    {
        $stf = User::where('category','STF')->pluck('id');

        $list = JuruteknikBertugas::where('juruteknik_bertugas', Auth::user()->id)->whereHas('aduan', function($query) use($stf) {
            $query->whereIn('id_pelapor', $stf)->whereIn('status_aduan', ['AK']);
        })->with(['juruteknik','aduan.kategori','aduan.tahap','aduan.status','aduan'])->get();

        return datatables()::of($list)
        ->addColumn('action', function ($list) {

            if($list->aduan->status_aduan=='DJ') {
                return '<div class="btn-group"><a href="/info-aduan/' . $list->id_aduan.'" class="btn btn-sm btn-info mr-2"><i class="fal fa-pencil"></i></a>
                        <a data-page="/download/' . $list->id_aduan.'" class="btn btn-sm btn-primary text-white" onclick="Print(this)"><i class="fal fa-file"></i></a></div>';
            } else {
                return '<a href="/info-aduan/' . $list->id_aduan.'" class="btn btn-sm btn-info"><i class="fal fa-pencil"></i></a>';
            }
        })

        ->editColumn('id', function ($list) {

            return '#'.$list->id_aduan;
        })

        ->editColumn('nama_pelapor', function ($list) {

            return $list->aduan->nama_pelapor;
        })

        ->editColumn('tarikh_laporan', function ($list) {

            return date(' Y-m-d ', strtotime($list->aduan->tarikh_laporan) );
        })

        ->editColumn('kategori_aduan', function ($list) {

            return $list->aduan->kategori->nama_kategori ?? '';
        })

        ->editColumn('status_aduan', function ($list) {

            return '<span class="badge badge-kiv">' . strtoupper($list->aduan->status->nama_status) . '</span>';
        })

        ->editColumn('tahap_kategori', function ($list) {

            if($list->aduan->tahap_kategori=='B')
            {
                return '<span class="low" data-toggle="tooltip" data-placement="top" title="BIASA">' . '</span>';
            }
            elseif($list->aduan->tahap_kategori=='S')
            {
                return '<span class="medium" data-toggle="tooltip" data-placement="top" title="SEGERA">' . '</span>';
            }
            else
            {
                return '<span class="none" data-toggle="tooltip" data-placement="top" title="BELUM DITENTUKAN">' . '</span>';
            }
        })

        ->rawColumns(['id', 'action', 'tahap_kategori', 'status_aduan', 'kategori_aduan', 'nama_pelapor', 'tarikh_laporan'])
        ->make(true);
    }

    public function data_kiv_juruteknik_pelajar()
    {
        $std = User::where('category','STD')->pluck('id');

        $list = JuruteknikBertugas::where('juruteknik_bertugas', Auth::user()->id)->whereHas('aduan', function($query) use($std) {
            $query->whereIn('id_pelapor', $std)->whereIn('status_aduan', ['AK']);
        })->with(['juruteknik','aduan.kategori','aduan.tahap','aduan.status','aduan'])->get();

        return datatables()::of($list)
        ->addColumn('action', function ($list) {

            if($list->aduan->status_aduan=='DJ') {
                return '<div class="btn-group"><a href="/info-aduan/' . $list->id_aduan.'" class="btn btn-sm btn-info mr-2"><i class="fal fa-pencil"></i></a>
                        <a data-page="/download/' . $list->id_aduan.'" class="btn btn-sm btn-primary text-white" onclick="Print(this)"><i class="fal fa-file"></i></a></div>';
            } else {
                return '<a href="/info-aduan/' . $list->id_aduan.'" class="btn btn-sm btn-info"><i class="fal fa-pencil"></i></a>';
            }
        })

        ->editColumn('id', function ($list) {

            return '#'.$list->id_aduan;
        })

        ->editColumn('nama_pelapor', function ($list) {

            return $list->aduan->nama_pelapor;
        })

        ->editColumn('tarikh_laporan', function ($list) {

            return date(' Y-m-d ', strtotime($list->aduan->tarikh_laporan) );
        })

        ->editColumn('kategori_aduan', function ($list) {

            return $list->aduan->kategori->nama_kategori ?? '';
        })

        ->editColumn('status_aduan', function ($list) {

            return '<span class="badge badge-kiv">' . strtoupper($list->aduan->status->nama_status) . '</span>';
        })

        ->editColumn('tahap_kategori', function ($list) {

            if($list->aduan->tahap_kategori=='B')
            {
                return '<span class="low" data-toggle="tooltip" data-placement="top" title="BIASA">' . '</span>';
            }
            elseif($list->aduan->tahap_kategori=='S')
            {
                return '<span class="medium" data-toggle="tooltip" data-placement="top" title="SEGERA">' . '</span>';
            }
            else
            {
                return '<span class="none" data-toggle="tooltip" data-placement="top" title="BELUM DITENTUKAN">' . '</span>';
            }
        })

        ->rawColumns(['id', 'action', 'tahap_kategori', 'status_aduan', 'kategori_aduan', 'nama_pelapor', 'tarikh_laporan'])
        ->make(true);
    }

    public function senaraiBertindihJuruteknik()
    {
        return view('aduan.senarai-aduan-bertindih-juruteknik');
    }

    public function data_bertindih_juruteknik()
    {
        $stf = User::where('category','STF')->pluck('id');

        $list = JuruteknikBertugas::where('juruteknik_bertugas', Auth::user()->id)->whereHas('aduan', function($query) use($stf) {
            $query->whereIn('id_pelapor', $stf)->whereIn('status_aduan', ['DP']);
        })->with(['juruteknik','aduan.kategori','aduan.tahap','aduan.status','aduan'])->get();

        return datatables()::of($list)
        ->addColumn('action', function ($list) {

            if($list->aduan->status_aduan=='DJ') {
                return '<div class="btn-group"><a href="/info-aduan/' . $list->id_aduan.'" class="btn btn-sm btn-info mr-2"><i class="fal fa-pencil"></i></a>
                        <a data-page="/download/' . $list->id_aduan.'" class="btn btn-sm btn-primary text-white" onclick="Print(this)"><i class="fal fa-file"></i></a></div>';
            } else {
                return '<a href="/info-aduan/' . $list->id_aduan.'" class="btn btn-sm btn-info"><i class="fal fa-pencil"></i></a>';
            }
        })

        ->editColumn('id', function ($list) {

            return '#'.$list->id_aduan;
        })

        ->editColumn('nama_pelapor', function ($list) {

            return $list->aduan->nama_pelapor;
        })

        ->editColumn('tarikh_laporan', function ($list) {

            return date(' Y-m-d ', strtotime($list->aduan->tarikh_laporan) );
        })

        ->editColumn('kategori_aduan', function ($list) {

            return $list->aduan->kategori->nama_kategori ?? '';
        })

        ->editColumn('status_aduan', function ($list) {

            return '<span class="badge badge-duplicate">' . strtoupper($list->aduan->status->nama_status) . '</span>';
        })

        ->editColumn('tahap_kategori', function ($list) {

            if($list->aduan->tahap_kategori=='B')
            {
                return '<span class="low" data-toggle="tooltip" data-placement="top" title="BIASA">' . '</span>';
            }
            elseif($list->aduan->tahap_kategori=='S')
            {
                return '<span class="medium" data-toggle="tooltip" data-placement="top" title="SEGERA">' . '</span>';
            }
            else
            {
                return '<span class="none" data-toggle="tooltip" data-placement="top" title="BELUM DITENTUKAN">' . '</span>';
            }
        })

        ->rawColumns(['id', 'action', 'tahap_kategori', 'status_aduan', 'kategori_aduan', 'nama_pelapor', 'tarikh_laporan'])
        ->make(true);
    }

    public function data_bertindih_juruteknik_pelajar()
    {
        $std = User::where('category','STD')->pluck('id');

        $list = JuruteknikBertugas::where('juruteknik_bertugas', Auth::user()->id)->whereHas('aduan', function($query) use($std) {
            $query->whereIn('id_pelapor', $std)->whereIn('status_aduan', ['DP']);
        })->with(['juruteknik','aduan.kategori','aduan.tahap','aduan.status','aduan'])->get();

        return datatables()::of($list)
        ->addColumn('action', function ($list) {

            if($list->aduan->status_aduan=='DJ') {
                return '<div class="btn-group"><a href="/info-aduan/' . $list->id_aduan.'" class="btn btn-sm btn-info mr-2"><i class="fal fa-pencil"></i></a>
                        <a data-page="/download/' . $list->id_aduan.'" class="btn btn-sm btn-primary text-white" onclick="Print(this)"><i class="fal fa-file"></i></a></div>';
            } else {
                return '<a href="/info-aduan/' . $list->id_aduan.'" class="btn btn-sm btn-info"><i class="fal fa-pencil"></i></a>';
            }
        })

        ->editColumn('id', function ($list) {

            return '#'.$list->id_aduan;
        })

        ->editColumn('nama_pelapor', function ($list) {

            return $list->aduan->nama_pelapor;
        })

        ->editColumn('tarikh_laporan', function ($list) {

            return date(' Y-m-d ', strtotime($list->aduan->tarikh_laporan) );
        })

        ->editColumn('kategori_aduan', function ($list) {

            return $list->aduan->kategori->nama_kategori ?? '';
        })

        ->editColumn('status_aduan', function ($list) {

            return '<span class="badge badge-duplicate">' . strtoupper($list->aduan->status->nama_status) . '</span>';
        })

        ->editColumn('tahap_kategori', function ($list) {

            if($list->aduan->tahap_kategori=='B')
            {
                return '<span class="low" data-toggle="tooltip" data-placement="top" title="BIASA">' . '</span>';
            }
            elseif($list->aduan->tahap_kategori=='S')
            {
                return '<span class="medium" data-toggle="tooltip" data-placement="top" title="SEGERA">' . '</span>';
            }
            else
            {
                return '<span class="none" data-toggle="tooltip" data-placement="top" title="BELUM DITENTUKAN">' . '</span>';
            }
        })

        ->rawColumns(['id', 'action', 'tahap_kategori', 'status_aduan', 'kategori_aduan', 'nama_pelapor', 'tarikh_laporan'])
        ->make(true);
    }

    // Export & PDF

    public function pdfAduan(Request $request, $id)
    {
        $aduan = Aduan::where('id', $id)->first();

        $resit = ResitAduan::where('id_aduan', $id)->get();

        $imej = ImejAduan::where('id_aduan', $id)->get();

        $gambar = ImejPembaikan::where('id_aduan', $id)->get();

        $juruteknik = JuruteknikBertugas::where('id_aduan', $id)->orderBy('jenis_juruteknik', 'ASC')->get();

        $alatan_ganti = AlatanPembaikan::where('id_aduan', $id)->get();

        $pengadu = User::where('id', $aduan->id_pelapor)->first();

        return view('aduan.aduanPdf', compact('aduan', 'resit', 'imej', 'gambar', 'juruteknik','alatan_ganti','pengadu'));
    }

    public function aduan_all(Request $request)
    {
        $kategori = KategoriAduan::select('kod_kategori', 'nama_kategori')->get();
        $status = StatusAduan::select('kod_status', 'nama_status')->get();
        $tahap = TahapKategori::select('kod_tahap', 'jenis_tahap')->get();
        $bulan = Aduan::select('bulan_laporan')->groupBy('bulan_laporan')->orderBy('bulan_laporan', 'ASC')->get();

        $req_kategori = $request->kategori;
        $req_status = $request->status;
        $req_tahap = $request->tahap;
        $req_bulan = $request->bulan;

        $data = $datas = $datass =  '';

        if($request->kategori || $request->status || $request->tahap || $request->bulan)
        {
            $result = new Aduan();

            if($request->tahap != "")
            {
                $result = $result->where('tahap_kategori', $request->tahap);
            }

            if($request->status != "")
            {
                $result = $result->where('status_aduan', $request->status);
            }

            if($request->kategori != "")
            {
                $result = $result->where('kategori_aduan', $request->kategori);
            }

            if($request->bulan != "")
            {
                $result = $result->where('bulan_laporan', $request->bulan);
            }

            $data = $result->get();
        } else {
            $data = Aduan::all();
        }

        $this->aduans($request->kategori,$request->status,$request->tahap,$request->bulan);

        return view('aduan.laporan_excel', compact( 'tahap', 'kategori', 'status', 'bulan', 'data', 'req_kategori', 'req_status', 'req_tahap', 'req_bulan'));
    }

    public function aduan_all_staff(Request $request)
    {
        $kategori = KategoriAduan::select('kod_kategori', 'nama_kategori')->get();

        $status = StatusAduan::select('kod_status', 'nama_status')->get();

        $tahap = TahapKategori::select('kod_tahap', 'jenis_tahap')->get();

        $bulan = Aduan::select('bulan_laporan')->groupBy('bulan_laporan')->orderBy('bulan_laporan', 'ASC')->get();

        $juruteknik = User::select('id', 'name')->whereHas('roles', function($query){
            $query->where('id', 'CMS002');
        })->get();

        $req_juruteknik = $request->juruteknik;
        $req_status = $request->stat;
        $req_kategori = $request->kate;
        $req_bulan = $request->bul;

        $data = $datas = $datass =  '';

        if($request->juruteknik || $request->stat || $request->kate || $request->bul)
        {
            $result = new JuruteknikBertugas();

            if($request->juruteknik != "")
            {
                $result = $result->where('juruteknik_bertugas', $request->juruteknik);
            }

            if($request->stat != "")
            {
                $result = $result->whereHas('aduan', function($query) use($request){
                    $query->where('status_aduan', $request->stat);
                });
            }

            if($request->kate != "")
            {
                $result = $result->whereHas('aduan', function($query) use($request){
                    $query->where('kategori_aduan', $request->kate);
                });
            }

            if($request->bul != "")
            {
                $result = $result->whereHas('aduan', function($query) use($request){
                    $query->where('bulan_laporan', $request->bul);
                });
            }

            $data = $result->get();
        }

        $req_stat = $request->sel_stat;
        $req_kate = $request->sel_kate;
        $req_bul = $request->sel_bul;

        $dat = $dats = $datss =  '';

        if($request->sel_stat || $request->sel_kate || $request->sel_bul)
        {
            $res = new JuruteknikBertugas();

            if($request->sel_stat != "")
            {
                $res = $res->whereHas('aduan', function($query) use($request){
                    $query->where('status_aduan', $request->sel_stat);
                });
            }

            if($request->sel_kate != "")
            {
                $res = $res->whereHas('aduan', function($query) use($request){
                    $query->where('kategori_aduan', $request->sel_kate);
                });
            }

            if($request->sel_bul != "")
            {
                $res = $res->whereHas('aduan', function($query) use($request){
                    $query->where('bulan_laporan', $request->sel_bul);
                });
            }

            $dat = $res->where('juruteknik_bertugas', Auth::user()->id)->get();
        }

        $this->jurutekniks($request->juruteknik,$request->stat,$request->kate,$request->bul);
        $this->individu($request->sel_stat,$request->sel_kate,$request->sel_bul);

        return view('aduan.laporan_excel_staf', compact('juruteknik', 'req_juruteknik', 'req_bulan', 'req_kategori', 'req_status', 'data', 'tahap', 'kategori',
        'status', 'bulan', 'request', 'req_stat', 'req_kate', 'req_bul','dat'));
    }

    public function aduans($kategori = null, $status = null, $tahap = null, $bulan = null)
    {
        return Excel::download(new AduanExport($kategori,$status,$tahap,$bulan),'Laporan Aduan.xlsx');
    }

    public function jurutekniks($juruteknik = null, $stat = null, $kate = null, $bul = null)
    {
        return Excel::download(new JuruteknikExport($juruteknik,$stat,$kate,$bul),'Laporan Aduan Juruteknik.xlsx');
    }

    public function individu($stats = null, $kates = null, $buls = null)
    {
        return Excel::download(new IndividuExport($stats,$kates,$buls),'Laporan Aduan Individu.xlsx');
    }

    public function downloadBorang(Request $request, $id)
    {
        $aduan = Aduan::where('id', $id)->first();

        $resit = ResitAduan::where('id_aduan', $id)->get();

        $imej = ImejAduan::where('id_aduan', $id)->get();

        $gambar = ImejPembaikan::where('id_aduan', $id)->get();

        $juruteknik = JuruteknikBertugas::where('id_aduan', $id)->orderBy('jenis_juruteknik', 'ASC')->get();

        $pengadu = User::where('id', $aduan->id_pelapor)->first();

        return view('aduan.borangManual', compact('aduan', 'resit', 'imej', 'gambar', 'juruteknik', 'pengadu'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    // Dashboard

    public function index(Request $request)
    {
        $years = Aduan::selectRaw("DATE_FORMAT(tarikh_laporan, '%Y') year")
                ->whereNotNull('tarikh_laporan')
                ->groupBy('year')
                ->orderBy('year', 'desc')
                ->get();

        if($request->year) {
            $selectedYear = $request->year;
        } else {
            $selectedYear = Carbon::now()->format('Y');
        }

        $category = DB::table('cms_kategori_aduan as categories')
        ->select('categories.nama_kategori','claims.kategori_aduan', DB::raw('COUNT(claims.kategori_aduan) as count'))
        ->leftJoin('cms_aduan as claims','categories.kod_kategori','=','claims.kategori_aduan')
        ->where(DB::raw('YEAR(claims.tarikh_laporan)'), '=', $selectedYear)
        ->groupBy('categories.kod_kategori', 'categories.nama_kategori', 'claims.kategori_aduan')
        ->get();

        $result[] = ['Juruteknik','Aduan'];
        foreach ($category as $key => $value) {
            $result[++$key] = [$value->nama_kategori, (int)$value->count];
        }

        $list = DB::table('cms_juruteknik as tblJuru')
        ->select('tblJuru.juruteknik_bertugas','tblUser.name', DB::raw('COUNT(tblAduan.status_aduan) as count'))
        ->leftJoin('cms_aduan as tblAduan','tblAduan.id','=','tblJuru.id_aduan')
        ->leftJoin('auth.users as tblUser','tblUser.id','=','tblJuru.juruteknik_bertugas')
        ->where(DB::raw('YEAR(tblAduan.tarikh_laporan)'), '=', $selectedYear)
        ->groupBy('tblJuru.juruteknik_bertugas','tblUser.name')
        ->get();

        $results[] = ['Juruteknik','Aduan'];
        foreach ($list as $key => $value) {
            $results[++$key] = [$value->name, (int)$value->count];
        }

        $senarai = User::whereHas('roles', function($query){
            $query->where('id', 'CMS002');
        })->with(['staff'])->get();

        $rank = JuruteknikBertugas::select('juruteknik_bertugas', DB::raw('count(*) as total'))->groupBy('juruteknik_bertugas')
                ->whereHas('aduan', function($query) use ($selectedYear) {
                    $query->where(DB::raw('YEAR(tarikh_laporan)'), '=', $selectedYear);
                })->limit(5)->orderBy('total', 'desc')->get();

        return view('aduan.dashboard', compact('years','selectedYear','rank','senarai'))->with('list',json_encode($results))->with('category',json_encode($result));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
