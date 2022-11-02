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

class AduanController extends Controller
{
    //Aduan Individu

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
            'upload_image'       => 'nullable',
            'resit_file'         => 'nullable',
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
        })->get();

        foreach($admin as $value)
        {
            $admin_email = $value->email;

            $data = [
                'nama_penerima' => 'Assalamualaikum wbt & Salam Sejahtera, Tuan/Puan/Encik/Cik ' . $value->name,
                'penerangan' => 'Anda telah menerima aduan baru daripada '.$aduan->nama_pelapor.' pada '.date(' d/m/Y ', strtotime(Carbon::now()->toDateTimeString())).'. Sila log masuk sistem IDS untuk tindakan selanjutnya',
            ];

            Mail::send('aduan.emel-aduan', $data, function ($message) use ($aduan, $admin_email) {
                $message->subject('Aduan Baru Tiket #'.$aduan->id);
                $message->from('ITadmin@intec.edu.my');
                // $message->from($user->email);
                $message->to($admin_email);
            });
        }

        $datas = [
            'nama_penerima' => 'Assalamualaikum wbt & Salam Sejahtera, Tuan/Puan/Encik/Cik ' . $aduan->nama_pelapor,
            'penerangan' => 'Anda telah membuat aduan pada '.date(' d/m/Y ', strtotime(Carbon::now()->toDateTimeString())).'. Tiket aduan anda ialah : #'.$aduan->id.'. Tiket boleh digunakan untuk menyemak maklum balas atau tahap aduan anda diproses
                             di dalam sistem IDS. Sila log masuk sistem IDS untuk menyemak aduan anda',
        ];

        Mail::send('aduan.emel-aduan', $datas, function ($message) use ($aduan) {
            $message->subject('Aduan Baru Tiket #'.$aduan->id);
            $message->from('ITadmin@intec.edu.my');
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

                    $all .= isset($test->juruteknik->name) ? '<div word-break: break-all>'.$test->juruteknik->name.'<br>'.'- '.$staff->staff_email.'<br>'.'- '.$staff->staff_phone.'</div>' : '--';
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
        })->get();

        foreach($admin as $value)
        {
            $admin_email = $value->email;

            $data = [
                'nama_penerima' => 'Assalamualaikum wbt & Salam Sejahtera, Tuan/Puan/Encik/Cik ' . $value->name,
                'penerangan' => 'Aduan daripada '.$aduan->nama_pelapor.' pada '.date(' d/m/Y ', strtotime(Carbon::now()->toDateTimeString())).' telah dibatalkan atas sebab '.$request->sebab_pembatalan,
            ];

            Mail::send('aduan.emel-aduan', $data, function ($message) use ($admin_email, $aduan) {
                $message->subject('Pembatalan Aduan Tiket #'.$aduan->id);
                $message->from('ITadmin@intec.edu.my');
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

    //Senarai Aduan

    public function senaraiAduan(Request $request)
    {
        $status = StatusAduan::whereIn('kod_status', ['AS', 'LK', 'LU'])->get();

        return view('aduan.senarai-aduan', compact('status'));
    }

    public function data_senarai()
    {

        if( Auth::user()->hasRole('Technical Admin') )
        {
            $staff = Staff::where('staff_id', Auth::user()->id)->first();

            if($staff->staff_dept == 'INFORMATION TECHNOLOGY') {
                $list = Aduan::whereIn('status_aduan', ['BS','DJ','TD'])->whereIn('kategori_aduan', ['IITU-HDWR','IITU-NTWK','IITU-SYS','IITU-OPR','IITU-OPR_EMEL','IITU-OPR_SFWR','IITU-NTWK WIRELESS'])->select('cms_aduan.*');
            } else {
                $list = Aduan::whereIn('status_aduan', ['BS','DJ','TD'])->whereIn('kategori_aduan', ['AWM','ELK','MKL','PKH','TKM'])->select('cms_aduan.*');
            }

            // $list = Aduan::whereIn('status_aduan', ['BS','DJ','TD'])->select('cms_aduan.*');
        }
        else
        {
            $list = JuruteknikBertugas::where('juruteknik_bertugas', Auth::user()->id)->whereHas('aduan', function($query) {
                $query->whereIn('status_aduan', ['DJ','TD']);
            })->get();
        }

        return datatables()::of($list)
        ->addColumn('action', function ($list) {

            if( Auth::user()->hasRole('Technical Admin') )
            {
                if($list->status_aduan == 'DJ') {
                    return '<div class="btn-group"><a href="/info-aduan/' . $list->id.'" class="btn btn-sm btn-info mr-2"><i class="fal fa-pencil"></i></a>
                            <a data-page="/download/' . $list->id.'" class="btn btn-sm btn-primary text-white mr-2" onclick="Print(this)"><i class="fal fa-file"></i></a></div>';
                            // <button class="btn btn-sm btn-danger btn-delete" data-remote="/senarai-aduan/' . $list->id . '"><i class="fal fa-trash"></i></button>
                } else {
                    return '<div class="btn-group"><a href="/info-aduan/' . $list->id.'" class="btn btn-sm btn-info mr-2"><i class="fal fa-pencil"></i></a></div>';
                    // <button class="btn btn-sm btn-danger btn-delete" data-remote="/senarai-aduan/' . $list->id . '"><i class="fal fa-trash"></i></button>
                }
            }
            else
            {
                if($list->aduan->status_aduan=='DJ') {
                    return '<div class="btn-group"><a href="/info-aduan/' . $list->id_aduan.'" class="btn btn-sm btn-info mr-2"><i class="fal fa-pencil"></i></a>
                            <a data-page="/download/' . $list->id_aduan.'" class="btn btn-sm btn-primary text-white" onclick="Print(this)"><i class="fal fa-file"></i></a></div>';
                } else {
                    return '<a href="/info-aduan/' . $list->id_aduan.'" class="btn btn-sm btn-info"><i class="fal fa-pencil"></i></a>';
                }
            }

        })

        ->editColumn('id', function ($list) {
            if( Auth::user()->hasRole('Technical Admin') )
            {
                return '#'.$list->id;
            } else {
                return '#'.$list->id_aduan;
            }
        })

        ->editColumn('nama_pelapor', function ($list) {

            if( Auth::user()->hasRole('Technical Admin') )
            {
                return $list->nama_pelapor;
            } else {
                return strtoupper($list->aduan->nama_pelapor);
            }
        })

        ->editColumn('tarikh', function ($list) {

            if( Auth::user()->hasRole('Technical Admin') )
            {
                return date(' Y/m/d ', strtotime($list->tarikh_laporan) );
            } else {
                return date(' Y/m/d ', strtotime($list->aduan->tarikh_laporan) );
            }
        })

        ->editColumn('masa', function ($list) {

            if( Auth::user()->hasRole('Technical Admin') )
            {
                return date(' H:i A', strtotime($list->tarikh_laporan) );
            } else {
                return date(' H:i A', strtotime($list->aduan->tarikh_laporan) );
            }
        })

        ->editColumn('lokasi_aduan', function ($list) {

            if( Auth::user()->hasRole('Technical Admin') )
            {
                return '<div>' .strtoupper($list->nama_bilik). ', ARAS ' .strtoupper($list->aras_aduan). ', BLOK ' .strtoupper($list->blok_aduan). ', ' .strtoupper($list->lokasi_aduan).'</div>' ;
            } else {
                return '<div>' .strtoupper($list->aduan->nama_bilik). ', ARAS ' .strtoupper($list->aduan->aras_aduan). ', BLOK ' .strtoupper($list->aduan->blok_aduan). ', ' .strtoupper($list->aduan->lokasi_aduan).'</div>' ;
            }
        })

        ->editColumn('kategori_aduan', function ($list) {

            if( Auth::user()->hasRole('Technical Admin') )
            {
                return '<div> Kategori : <b>' .strtoupper($list->kategori->nama_kategori). '</b></div word-break: break-all><div> Jenis : <b>' .strtoupper($list->jenis->jenis_kerosakan). '</b></div word-break: break-all><div> Sebab : <b>' .strtoupper($list->sebab->sebab_kerosakan). '</b></div>' ;
            } else {
                return '<div> Kategori : <b>' .strtoupper($list->aduan->kategori->nama_kategori). '</b></div word-break: break-all><div> Jenis : <b>' .strtoupper($list->aduan->jenis->jenis_kerosakan). '</b></div word-break: break-all><div> Sebab : <b>' .strtoupper($list->aduan->sebab->sebab_kerosakan). '</b></div>' ;
            }
        })

        ->editColumn('status_aduan', function ($list) {

            if( Auth::user()->hasRole('Technical Admin') )
            {
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


            }
            else
            {
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
            }

        })

        ->editColumn('tempoh', function ($list) {

            if( Auth::user()->hasRole('Technical Admin') )
            {
                if(isset($list->tarikh_selesai_aduan))
                {
                    $tempoh = Carbon::parse($list->tarikh_laporan)->diffInDays($list->tarikh_selesai_aduan);

                } else {

                    $tempoh = Carbon::parse($list->tarikh_laporan)->diffInDays(Carbon::now());
                }

                return $tempoh.' hari';
            }
            else
            {
                if(isset($list->aduan->tarikh_selesai_aduan))
                {
                    $tempoh = Carbon::parse($list->aduan->tarikh_laporan)->diffInDays($list->aduan->tarikh_selesai_aduan);

                } else {

                    $tempoh = Carbon::parse($list->aduan->tarikh_laporan)->diffInDays(Carbon::now());
                }

                return $tempoh.' hari';

            }
        })

        ->editColumn('tahap_kategori', function ($list) {

            if( Auth::user()->hasRole('Technical Admin') )
            {
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
            }
            else
            {
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
            }
        })

        ->rawColumns(['lokasi_aduan', 'id', 'action', 'tahap_kategori', 'status_aduan', 'kategori_aduan', 'nama_pelapor', 'tempoh', 'tarikh', 'masa'])
        ->make(true);
    }

    // public function updateJuruteknik(Request $request)
    // {
    //     $aduan = Aduan::where('id', $request->id)->first();

    //     $aduan->update([
    //         'tahap_kategori'         => $request->tahap_kategori,
    //         'status_aduan'           => 'DJ',
    //         'caj_kerosakan'          => $request->caj_kerosakan,
    //         'tarikh_serahan_aduan'   => Carbon::now()->toDateTimeString(),
    //     ]);

    //     foreach($request->input('juruteknik_bertugas') as $key => $value) {
    //         $juruteknik = JuruteknikBertugas::create([
    //             'id_aduan'              => $request->id,
    //             'juruteknik_bertugas'   => $value,
    //             'jenis_juruteknik'      => $request->jenis_juruteknik[$key],
    //         ]);

    //         //hantar emel kpd juruteknik

    //         $data = [
    //             'nama_penerima' => 'Assalamualaikum wbt & Salam Sejahtera, Tuan/Puan/Encik/Cik ' . $juruteknik->juruteknik->name,
    //             'penerangan' => 'Anda telah menerima aduan baru pada '.date(' d/m/Y ', strtotime(Carbon::now()->toDateTimeString())).'. Sila log masuk sistem IDS untuk tindakan selanjutnya',
    //         ];

    //         $email = $juruteknik->juruteknik->email;

    //         Mail::send('aduan.emel-aduan', $data, function ($message) use ($email, $juruteknik) {
    //             $message->subject('Aduan Baru ID : ' . $juruteknik->id_aduan);
    //             $message->from(Auth::user()->email);
    //             $message->to($email);
    //         });
    //     }

    //     Session::flash('message', 'Aduan Telah Berjaya Dihantar kepada Juruteknik');
    //     return redirect('info-aduan/'.$aduan->id);
    // }

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

        return view('aduan.info-aduan', compact('aduan', 'juru', 'tahap', 'juruteknik', 'status', 'tukarStatus', 'resit', 'imej', 'senarai_juruteknik', 'alatan', 'alatan_ganti', 'senarai_alat', 'gambar'))->with('no', 1)->with('urutan', 1);
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
        } else {

            $aduan->update([
                'tahap_kategori'         => $request->tahap_kategori,
                'caj_kerosakan'          => $request->caj_kerosakan,
            ]);
        }

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
                $message->subject('Aduan Baru : Tiket #' . $juruteknik->id_aduan);
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
            $message->subject('Aduan Tiket #' . $aduan->id);
            $message->from(Auth::user()->email);
            $message->to($aduan->emel_pelapor);
        });

        Session::flash('kemaskiniTahap', 'Maklumat penyerahan aduan telah berjaya dihantar dan direkodkan.');
        return redirect('info-aduan/'.$request->ids);
    }

    public function tukarStatus(Request $request)
    {
        $id = Auth::user()->id;

        $aduan = Aduan::where('id', $request->status_id)->update([
            'status_aduan'          => $request->kod_status,
            'tukar_status'          => $id,
            'tarikh_selesai_aduan'  => Carbon::now()->toDateTimeString(),
        ]);

        Session::flash('status', 'Status aduan telah berjaya ditukar. Sila semak aduan dibahagian Pengurusan Aduan > Selesai');
        return redirect('/senarai-aduan');
    }

    // public function simpanPenambahbaikan(Request $request)
    // {

    //     $aduan = Aduan::where('id', $request->id)->first();

    //     $request->validate([
    //         'laporan_pembaikan'       => 'required',
    //         'tarikh_selesai_aduan'    => 'required',
    //         'status_aduan'            => 'required',
    //     ]);

    //     $aduan->update([
    //         'laporan_pembaikan'       => $request->laporan_pembaikan,
    //         'ak_upah'                 => $request->ak_upah,
    //         'ak_bahan_alat'           => $request->ak_bahan_alat,
    //         'jumlah_kos'              => $request->jumlah_kos,
    //         'tarikh_selesai_aduan'    => $request->tarikh_selesai_aduan,
    //         'status_aduan'            => $request->status_aduan,
    //     ]);

    //     if (isset($request->bahan_alat)) {
    //         foreach($request->bahan_alat as $value) {
    //             $fields = [
    //                 'id_aduan' => $aduan->id,
    //                 'alat_ganti' => $value
    //             ];

    //             AlatanPembaikan::create($fields);
    //         }
    //     }

    //     if (isset($request->upload_image)) {
    //         $image = $request->upload_image;
    //         $paths = storage_path()."/pembaikan/";

    //         for($y = 0; $y < count($image); $y++)
    //         {
    //             $originalsName = $image[$y]->getClientOriginalName();
    //             $fileSizes = $image[$y]->getSize();
    //             $fileNames = $originalsName;
    //             $image[$y]->storeAs('/pembaikan', date('dmyhi').' - '.$fileNames);
    //             ImejPembaikan::create([
    //                 'id_aduan'       => $aduan->id,
    //                 'upload_image'   => date('dmyhi').' - '.$originalsName,
    //                 'web_path'       => "app/pembaikan/".date('dmyhi').' - '.$fileNames,
    //             ]);
    //         }
    //     }

    //     $admin = User::whereHas('roles', function($query){
    //         $query->where('id', 'CMS001');
    //     })->get();

    //     foreach($admin as $value)
    //     {
    //         $admin_email = $value->email;

    //         $data = [
    //             'nama_penerima' => 'Assalamualaikum wbt & Salam Sejahtera, Tuan/Puan/Encik/Cik ' . $value->name,
    //             'penerangan'    => 'Aduan yang dilaporkan pada '.date(' d/m/Y ', strtotime($aduan->tarikh_laporan)).
    //                                 ' telah dilaksanakan pembaikan oleh juruteknik bertarikh '.date(' d/m/Y ', strtotime($aduan->tarikh_selesai_aduan)).
    //                                 'Sila log masuk sistem IDS untuk tindakan selanjutnya',
    //         ];

    //         Mail::send('aduan.emel-aduan', $data, function ($message) use ($admin_email) {
    //             $message->subject('Perlaksanaan Pembaikan Aduan');
    //             $message->from(Auth::user()->email);
    //             $message->to($admin_email);
    //         });
    //     }

    //     Session::flash('simpanPembaikan', 'Pembaikan aduan telah berjaya dihantar.');
    //     return redirect('info-aduan/'.$aduan->id);
    // }

    public function kemaskiniPenambahbaikan(Request $request)
    {
        $aduan = Aduan::where('id', $request->idp)->first();

        if($request->laporan_pembaikan != null) {

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

        } else {

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
            })->get();

            foreach($admin as $value)
            {
                $admin_email = $value->email;

                $data = [
                    'nama_penerima' => 'Assalamualaikum wbt & Salam Sejahtera, Tuan/Puan/Encik/Cik ' . $value->name,
                    'penerangan'    => 'Aduan yang dilaporkan pada '.date(' d/m/Y ', strtotime($aduan->tarikh_laporan)).
                                        ' telah dilaksanakan pembaikan oleh juruteknik bertarikh '.date(' d/m/Y ', strtotime($aduan->tarikh_selesai_aduan)).
                                        'Sila log masuk sistem IDS untuk tindakan selanjutnya',
                ];

                Mail::send('aduan.emel-aduan', $data, function ($message) use ($admin_email, $aduan) {
                    $message->subject('Perlaksanaan Pembaikan Aduan Tiket #'.$aduan->id);
                    $message->from(Auth::user()->email);
                    $message->to($admin_email);
                });
            }

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

    // public function padamAduan($id)
    // {
    //     $exist = Aduan::find($id);
    //     $exist->delete();

    //     return response()->json(['success'=>'Aduan Berjaya Dipadam.']);
    // }

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

        if( Auth::user()->hasRole('Technical Admin') )
        {
            $list = Aduan::whereIn('status_aduan', ['AS','LK','LU'])->select('cms_aduan.*');
        }
        else
        {
            $list = JuruteknikBertugas::where('juruteknik_bertugas', Auth::user()->id)->whereHas('aduan', function($query) {
                $query->whereIn('status_aduan', ['AS','LK','LU']);
            })->get();

        }

        return datatables()::of($list)
        ->addColumn('action', function ($list) {

            if( Auth::user()->hasRole('Technical Admin') )
            {
                return '<a href="/info-aduan/' . $list->id.'" class="btn btn-sm btn-info mr-2"><i class="fal fa-pencil"></i></a>';
            }
            else
            {
                return '<a href="/info-aduan/' . $list->id_aduan.'" class="btn btn-sm btn-info"><i class="fal fa-pencil"></i></a>';
            }

        })

        ->editColumn('id', function ($list) {
            if( Auth::user()->hasRole('Technical Admin') )
            {
                return '#'.$list->id;
            } else {
                return '#'.$list->id_aduan;
            }
        })

        ->editColumn('nama_pelapor', function ($list) {

            if( Auth::user()->hasRole('Technical Admin') )
            {
                return $list->nama_pelapor;
            } else {
                return strtoupper($list->aduan->nama_pelapor) ?? '';
            }

        })

        ->editColumn('tarikh', function ($list) {

            if( Auth::user()->hasRole('Technical Admin') )
            {
                return date(' Y/m/d ', strtotime($list->tarikh_laporan) );
            } else {
                return date(' Y/m/d ', strtotime($list->aduan->tarikh_laporan) ) ?? '';
            }

        })

        ->editColumn('masa', function ($list) {

            if( Auth::user()->hasRole('Technical Admin') )
            {
                return date(' H:i A', strtotime($list->tarikh_laporan) );
            } else {
                return date(' H:i A', strtotime($list->aduan->tarikh_laporan) ) ?? '';
            }

        })

        ->editColumn('lokasi_aduan', function ($list) {

            if( Auth::user()->hasRole('Technical Admin') )
            {
                return '<div>' .strtoupper($list->nama_bilik). ', ARAS ' .strtoupper($list->aras_aduan). ', BLOK ' .strtoupper($list->blok_aduan). ', ' .strtoupper($list->lokasi_aduan).'</div>' ;
            } else {
                return '<div>' .strtoupper($list->aduan->nama_bilik). ', ARAS ' .strtoupper($list->aduan->aras_aduan). ', BLOK ' .strtoupper($list->aduan->blok_aduan). ', ' .strtoupper($list->aduan->lokasi_aduan).'</div>' ;
            }

        })

        ->editColumn('kategori_aduan', function ($list) {

            if( Auth::user()->hasRole('Technical Admin') )
            {
                return '<div> Kategori : <b>' .strtoupper($list->kategori->nama_kategori). '</b></div word-break: break-all><div> Jenis : <b>' .strtoupper($list->jenis->jenis_kerosakan). '</b></div word-break: break-all><div> Sebab : <b>' .strtoupper($list->sebab->sebab_kerosakan). '</b></div>' ;
            } else {
                return '<div> Kategori : <b>' .strtoupper($list->aduan->kategori->nama_kategori). '</b></div word-break: break-all><div> Jenis : <b>' .strtoupper($list->aduan->jenis->jenis_kerosakan). '</b></div word-break: break-all><div> Sebab : <b>' .strtoupper($list->aduan->sebab->sebab_kerosakan). '</b></div>' ;
            }

        })

        ->editColumn('status_aduan', function ($list) {

            if( Auth::user()->hasRole('Technical Admin') )
            {
                if($list->status_aduan=='AS')
                {
                    return '<span class="badge badge-success">' . strtoupper($list->status->nama_status) . '</span>';
                }
                else
                {
                    return '<span class="badge badge-success2">' . strtoupper($list->status->nama_status) . '</span>';
                }
            }
            else
            {
                if($list->aduan->status_aduan=='AS')
                {
                    return '<span class="badge badge-success">' . strtoupper($list->aduan->status->nama_status) . '</span>';
                }
                else
                {
                    return '<span class="badge badge-success2">' . strtoupper($list->aduan->status->nama_status) . '</span>';
                }
            }

        })

        ->editColumn('tahap_kategori', function ($list) {

            if( Auth::user()->hasRole('Technical Admin') )
            {
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
            }
            else
            {
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
            }
        })

        ->rawColumns(['lokasi_aduan', 'id', 'action', 'tahap_kategori', 'status_aduan', 'kategori_aduan', 'nama_pelapor', 'tarikh', 'masa'])
        ->make(true);
    }

    public function senaraiKiv(Request $request)
    {
        return view('aduan.senarai-aduan-kiv');
    }

    public function data_kiv()
    {
        if( Auth::user()->hasRole('Technical Admin') )
        {
            $list = Aduan::whereIn('status_aduan', ['AK'])->select('cms_aduan.*');
        }
        else
        {
            $list = JuruteknikBertugas::where('juruteknik_bertugas', Auth::user()->id)->whereHas('aduan', function($query) {
                $query->whereIn('status_aduan', ['AK']);
            })->get();
        }

        return datatables()::of($list)
        ->addColumn('action', function ($list) {

            if( Auth::user()->hasRole('Technical Admin') )
            {
                return '<a href="/info-aduan/' . $list->id.'" class="btn btn-sm btn-info mr-2"><i class="fal fa-pencil"></i></a>';
            }
            else
            {
                return '<a href="/info-aduan/' . $list->id_aduan.'" class="btn btn-sm btn-info"><i class="fal fa-pencil"></i></a>';
            }

        })

        ->editColumn('id', function ($list) {
            if( Auth::user()->hasRole('Technical Admin') )
            {
                return '#'.$list->id;
            } else {
                return '#'.$list->id_aduan;
            }
        })

        ->editColumn('nama_pelapor', function ($list) {

            if( Auth::user()->hasRole('Technical Admin') )
            {
                return $list->nama_pelapor;
            } else {
                return strtoupper($list->aduan->nama_pelapor);
            }

        })

        ->editColumn('tarikh', function ($list) {

            if( Auth::user()->hasRole('Technical Admin') )
            {
                return date(' Y/m/d ', strtotime($list->tarikh_laporan) );
            } else {
                return date(' Y/m/d ', strtotime($list->aduan->tarikh_laporan) );
            }

        })

        ->editColumn('masa', function ($list) {

            if( Auth::user()->hasRole('Technical Admin') )
            {
                return date(' H:i A', strtotime($list->tarikh_laporan) );
            } else {
                return date(' H:i A', strtotime($list->aduan->tarikh_laporan) );
            }

        })

        ->editColumn('lokasi_aduan', function ($list) {

            if( Auth::user()->hasRole('Technical Admin') )
            {
                return '<div>' .strtoupper($list->nama_bilik). ', ARAS ' .strtoupper($list->aras_aduan). ', BLOK ' .strtoupper($list->blok_aduan). ', ' .strtoupper($list->lokasi_aduan).'</div>' ;
            } else {
                return '<div>' .strtoupper($list->aduan->nama_bilik). ', ARAS ' .strtoupper($list->aduan->aras_aduan). ', BLOK ' .strtoupper($list->aduan->blok_aduan). ', ' .strtoupper($list->aduan->lokasi_aduan).'</div>' ;
            }

        })

        ->editColumn('kategori_aduan', function ($list) {

            if( Auth::user()->hasRole('Technical Admin') )
            {
                return '<div> Kategori : <b>' .strtoupper($list->kategori->nama_kategori). '</b></div word-break: break-all><div> Jenis : <b>' .strtoupper($list->jenis->jenis_kerosakan). '</b></div word-break: break-all><div> Sebab : <b>' .strtoupper($list->sebab->sebab_kerosakan). '</b></div>' ;
            } else {
                return '<div> Kategori : <b>' .strtoupper($list->aduan->kategori->nama_kategori). '</b></div word-break: break-all><div> Jenis : <b>' .strtoupper($list->aduan->jenis->jenis_kerosakan). '</b></div word-break: break-all><div> Sebab : <b>' .strtoupper($list->aduan->sebab->sebab_kerosakan). '</b></div>' ;
            }

        })

        ->editColumn('status_aduan', function ($list) {

            if( Auth::user()->hasRole('Technical Admin') )
            {
                if($list->status_aduan=='AK')
                {
                    return '<span class="badge badge-kiv">' . strtoupper($list->status->nama_status) . '</span>';
                }
            }
            else
            {
                if($list->aduan->status_aduan=='AK')
                {
                   return '<span class="badge badge-kiv">' . strtoupper($list->aduan->status->nama_status) . '</span>';
                }
            }

        })

        ->editColumn('tahap_kategori', function ($list) {

            if( Auth::user()->hasRole('Technical Admin') )
            {
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
            }
            else
            {
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
            }
        })

        ->rawColumns(['lokasi_aduan', 'id', 'action', 'tahap_kategori', 'status_aduan', 'kategori_aduan', 'nama_pelapor', 'tarikh', 'masa'])
        ->make(true);
    }

    public function senaraiBertindih(Request $request)
    {
        return view('aduan.senarai-aduan-bertindih');
    }

    public function data_bertindih()
    {
        if( Auth::user()->hasRole('Technical Admin') )
        {
            $list = Aduan::whereIn('status_aduan', ['DP'])->select('cms_aduan.*');
        }
        else
        {
            $list = JuruteknikBertugas::where('juruteknik_bertugas', Auth::user()->id)->whereHas('aduan', function($query) {
                $query->whereIn('status_aduan', ['DP']);
            })->get();
        }

        return datatables()::of($list)
        ->addColumn('action', function ($list) {

            if( Auth::user()->hasRole('Technical Admin') )
            {
                return '<a href="/info-aduan/' . $list->id.'" class="btn btn-sm btn-info mr-2"><i class="fal fa-pencil"></i></a>';
            }
            else
            {
                return '<a href="/info-aduan/' . $list->id_aduan.'" class="btn btn-sm btn-info"><i class="fal fa-pencil"></i></a>';
            }

        })

        ->editColumn('id', function ($list) {
            if( Auth::user()->hasRole('Technical Admin') )
            {
                return '#'.$list->id;
            } else {
                return '#'.$list->id_aduan;
            }
        })

        ->editColumn('nama_pelapor', function ($list) {

            if( Auth::user()->hasRole('Technical Admin') )
            {
                return $list->nama_pelapor;
            } else {
                return strtoupper($list->aduan->nama_pelapor);
            }

        })

        ->editColumn('tarikh', function ($list) {

            if( Auth::user()->hasRole('Technical Admin') )
            {
                return date(' Y/m/d ', strtotime($list->tarikh_laporan) );
            } else {
                return date(' Y/m/d ', strtotime($list->aduan->tarikh_laporan) );
            }

        })

        ->editColumn('masa', function ($list) {

            if( Auth::user()->hasRole('Technical Admin') )
            {
                return date(' H:i A', strtotime($list->tarikh_laporan) );
            } else {
                return date(' H:i A', strtotime($list->aduan->tarikh_laporan) );
            }

        })

        ->editColumn('lokasi_aduan', function ($list) {

            if( Auth::user()->hasRole('Technical Admin') )
            {
                return '<div>' .strtoupper($list->nama_bilik). ', ARAS ' .strtoupper($list->aras_aduan). ', BLOK ' .strtoupper($list->blok_aduan). ', ' .strtoupper($list->lokasi_aduan).'</div>' ;
            } else {
                return '<div>' .strtoupper($list->aduan->nama_bilik). ', ARAS ' .strtoupper($list->aduan->aras_aduan). ', BLOK ' .strtoupper($list->aduan->blok_aduan). ', ' .strtoupper($list->aduan->lokasi_aduan).'</div>' ;
            }

        })

        ->editColumn('kategori_aduan', function ($list) {

            if( Auth::user()->hasRole('Technical Admin') )
            {
                return '<div> Kategori : <b>' .strtoupper($list->kategori->nama_kategori). '</b></div word-break: break-all><div> Jenis : <b>' .strtoupper($list->jenis->jenis_kerosakan). '</b></div word-break: break-all><div> Sebab : <b>' .strtoupper($list->sebab->sebab_kerosakan). '</b></div>' ;
            } else {
                return '<div> Kategori : <b>' .strtoupper($list->aduan->kategori->nama_kategori). '</b></div word-break: break-all><div> Jenis : <b>' .strtoupper($list->aduan->jenis->jenis_kerosakan). '</b></div word-break: break-all><div> Sebab : <b>' .strtoupper($list->aduan->sebab->sebab_kerosakan). '</b></div>' ;
            }

        })

        ->editColumn('status_aduan', function ($list) {

            if( Auth::user()->hasRole('Technical Admin') )
            {
                if($list->status_aduan=='DP')
                {
                    return '<span class="badge badge-duplicate">' . strtoupper($list->status->nama_status) . '</span>';
                }
            }
            else
            {
                if($list->aduan->status_aduan=='DP')
                {
                    return '<span class="badge badge-duplicate">' . strtoupper($list->aduan->status->nama_status) . '</span>';
                }
            }

        })

        ->editColumn('tahap_kategori', function ($list) {

            if( Auth::user()->hasRole('Technical Admin') )
            {
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
            }
            else
            {
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
            }
        })

        ->rawColumns(['lokasi_aduan', 'id', 'action', 'tahap_kategori', 'status_aduan', 'kategori_aduan', 'nama_pelapor', 'tarikh', 'masa'])
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
            $message->subject('Pengesahan Penambahbaikan Aduan Tiket #'.$aduan->id);
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

    // Export & PDF

    public function pdfAduan(Request $request, $id)
    {
        $aduan = Aduan::where('id', $id)->first();

        $resit = ResitAduan::where('id_aduan', $id)->get();

        $imej = ImejAduan::where('id_aduan', $id)->get();

        $gambar = ImejPembaikan::where('id_aduan', $id)->get();

        $juruteknik = JuruteknikBertugas::where('id_aduan', $id)->orderBy('jenis_juruteknik', 'ASC')->get();

        $alatan_ganti = AlatanPembaikan::where('id_aduan', $id)->get();

        return view('aduan.aduanPdf', compact('aduan', 'resit', 'imej', 'gambar', 'juruteknik','alatan_ganti'));
    }

    public function aduan_all(Request $request)
    {
        $kategori = KategoriAduan::select('kod_kategori', 'nama_kategori')->get();
        $status = StatusAduan::select('kod_status', 'nama_status')->get();
        $tahap = TahapKategori::select('kod_tahap', 'jenis_tahap')->get();
        $bulan = Aduan::select('bulan_laporan')->groupBy('bulan_laporan')->orderBy('bulan_laporan', 'ASC')->get();

        $cond = "1"; // 1 = selected

        $selectedkategori = $request->kategori;
        $selectedstatus = $request->status;
        $selectedtahap = $request->tahap;
        $selectedbulan = $request->bulan;

        return view('aduan.laporan_excel', compact( 'tahap', 'kategori', 'status', 'bulan', 'request', 'selectedtahap', 'selectedkategori', 'selectedstatus', 'selectedbulan'));
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
        'status', 'bulan', 'request', 'req_stat', 'req_kate', 'req_bul'));
    }

    public function aduans($kategori = null, $status = null, $tahap = null, $bulan = null)
    {
        return Excel::download(new AduanExport($kategori,$status,$tahap,$bulan),'Laporan Aduan.xlsx');
    }

    public function data_aduanexport(Request $request)
    {
        $cond = "1";
        if($request->kategori && $request->kategori != "All")
        {
            $cond .= " AND kategori_aduan = '".$request->kategori."' ";
        }

        if( $request->status != "" && $request->status != "All")
        {
            $cond .= " AND status_aduan = '".$request->status."' ";
        }

        if( $request->tahap != "" && $request->tahap != "All")
        {
            $cond .= " AND tahap_kategori = '".$request->tahap."' ";
        }

        if( $request->bulan != "" && $request->bulan != "All")
        {
            $cond .= " AND bulan_laporan = '".$request->bulan."' ";
        }

        if( Auth::user()->hasRole('Technical Admin') )
        {
            $aduan = Aduan::whereRaw($cond);

        } else {

            $aduan = Aduan::whereRaw($cond)->with(['juruteknik'=>function($query){
                $query->where('juruteknik_bertugas', Auth::user()->id);
            }])->get();
        }

        return datatables()::of($aduan)

        ->editColumn('id', function ($aduan) {

            return '#'.$aduan->id;
        })

        ->editColumn('nama_pelapor', function ($aduan) {

            return $aduan->id_pelapor.' : <div style="text-transform:uppercase">'.$aduan->nama_pelapor.'</div>' ?? '<div style="color:red;" > -- </div>';
        })

        ->editColumn('nama_bilik', function ($aduan) {

            return '<div style="text-transform:uppercase">'.$aduan->nama_bilik.'</div>' ?? '<div style="color:red;" > -- </div>';
        })

        ->editColumn('aras_aduan', function ($aduan) {

            return '<div style="text-transform:uppercase">'.$aduan->aras_aduan.'</div>' ?? '<div style="color:red;" > -- </div>';
        })

        ->editColumn('blok_aduan', function ($aduan) {

            return '<div style="text-transform:uppercase">'.$aduan->blok_aduan.'</div>' ?? '<div style="color:red;" > -- </div>';
        })

        ->editColumn('lokasi_aduan', function ($aduan) {

            return '<div style="text-transform:uppercase">'.$aduan->lokasi_aduan.'</div>' ?? '<div style="color:red;" > -- </div>';
        })

        ->editColumn('kategori_aduan', function ($aduan) {

            return '<div style="text-transform:uppercase">'.$aduan->kategori->nama_kategori.'</div>' ?? '<div style="color:red;" > -- </div>';
        })

        ->editColumn('jenis_kerosakan', function ($aduan) {

            return '<div style="text-transform:uppercase">'.$aduan->jenis->jenis_kerosakan.'</div>' ?? '<div style="color:red;" > -- </div>';
        })

        ->editColumn('sebab_kerosakan', function ($aduan) {

            return '<div style="text-transform:uppercase">'.$aduan->sebab->sebab_kerosakan.'</div>' ?? '<div style="color:red;" > -- </div>';
        })

        ->editColumn('maklumat_tambahan', function ($aduan) {

            return '<div style="text-transform:uppercase">'.$aduan->maklumat_tambahan.'</div>' ?? '<div style="color:red;" > -- </div>';
        })

        ->editColumn('tahap_kategori', function ($aduan) {

            return isset($aduan->tahap_kategori) ? strtoupper($aduan->tahap->jenis_tahap) : '<div style="color:red;" > -- </div>';
        })

        ->editColumn('tarikh_laporan', function ($aduan) {

            return isset($aduan->tarikh_laporan) ? date(' d-m-Y ', strtotime($aduan->tarikh_laporan)) : '<div style="color:red;" > -- </div>';
        })

        ->editColumn('tarikh_serahan_aduan', function ($aduan) {

            return isset($aduan->tarikh_serahan_aduan) ? date(' d-m-Y ', strtotime($aduan->tarikh_serahan_aduan)) : '<div style="color:red;" > -- </div>';
        })

        ->editColumn('laporan_pembaikan', function ($aduan) {

            return isset($aduan->sebab_pembatalan) ? strtoupper($aduan->laporan_pembaikan) : '<div style="color:red;" > -- </div>';
        })

        ->editColumn('pengesahan_aduan', function ($aduan) {

            if($aduan->pengesahan_aduan == 'Y') {
                return 'DISAHKAN';
            } else {
                return '<div style="color:red">BELUM DISAHKAN</div>';
            }

        })

        ->editColumn('pengesahan_pembaikan', function ($aduan) {

            if($aduan->pengesahan_pembaikan == 'Y') {
                return 'DISAHKAN';
            } else {
                return '<div style="color:red">BELUM DISAHKAN</div>';
            }
        })

        ->editColumn('caj_kerosakan', function ($aduan) {

            return isset($aduan->sebab_pembatalan) ? strtoupper($aduan->caj_kerosakan) : '<div style="color:red;" > -- </div>';
        })

        ->editColumn('bahan', function ($aduan) {

            $datas = AlatanPembaikan::where('id_aduan', $aduan->id)->get();
            $alat = '';
            foreach($datas as $data){
                $alat .= '<div>'.$data->alat->alat_ganti.', </div word-break>';
            }

            return isset($alat) ? strtoupper($alat) : '<div style="color:red;" > -- </div>';
        })

        ->editColumn('ak_upah', function ($aduan) {

            return 'RM '.$aduan->ak_upah ?? '<div style="color:red;" > -- </div>';
        })

        ->editColumn('ak_bahan_alat', function ($aduan) {

            return 'RM '.$aduan->ak_bahan_alat ?? '<div style="color:red;" > -- </div>';
        })

        ->editColumn('jumlah_kos', function ($aduan) {

            return 'RM '.$aduan->jumlah_kos ?? '<div style="color:red;" > -- </div>';
        })

        ->editColumn('tarikh_selesai_aduan', function ($aduan) {

            return isset($aduan->tarikh_selesai_aduan) ? date(' d-m-Y ', strtotime($aduan->tarikh_selesai_aduan)) : '<div style="color:red;" > -- </div>';
        })

        ->editColumn('sebab_pembatalan', function ($aduan) {

            return isset($aduan->sebab_pembatalan) ? strtoupper($aduan->sebab_pembatalan) : '<div style="color:red;" > -- </div>';
        })

        ->editColumn('catatan_pembaikan', function ($aduan) {

            return isset($aduan->sebab_pembatalan) ? strtoupper($aduan->catatan_pembaikan) : '<div style="color:red;" > -- </div>';
        })

        ->editColumn('status_aduan', function ($aduan) {

            return '<div style="text-transform:uppercase">'.$aduan->status->nama_status.'</div>' ?? '<div style="color:red;" > -- </div>';
        })

        ->editColumn('tukar_status', function ($aduan) {

            return isset($aduan->tukar_status) ? $aduan->tukar_status.' : '.strtoupper($aduan->penukaran->staff_name) : '<div style="color:red;" > -- </div>';
        })

        ->editColumn('juruteknik', function ($aduan) {

            $data = JuruteknikBertugas::where('id_aduan', $aduan->id)->with(['juruteknik'])->get();

            $juru = '';
            foreach($data as $datas){
                $juru .= '<div>'.$datas->juruteknik_bertugas.' : '.$datas->juruteknik->name.', </div word-break>';
            }

            return isset($juru) ? strtoupper($juru) : '<div style="color:red;" > -- </div>';
        })

        ->rawColumns(['nama_pelapor', 'tarikh_laporan', 'nama_bilik', 'aras_aduan', 'blok_aduan', 'lokasi_aduan', 'kategori_aduan', 'jenis_kerosakan', 'sebab_kerosakan', 'maklumat_tambahan', 'tahap_kategori',
                      'tarikh_serahan_aduan', 'laporan_pembaikan', 'bahan', 'ak_upah', 'ak_bahan_alat', 'jumlah_kos', 'tarikh_selesai_aduan', 'catatan_pembaikan', 'status_aduan', 'juruteknik', 'pengesahan_pembaikan',
                      'pengesahan_aduan', 'caj_kerosakan', 'id', 'sebab_pembatalan', 'tukar_status'])
        ->make(true);
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

        return view('aduan.borangManual', compact('aduan', 'resit', 'imej', 'gambar', 'juruteknik'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    // Dashboard

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
        ->where('tblJuru.juruteknik_bertugas', Auth::user()->id)
        ->get();

        $result[] = ['Status','Jumlah'];
        foreach ($aduan as $key => $value) {
            $result[++$key] = [$value->kod_status, (int)$value->count];
        }

        $results[] = ['Juruteknik','Aduan'];
        foreach ($list as $key => $value) {
            $results[++$key] = [$value->juruteknik_bertugas, (int)$value->count];
        }

        $res[] = ['Status','Jumlah'];
        foreach ($data as $key => $value) {
            $res[++$key] = [$value->status_aduan, (int)$value->count];
        }

        $senarai = User::whereHas('roles', function($query){
            $query->where('id', 'CMS002');
        })->with(['staff'])->get();

        $senaraiAdmin = User::whereHas('roles', function($query){
            $query->where('id', 'CMS001');
        })->with(['staff'])->get();

        return view('aduan.dashboard', compact('senarai','senaraiAdmin'))->with('aduan',json_encode($result))->with('list',json_encode($results))->with('juruteknik',json_encode($res))->with('no', '1');
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
