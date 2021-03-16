<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use Session;
use Carbon\Carbon;
use App\Aduan;
use App\JawatanPengadu;
use App\JenisKerosakan;
use App\KategoriAduan;
use App\SebabKerosakan;
use App\StatusAduan;
use App\TahapKategori;
use Illuminate\Http\Request;
use App\Http\Requests\StoreAduanRequest;
use App\Http\Requests\StoreEditAduanRequest;
use App\Http\Requests\StorePembaikanRequest;
use Illuminate\Support\Facades\Mail;

class AduanController extends Controller
{
    //Borang Aduan

    public function aduanBaru()
    {
        return view('aduan.aduan-baru');
    }

    public function borangAduan()
    {
        $jawatan = JawatanPengadu::all();
        $kategori = KategoriAduan::all();
        $jenis = JenisKerosakan::all();
        $sebab = SebabKerosakan::all();
        $aduan = new Aduan();
        return view('aduan.borang-aduan', compact('jawatan', 'kategori', 'jenis', 'sebab', 'aduan'));
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

    public function simpanAduan(StoreAduanRequest $request)
    {
        $aduan = Aduan::create([
            'nama_pelapor'              => strtoupper($request->nama_pelapor),
            'emel_pelapor'              => $request->emel_pelapor,
            'jawatan_pelapor'           => $request->jawatan_pelapor,
            'no_tel_pelapor'            => $request->no_tel_pelapor,
            'no_tel_bimbit_pelapor'     => $request->no_tel_bimbit_pelapor, 
            'no_bilik_pelapor'          => $request->no_bilik_pelapor, 
            'tarikh_laporan'            => Carbon::now()->toDateTimeString(),
            'lokasi_aduan'              => $request->lokasi_aduan,
            'blok_aduan'                => $request->blok_aduan, 
            'aras_aduan'                => $request->aras_aduan, 
            'nama_bilik'                => $request->nama_bilik,
            'kategori_aduan'            => $request->kategori_aduan,
            'jenis_kerosakan'           => $request->jenis_kerosakan,
            'jk_penerangan'             => $request->jk_penerangan,
            'sebab_kerosakan'           => $request->sebab_kerosakan,
            'sk_penerangan'             => $request->sk_penerangan,
            'maklumat_tambahan'         => $request->maklumat_tambahan,
            'status_aduan'              => 'BS',
        ]);
            
        $admin = User::whereHas('roles', function($query){
            $query->where('id', 'CMS001');
        })->get();

        foreach($admin as $value)
        {
            $admin_email = $value->email;

            $data = [
                'nama_penerima' => 'Assalamualaikum wbt & Salam Sejahtera, ' . $value->name,
                'penerangan' => 'Anda telah menerima aduan baru. Sila log masuk sistem IDS',
            ];

            Mail::send('aduan.emel-aduan-baru', $data, function ($message) use ($admin_email) {
                $message->subject('ADUAN BARU');
                $message->from('ITadmin@intec.edu.my');
                $message->to($admin_email);
            });

        }

        $emel = $request->emel_pelapor;

        $data2 = [
            'nama_penerima' => 'Assalamualaikum wbt & Salam Sejahtera, ' . $request->nama_pelapor,
            'penerangan' => 'Terima kasih kerana menggunakan platform E-Aduan INTEC Education College.',
            'id_semakan' => 'ID untuk semakan aduan anda ialah : ' . $aduan->id,
        ];

        Mail::send('aduan.emel-semakan', $data2, function ($message) use ($emel) {
            $message->subject('ID SEMAKAN ADUAN');
            $message->from('ITadmin@intec.edu.my');
            $message->to($emel);
        });

        Session::flash('message', 'Aduan anda telah berjaya dihantar. ID semakan aduan telah dihantar kepada emel anda. Sebarang info akan dimaklumkan kemudian.');
        return redirect('/aduan');
    }

    public function semakAduan(Request $request)
    {
        $semak = Aduan::where('id', $request->id)->get();
        return view('aduan.semak-aduan', compact('semak'));
    }

    //Senarai Aduan

    public function senaraiAduan(Request $request)
    {
        $aduan = Aduan::all();

        $juruteknik = User::whereHas('roles', function($query){
            $query->where('id', 'CMS002');
        })->get();

        return view('aduan.senarai-aduan', compact('aduan', 'juruteknik'))->with('no', 1);
    }

    public function updateJuruteknik(StoreEditAduanRequest $request) 
    {
        //ubah juruteknik
        $aduan = Aduan::where('id', $request->id)->first();

        $aduan->update([
            'juruteknik_bertugas'    => $request->juruteknik_bertugas,
            'tahap_kategori'         => $request->tahap_kategori,
            'status_aduan'           => 'DJ',
            'tarikh_serahan_aduan'   => Carbon::now()->toDateTimeString(),
        ]);

        //hantar emel kpd juruteknik
        $data = [
            'nama_penerima' => 'Assalamualaikum wbt & Salam Sejahtera, ' . $aduan->juruteknik->name,
            'penerangan' => 'Anda telah menerima tugasan baru. Sila log masuk sistem CMS',
        ];

        $email = $aduan->juruteknik->email;

        Mail::send('aduan.emel-aduan', $data, function ($message) use ($email, $aduan) {
            $message->subject('Aduan Baru ID : ' . $aduan->id);
            $message->from(Auth::user()->email);
            $message->to($email);
        });
        
        Session::flash('message', 'Aduan Telah Berjaya Dihantar kepada Juruteknik');
        return redirect('info-aduan/'.$aduan->id);
    }

    public function padamAduan($id)
    {
        $exist = Aduan::find($id);
        $exist->delete();
        return response()->json(['success'=>'Aduan Berjaya Dipadam.']);
    }

    public function data_senarai()
    {
       
        if( Auth::user()->hasRole('Operation Admin') )
        { 
            $aduan = Aduan::all()->whereIn('status_aduan', ['BS','DJ','TD']);
        }
        else
        {
            $aduan = Aduan::select('*')->whereIn('status_aduan', ['BS','DJ','TD'])->where('juruteknik_bertugas', Auth::user()->id)->get();
        }

        return datatables()::of($aduan)
        ->addColumn('action', function ($aduan) {

        if( Auth::user()->hasRole('Operation Admin') )
        { 
            return '<a href="/info-aduan/' . $aduan->id.'" class="btn btn-sm btn-info"><i class="fal fa-pencil"></i> Aduan</a>
                    <button class="btn btn-sm btn-danger btn-delete" data-remote="/senarai-aduan/' . $aduan->id . '"><i class="fal fa-trash"></i>  Padam</button>';
        }

        else
        {
            return '<a href="/info-aduan/' . $aduan->id.'" class="btn btn-sm btn-info"><i class="fal fa-pencil"></i> Pembaikan Aduan</a>';
        }
            
        })

        ->editColumn('tarikh_laporan', function ($aduan) {

            return date(' Y-m-d | H:i A', strtotime($aduan->tarikh_laporan) );
        })

        ->editColumn('jawatan_pelapor', function ($aduan) {

            return strtoupper($aduan->jawatan->nama_jawatan);
        })

        ->editColumn('lokasi_aduan', function ($aduan) {

            return '<div>' .strtoupper($aduan->nama_bilik). ', ARAS ' .strtoupper($aduan->aras_aduan). ', BLOK ' .strtoupper($aduan->blok_aduan). ', ' .strtoupper($aduan->lokasi_aduan).'</div>' ;
        })

        ->editColumn('kategori_aduan', function ($aduan) {

            return $aduan->kategori->nama_kategori;
        })

        ->editColumn('status_aduan', function ($aduan) {
           
            if($aduan->status_aduan=='BS')
            {
                return '<span class="badge badge-new">' . strtoupper($aduan->status->nama_status) . '</span>';
            }
            if($aduan->status_aduan=='DJ')
            {
                return '<span class="badge badge-sent">' . strtoupper($aduan->status->nama_status) . '</span>';
            }
            else
            {
                return '<span class="badge badge-done">' . strtoupper($aduan->status->nama_status) . '</span>';
            }

        })

        ->editColumn('juruteknik_bertugas', function ($aduan) {

            return isset($aduan->juruteknik->name) ? $aduan->juruteknik->name : '<p style="color:red">TIADA JURUTEKNIK DITUGASKAN</p>';
        })
        
        ->editColumn('tahap_kategori', function ($aduan) {

            if($aduan->tahap_kategori=='B')
            {
                return '<span class="low" data-toggle="tooltip" data-placement="top" title="BIASA">' . '</span>';
            }
            elseif($aduan->tahap_kategori=='S')
            {
                return '<span class="medium" data-toggle="tooltip" data-placement="top" title="SEGERA">' . '</span>';
            }
            elseif($aduan->tahap_kategori=='C')
            {
                return '<span class="high" data-toggle="tooltip" data-placement="top" title="CEMAS">' . '</span>';
            }
            else
            {
                return '<span class="none" data-toggle="tooltip" data-placement="top" title="BELUM DITENTUKAN">' . '</span>';
            }
        })
        
        ->rawColumns(['lokasi_aduan', 'action', 'juruteknik_bertugas', 'tahap_kategori', 'status_aduan'])
        ->make(true);
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
            $aduan = Aduan::all()->whereIn('status_aduan', ['AS']);
        }
        else
        {
            $aduan = Aduan::select('*')->whereIn('status_aduan', ['AS'])->where('juruteknik_bertugas', Auth::user()->id)->get();
        }

        return datatables()::of($aduan)
        ->addColumn('action', function ($aduan) {

        if( Auth::user()->hasRole('Operation Admin') )
        { 
            return '<a href="/info-aduan/' . $aduan->id.'" class="btn btn-sm btn-info"><i class="fal fa-pencil"></i> Aduan</a>
                    <button class="btn btn-sm btn-danger btn-delete" data-remote="/senarai-aduan/' . $aduan->id . '"><i class="fal fa-trash"></i>  Padam</button>';
        }

        else
        {
            return '<a href="/info-aduan/' . $aduan->id.'" class="btn btn-sm btn-info"><i class="fal fa-pencil"></i> Pembaikan Aduan</a>';
        }
            
        })

        ->editColumn('tarikh_laporan', function ($aduan) {

            return date(' Y-m-d | H:i A', strtotime($aduan->tarikh_laporan) );
        })

        ->editColumn('jawatan_pelapor', function ($aduan) {

            return strtoupper($aduan->jawatan->nama_jawatan);
        })

        ->editColumn('lokasi_aduan', function ($aduan) {

            return '<div>' .strtoupper($aduan->nama_bilik). ', ARAS ' .strtoupper($aduan->aras_aduan). ', BLOK ' .strtoupper($aduan->blok_aduan). ', ' .strtoupper($aduan->lokasi_aduan).'</div>' ;
        })

        ->editColumn('kategori_aduan', function ($aduan) {

            return $aduan->kategori->nama_kategori; 
        })

        ->editColumn('status_aduan', function ($aduan) {

            return '<span class="badge badge-success">' . strtoupper($aduan->status->nama_status) . '</span>';
        })

        ->editColumn('juruteknik_bertugas', function ($aduan) {

            return isset($aduan->juruteknik->name) ? $aduan->juruteknik->name : '<p style="color:red">TIADA JURUTEKNIK DITUGASKAN</p>';
        })

        ->editColumn('tahap_kategori', function ($aduan) {

            if($aduan->tahap_kategori=='B')
            {
                return '<span class="low" data-toggle="tooltip" data-placement="top" title="BIASA">' . '</span>';
            }
            elseif($aduan->tahap_kategori=='S')
            {
                return '<span class="medium" data-toggle="tooltip" data-placement="top" title="SEGERA">' . '</span>';
            }
            elseif($aduan->tahap_kategori=='C')
            {
                return '<span class="high" data-toggle="tooltip" data-placement="top" title="CEMAS">' . '</span>';
            }
            else
            {
                return '<span class="none" data-toggle="tooltip" data-placement="top" title="BELUM DITENTUKAN">' . '</span>';
            }
        })
        
        ->rawColumns(['lokasi_aduan', 'action', 'juruteknik_bertugas', 'tahap_kategori', 'status_aduan'])
        ->make(true);
    }

    public function senaraiKiv(Request $request)
    {
        $aduan = Aduan::all();

        $juruteknik = User::whereHas('roles', function($query){
            $query->where('id', 'CMS002');
        })->get();

        return view('aduan.senarai-aduan-kiv', compact('aduan', 'juruteknik'))->with('no', 1);
    }

    public function data_kiv()
    {
       
        if( Auth::user()->hasRole('Operation Admin') )
        { 
            $aduan = Aduan::all()->whereIn('status_aduan', ['AK']);
        }
        else
        {
            $aduan = Aduan::select('*')->whereIn('status_aduan', ['AK'])->where('juruteknik_bertugas', Auth::user()->id)->get();
        }

        return datatables()::of($aduan)
        ->addColumn('action', function ($aduan) {

        if( Auth::user()->hasRole('Operation Admin') )
        { 
            return '<a href="/info-aduan/' . $aduan->id.'" class="btn btn-sm btn-info"><i class="fal fa-pencil"></i> Aduan</a>
                    <button class="btn btn-sm btn-danger btn-delete" data-remote="/senarai-aduan/' . $aduan->id . '"><i class="fal fa-trash"></i>  Padam</button>';
        }

        else
        {
            return '<a href="/info-aduan/' . $aduan->id.'" class="btn btn-sm btn-info"><i class="fal fa-pencil"></i> Pembaikan Aduan</a>';
        }
            
        })

        ->editColumn('tarikh_laporan', function ($aduan) {

            return date(' Y-m-d | H:i A', strtotime($aduan->tarikh_laporan) );
        })

        ->editColumn('jawatan_pelapor', function ($aduan) {

            return strtoupper($aduan->jawatan->nama_jawatan);
        })

        ->editColumn('lokasi_aduan', function ($aduan) {

            return '<div>' .strtoupper($aduan->nama_bilik). ', ARAS ' .strtoupper($aduan->aras_aduan). ', BLOK ' .strtoupper($aduan->blok_aduan). ', ' .strtoupper($aduan->lokasi_aduan).'</div>' ;
        })

        ->editColumn('kategori_aduan', function ($aduan) {

            return $aduan->kategori->nama_kategori;
             
        })

        ->editColumn('status_aduan', function ($aduan) {

            return '<span class="badge badge-kiv">' . strtoupper($aduan->status->nama_status) . '</span>';
             
        })

        ->editColumn('juruteknik_bertugas', function ($aduan) {

            return isset($aduan->juruteknik->name) ? $aduan->juruteknik->name : '<p style="color:red">TIADA JURUTEKNIK DITUGASKAN</p>';
        })
        
        ->editColumn('tahap_kategori', function ($aduan) {

            if($aduan->tahap_kategori=='B')
            {
                return '<span class="low" data-toggle="tooltip" data-placement="top" title="BIASA">' . '</span>';
            }
            elseif($aduan->tahap_kategori=='S')
            {
                return '<span class="medium" data-toggle="tooltip" data-placement="top" title="SEGERA">' . '</span>';
            }
            elseif($aduan->tahap_kategori=='C')
            {
                return '<span class="high" data-toggle="tooltip" data-placement="top" title="CEMAS">' . '</span>';
            }
            else
            {
                return '<span class="none" data-toggle="tooltip" data-placement="top" title="BELUM DITENTUKAN">' . '</span>';
            }
        })
        
        ->rawColumns(['lokasi_aduan', 'action', 'juruteknik_bertugas', 'tahap_kategori', 'status_aduan'])
        ->make(true);
    }

    public function infoAduan($id)
    {
        $aduan = Aduan::where('id', $id)->first(); 
        $tahap = TahapKategori::all();
        $status = StatusAduan::select('*')->whereIn('kod_status', ['TD', 'AK'])->get();
        $tukarStatus = StatusAduan::select('*')->whereIn('kod_status', ['AS'])->get();
        $juruteknik = User::whereHas('roles', function($query){
            $query->where('id', 'CMS002');
        })->get();

        return view('aduan.info-aduan', compact('aduan', 'tahap', 'juruteknik', 'status', 'tukarStatus'))->with('no', 1);
    }

    public function simpanPenambahbaikan(StorePembaikanRequest $request)
    {
        $aduan = Aduan::where('id', $request->id)->first();

        $aduan->update([
            'laporan_pembaikan'       => $request->laporan_pembaikan,
            'bahan_alat'              => $request->bahan_alat,
            'ak_upah'                 => $request->ak_upah,
            'ak_bahan_alat'           => $request->ak_bahan_alat, 
            'jumlah_kos'              => $request->jumlah_kos, 
            'tarikh_selesai_aduan'    => $request->tarikh_selesai_aduan,
            'status_aduan'            => $request->status_aduan,
        ]);

        Session::flash('message', 'Pembaikan aduan telah berjaya dihantar.');
        return redirect('info-aduan/'.$aduan->id);
    }

    public function kemaskiniPenambahbaikan(Request $request)
    {
        $aduan = Aduan::where('id', $request->id)->first();

        $aduan->update([
            'laporan_pembaikan'       => $request->laporan_pembaikan,
            'bahan_alat'              => $request->bahan_alat,
            'ak_upah'                 => $request->ak_upah,
            'ak_bahan_alat'           => $request->ak_bahan_alat, 
            'jumlah_kos'              => $request->jumlah_kos, 
            'tarikh_selesai_aduan'    => $request->tarikh_selesai_aduan,
            'status_aduan'            => $request->status_aduan,
        ]);

        Session::flash('message', 'Pembaikan aduan telah berjaya dikemaskini dan dihantar.');
        return redirect('info-aduan/'.$aduan->id);
    }

    public function simpanStatus(Request $request)
    {
        $aduan = Aduan::where('id', $request->id)->first();

        $aduan->update([
            'status_aduan'           => $request->status_aduan,
            'catatan_pembaikan'      => $request->catatan_pembaikan,
        ]);

        Session::flash('message', 'Data telah berjaya dikemaskini.');
        return redirect('info-aduan/'.$aduan->id);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
