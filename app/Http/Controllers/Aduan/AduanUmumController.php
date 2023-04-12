<?php

namespace App\Http\Controllers\Aduan;

use File;
use Session;
use Response;
use App\User;
use App\Staff;
use App\Student;
use App\Aduan;
use App\ImejAduan;
use App\ResitAduan;
use Carbon\Carbon;
use App\KategoriAduan;
use App\JenisKerosakan;
use App\SebabKerosakan;
use App\StatusAduan;
use App\JuruteknikBertugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;

class AduanUmumController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ic_no  != "")
        {
            $request->validate([
                'ic_no'     => 'required|min:12|max:12|regex:/^[\w-]*$/',
            ]);

            $exist_stf = Staff::where('staff_ic', $request->ic_no)->first();

            $exist_std = Student::where('students_ic', $request->ic_no)->first();

            if(isset($exist_stf)){
                $result = 'Anda telah disahkan sebagai Staf INTEC Education College. Sila log masuk sistem IDS untuk membuat aduan.';

            } elseif($exist_std){
                $result = 'Anda telah disahkan sebagai Pelajar INTEC Education College. Sila log masuk sistem IDS untuk membuat aduan.';

            } else {
                $result = 'Anda layak untuk membuat aduan. Sila pilih samaada hendak Membuat Aduan Baru atau Menyemak Aduan.';

            }

            return view('aduan-umum.aduan-umum', compact('request','result','exist_stf','exist_std'));
        }else{
            return view('aduan-umum.aduan-umum', compact('request'));
        }

    }

    public function borangAduan($id)
    {
        $kategori = KategoriAduan::all();

        $jenis = JenisKerosakan::all();

        $sebab = SebabKerosakan::all();

        $aduan = new Aduan();

        $exist = Aduan::where('id_pelapor', $id)->first();

        return view('aduan-umum.borang-umum', compact('kategori', 'jenis', 'sebab', 'aduan','id','exist'));
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
        $request->validate([
            'nama_pelapor'       => 'required',
            'emel_pelapor'       => 'required',
            'no_tel_pelapor'     => 'required',
            'id_pelapor'         => 'required',
            'lokasi_aduan'       => 'required',
            'blok_aduan'         => 'required',
            'aras_aduan'         => 'required',
            'nama_bilik'         => 'required',
            'kategori_aduan'     => 'required',
            'jenis_kerosakan'    => 'required',
            'sebab_kerosakan'    => 'required',
            'upload_image'       => 'required',
        ]);

        $aduan = Aduan::create([
            'nama_pelapor'              => $request->nama_pelapor,
            'emel_pelapor'              => $request->emel_pelapor,
            'id_pelapor'                => $request->id_pelapor,
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


        if($aduan->kategori_aduan == 'IITU-HDWR' || $aduan->kategori_aduan == 'IITU-NTWK' || $aduan->kategori_aduan == 'IITU-OPR_EMEL' || $aduan->kategori_aduan == 'IITU-NTWK WIRELESS'){

            $admin_staff = Staff::whereIn('staff_id', $admin)->where('staff_code', 'IITU')->get();

            foreach($admin_staff as $value)
            {
                $admin_email = $value->staff_email;

                $data = [
                    'nama_penerima' => 'Assalamualaikum wbt & Salam Sejahtera, Tuan/Puan/Encik/Cik ' . $value->staff_name,
                    'penerangan' => 'Anda telah menerima aduan baru daripada '.$aduan->nama_pelapor.' pada '.date(' d/m/Y ', strtotime(Carbon::now()->toDateTimeString())).'. Sila log masuk sistem IDS untuk tindakan selanjutnya',
                ];

                Mail::send('aduan.emel-aduan', $data, function ($message) use ($user, $admin_email) {
                    $message->subject('EADUAN: ADUAN BAHARU UMUM');
                    $message->from($user->email);
                    $message->to($admin_email);
                });
            }
        }

        if($aduan->kategori_aduan == 'AWM' || $aduan->kategori_aduan == 'ELK' || $aduan->kategori_aduan == 'MKL' || $aduan->kategori_aduan == 'PKH' || $aduan->kategori_aduan == 'TKM'){

            $admin_email = 'intecfacilityuser@intec.edu.my';

            $data = [
                'nama_penerima' => 'Assalamualaikum wbt & Salam Sejahtera, Tuan/Puan/Encik/Cik',
                'penerangan' => 'Anda telah menerima aduan baru daripada '.$aduan->nama_pelapor.' pada '.date(' d/m/Y ', strtotime(Carbon::now()->toDateTimeString())).'. Sila log masuk sistem IDS untuk tindakan selanjutnya',
            ];

            Mail::send('aduan.emel-aduan', $data, function ($message) use ($aduan, $admin_email) {
                $message->subject('EADUAN: ADUAN BAHARU UMUM');
                $message->from($aduan->emel_pelapor);
                $message->to($admin_email);
            });
        }

        $datas = [
            'nama_penerima' => 'Assalamualaikum wbt & Salam Sejahtera, Tuan/Puan/Encik/Cik ' . $aduan->nama_pelapor,
            'penerangan' => 'Anda telah membuat aduan pada '.date(' d/m/Y ', strtotime(Carbon::now()->toDateTimeString())).'. Tiket aduan anda ialah : #'.$aduan->id.'. Tiket boleh digunakan untuk menyemak maklum balas atau tahap aduan anda diproses
                             di dalam sistem IDS. Sila log masuk sistem IDS untuk menyemak aduan anda',
        ];

        Mail::send('aduan.emel-aduan', $datas, function ($message) use ($aduan) {
            $message->subject('EADUAN: ADUAN BAHARU UMUM');
            $message->to($aduan->emel_pelapor);
        });

        Session::flash('message','Aduan anda telah berjaya dihantar dan direkodkan. Sebarang info akan dimaklumkan kemudian. Sila rujuk bahagian di bawah untuk melihat aduan yang dibuat.');
        return redirect('semak-aduan/'.$aduan->id_pelapor);
    }

    public function semakAduan($id)
    {
        $status = StatusAduan::all();

        return view('aduan-umum.semak-umum', compact('status','id'));
    }

    public function dataAduan($id)
    {
        $aduan = Aduan::where('id_pelapor', $id)->with(['kategori','status','juruteknik'])->select('cms_aduan.*');

        return datatables()::of($aduan)
        ->addColumn('action', function ($aduan) {

            if($aduan->status_aduan != 'AB' && $aduan->status_aduan == 'BS'){
                return '<div class="btn-group"><a href="/maklumat-aduan-umum/' . $aduan->id.'" class="btn btn-sm btn-info mr-2"><i class="fal fa-eye"></i></a>
                <a href="" data-target="#crud-modal" data-toggle="modal" data-id="'.$aduan->id.'" class="btn btn-sm btn-danger mr-1"><i class="fal fa-trash"></i></a></div>';
            } else {
                return '<div class="btn-group"><a href="/maklumat-aduan-umum/' . $aduan->id.'" class="btn btn-sm btn-info mr-2"><i class="fal fa-eye"></i></a></div>';
            }
        })

        ->editColumn('id', function ($aduan) {

            return '#'.$aduan->id;
        })

        ->editColumn('tarikh', function ($aduan) {

            return date(' Y/m/d ', strtotime($aduan->tarikh_laporan));
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

            if($aduan->pengesahan_pembaikan == 'Y')
            {
                return '<span class="low" data-toggle="tooltip" data-placement="top" title="DISAHKAN">' . '</span>';
            }
            else
            {
                return '<span class="high" data-toggle="tooltip" data-placement="top" title="BELUM DISAHKAN">' . '</span>';
            }
        })

        ->rawColumns(['action', 'status_aduan', 'lokasi_aduan', 'kategori_aduan', 'juruteknik_bertugas', 'tarikh', 'pengesahan_pembaikan', 'id'])
        ->make(true);
    }

    public function batalAduan(Request $request)
    {
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


        if($aduan->kategori_aduan == 'IITU-HDWR' || $aduan->kategori_aduan == 'IITU-NTWK' || $aduan->kategori_aduan == 'IITU-OPR_EMEL' || $aduan->kategori_aduan == 'IITU-NTWK WIRELESS'){

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
                $message->subject('EADUAN: PEMBATALAN ADUAN UMUM');
                $message->to($admin_email);
            });
        }

        Session::flash('message','Aduan telah berjaya dibatalkan. Aduan yang dibatalkan boleh dilihat dalam senarai anda.');
        return redirect('semak-aduan/'.$aduan->id_pelapor);
    }

    public function maklumatAduan($id)
    {
        $aduan = Aduan::where('id', $id)->first();

        $resit = ResitAduan::where('id_aduan', $id)->get();

        $imej = ImejAduan::where('id_aduan', $id)->get();

        return view('aduan-umum.maklumat-umum', compact('aduan', 'resit', 'imej'));
    }

    public function imejAduan($filename,$type)
    {
        return Storage::response('aduan/'.$filename);
    }

    public function resitAduan($filename,$type)
    {
        return Storage::response('resit/'.$filename);
    }

    public function simpanPengesahan(Request $request)
    {
        $aduan = Aduan::where('id', $request->id)->first();

        $aduan->update([
            'pengesahan_pembaikan'    => 'Y',
        ]);

        Session::flash('message', 'Pengesahan telah berjaya dilaksanakan. Aduan yang disahkan boleh dilihat dalam senarai anda.');

        return redirect('semak-aduan/'.$aduan->id_pelapor);
    }

    public function manualAduan()
    {
        $file = "E-ADUAN MANUAL PENGGUNA LUAR.pdf";

        $path = storage_path().'/eaduan/'.$file;

        $form = File::get($path);
        $filetype = File::mimeType($path);

        $response = Response::make($form, 200);
        $response->header("Content-Type", $filetype);

        return $response;
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
