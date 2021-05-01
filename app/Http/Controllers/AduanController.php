<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use File;
use Session;
use Response;
use App\User;
use App\Aduan;
use Carbon\Carbon;
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
use Illuminate\Support\Facades\Mail;

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
                ->where('jenis_kerosakan', $request->id)
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
            // 'jk_penerangan'             => $request->jk_penerangan,
            'sebab_kerosakan'           => $request->sebab_kerosakan,
            // 'sk_penerangan'             => $request->sk_penerangan,
            'kuantiti_unit'             => $request->kuantiti_unit,
            'caj_kerosakan'             => $request->caj_kerosakan,
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
                $image[$y]->storeAs('/aduan', $fileNames.date('dmyhis'));
                ImejAduan::create([
                    'id_aduan'  => $aduan->id,
                    'upload_image' => $originalsName.date('dmyhis'),
                    'web_path'  => "app/aduan/".$fileNames.date('dmyhis'),
                ]);
            }
        }

        $file = $request->resit_file;
        $path=storage_path()."/resit/";

        if (isset($image)) { 

            for($x = 0; $x < count($file) ; $x ++)
            {
                $originalName = $file[$x]->getClientOriginalName();
                $fileSize = $file[$x]->getSize();
                $fileName = $originalName;
                $file[$x]->storeAs('/resit', $fileName.date('dmyhis'));
                ResitAduan::create([
                    'id_aduan'  => $aduan->id,
                    'nama_fail' => $originalName.date('dmyhis'),
                    'saiz_fail' => $fileSize,
                    'web_path'  => "app/resit/".$fileName.date('dmyhis'),
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
                'penerangan' => 'Anda telah menerima aduan baru daripada '.$aduan->nama_pelapor.' pada '.date(' j F Y ', strtotime(Carbon::now()->toDateTimeString())).'. Sila log masuk sistem IDS untuk tindakan selanjutnya',
            ];

            Mail::send('aduan.emel-aduan-baru', $data, function ($message) use ($admin_email) {
                $message->subject('ADUAN BARU');
                $message->from('ITadmin@intec.edu.my');
                $message->to($admin_email);
            });
        }

        Session::flash('message', 'Aduan anda telah berjaya dihantar. Sebarang info akan dimaklumkan kemudian.');
        return redirect('/aduan');
    }

    public function aduan()
    {
        return view('aduan.aduan');
    }

    public function data_aduan()
    {
        $aduan = Aduan::select('*')->where('id_pelapor', Auth::user()->id)->get();

        return datatables()::of($aduan)
        ->addColumn('action', function ($aduan) {

            return '<a href="/maklumat-aduan/' . $aduan->id.'" class="btn btn-sm btn-primary"><i class="fal fa-eye"></i></a>'; 
        })

        ->addColumn('tarikh_laporan', function ($aduan) {

            return date(' j F Y | h:i:s A ', strtotime($aduan->tarikh_laporan)); 
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
                    $all .= isset($test->juruteknik->name) ? '<div word-break: break-all>'.$test->juruteknik->name.'</div>' : '--';
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
                elseif($aduan->status_aduan=='AK')
                {
                    return '<span class="badge badge-kiv">' . strtoupper($aduan->status->nama_status) . '</span>';
                }
                else //DP
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
        
        ->addIndexColumn()
        ->rawColumns(['action', 'status_aduan', 'lokasi_aduan', 'kategori_aduan', 'juruteknik_bertugas', 'tarikh_laporan', 'pengesahan_pembaikan'])
        ->make(true);
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
        $path = storage_path().'/'.'app'.'/aduan/'.$file;

        $file = File::get($path);
        $filetype = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $filetype);

        return $response;
    }

    public function failResit($filename,$type)
    {
        $path = storage_path().'/'.'app'.'/resit/'.$filename;

        if($type == "Download")
        {
            if (file_exists($path)) {
                return Response::download($path);
            }
        }
        else
        {
            $file = File::get($path);
            $filetype = File::mimeType($path);

            $response = Response::make($file, 200);
            $response->header("Content-Type", $type);

            return $response;
        }
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

    //Senarai Aduan

    public function senaraiAduan(Request $request)
    {
        return view('aduan.senarai-aduan');
    }

    public function data_senarai()
    {
       
        if( Auth::user()->hasRole('Operation Admin') )
        { 
            $list = Aduan::all()->whereIn('status_aduan', ['BS','DJ','TD']);
        }
        else
        {
            $list = JuruteknikBertugas::where('juruteknik_bertugas', Auth::user()->id)->whereHas('aduan', function($query) {
                $query->select('*')->whereIn('status_aduan', ['BS','DJ','TD']);
            })->get();
        }
            
        return datatables()::of($list)
        ->addColumn('action', function ($list) {

            if( Auth::user()->hasRole('Operation Admin') )
            { 
                return '<a href="/info-aduan/' . $list->id.'" class="btn btn-sm btn-info"><i class="fal fa-pencil"></i></a>
                        <button class="btn btn-sm btn-danger btn-delete" data-remote="/senarai-aduan/' . $list->id . '"><i class="fal fa-trash"></i></button>';
            }
            else
            {
                return '<a href="/info-aduan/' . $list->id_aduan.'" class="btn btn-sm btn-info"><i class="fal fa-pencil"></i></a>';
            }
            
        })

        ->editColumn('id', function ($list) {
            if( Auth::user()->hasRole('Operation Admin') )
            { 
                return $list->id;
            }

            else
            {
                return $list->id_aduan;
            }
        })

        ->editColumn('nama_pelapor', function ($list) {

            if( Auth::user()->hasRole('Operation Admin') )
            { 
                return $list->nama_pelapor;
            }

            else
            {
                return strtoupper($list->aduan->nama_pelapor);
            }
            
        })

        ->editColumn('tarikh_laporan', function ($list) {

            if( Auth::user()->hasRole('Operation Admin') )
            { 
                return date(' Y-m-d | H:i A', strtotime($list->tarikh_laporan) );
            }

            else
            {
                return date(' Y-m-d | H:i A', strtotime($list->aduan->tarikh_laporan) );
            }
            
        })

        ->editColumn('lokasi_aduan', function ($list) {

            if( Auth::user()->hasRole('Operation Admin') )
            { 
                return '<div>' .strtoupper($list->nama_bilik). ', ARAS ' .strtoupper($list->aras_aduan). ', BLOK ' .strtoupper($list->blok_aduan). ', ' .strtoupper($list->lokasi_aduan).'</div>' ;
            }

            else
            {
                return '<div>' .strtoupper($list->aduan->nama_bilik). ', ARAS ' .strtoupper($list->aduan->aras_aduan). ', BLOK ' .strtoupper($list->aduan->blok_aduan). ', ' .strtoupper($list->aduan->lokasi_aduan).'</div>' ;
            }
            
        })

        ->editColumn('kategori_aduan', function ($list) {

            if( Auth::user()->hasRole('Operation Admin') )
            { 
                return '<div> Kategori : <b>' .strtoupper($list->kategori->nama_kategori). '</b></div word-break: break-all><div> Jenis : <b>' .strtoupper($list->jenis->jenis_kerosakan). '</b></div word-break: break-all><div> Sebab : <b>' .strtoupper($list->sebab->sebab_kerosakan). '</b></div>' ;
            }

            else
            {
                return '<div> Kategori : <b>' .strtoupper($list->aduan->kategori->nama_kategori). '</b></div word-break: break-all><div> Jenis : <b>' .strtoupper($list->aduan->jenis->jenis_kerosakan). '</b></div word-break: break-all><div> Sebab : <b>' .strtoupper($list->aduan->sebab->sebab_kerosakan). '</b></div>' ;
            }
            
        })

        ->editColumn('status_aduan', function ($list) {
           
            if( Auth::user()->hasRole('Operation Admin') )
            { 
                if($list->status_aduan=='BS')
                {
                    return '<span class="badge badge-new">' . strtoupper($list->status->nama_status) . '</span>';
                }
                if($list->status_aduan=='DJ')
                {
                    return '<span class="badge badge-sent">' . strtoupper($list->status->nama_status) . '</span>';
                }
                else //TD
                {
                    return '<span class="badge badge-done">' . strtoupper($list->status->nama_status) . '</span>';
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
                else //TD
                {
                    return '<span class="badge badge-done">' . strtoupper($list->aduan->status->nama_status) . '</span>';
                }
            }

        })
        
        ->editColumn('tahap_kategori', function ($list) {

            if( Auth::user()->hasRole('Operation Admin') )
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
        
        ->rawColumns(['lokasi_aduan', 'id', 'action', 'tahap_kategori', 'status_aduan', 'kategori_aduan', 'nama_pelapor'])
        ->make(true);
    }

    public function updateJuruteknik(Request $request) 
    {
        $aduan = Aduan::where('id', $request->id)->first();

        $aduan->update([
            'tahap_kategori'         => $request->tahap_kategori,
            'status_aduan'           => 'DJ',
            'tarikh_serahan_aduan'   => Carbon::now()->toDateTimeString(),
        ]);

        foreach($request->input('juruteknik_bertugas') as $key => $value) {
            $juruteknik = JuruteknikBertugas::create([
                'id_aduan'              => $request->id,
                'juruteknik_bertugas'   => $value,
                'jenis_juruteknik'      => $request->jenis_juruteknik[$key],
            ]);

            //hantar emel kpd juruteknik

            $data = [
                'nama_penerima' => 'Assalamualaikum wbt & Salam Sejahtera, Tuan/Puan/Encik/Cik ' . $juruteknik->juruteknik->name,
                'penerangan' => 'Anda telah menerima aduan baru pada '.date(' j F Y ', strtotime(Carbon::now()->toDateTimeString())).'. Sila log masuk sistem IDS untuk tindakan selanjutnya',
            ];

            $email = $juruteknik->juruteknik->email;

            Mail::send('aduan.emel-aduan', $data, function ($message) use ($email, $juruteknik) {
                $message->subject('ADUAN BARU ID : ' . $juruteknik->id_aduan);
                $message->from(Auth::user()->email);
                $message->to($email);
            });
        }
        
        Session::flash('message', 'Aduan Telah Berjaya Dihantar kepada Juruteknik');
        return redirect('info-aduan/'.$aduan->id);
    }

    public function infoAduan($id)
    {
        $aduan = Aduan::where('id', $id)->first(); 
        $tahap = TahapKategori::all();
        $status = StatusAduan::select('*')->whereIn('kod_status', ['TD', 'AK', 'DP'])->get();
        $tukarStatus = StatusAduan::select('*')->whereIn('kod_status', ['AS', 'LK'])->get();
        $juruteknik = User::whereHas('roles', function($query){
            $query->where('id', 'CMS002');
        })->get();
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

    public function updateTahap(Request $request) 
    {
        $aduan = Aduan::where('id', $request->id_adu)->first();

        $aduan->update([
            'tahap_kategori'         => $request->tahap_kategori,
        ]);

        $juruteknik = JuruteknikBertugas::where('id_aduan', $request->id_adu)->delete();
        
        foreach($request->juruteknik_bertugas as $key => $value) {
            $juruteknik = JuruteknikBertugas::create([
                'id_aduan'              => $request->id_adu,
                'juruteknik_bertugas'   => $value,
                'jenis_juruteknik'      => $request->jenis_juruteknik[$key],
            ]);
        }
    
        // hantar emel kpd juruteknik

        $data = [
            'nama_penerima' => 'Assalamualaikum wbt & Salam Sejahtera, Tuan/Puan/Encik/Cik ' . $juruteknik->juruteknik->name,
            'penerangan' => 'Anda telah menerima aduan baru pada '.date(' j F Y ', strtotime(Carbon::now()->toDateTimeString())).'. Sila log masuk sistem IDS untuk tindakan selanjutnya',
        ];

        $email = $juruteknik->juruteknik->email;

        Mail::send('aduan.emel-aduan', $data, function ($message) use ($email, $juruteknik) {
            $message->subject('ADUAN BARU ID : ' . $juruteknik->id_aduan);
            $message->from(Auth::user()->email);
            $message->to($email);
        });

        Session::flash('message', 'Aduan Telah Berjaya Dikemaskini');
        return redirect('info-aduan/'.$request->id_adu);
    }

    public function simpanPenambahbaikan(Request $request)
    {
        // dd($request);
        $aduan = Aduan::where('id', $request->id)->first();

        $request->validate([
            'laporan_pembaikan'       => 'required|min:5|max:255',
            'tarikh_selesai_aduan'    => 'required',
            'status_aduan'            => 'required',
            // 'alat_ganti'           => 'required',
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
                $image[$y]->storeAs('/pembaikan', $fileNames.date('dmyhis'));
                ImejPembaikan::create([
                    'id_aduan'  => $aduan->id,
                    'upload_image' => $originalsName.date('dmyhis'),
                    'web_path'  => "app/pembaikan/".$fileNames.date('dmyhis'),
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
                'penerangan'    => 'Aduan yang dilaporkan pada '.date(' j F Y ', strtotime($aduan->tarikh_laporan)).
                                    ' telah dilaksanakan pembaikan oleh juruteknik bertarikh '.date(' j F Y ', strtotime($aduan->tarikh_selesai_aduan)).
                                    'Sila log masuk sistem IDS untuk tindakan selanjutnya',
            ];

            Mail::send('aduan.emel-pembaikan', $data, function ($message) use ($admin_email) {
                $message->subject('PERLAKSANAAN PENAMBAHBAIKAN ADUAN');
                $message->from(Auth::user()->email);
                $message->to($admin_email);
            });
        }

        Session::flash('simpanPembaikan', 'Pembaikan aduan telah berjaya dihantar.');
        return redirect('info-aduan/'.$aduan->id);
    }

    public function kemaskiniPenambahbaikan(Request $request)
    {
        $aduan = Aduan::where('id', $request->id)->first();

        $request->validate([
            'laporan_pembaikan'       => 'required|min:5|max:255',
            'tarikh_selesai_aduan'    => 'required',
            'status_aduan'            => 'required',
            // 'alat_ganti'           => 'required',
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
                $image[$y]->storeAs('/pembaikan', $fileNames.date('dmyhis'));
                ImejPembaikan::create([
                    'id_aduan'  => $aduan->id,
                    'upload_image' => $originalsName.date('dmyhis'),
                    'web_path'  => "app/pembaikan/".$fileNames.date('dmyhis'),
                ]);
            }
        }

        Session::flash('kemaskiniPembaikan', 'Pembaikan aduan telah berjaya dikemaskini dan dihantar.');
        return redirect('info-aduan/'.$aduan->id);
    }

    public function padamAlatan($id, $id_aduan)
    {
        $aduan = Aduan::where('id',$id_aduan)->first();
        $alat = AlatanPembaikan::find($id);
        $alat->delete($aduan);
        return redirect()->back()->with('message', 'Bahan/Alat Ganti Berjaya Dipadam');
    }

    public function padamAduan($id)
    {
        $exist = Aduan::find($id);
        $exist->delete();
        return response()->json(['success'=>'Aduan Berjaya Dipadam.']);
    }

    public function getGambar($file)
    {
        $path = storage_path().'/'.'app'.'/pembaikan/'.$file;

        $file = File::get($path);
        $filetype = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $filetype);

        return $response;
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
       
        if( Auth::user()->hasRole('Operation Admin') )
        { 
            $list = Aduan::all()->whereIn('status_aduan', ['AS','LK']);
        }
        else
        {
            $list = JuruteknikBertugas::where('juruteknik_bertugas', Auth::user()->id)->whereHas('aduan', function($query) {
                $query->select('*')->whereIn('status_aduan', ['AS','LK']);
            })->get();
            
        }

        return datatables()::of($list)
        ->addColumn('action', function ($list) {

            if( Auth::user()->hasRole('Operation Admin') )
            { 
                return '<a href="/info-aduan/' . $list->id.'" class="btn btn-sm btn-info"><i class="fal fa-pencil"></i></a>
                        <button class="btn btn-sm btn-danger btn-delete" data-remote="/senarai-aduan/' . $list->id . '"><i class="fal fa-trash"></i></button>';
            }
            else
            {
                return '<a href="/info-aduan/' . $list->id_aduan.'" class="btn btn-sm btn-info"><i class="fal fa-pencil"></i></a>';
            }
            
        })

        ->editColumn('id', function ($list) {
            if( Auth::user()->hasRole('Operation Admin') )
            { 
                return $list->id;
            }

            else
            {
                return $list->id_aduan;
            }
        })

        ->editColumn('nama_pelapor', function ($list) {

            if( Auth::user()->hasRole('Operation Admin') )
            { 
                return $list->nama_pelapor;
            }

            else
            {
                return strtoupper(isset($list->aduan->nama_pelapor) ? $list->aduan->nama_pelapor : '');
            }
            
        })

        ->editColumn('tarikh_laporan', function ($list) {

            if( Auth::user()->hasRole('Operation Admin') )
            { 
                return date(' Y-m-d | H:i A', strtotime($list->tarikh_laporan) );
            }

            else
            {
                return isset($list->aduan->tarikh_laporan) ? date(' Y-m-d | H:i A', strtotime($list->aduan->tarikh_laporan) ) : '';
            }
            
        })

        ->editColumn('lokasi_aduan', function ($list) {

            if( Auth::user()->hasRole('Operation Admin') )
            { 
                return '<div>' .strtoupper($list->nama_bilik). ', ARAS ' .strtoupper($list->aras_aduan). ', BLOK ' .strtoupper($list->blok_aduan). ', ' .strtoupper($list->lokasi_aduan).'</div>' ;
            }

            else
            {
                return '<div>' .strtoupper($list->aduan->nama_bilik). ', ARAS ' .strtoupper($list->aduan->aras_aduan). ', BLOK ' .strtoupper($list->aduan->blok_aduan). ', ' .strtoupper($list->aduan->lokasi_aduan).'</div>' ;
            }
            
        })

        ->editColumn('kategori_aduan', function ($list) {

            if( Auth::user()->hasRole('Operation Admin') )
            { 
                return '<div> Kategori : <b>' .strtoupper($list->kategori->nama_kategori). '</b></div word-break: break-all><div> Jenis : <b>' .strtoupper($list->jenis->jenis_kerosakan). '</b></div word-break: break-all><div> Sebab : <b>' .strtoupper($list->sebab->sebab_kerosakan). '</b></div>' ;
            }

            else
            {
                return '<div> Kategori : <b>' .strtoupper($list->aduan->kategori->nama_kategori). '</b></div word-break: break-all><div> Jenis : <b>' .strtoupper($list->aduan->jenis->jenis_kerosakan). '</b></div word-break: break-all><div> Sebab : <b>' .strtoupper($list->aduan->sebab->sebab_kerosakan). '</b></div>' ;
            }
            
        })

        ->editColumn('status_aduan', function ($list) {
           
            if( Auth::user()->hasRole('Operation Admin') )
            { 
                if($list->status_aduan=='AS')
                {
                    return '<span class="badge badge-success">' . strtoupper($list->status->nama_status) . '</span>';
                }
                else //LK
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
                else //LK
                {
                    return '<span class="badge badge-success2">' . strtoupper($list->aduan->status->nama_status) . '</span>';
                }
            }

        })
        
        ->editColumn('tahap_kategori', function ($list) {

            if( Auth::user()->hasRole('Operation Admin') )
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
        
        ->rawColumns(['lokasi_aduan', 'id', 'action', 'tahap_kategori', 'status_aduan', 'kategori_aduan', 'nama_pelapor'])
        ->make(true);
    }

    public function senaraiKiv(Request $request)
    {
        return view('aduan.senarai-aduan-kiv');
    }

    public function data_kiv()
    {
        if( Auth::user()->hasRole('Operation Admin') )
        { 
            $list = Aduan::all()->whereIn('status_aduan', ['AK']);
        }
        else
        {
            $list = JuruteknikBertugas::where('juruteknik_bertugas', Auth::user()->id)->whereHas('aduan', function($query) {
                $query->select('*')->whereIn('status_aduan', ['AK']);
            })->get();
        }

        return datatables()::of($list)
        ->addColumn('action', function ($list) {

            if( Auth::user()->hasRole('Operation Admin') )
            { 
                return '<a href="/info-aduan/' . $list->id.'" class="btn btn-sm btn-info"><i class="fal fa-pencil"></i></a>
                        <button class="btn btn-sm btn-danger btn-delete" data-remote="/senarai-aduan/' . $list->id . '"><i class="fal fa-trash"></i></button>';
            }
            else
            {
                return '<a href="/info-aduan/' . $list->id_aduan.'" class="btn btn-sm btn-info"><i class="fal fa-pencil"></i></a>';
            }
            
        })

        ->editColumn('id', function ($list) {
            if( Auth::user()->hasRole('Operation Admin') )
            { 
                return $list->id;
            }

            else
            {
                return $list->id_aduan;
            }
        })

        ->editColumn('nama_pelapor', function ($list) {

            if( Auth::user()->hasRole('Operation Admin') )
            { 
                return $list->nama_pelapor;
            }

            else
            {
                return strtoupper($list->aduan->nama_pelapor);
            }
            
        })

        ->editColumn('tarikh_laporan', function ($list) {

            if( Auth::user()->hasRole('Operation Admin') )
            { 
                return date(' Y-m-d | H:i A', strtotime($list->tarikh_laporan) );
            }

            else
            {
                return date(' Y-m-d | H:i A', strtotime($list->aduan->tarikh_laporan) );
            }
            
        })

        ->editColumn('lokasi_aduan', function ($list) {

            if( Auth::user()->hasRole('Operation Admin') )
            { 
                return '<div>' .strtoupper($list->nama_bilik). ', ARAS ' .strtoupper($list->aras_aduan). ', BLOK ' .strtoupper($list->blok_aduan). ', ' .strtoupper($list->lokasi_aduan).'</div>' ;
            }

            else
            {
                return '<div>' .strtoupper($list->aduan->nama_bilik). ', ARAS ' .strtoupper($list->aduan->aras_aduan). ', BLOK ' .strtoupper($list->aduan->blok_aduan). ', ' .strtoupper($list->aduan->lokasi_aduan).'</div>' ;
            }
            
        })

        ->editColumn('kategori_aduan', function ($list) {

            if( Auth::user()->hasRole('Operation Admin') )
            { 
                return '<div> Kategori : <b>' .strtoupper($list->kategori->nama_kategori). '</b></div word-break: break-all><div> Jenis : <b>' .strtoupper($list->jenis->jenis_kerosakan). '</b></div word-break: break-all><div> Sebab : <b>' .strtoupper($list->sebab->sebab_kerosakan). '</b></div>' ;
            }

            else
            {
                return '<div> Kategori : <b>' .strtoupper($list->aduan->kategori->nama_kategori). '</b></div word-break: break-all><div> Jenis : <b>' .strtoupper($list->aduan->jenis->jenis_kerosakan). '</b></div word-break: break-all><div> Sebab : <b>' .strtoupper($list->aduan->sebab->sebab_kerosakan). '</b></div>' ;
            }
            
        })

        ->editColumn('status_aduan', function ($list) {
           
            if( Auth::user()->hasRole('Operation Admin') )
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

            if( Auth::user()->hasRole('Operation Admin') )
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
        
        ->rawColumns(['lokasi_aduan', 'id', 'action', 'tahap_kategori', 'status_aduan', 'kategori_aduan', 'nama_pelapor'])
        ->make(true);
    }

    public function senaraiBertindih(Request $request)
    {
        return view('aduan.senarai-aduan-bertindih');
    }

    public function data_bertindih()
    {
        if( Auth::user()->hasRole('Operation Admin') )
        { 
            $list = Aduan::all()->whereIn('status_aduan', ['DP']);
        }
        else
        {
            $list = JuruteknikBertugas::where('juruteknik_bertugas', Auth::user()->id)->whereHas('aduan', function($query) {
                $query->select('*')->whereIn('status_aduan', ['DP']);
            })->get();
        }

        return datatables()::of($list)
        ->addColumn('action', function ($list) {

            if( Auth::user()->hasRole('Operation Admin') )
            { 
                return '<a href="/info-aduan/' . $list->id.'" class="btn btn-sm btn-info"><i class="fal fa-pencil"></i></a>
                        <button class="btn btn-sm btn-danger btn-delete" data-remote="/senarai-aduan/' . $list->id . '"><i class="fal fa-trash"></i></button>';
            }
            else
            {
                return '<a href="/info-aduan/' . $list->id_aduan.'" class="btn btn-sm btn-info"><i class="fal fa-pencil"></i></a>';
            }
            
        })

        ->editColumn('id', function ($list) {
            if( Auth::user()->hasRole('Operation Admin') )
            { 
                return $list->id;
            }

            else
            {
                return $list->id_aduan;
            }
        })

        ->editColumn('nama_pelapor', function ($list) {

            if( Auth::user()->hasRole('Operation Admin') )
            { 
                return $list->nama_pelapor;
            }

            else
            {
                return strtoupper($list->aduan->nama_pelapor);
            }
            
        })

        ->editColumn('tarikh_laporan', function ($list) {

            if( Auth::user()->hasRole('Operation Admin') )
            { 
                return date(' Y-m-d | H:i A', strtotime($list->tarikh_laporan) );
            }

            else
            {
                return date(' Y-m-d | H:i A', strtotime($list->aduan->tarikh_laporan) );
            }
            
        })

        ->editColumn('lokasi_aduan', function ($list) {

            if( Auth::user()->hasRole('Operation Admin') )
            { 
                return '<div>' .strtoupper($list->nama_bilik). ', ARAS ' .strtoupper($list->aras_aduan). ', BLOK ' .strtoupper($list->blok_aduan). ', ' .strtoupper($list->lokasi_aduan).'</div>' ;
            }

            else
            {
                return '<div>' .strtoupper($list->aduan->nama_bilik). ', ARAS ' .strtoupper($list->aduan->aras_aduan). ', BLOK ' .strtoupper($list->aduan->blok_aduan). ', ' .strtoupper($list->aduan->lokasi_aduan).'</div>' ;
            }
            
        })

        ->editColumn('kategori_aduan', function ($list) {

            if( Auth::user()->hasRole('Operation Admin') )
            { 
                return '<div> Kategori : <b>' .strtoupper($list->kategori->nama_kategori). '</b></div word-break: break-all><div> Jenis : <b>' .strtoupper($list->jenis->jenis_kerosakan). '</b></div word-break: break-all><div> Sebab : <b>' .strtoupper($list->sebab->sebab_kerosakan). '</b></div>' ;
            }

            else
            {
                return '<div> Kategori : <b>' .strtoupper($list->aduan->kategori->nama_kategori). '</b></div word-break: break-all><div> Jenis : <b>' .strtoupper($list->aduan->jenis->jenis_kerosakan). '</b></div word-break: break-all><div> Sebab : <b>' .strtoupper($list->aduan->sebab->sebab_kerosakan). '</b></div>' ;
            }
            
        })

        ->editColumn('status_aduan', function ($list) {
           
            if( Auth::user()->hasRole('Operation Admin') )
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

            if( Auth::user()->hasRole('Operation Admin') )
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
        
        ->rawColumns(['lokasi_aduan', 'id', 'action', 'tahap_kategori', 'status_aduan', 'kategori_aduan', 'nama_pelapor'])
        ->make(true);
    }
    
    public function simpanStatus(Request $request)
    {
        $aduan = Aduan::where('id', $request->id)->first();

        $aduan->update([
            'status_aduan'           => $request->status_aduan,
            'catatan_pembaikan'      => $request->catatan_pembaikan,
        ]);

        $emel = $aduan->emel_pelapor;

        $data2 = [
            'nama_penerima' => 'Assalamualaikum wbt & Salam Sejahtera, Tuan/Puan/Encik/Cik ' . $aduan->nama_pelapor,
            'penerangan' => 'Aduan yang dilaporkan bertarikh '.$aduan->tarikh_laporan. ' telah selesai dilakukan penambahbaikan. Sila log masuk sistem IDS untuk melakukan pengesahan.',
        ];

        Mail::send('aduan.emel-semakan', $data2, function ($message) use ($emel) {
            $message->subject('PENGESAHAN PENAMBAHBAIKAN ADUAN');
            $message->from(Auth::user()->email);
            $message->to($emel);
        });

        Session::flash('simpanCatatan', 'Pengesahan pembaikan telah berjaya dikemaskini.');
        return redirect('info-aduan/'.$aduan->id);
    }

    // Export & PDF

    public function pdfAduan(Request $request, $id)
    {
        $aduan = Aduan::where('id', $id)->first();
        $resit = ResitAduan::where('id_aduan', $id)->get();
        $imej = ImejAduan::where('id_aduan', $id)->get();
        $gambar = ImejPembaikan::where('id_aduan', $id)->get();
        $juruteknik = JuruteknikBertugas::where('id_aduan', $id)->orderBy('jenis_juruteknik', 'ASC')->get();
        return view('aduan.aduanPdf', compact('aduan', 'resit', 'imej', 'gambar', 'juruteknik'));
    }

    public function aduan_all(Request $request)
    {
        $kategori = KategoriAduan::select('kod_kategori', 'nama_kategori')->get();
        $status = StatusAduan::select('kod_status', 'nama_status')->get();
        $tahap = TahapKategori::select('kod_tahap', 'jenis_tahap')->get();
        $bulan = Aduan::select('bulan_laporan')->groupBy('bulan_laporan')->orderBy('bulan_laporan', 'ASC')->get();
        // $test = Aduan::select(DB::raw("MONTH(tarikh_laporan) bulan"))
        // ->groupby('bulan')
        // ->get();
        
        $juruteknik = User::select('id', 'name')->whereHas('roles', function($query){
            $query->where('id', 'CMS002');
        })->get();

        $cond = "1"; // 1 = selected

        $selectedkategori = $request->kategori;
        $selectedstatus = $request->status;
        $selectedtahap = $request->tahap; 
        $selectedbulan = $request->bulan;
        $list = [];

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

        return view('aduan.laporan_excel', compact('dat', 'juruteknik', 'req_juruteknik', 'req_bulan', 'req_kategori', 'req_status', 'data', 'tahap', 'kategori', 'list', 
        'status', 'bulan', 'request', 'selectedtahap', 'selectedkategori', 'selectedstatus', 'selectedbulan', 'req_stat', 'req_kate', 'req_bul'));
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

        if( $request->juruteknik != "" && $request->juruteknik != "All")
        {
            $cond .= " AND id = '".$request->juruteknik."' ";
        }
        
        if( Auth::user()->hasRole('Operation Admin') )
        { 
            $aduan = Aduan::whereRaw($cond)->get();

        } else {

            $aduan = Aduan::whereRaw($cond)->with(['juruteknik'=>function($query){
                $query->where('juruteknik_bertugas', Auth::user()->id);
            }])->get();
        }

        return datatables()::of($aduan)

        ->editColumn('nama_pelapor', function ($aduan) {

            return isset($aduan->nama_pelapor) ? strtoupper($aduan->nama_pelapor) : '<div style="color:red;" > -- </div>';
        })

        ->editColumn('nama_bilik', function ($aduan) {

            return isset($aduan->nama_bilik) ? strtoupper($aduan->nama_bilik) : '<div style="color:red;" > -- </div>';
        })

        ->editColumn('aras_aduan', function ($aduan) {

            return isset($aduan->aras_aduan) ? strtoupper($aduan->aras_aduan) : '<div style="color:red;" > -- </div>';
        })

        ->editColumn('blok_aduan', function ($aduan) {

            return isset($aduan->blok_aduan) ? strtoupper($aduan->blok_aduan) : '<div style="color:red;" > -- </div>';
        })

        ->editColumn('lokasi_aduan', function ($aduan) {

            return isset($aduan->lokasi_aduan) ? strtoupper($aduan->lokasi_aduan) : '<div style="color:red;" > -- </div>';
        })

        ->editColumn('kategori_aduan', function ($aduan) {

            return isset($aduan->kategori->nama_kategori) ? strtoupper($aduan->kategori->nama_kategori) : '<div style="color:red;" > -- </div>';
        })

        ->editColumn('jenis_kerosakan', function ($aduan) {

            return isset($aduan->jenis->jenis_kerosakan) ? strtoupper($aduan->jenis->jenis_kerosakan) : '<div style="color:red;" > -- </div>';
        })

        ->editColumn('sebab_kerosakan', function ($aduan) {

            return isset($aduan->sebab->sebab_kerosakan) ? strtoupper($aduan->sebab->sebab_kerosakan) : '<div style="color:red;" > -- </div>';
        })

        ->editColumn('maklumat_tambahan', function ($aduan) {

            return isset($aduan->maklumat_tambahan) ? strtoupper($aduan->maklumat_tambahan) : '<div style="color:red;" > -- </div>';
        })

        ->editColumn('tahap_kategori', function ($aduan) {

            return isset($aduan->tahap->jenis_tahap) ? strtoupper($aduan->tahap->jenis_tahap) : '<div style="color:red;" > -- </div>';
        })

        ->editColumn('tarikh_laporan', function ($aduan) {

            return isset($aduan->tarikh_laporan) ? date(' d-m-Y ', strtotime($aduan->tarikh_laporan)) : '--';
        })

        ->editColumn('tarikh_serahan_aduan', function ($aduan) {

            return isset($aduan->tarikh_serahan_aduan) ? date(' d-m-Y ', strtotime($aduan->tarikh_serahan_aduan)) : '--';
        })

        ->editColumn('laporan_pembaikan', function ($aduan) {

            return isset($aduan->laporan_pembaikan) ? strtoupper($aduan->laporan_pembaikan) : '<div style="color:red;" > -- </div>';
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

            // return isset($aduan->pengesahan_pembaikan) ? strtoupper($aduan->pengesahan_pembaikan) : '<div style="color:red;" > -- </div>';
        })

        ->editColumn('caj_kerosakan', function ($aduan) {

            return isset($aduan->caj_kerosakan) ? strtoupper($aduan->caj_kerosakan) : '<div style="color:red;" > -- </div>';
        })

        ->editColumn('bahan', function ($aduan) {

            $datas = AlatanPembaikan::where('id_aduan', $aduan->id)->get();
            $alat = '';
            foreach($datas as $data){
                $alat .= '<div>'.$data->alat->alat_ganti.', </div word-break>';
            }

            return isset($alat) ? strtoupper($alat) : '--';
        })

        ->editColumn('ak_upah', function ($aduan) {

            return isset($aduan->ak_upah) ? 'RM'.strtoupper($aduan->ak_upah) : '<div style="color:red;" > -- </div>';
        })

        ->editColumn('ak_bahan_alat', function ($aduan) {

            return isset($aduan->ak_bahan_alat) ? 'RM'.strtoupper($aduan->ak_bahan_alat) : '<div style="color:red;" > -- </div>';
        })

        ->editColumn('jumlah_kos', function ($aduan) {

            return isset($aduan->jumlah_kos) ? 'RM'.strtoupper($aduan->jumlah_kos) : '<div style="color:red;" > -- </div>';
        })

        ->editColumn('tarikh_selesai_aduan', function ($aduan) {

            return isset($aduan->tarikh_selesai_aduan) ? date(' d-m-Y ', strtotime($aduan->tarikh_selesai_aduan)) : '--';
        })

        ->editColumn('catatan_pembaikan', function ($aduan) {

            return isset($aduan->catatan_pembaikan) ? strtoupper($aduan->catatan_pembaikan) : '<div style="color:red;" > -- </div>';
        })

        ->editColumn('status_aduan', function ($aduan) {

            return isset($aduan->status->nama_status) ? strtoupper($aduan->status->nama_status) : '<div style="color:red;" > -- </div>';
        })

        ->editColumn('juruteknik', function ($aduan) {

            $data = JuruteknikBertugas::where('id_aduan', $aduan->id)->with(['juruteknik'])->get();

            $juru = '';
            foreach($data as $datas){
                $juru .= '<div>'.$datas->juruteknik->name.', </div word-break>';
            }
    
            return isset($juru) ? strtoupper($juru) : '--';
        })

        ->rawColumns(['nama_pelapor', 'tarikh_laporan', 'nama_bilik', 'aras_aduan', 'blok_aduan', 'lokasi_aduan', 'kategori_aduan', 'jenis_kerosakan', 'sebab_kerosakan', 'maklumat_tambahan', 'tahap_kategori', 
                      'tarikh_serahan_aduan', 'laporan_pembaikan', 'bahan', 'ak_upah', 'ak_bahan_alat', 'jumlah_kos', 'tarikh_selesai_aduan', 'catatan_pembaikan', 'status_aduan', 'juruteknik', 'pengesahan_pembaikan',
                      'pengesahan_aduan', 'caj_kerosakan'])
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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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
