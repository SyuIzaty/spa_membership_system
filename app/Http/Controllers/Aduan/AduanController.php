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
use App\Stock;
use App\Student;
use App\AduanLog;
use App\ImejAduan;
use App\AlatGanti;
use App\ResitAduan;
use App\StatusAduan;
use App\StokPembaikan;
use App\TahapKategori;
use App\ImejPembaikan;
use App\KategoriAduan;
use App\SebabKerosakan;
use App\JenisKerosakan;
use App\AlatanPembaikan;
use App\JuruteknikBertugas;
use App\StockTransaction;
use Illuminate\Http\Request;
use App\Exports\AduanExport;
use App\Exports\JuruteknikExport;
use App\Exports\IndividuExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use App\Exports\Aduan\eAduanFacilityExport;
use App\Exports\Aduan\eAduanFacilityAllExport;

class AduanController extends Controller
{
    // Aduan Individu

    public function borangAduan()
    {
        $kategori = KategoriAduan::whereIn('kod_kategori', ['AWM','ELK','MKL','PKH','TKM'])->get();
        //after standardized can remove kod_kategori

        $aduan = new Aduan();

        $pengguna = Auth::user();

        return view('aduan.pengguna.borang-aduan', compact('kategori', 'aduan', 'pengguna'));
    }

    public function cariJenis(Request $request)
    {
        $data = JenisKerosakan::select('jenis_kerosakan', 'id')

                ->where('kategori_aduan', $request->id)

                ->get();

        return response()->json($data);
    }

    public function cariSebab(Request $request)
    {
        $data = SebabKerosakan::select('sebab_kerosakan', 'id')

                ->where('kategori_aduan', $request->id)

                ->get();

        return response()->json($data);
    }

    public function cariPengadu(Request $request)
    {
        $data = User::select('id', 'name')

                ->where('category', $request->id)

                ->get();

        return response()->json($data);
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
            'upload_image'       => 'required',
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

        $admin_staff = Staff::whereIn('staff_id', $admin)->where('staff_code', 'OFM')->get();
        //after standardized can remove staff_code

        foreach($admin_staff as $value)
        {
            $data_admin = [
                'nama_penerima'     => $value->staff_name,
                'nama_pengadu'      => $aduan->nama_pelapor,
                'pembuka'           => 'Anda telah menerima aduan baru. Berikut adalah maklumat aduan:',
                'tiket_aduan'       => $aduan->id,
                'lokasi_aduan'      => strtoupper($aduan->lokasi_aduan),
                'kategori_aduan'    => $aduan->kategori->nama_kategori,
                'jenis_kerosakan'   => strtoupper($aduan->jenis->jenis_kerosakan),
                'sebab_kerosakan'   => strtoupper($aduan->sebab->sebab_kerosakan),
                'tarikh'            => date(' d/m/Y ', strtotime(Carbon::now()->toDateTimeString())),
                'penutup'           => 'Sila log masuk ke sistem INTEC Digital Services (IDS) untuk tindakan selanjutnya.',
            ];

            Mail::send('aduan.emel-aduan', $data_admin, function ($message) use ($aduan, $value) {
                $message->subject('E-Aduan: Aduan Baharu');
                $message->from($aduan->emel_pelapor);
                $message->to($value->staff_email);
            });
        }

        $data_pengadu = [
            'nama_penerima'     => $aduan->nama_pelapor,
            'pembuka'           => 'Anda telah membuat aduan baru. Berikut adalah maklumat aduan:',
            'tiket_aduan'       => $aduan->id,
            'lokasi_aduan'      => strtoupper($aduan->lokasi_aduan),
            'kategori_aduan'    => $aduan->kategori->nama_kategori,
            'jenis_kerosakan'   => strtoupper($aduan->jenis->jenis_kerosakan),
            'sebab_kerosakan'   => strtoupper($aduan->sebab->sebab_kerosakan),
            'tarikh'            => date(' d/m/Y ', strtotime(Carbon::now()->toDateTimeString())),
            'penutup'           => 'Tiket boleh digunakan untuk menyemak maklum balas atau tahap aduan anda diproses di dalam sistem. Sila log masuk sistem INTEC Digital Services (IDS) untuk menyemak aduan anda',
        ];

        Mail::send('aduan.emel-aduan', $data_pengadu, function ($message) use ($aduan) {
            $message->subject('E-Aduan: Aduan Baharu');
            $message->to($aduan->emel_pelapor);
        });

        AduanLog::create([
            'name'              => 'default',
            'description'       => 'E-Aduan : Aduan Baru Daripada Pengadu',
            'subject_id'        => $aduan->id,
            'subject_type'      => 'App\Aduan',
            'properties'        => json_encode($request->all()),
            'creator_id'        => Auth::user()->id,
            'creator_type'      => 'App\User',
        ]);

        Session::flash('message');

        return redirect()->back();
    }

    public function aduanIndividu()
    {
        $status = StatusAduan::all();

        return view('aduan.pengguna.aduan', compact('status'));
    }

    public function dataAduanIndividu()
    {
        $aduan = Aduan::where('id_pelapor', Auth::user()->id)->whereIn('kategori_aduan', ['AWM','ELK','MKL','PKH','TKM'])->with(['kategori','jenis','sebab','status'])->select('cms_aduan.*');
        //after standardized can remove kategori_aduan

        return datatables()::of($aduan)

        ->addColumn('action', function ($aduan) {

            if($aduan->status_aduan != 'AB' && $aduan->status_aduan == 'BS'){
                return '<div class="btn-group"><a href="/maklumat-aduan/' . $aduan->id.'" class="btn btn-sm btn-primary mr-2"><i class="fal fa-eye"></i></a>
                <a href="" data-target="#crud-modal" data-toggle="modal" data-id="'.$aduan->id.'" class="btn btn-sm btn-danger mr-1"><i class="fal fa-trash"></i></a></div>';
            } else {
                return '<div class="btn-group"><a href="/maklumat-aduan/' . $aduan->id.'" class="btn btn-sm btn-primary mr-2"><i class="fal fa-eye"></i></a></div>';
            }

        })

        ->addColumn('pdf', function ($aduan) {

            return '<a data-page="/pdf-aduan/'.$aduan->id.'" class="btn btn-info btn-sm text-white float-right" style="cursor: pointer" onclick="Print(this)"><i class="fal fa-print"></i></a>';
        })

        ->editColumn('tarikh_laporan', function ($aduan) {

            return isset($aduan->tarikh_laporan) ? date(' d-m-Y | h:i:s A', strtotime($aduan->tarikh_laporan)) : '-';
        })

        ->editColumn('lokasi_aduan', function ($aduan) {

            return isset($aduan->lokasi_aduan) ? strtoupper($aduan->lokasi_aduan) : '-';
        })

        ->editColumn('kategori_aduan', function ($aduan) {

            return isset($aduan->kategori_aduan) ? strtoupper($aduan->kategori->nama_kategori) : '-';
        })

        ->editColumn('jenis_kerosakan', function ($aduan) {

            return isset($aduan->jenis_kerosakan) ? strtoupper($aduan->jenis->jenis_kerosakan) : '-';
        })

        ->editColumn('sebab_kerosakan', function ($aduan) {

            return isset($aduan->sebab_kerosakan) ? strtoupper($aduan->sebab->sebab_kerosakan) : '-';
        })

        ->addColumn('juruteknik_bertugas', function ($aduan) {

            $staf = null;
            $ketua_juruteknik = JuruteknikBertugas::where('id_aduan', $aduan->id)->where('jenis_juruteknik', 'K')->first();

            if ($ketua_juruteknik) {
                $staf = Staff::where('staff_id', $ketua_juruteknik->juruteknik_bertugas)->first();
            } else {
                $pembantu_juruteknik = JuruteknikBertugas::where('id_aduan', $aduan->id)->where('jenis_juruteknik', 'P')->first();
                if ($pembantu_juruteknik) {
                    $staf = Staff::where('staff_id', $pembantu_juruteknik->juruteknik_bertugas)->first();
                }
            }

            if ($staf) {
                if (isset($staf->staff_phone)) {
                    return $staf->staff_name . ' (' . $staf->staff_phone . ')';
                } elseif (isset($staf->staff_email)) {
                    return $staf->staff_name . ' (' . $staf->staff_email . ')';
                } else {
                    return $staf->staff_name;
                }
            } else {
                return 'TIADA JURUTEKNIK DITUGASKAN';
            }
        })

        ->editColumn('status_aduan', function ($aduan) {

            $statusClasses = [
                'BS' => 'badge-new',
                'DJ' => 'badge-sent',
                'TD' => 'badge-done',
                'AS' => 'badge-success',
                'LK' => 'badge-success2',
                'LU' => 'badge-success2',
                'AK' => 'badge-kiv',
            ];

            $status = $aduan->status_aduan;
            $badgeClass = $statusClasses[$status] ?? 'badge-duplicate';

            return '<span class="badge ' . $badgeClass . '">' . strtoupper($aduan->status->nama_status) . '</span>';
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

        ->rawColumns(['action', 'status_aduan', 'kategori_aduan', 'juruteknik_bertugas', 'tarikh_laporan', 'jenis_kerosakan',
        'pengesahan_pembaikan','sebab_kerosakan','lokasi_aduan','pdf'])

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

        $admin_staff = Staff::whereIn('staff_id', $admin)->where('staff_code', 'OFM')->get();
        //after standardized can remove staff_code

        foreach($admin_staff as $value)
        {
            $data_admin = [
                'nama_penerima'     => $value->staff_name,
                'nama_pengadu'      => $aduan->nama_pelapor,
                'pembuka'           => 'Aduan yang dibuat telah dibatalkan. Berikut adalah maklumat aduan:',
                'tiket_aduan'       => $aduan->id,
                'lokasi_aduan'      => strtoupper($aduan->lokasi_aduan),
                'kategori_aduan'    => $aduan->kategori->nama_kategori,
                'jenis_kerosakan'   => strtoupper($aduan->jenis->jenis_kerosakan),
                'sebab_kerosakan'   => strtoupper($aduan->sebab->sebab_kerosakan),
                'tarikh'            => date(' d/m/Y ', strtotime($aduan->tarikh_laporan)),
                'tarikh_pembatalan' => date(' d/m/Y ', strtotime(Carbon::now()->toDateTimeString())),
                'sebab_pembatalan'  => $aduan->sebab_pembatalan,
                'penutup'           => 'Sila log masuk ke sistem INTEC Digital Services (IDS) untuk menyemak aduan.',
            ];

            Mail::send('aduan.emel-aduan', $data_admin, function ($message) use ($value) {
                $message->subject('E-Aduan: Pembatalan Aduan');
                $message->to($value->staff_email);
            });
        }

        AduanLog::create([
            'name'              => 'default',
            'description'       => 'E-Aduan : Pembatalan Aduan Daripada Pengadu',
            'subject_id'        => $aduan->id,
            'subject_type'      => 'App\Aduan',
            'properties'        => json_encode($request->all()),
            'creator_id'        => Auth::user()->id,
            'creator_type'      => 'App\User',
        ]);

        Session::flash('message','Aduan telah berjaya dibatalkan. Aduan yang dibatalkan boleh dilihat dalam senarai anda.');

        return redirect()->back();
    }

    public function maklumatAduan($id)
    {
        $aduan = Aduan::where('id', $id)->first();

        $resit = ResitAduan::where('id_aduan', $id)->get();

        $imej = ImejAduan::where('id_aduan', $id)->get();

        $gambar = ImejPembaikan::where('id_aduan', $id)->get();

        $juruteknik = JuruteknikBertugas::where('id_aduan', $id)->orderBy('jenis_juruteknik', 'ASC')->get();

        return view('aduan.pengguna.maklumat-aduan', compact('aduan', 'resit', 'imej', 'gambar', 'juruteknik'));
    }

    public function failImejAduan($file)
    {
        return Storage::response('aduan/'.$file);
    }

    public function failResitAduan($filename,$type)
    {
        return Storage::response('resit/'.$filename);
    }

    public function simpanPengesahan(Request $request)
    {
        $aduan = Aduan::where('id', $request->id)->where('id_pelapor', Auth::user()->id)->first();

        $aduan->update([
            'pengesahan_pembaikan'    => 'Y',
        ]);

        AduanLog::create([
            'name'              => 'default',
            'description'       => 'E-Aduan : Pengesahan Pembaikan Aduan Pengadu',
            'subject_id'        => $aduan->id,
            'subject_type'      => 'App\Aduan',
            'properties'        => json_encode($request->all()),
            'creator_id'        => Auth::user()->id,
            'creator_type'      => 'App\User',
        ]);

        Session::flash('message', 'Pengesahan telah berjaya dihantar.');

        return redirect()->back();
    }

    public function failImejPembaikan($file)
    {
        return Storage::response('pembaikan/'.$file);
    }

    public function exportExcelPengadu($id)
    {
        return Excel::download(new eAduanFacilityExport($id), 'Laporan E-Aduan.xlsx');
    }

    public function manualAduan() // OG
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

    public function senarai_aduan(Request $request)
    {
        $status = StatusAduan::all();

        return view('aduan.admin.senarai-aduan', compact('status'));
    }

    public function dataAduan()
    {
        $stf = User::where('category','STF')->pluck('id');

        $list = Aduan::whereIn('status_aduan', ['BS','DJ','TD'])->with(['kategori','status','tahap'])->whereIn('id_pelapor', $stf)->whereIn('kategori_aduan', ['AWM','ELK','MKL','PKH','TKM'])->select('cms_aduan.*');

        return datatables()::of($list)

        ->addColumn('action', function ($list) {

            return '<div class="btn-group"><a href="/info-aduan/' . $list->id.'" class="btn btn-sm btn-primary mr-2"><i class="fal fa-eye"></i></a></div>';
        })

        ->editColumn('nama_pelapor', function ($list) {

            return $list->nama_pelapor ?? '';
        })

        ->editColumn('lokasi_aduan', function ($list) {

            return strtoupper($list->lokasi_aduan) ?? '';
        })

        ->editColumn('tarikh_laporan', function ($list) {

            return date(' d-m-Y ', strtotime($list->tarikh_laporan) );
        })

        ->editColumn('kategori_aduan', function ($list) {

            return $list->kategori->nama_kategori ?? '';
        })

        ->editColumn('status_aduan', function ($list) {

            $statusBadge = '';

            if ($list->status_aduan == 'BS') {
                $statusBadge = '<span class="badge badge-new">' . strtoupper($list->status->nama_status) . '</span>';
            } elseif ($list->status_aduan == 'DJ') {
                $statusBadge = '<span class="badge badge-sent">' . strtoupper($list->status->nama_status) . '</span>';
            } else {
                $statusBadge = '<span class="badge badge-done">' . strtoupper($list->status->nama_status) . '</span>';
            }

            if (Auth::user()->hasPermissionTo('view complaint - admin')) {
                $editLink = '<a href="" data-target="#crud-modals" data-toggle="modal" data-id="'. $list->id.'"><i class="fal fa-pencil ml-2" style="color: red"></i></a>';
                return $statusBadge . $editLink;
            } else {
                return $statusBadge;
            }
        })

        ->addColumn('tempoh', function ($list) {

            if(isset($list->tarikh_selesai_aduan))
            {
                $tempoh = Carbon::parse($list->tarikh_laporan)->diffInDays($list->tarikh_selesai_aduan)+1;

            } else {

                $tempoh = Carbon::parse($list->tarikh_laporan)->diffInDays(Carbon::now())+1;
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

        ->rawColumns(['action', 'tahap_kategori', 'status_aduan', 'kategori_aduan', 'nama_pelapor', 'tempoh', 'tarikh_laporan', 'lokasi_aduan'])
        ->make(true);
    }

    public function dataAduanPelajar()
    {
        $std = User::where('category','STD')->pluck('id');

        $list = Aduan::whereIn('status_aduan', ['BS','DJ','TD'])->with(['kategori','status','tahap'])->whereIn('id_pelapor', $std)->whereIn('kategori_aduan', ['AWM','ELK','MKL','PKH','TKM'])->select('cms_aduan.*');

        return datatables()::of($list)

        ->addColumn('action', function ($list) {

            return '<div class="btn-group"><a href="/info-aduan/' . $list->id.'" class="btn btn-sm btn-primary mr-2"><i class="fal fa-eye"></i></a></div>';
        })

        ->editColumn('nama_pelapor', function ($list) {

            return $list->nama_pelapor ?? '';
        })

        ->editColumn('lokasi_aduan', function ($list) {

            return strtoupper($list->lokasi_aduan) ?? '';
        })

        ->editColumn('tarikh_laporan', function ($list) {

            return date(' d-m-Y ', strtotime($list->tarikh_laporan) );
        })

        ->editColumn('kategori_aduan', function ($list) {

            return $list->kategori->nama_kategori ?? '';
        })

        ->editColumn('status_aduan', function ($list) {

            $statusBadge = '';

            if ($list->status_aduan == 'BS') {
                $statusBadge = '<span class="badge badge-new">' . strtoupper($list->status->nama_status) . '</span>';
            } elseif ($list->status_aduan == 'DJ') {
                $statusBadge = '<span class="badge badge-sent">' . strtoupper($list->status->nama_status) . '</span>';
            } else {
                $statusBadge = '<span class="badge badge-done">' . strtoupper($list->status->nama_status) . '</span>';
            }

            if (Auth::user()->hasPermissionTo('view complaint - admin')) {
                $editLink = '<a href="" data-target="#crud-modals" data-toggle="modal" data-id="'. $list->id.'"><i class="fal fa-pencil ml-2" style="color: red"></i></a>';
                return $statusBadge . $editLink;
            } else {
                return $statusBadge;
            }
        })

        ->addColumn('tempoh', function ($list) {

            if(isset($list->tarikh_selesai_aduan))
            {
                $tempoh = Carbon::parse($list->tarikh_laporan)->diffInDays($list->tarikh_selesai_aduan)+1;

            } else {

                $tempoh = Carbon::parse($list->tarikh_laporan)->diffInDays(Carbon::now())+1;
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

        ->rawColumns(['action', 'tahap_kategori', 'status_aduan', 'kategori_aduan', 'nama_pelapor', 'tempoh', 'tarikh_laporan', 'lokasi_aduan'])
        ->make(true);
    }

    // public function data_luar()
    // {
    //     $merge = User::whereIn('category',['STF','STD'])->pluck('id')->toArray();

    //     $staff = Staff::where('staff_id', Auth::user()->id)->first();

    //     if($staff->staff_code == 'IITU') {

    //         $list = Aduan::whereIn('status_aduan', ['BS','DJ','TD'])->whereNotIn('id_pelapor', $merge)->with(['kategori','status','tahap'])->whereIn('kategori_aduan', ['IITU-HDWR','IITU-NTWK','IITU-OPR_EMEL','IITU-NTWK WIRELESS'])->select('cms_aduan.*');
    //     } elseif($staff->staff_code == 'OFM' || $staff->staff_code == 'AA') {

    //         $list = Aduan::whereIn('status_aduan', ['BS','DJ','TD'])->whereNotIn('id_pelapor', $merge)->with(['kategori','status','tahap'])->whereIn('kategori_aduan', ['AWM','ELK','MKL','PKH','TKM'])->select('cms_aduan.*');
    //     } else {

    //         $list = Aduan::whereIn('status_aduan', ['BS','DJ','TD'])->whereNotIn('id_pelapor', $merge)->with(['kategori','status','tahap'])->select('cms_aduan.*');
    //     }

    //     return datatables()::of($list)
    //     ->addColumn('action', function ($list) {

    //         if ($list->status_aduan == 'DJ' && Auth::user()->hasPermissionTo('view complaint - admin')) {

    //             return '<div class="btn-group"><a href="/info-aduan/' . $list->id.'" class="btn btn-sm btn-info mr-2"><i class="fal fa-pencil"></i></a>
    //                     <a data-page="/muaturun-borang' . $list->id.'" class="btn btn-sm btn-primary text-white mr-2" onclick="Print(this)"><i class="fal fa-file"></i></a></div>';
    //         } else {

    //             return '<div class="btn-group"><a href="/info-aduan/' . $list->id.'" class="btn btn-sm btn-info mr-2"><i class="fal fa-pencil"></i></a></div>';
    //         }
    //     })

    //     ->editColumn('id', function ($list) {

    //         return '#'.$list->id;
    //     })

    //     ->editColumn('nama_pelapor', function ($list) {

    //         return $list->nama_pelapor;
    //     })

    //     ->editColumn('tarikh_laporan', function ($list) {

    //         return date(' Y-m-d ', strtotime($list->tarikh_laporan) );
    //     })

    //     ->editColumn('kategori_aduan', function ($list) {

    //         return $list->kategori->nama_kategori ?? '';
    //     })

    //     ->editColumn('status_aduan', function ($list) {

    //         if (Auth::user()->hasPermissionTo('view complaint - admin')) {

    //             if ($list->status_aduan == 'BS') {
    //                 return '<span class="badge badge-new">' . strtoupper($list->status->nama_status) . '</span>
    //                         <a href="" data-target="#crud-modals" data-toggle="modal" data-id="'. $list->id.'"><i class="fal fa-pencil" style="color: red"></i></a>';
    //             } elseif ($list->status_aduan == 'DJ') {
    //                 return '<span class="badge badge-sent">' . strtoupper($list->status->nama_status) . '</span>
    //                         <a href="" data-target="#crud-modals" data-toggle="modal" data-id="'. $list->id.'"><i class="fal fa-pencil" style="color: red"></i></a>';
    //             } else {
    //                 return '<span class="badge badge-done">' . strtoupper($list->status->nama_status) . '</span>
    //                         <a href="" data-target="#crud-modals" data-toggle="modal" data-id="'. $list->id.'"><i class="fal fa-pencil" style="color: red"></i></a>';
    //             }

    //         } else {

    //             if ($list->status_aduan == 'BS') {
    //                 return '<span class="badge badge-new">' . strtoupper($list->status->nama_status) . '</span>';
    //             } elseif ($list->status_aduan == 'DJ') {
    //                 return '<span class="badge badge-sent">' . strtoupper($list->status->nama_status) . '</span>';
    //             } else {
    //                 return '<span class="badge badge-done">' . strtoupper($list->status->nama_status) . '</span>';
    //             }

    //         }
    //     })

    //     ->editColumn('tempoh', function ($list) {

    //         if(isset($list->tarikh_selesai_aduan))
    //         {
    //             $tempoh = Carbon::parse($list->tarikh_laporan)->diffInDays($list->tarikh_selesai_aduan);

    //         } else {

    //             $tempoh = Carbon::parse($list->tarikh_laporan)->diffInDays(Carbon::now());
    //         }

    //         return $tempoh.' hari';

    //     })

    //     ->editColumn('tahap_kategori', function ($list) {

    //         if($list->tahap_kategori=='B')
    //         {
    //             return '<span class="low" data-toggle="tooltip" data-placement="top" title="BIASA">' . '</span>';
    //         }
    //         elseif($list->tahap_kategori=='S')
    //         {
    //             return '<span class="medium" data-toggle="tooltip" data-placement="top" title="SEGERA">' . '</span>';
    //         }
    //         else
    //         {
    //             return '<span class="none" data-toggle="tooltip" data-placement="top" title="BELUM DITENTUKAN">' . '</span>';
    //         }
    //     })

    //     ->rawColumns(['id', 'action', 'tahap_kategori', 'status_aduan', 'kategori_aduan', 'nama_pelapor', 'tempoh', 'tarikh_laporan'])
    //     ->make(true);
    // }

    public function infoAduan($id)
    {
        $aduan = Aduan::where('id', $id)->first();

        $tahap = TahapKategori::all();

        $status = StatusAduan::all();

        $exist = JuruteknikBertugas::where('id_aduan', $aduan->id)->get();

        $juruteknik_exist = array_column($exist->toArray(), 'juruteknik_bertugas');

        $stok = Stock::where('department_id', 'OFM')->where('status','1')->where('applicable_for_aduan','1')->get();

        $staff_exists = [];

        $staff_exists = Staff::where('staff_code', 'OFM')->whereNotIn('staff_id', $juruteknik_exist)->pluck('staff_id')->toArray();

        $juruteknik = User::whereHas('roles', function ($query) {
            $query->where('id', 'CMS002');
        })->whereIn('id', $staff_exists)->where('active', 'Y')->get();

        $resit = ResitAduan::where('id_aduan', $aduan->id)->get();

        $imej = ImejAduan::where('id_aduan', $aduan->id)->get();

        $gambar = ImejPembaikan::where('id_aduan', $aduan->id)->get();

        $alatan = AlatGanti::orderBy('alat_ganti')->get();

        $alatan_ganti = AlatanPembaikan::where('id_aduan', $aduan->id)->get();

        $stok_pembaikan = StokPembaikan::where('id_aduan', $aduan->id)->get();

        $data = array_column($alatan_ganti->toArray(), 'alat_ganti');

        $senarai_alat =  AlatGanti::whereNotIn('id', $data)->get();

        $senarai_juruteknik = JuruteknikBertugas::where('id_aduan', $aduan->id)->get();

        $juru = JuruteknikBertugas::where('id_aduan', $aduan->id)->where('juruteknik_bertugas', Auth::user()->id)->first();

        $pengadu = User::where('id', $aduan->id_pelapor)->first();

        return view('aduan.info-aduan', compact('pengadu', 'aduan', 'juru', 'tahap', 'juruteknik', 'status', 'resit',
        'imej', 'senarai_juruteknik', 'alatan', 'alatan_ganti', 'senarai_alat', 'gambar','stok','stok_pembaikan'));
    }

    public function cariKuantiti(Request $request)
    {
        $total_bal = 0;
        $stockId = $request->input('id_stok');
        $stockData = Stock::where('id', $stockId)->first();

        if ($stockData) {
            foreach ($stockData->transaction as $list) {
                $total_bal += ($list->stock_in - $list->stock_out);
            }

            $numbers = $total_bal > 0 ? range(1, $total_bal) : [];

            return response()->json($numbers);
        }

        return response()->json([]);
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

                $data_juruteknik = [
                    'nama_penerima'     => $juruteknik->juruteknik->name,
                    'nama_pengadu'      => $aduan->nama_pelapor,
                    'pembuka'           => 'Anda telah ditugaskan dengan aduan baru. Berikut adalah maklumat aduan:',
                    'tiket_aduan'       => $aduan->id,
                    'lokasi_aduan'      => strtoupper($aduan->lokasi_aduan),
                    'kategori_aduan'    => $aduan->kategori->nama_kategori,
                    'jenis_kerosakan'   => strtoupper($aduan->jenis->jenis_kerosakan),
                    'sebab_kerosakan'   => strtoupper($aduan->sebab->sebab_kerosakan),
                    'tarikh'            => date(' d/m/Y ', strtotime($aduan->tarikh_laporan)),
                    'tarikh_serahan'    => date(' d/m/Y ', strtotime(Carbon::now()->toDateTimeString())),
                    'penutup'           => 'Sila log masuk ke sistem INTEC Digital Services (IDS) untuk tindakan selanjutnya.',
                ];

                Mail::send('aduan.emel-aduan', $data_juruteknik, function ($message) use ($juruteknik) {
                    $message->subject('E-Aduan: Penyerahan Aduan');
                    $message->from(Auth::user()->email);
                    $message->to($juruteknik->juruteknik->email);
                });
            }

            $data_pengadu = [
                'nama_penerima'     => $aduan->nama_pelapor,
                'nama_penghantar'   => Auth::user()->name,
                'pembuka'           => 'Aduan anda telah diserahkan kepada juruteknik. Berikut adalah maklumat aduan:',
                'tiket_aduan'       => $aduan->id,
                'lokasi_aduan'      => strtoupper($aduan->lokasi_aduan),
                'kategori_aduan'    => $aduan->kategori->nama_kategori,
                'jenis_kerosakan'   => strtoupper($aduan->jenis->jenis_kerosakan),
                'sebab_kerosakan'   => strtoupper($aduan->sebab->sebab_kerosakan),
                'tarikh'            => date(' d/m/Y ', strtotime($aduan->tarikh_laporan)),
                'tarikh_serahan'    => date(' d/m/Y ', strtotime(Carbon::now()->toDateTimeString())),
                'penutup'           => 'Anda boleh berkomunikasi dengan juruteknik yang ditugaskan untuk sebarang maklumbalas atau pertanyaan.
                                        Sila log masuk sistem INTEC Digital Services (IDS) untuk menyemak status aduan anda.',
            ];

            Mail::send('aduan.emel-aduan', $data_pengadu, function ($message) use ($aduan) {
                $message->subject('E-Aduan: Penyerahan Aduan');
                $message->from(Auth::user()->email);
                $message->to($aduan->emel_pelapor);
            });

        } else {

            $aduan->update([
                'tahap_kategori'         => $request->tahap_kategori,
                'caj_kerosakan'          => $request->caj_kerosakan,
            ]);
        }

        AduanLog::create([
            'name'              => 'default',
            'description'       => 'E-Aduan : Penyerahan Aduan Kepada Juruteknik',
            'subject_id'        => $aduan->id,
            'subject_type'      => 'App\Aduan',
            'properties'        => json_encode($request->all()),
            'creator_id'        => Auth::user()->id,
            'creator_type'      => 'App\User',
        ]);

        Session::flash('kemaskiniTahap', 'Maklumat penyerahan aduan telah berjaya dihantar dan direkodkan.');

        return redirect()->back();
    }

    public function tukarStatus(Request $request)
    {
        $request->validate([
            'kod_status'         => 'required',
            'sebab_tukar_status' => 'required',
        ]);

        if($request->kod_status == 'AS' || $request->kod_status == 'LU' || $request->kod_status == 'LK'){

            $aduan = Aduan::where('id', $request->status_id)->update([
                'status_aduan'          => $request->kod_status,
                'tukar_status'          => Auth::user()->id,
                'sebab_tukar_status'    => $request->sebab_tukar_status,
                'tarikh_selesai_aduan'  => Carbon::now()->toDateTimeString(),
            ]);

        } else {

            if($request->kod_status == 'DJ'){

                $aduan = Aduan::where('id', $request->status_id)->update([
                    'status_aduan'          => $request->kod_status,
                    'tukar_status'          => Auth::user()->id,
                    'sebab_tukar_status'    => $request->sebab_tukar_status,
                    'tarikh_serahan_aduan'  => Carbon::now()->toDateTimeString(),
                ]);

            } else {

                $aduan = Aduan::where('id', $request->status_id)->update([
                    'status_aduan'          => $request->kod_status,
                    'tukar_status'          => Auth::user()->id,
                    'sebab_tukar_status'    => $request->sebab_tukar_status,
                ]);
            }
        }

        AduanLog::create([
            'name'              => 'default',
            'description'       => 'E-Aduan : Penukaran Status Aduan',
            'subject_id'        => $aduan->id,
            'subject_type'      => 'App\Aduan',
            'properties'        => json_encode($request->all()),
            'creator_id'        => Auth::user()->id,
            'creator_type'      => 'App\User',
        ]);

        Session::flash('status', 'Status aduan telah berjaya ditukar.');

        return redirect()->back();
    }

    public function kemaskiniPembaikan(Request $request)
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

        if (isset($request->id_stok)) {

            $idStokArray = $request->id_stok;
            $kuantitiArray = $request->kuantiti;

            for ($i = 0; $i < count($idStokArray); $i++) {
                $stockId = $idStokArray[$i];
                $kuantiti = $kuantitiArray[$i];

                StockTransaction::create([
                    'stock_id'      => $stockId,
                    'stock_in'      => '0',
                    'stock_out'     => $kuantiti,
                    'created_by'    => Auth::user()->id,
                    'reason'        => 'Transaction Out For E-Aduan : '. $aduan->id,
                    'supply_type'   => 'INT',
                    'supply_to'     => Auth::user()->id,
                    'trans_date'    => $request->tarikh_selesai_aduan,
                    'status'        => '0',
                ]);

                StokPembaikan::create([
                    'id_aduan'   => $aduan->id,
                    'id_stok'    => $stockId,
                    'kuantiti'   => $kuantiti
                ]);
            }
        }

        if($request->status_aduan == 'TD'){

            $admin = User::whereHas('roles', function($query){
                $query->where('id', 'CMS001');
            })->pluck('id');

            $admin_staff = Staff::whereIn('staff_id', $admin)->where('staff_code', 'OFM')->get();

            foreach($admin_staff as $value)
            {
                $data_admin = [
                    'nama_penerima'     => $value->staff_name,
                    'nama_pengadu'      => $aduan->nama_pelapor,
                    'pembuka'           => 'Aduan telah dilaksanakan pembaikan oleh juruteknik . Berikut adalah maklumat aduan:',
                    'tiket_aduan'       => $aduan->id,
                    'lokasi_aduan'      => strtoupper($aduan->lokasi_aduan),
                    'kategori_aduan'    => $aduan->kategori->nama_kategori,
                    'jenis_kerosakan'   => strtoupper($aduan->jenis->jenis_kerosakan),
                    'sebab_kerosakan'   => strtoupper($aduan->sebab->sebab_kerosakan),
                    'tarikh'            => date(' d/m/Y ', strtotime($aduan->tarikh_laporan)),
                    'tarikh_selesai'    => date(' d/m/Y ', strtotime($aduan->tarikh_selesai_aduan)),
                    'penutup'           => 'Sila log masuk ke sistem INTEC Digital Services (IDS) untuk tindakan selanjutnya.',
                ];

                Mail::send('aduan.emel-aduan', $data_admin, function ($message) use ($value) {
                    $message->subject('E-Aduan: Pelaksanaan Pembaikan Aduan');
                    $message->from(Auth::user()->email);
                    $message->to($value->staff_email);
                });
            }

        } else {
            // AK or DP

            $data_pengguna = [
                'nama_penerima'     => $aduan->nama_pelapor,
                'pembuka'           => 'Aduan yang dibuat telah menerima maklum balas daripada pihak Juruteknik. Berikut adalah maklumat aduan:',
                'tiket_aduan'       => $aduan->id,
                'lokasi_aduan'      => strtoupper($aduan->lokasi_aduan),
                'kategori_aduan'    => $aduan->kategori->nama_kategori,
                'jenis_kerosakan'   => strtoupper($aduan->jenis->jenis_kerosakan),
                'sebab_kerosakan'   => strtoupper($aduan->sebab->sebab_kerosakan),
                'tarikh'            => date(' d/m/Y ', strtotime($aduan->tarikh_laporan)),
                'tarikh_selesai'    => date(' d/m/Y ', strtotime($aduan->tarikh_selesai_aduan)),
                'penutup'           => 'Sila log masuk ke sistem INTEC Digital Services (IDS) untuk melihat maklumat aduan.',
            ];

            Mail::send('aduan.emel-aduan', $data_pengguna, function ($message) use ($aduan) {
                $message->subject('E-Aduan: Maklumbalas Aduan');
                $message->from(Auth::user()->email);
                $message->to($aduan->emel_pelapor);
            });
        }

        AduanLog::create([
            'name'              => 'default',
            'description'       => 'E-Aduan : Pengemaskinian Pembaikan Aduan',
            'subject_id'        => $aduan->id,
            'subject_type'      => 'App\Aduan',
            'properties'        => json_encode($request->all()),
            'creator_id'        => Auth::user()->id,
            'creator_type'      => 'App\User',
        ]);

        Session::flash('kemaskiniPembaikan', 'Maklumat pembaikan telah dihantar dan direkodkan.');

        return redirect()->back();
    }

    public function padamAlatan($id, $id_aduan)
    {
        $aduan = Aduan::where('id',$id_aduan)->first();

        $alat = AlatanPembaikan::find($id);

        $alat->delete();

        AduanLog::create([
            'name'              => 'default',
            'description'       => 'E-Aduan : Padam Alat Ganti/Bahan Pembaikan',
            'subject_id'        => $alat->id,
            'subject_type'      => 'App\AlatanPembaikan',
            'properties'        => json_encode($alat),
            'creator_id'        => Auth::user()->id,
            'creator_type'      => 'App\User',
        ]);

        return redirect()->back()->with('message', 'Bahan/Alat Ganti Berjaya Dipadam');
    }

    public function padamJuruteknik($id, $id_aduan)
    {
        $juruteknik = JuruteknikBertugas::find($id);

        $juruteknik->delete();

        AduanLog::create([
            'name'              => 'default',
            'description'       => 'E-Aduan : Padam Juruteknik Bertugas',
            'subject_id'        => $juruteknik->id,
            'subject_type'      => 'App\JuruteknikBertugas',
            'properties'        => json_encode($juruteknik),
            'creator_id'        => Auth::user()->id,
            'creator_type'      => 'App\User',
        ]);

        return redirect()->back()->with('kemaskiniTahap', 'Juruteknik Berjaya Dipadam.');
    }

    public function senaraiSelesai(Request $request)
    {
        $status = StatusAduan::all();

        return view('aduan.admin.senarai-aduan-selesai', compact('status'));
    }

    public function dataSelesai()
    {
        $stf = User::where('category','STF')->pluck('id');

        $list = Aduan::whereIn('status_aduan', ['AS','LK','LU'])->whereIn('id_pelapor', $stf)->with(['kategori','status','tahap'])->whereIn('kategori_aduan', ['AWM','ELK','MKL','PKH','TKM'])->select('cms_aduan.*');

        return datatables()::of($list)

        ->addColumn('action', function ($list) {

            return '<div class="btn-group"><a href="/info-aduan/' . $list->id.'" class="btn btn-sm btn-primary mr-2"><i class="fal fa-eye"></i></a></div>';
        })

        ->editColumn('nama_pelapor', function ($list) {

            return $list->nama_pelapor ?? '';
        })

        ->editColumn('lokasi_aduan', function ($list) {

            return strtoupper($list->lokasi_aduan) ?? '';
        })

        ->editColumn('tarikh_laporan', function ($list) {

            return date(' d-m-Y ', strtotime($list->tarikh_laporan) );
        })

        ->editColumn('tarikh_selesai_aduan', function ($list) {

            return date(' d-m-Y ', strtotime($list->tarikh_selesai_aduan) );
        })

        ->editColumn('kategori_aduan', function ($list) {

            return $list->kategori->nama_kategori ?? '';
        })

        ->editColumn('status_aduan', function ($list) {

            $badgeClass = $list->status_aduan == 'AS' ? 'badge-success' : 'badge-success2';

            $statusBadge = '<span class="badge ' . $badgeClass . '">' . strtoupper($list->status->nama_status) . '</span>';

            $editLink = '<a href="" data-target="#crud-modals" data-toggle="modal" data-id="'. $list->id.'"><i class="fal fa-pencil ml-2" style="color: red"></i></a>';

            if (Auth::user()->hasPermissionTo('view complaint - admin')) {
                return $statusBadge . $editLink;
            }
            return $statusBadge;
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

        ->addColumn('tempoh', function ($list) {

            if(isset($list->tarikh_selesai_aduan))
            {
                $tempoh = Carbon::parse($list->tarikh_laporan)->diffInDays($list->tarikh_selesai_aduan)+1;

            } else {

                $tempoh = Carbon::parse($list->tarikh_laporan)->diffInDays(Carbon::now())+1;
            }

            return $tempoh.' hari';
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

        ->rawColumns(['action', 'tahap_kategori', 'status_aduan', 'kategori_aduan', 'nama_pelapor', 'tarikh_laporan',
        'lokasi_aduan','tarikh_selesai_aduan','tempoh','pengesahan_pembaikan'])
        ->make(true);
    }

    public function dataSelesaiPelajar()
    {
        $std = User::where('category','STD')->pluck('id');

        $list = Aduan::whereIn('status_aduan', ['AS','LK','LU'])->whereIn('id_pelapor', $std)->with(['kategori','status','tahap'])->whereIn('kategori_aduan', ['AWM','ELK','MKL','PKH','TKM'])->select('cms_aduan.*');

        return datatables()::of($list)

        ->addColumn('action', function ($list) {

            return '<div class="btn-group"><a href="/info-aduan/' . $list->id.'" class="btn btn-sm btn-primary mr-2"><i class="fal fa-eye"></i></a></div>';
        })

        ->editColumn('nama_pelapor', function ($list) {

            return $list->nama_pelapor ?? '';
        })

        ->editColumn('lokasi_aduan', function ($list) {

            return strtoupper($list->lokasi_aduan) ?? '';
        })

        ->editColumn('tarikh_laporan', function ($list) {

            return date(' d-m-Y ', strtotime($list->tarikh_laporan) );
        })

        ->editColumn('tarikh_selesai_aduan', function ($list) {

            return date(' d-m-Y ', strtotime($list->tarikh_selesai_aduan) );
        })

        ->editColumn('kategori_aduan', function ($list) {

            return $list->kategori->nama_kategori ?? '';
        })

        ->editColumn('status_aduan', function ($list) {

            $badgeClass = $list->status_aduan == 'AS' ? 'badge-success' : 'badge-success2';

            $statusBadge = '<span class="badge ' . $badgeClass . '">' . strtoupper($list->status->nama_status) . '</span>';

            $editLink = '<a href="" data-target="#crud-modals" data-toggle="modal" data-id="'. $list->id.'"><i class="fal fa-pencil ml-2" style="color: red"></i></a>';

            if (Auth::user()->hasPermissionTo('view complaint - admin')) {
                return $statusBadge . $editLink;
            }
            return $statusBadge;
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

        ->addColumn('tempoh', function ($list) {

            if(isset($list->tarikh_selesai_aduan))
            {
                $tempoh = Carbon::parse($list->tarikh_laporan)->diffInDays($list->tarikh_selesai_aduan)+1;

            } else {

                $tempoh = Carbon::parse($list->tarikh_laporan)->diffInDays(Carbon::now())+1;
            }

            return $tempoh.' hari';
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

        ->rawColumns(['action', 'tahap_kategori', 'status_aduan', 'kategori_aduan', 'nama_pelapor', 'tarikh_laporan',
        'lokasi_aduan','tarikh_selesai_aduan','tempoh','pengesahan_pembaikan'])
        ->make(true);
    }

    // public function data_selesai_luar()
    // {
    //     $merge = User::whereIn('category',['STF','STD'])->pluck('id')->toArray();

    //     $staff = Staff::where('staff_id', Auth::user()->id)->first();

    //     if($staff->staff_code == 'IITU') {

    //         $list = Aduan::whereIn('status_aduan', ['AS','LK','LU'])->whereNotIn('id_pelapor', $merge)->with(['kategori','status','tahap'])->whereIn('kategori_aduan', ['IITU-HDWR','IITU-NTWK','IITU-OPR_EMEL','IITU-NTWK WIRELESS'])->select('cms_aduan.*');
    //     } elseif($staff->staff_code == 'OFM' || $staff->staff_code == 'AA') {

    //         $list = Aduan::whereIn('status_aduan', ['AS','LK','LU'])->whereNotIn('id_pelapor', $merge)->with(['kategori','status','tahap'])->whereIn('kategori_aduan', ['AWM','ELK','MKL','PKH','TKM'])->select('cms_aduan.*');
    //     } else {

    //         $list = Aduan::whereIn('status_aduan', ['AS','LK','LU'])->whereNotIn('id_pelapor', $merge)->with(['kategori','status','tahap'])->select('cms_aduan.*');
    //     }

    //     return datatables()::of($list)
    //     ->addColumn('action', function ($list) {

    //         if($list->status_aduan == 'DJ') {
    //             return '<div class="btn-group"><a href="/info-aduan/' . $list->id.'" class="btn btn-sm btn-info mr-2"><i class="fal fa-pencil"></i></a>
    //                     <a data-page="/muaturun-borang' . $list->id.'" class="btn btn-sm btn-primary text-white mr-2" onclick="Print(this)"><i class="fal fa-file"></i></a></div>';
    //         } else {
    //             return '<div class="btn-group"><a href="/info-aduan/' . $list->id.'" class="btn btn-sm btn-info mr-2"><i class="fal fa-pencil"></i></a></div>';
    //         }
    //     })

    //     ->editColumn('id', function ($list) {

    //         return '#'.$list->id;
    //     })

    //     ->editColumn('nama_pelapor', function ($list) {

    //         return $list->nama_pelapor;
    //     })

    //     ->editColumn('tarikh_laporan', function ($list) {

    //         return date(' Y-m-d ', strtotime($list->tarikh_laporan) );
    //     })

    //     ->editColumn('kategori_aduan', function ($list) {

    //         return $list->kategori->nama_kategori ?? '';
    //     })

    //     ->editColumn('status_aduan', function ($list) {

    //         if($list->status_aduan=='AS')
    //         {
    //             return '<span class="badge badge-success">' . strtoupper($list->status->nama_status) . '</span>';

    //         }
    //         if($list->status_aduan=='LK')
    //         {
    //             return '<span class="badge badge-success2">' . strtoupper($list->status->nama_status) . '</span>';
    //         }
    //         else
    //         {
    //             return '<span class="badge badge-success2">' . strtoupper($list->status->nama_status) . '</span>';
    //         }
    //     })

    //     ->editColumn('tahap_kategori', function ($list) {

    //         if($list->tahap_kategori=='B')
    //         {
    //             return '<span class="low" data-toggle="tooltip" data-placement="top" title="BIASA">' . '</span>';
    //         }
    //         elseif($list->tahap_kategori=='S')
    //         {
    //             return '<span class="medium" data-toggle="tooltip" data-placement="top" title="SEGERA">' . '</span>';
    //         }
    //         else
    //         {
    //             return '<span class="none" data-toggle="tooltip" data-placement="top" title="BELUM DITENTUKAN">' . '</span>';
    //         }
    //     })

    //     ->rawColumns(['id', 'action', 'tahap_kategori', 'status_aduan', 'kategori_aduan', 'nama_pelapor', 'tarikh_laporan'])
    //     ->make(true);
    // }

    public function senaraiKiv(Request $request)
    {
        $status = StatusAduan::all();

        return view('aduan.admin.senarai-aduan-kiv', compact('status'));
    }

    public function dataKiv()
    {
        $stf = User::where('category','STF')->pluck('id');

        $list = Aduan::whereIn('status_aduan', ['AK'])->whereIn('id_pelapor', $stf)->with(['kategori','status','tahap'])->whereIn('kategori_aduan', ['AWM','ELK','MKL','PKH','TKM'])->select('cms_aduan.*');

        return datatables()::of($list)

        ->addColumn('action', function ($list) {

            return '<div class="btn-group"><a href="/info-aduan/' . $list->id.'" class="btn btn-sm btn-primary mr-2"><i class="fal fa-eye"></i></a></div>';
        })

        ->editColumn('nama_pelapor', function ($list) {

            return $list->nama_pelapor ?? '';
        })

        ->editColumn('lokasi_aduan', function ($list) {

            return strtoupper($list->lokasi_aduan) ?? '';
        })

        ->editColumn('tarikh_laporan', function ($list) {

            return date(' d-m-Y ', strtotime($list->tarikh_laporan) );
        })

        ->editColumn('tarikh_selesai_aduan', function ($list) {

            return date(' d-m-Y ', strtotime($list->tarikh_selesai_aduan) );
        })

        ->editColumn('kategori_aduan', function ($list) {

            return $list->kategori->nama_kategori ?? '';
        })

        ->editColumn('status_aduan', function ($list) {

            if (Auth::user()->hasPermissionTo('view complaint - admin')) {

                return '<span class="badge badge-kiv">' . strtoupper($list->status->nama_status) . '</span>
                <a href="" data-target="#crud-modals" data-toggle="modal" data-id="'. $list->id.'"><i class="fal fa-pencil ml-2" style="color: red"></i></a>';

            } else {

                return '<span class="badge badge-kiv">' . strtoupper($list->status->nama_status) . '</span>';
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

        ->addColumn('tempoh', function ($list) {

            if(isset($list->tarikh_selesai_aduan))
            {
                $tempoh = Carbon::parse($list->tarikh_laporan)->diffInDays($list->tarikh_selesai_aduan)+1;

            } else {

                $tempoh = Carbon::parse($list->tarikh_laporan)->diffInDays(Carbon::now())+1;
            }

            return $tempoh.' hari';
        })

        ->rawColumns(['action', 'tahap_kategori', 'status_aduan', 'kategori_aduan', 'nama_pelapor', 'tarikh_laporan','lokasi_aduan','tarikh_selesai_aduan','tempoh'])
        ->make(true);
    }

    public function dataKivPelajar()
    {
        $std = User::where('category','STD')->pluck('id');

        $list = Aduan::whereIn('status_aduan', ['AK'])->whereIn('id_pelapor', $std)->with(['kategori','status','tahap'])->whereIn('kategori_aduan', ['AWM','ELK','MKL','PKH','TKM'])->select('cms_aduan.*');

        return datatables()::of($list)

        ->addColumn('action', function ($list) {

            return '<div class="btn-group"><a href="/info-aduan/' . $list->id.'" class="btn btn-sm btn-primary mr-2"><i class="fal fa-eye"></i></a></div>';
        })

        ->editColumn('nama_pelapor', function ($list) {

            return $list->nama_pelapor ?? '';
        })

        ->editColumn('lokasi_aduan', function ($list) {

            return strtoupper($list->lokasi_aduan) ?? '';
        })

        ->editColumn('tarikh_laporan', function ($list) {

            return date(' d-m-Y ', strtotime($list->tarikh_laporan) );
        })

        ->editColumn('tarikh_selesai_aduan', function ($list) {

            return date(' d-m-Y ', strtotime($list->tarikh_selesai_aduan) );
        })

        ->editColumn('kategori_aduan', function ($list) {

            return $list->kategori->nama_kategori ?? '';
        })

        ->editColumn('status_aduan', function ($list) {

            if (Auth::user()->hasPermissionTo('view complaint - admin')) {

                return '<span class="badge badge-kiv">' . strtoupper($list->status->nama_status) . '</span>
                <a href="" data-target="#crud-modals" data-toggle="modal" data-id="'. $list->id.'"><i class="fal fa-pencil ml-2" style="color: red"></i></a>';

            } else {

                return '<span class="badge badge-kiv">' . strtoupper($list->status->nama_status) . '</span>';
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

        ->addColumn('tempoh', function ($list) {

            if(isset($list->tarikh_selesai_aduan))
            {
                $tempoh = Carbon::parse($list->tarikh_laporan)->diffInDays($list->tarikh_selesai_aduan)+1;

            } else {

                $tempoh = Carbon::parse($list->tarikh_laporan)->diffInDays(Carbon::now())+1;
            }

            return $tempoh.' hari';
        })

        ->rawColumns(['action', 'tahap_kategori', 'status_aduan', 'kategori_aduan', 'nama_pelapor', 'tarikh_laporan','lokasi_aduan','tarikh_selesai_aduan','tempoh'])
        ->make(true);
    }

    // public function data_kiv_luar()
    // {
    //     $merge = User::whereIn('category',['STF','STD'])->pluck('id')->toArray();

    //     $staff = Staff::where('staff_id', Auth::user()->id)->first();

    //     if($staff->staff_code == 'IITU') {

    //         $list = Aduan::whereIn('status_aduan', ['AK'])->whereNotIn('id_pelapor', $merge)->with(['kategori','status','tahap'])->whereIn('kategori_aduan', ['IITU-HDWR','IITU-NTWK','IITU-OPR_EMEL','IITU-NTWK WIRELESS'])->select('cms_aduan.*');
    //     } elseif($staff->staff_code == 'OFM' || $staff->staff_code == 'AA') {

    //         $list = Aduan::whereIn('status_aduan', ['AK'])->whereNotIn('id_pelapor', $merge)->with(['kategori','status','tahap'])->whereIn('kategori_aduan', ['AWM','ELK','MKL','PKH','TKM'])->select('cms_aduan.*');
    //     } else {

    //         $list = Aduan::whereIn('status_aduan', ['AK'])->whereNotIn('id_pelapor', $merge)->with(['kategori','status','tahap'])->select('cms_aduan.*');
    //     }

    //     return datatables()::of($list)
    //     ->addColumn('action', function ($list) {

    //         if($list->status_aduan == 'DJ') {
    //             return '<div class="btn-group"><a href="/info-aduan/' . $list->id.'" class="btn btn-sm btn-info mr-2"><i class="fal fa-pencil"></i></a>
    //                     <a data-page="/muaturun-borang' . $list->id.'" class="btn btn-sm btn-primary text-white mr-2" onclick="Print(this)"><i class="fal fa-file"></i></a></div>';
    //         } else {
    //             return '<div class="btn-group"><a href="/info-aduan/' . $list->id.'" class="btn btn-sm btn-info mr-2"><i class="fal fa-pencil"></i></a></div>';
    //         }
    //     })

    //     ->editColumn('id', function ($list) {

    //         return '#'.$list->id;
    //     })

    //     ->editColumn('nama_pelapor', function ($list) {

    //         return $list->nama_pelapor;
    //     })

    //     ->editColumn('tarikh_laporan', function ($list) {

    //         return date(' Y-m-d ', strtotime($list->tarikh_laporan) );
    //     })

    //     ->editColumn('kategori_aduan', function ($list) {

    //         return $list->kategori->nama_kategori ?? '';
    //     })

    //     ->editColumn('status_aduan', function ($list) {

    //         return '<span class="badge badge-kiv">' . strtoupper($list->status->nama_status) . '</span>';
    //     })

    //     ->editColumn('tahap_kategori', function ($list) {

    //         if($list->tahap_kategori=='B')
    //         {
    //             return '<span class="low" data-toggle="tooltip" data-placement="top" title="BIASA">' . '</span>';
    //         }
    //         elseif($list->tahap_kategori=='S')
    //         {
    //             return '<span class="medium" data-toggle="tooltip" data-placement="top" title="SEGERA">' . '</span>';
    //         }
    //         else
    //         {
    //             return '<span class="none" data-toggle="tooltip" data-placement="top" title="BELUM DITENTUKAN">' . '</span>';
    //         }
    //     })

    //     ->rawColumns(['id', 'action', 'tahap_kategori', 'status_aduan', 'kategori_aduan', 'nama_pelapor', 'tarikh_laporan'])
    //     ->make(true);
    // }

    public function senaraiBertindih(Request $request)
    {
        $status = StatusAduan::whereIn('kod_status', ['DP'])->get();

        return view('aduan.admin.senarai-aduan-bertindih', compact('status'));
    }

    public function dataBertindih()
    {
        $stf = User::where('category','STF')->pluck('id');

        $list = Aduan::whereIn('status_aduan', ['DP'])->whereIn('id_pelapor', $stf)->with(['kategori','status','tahap'])->whereIn('kategori_aduan', ['AWM','ELK','MKL','PKH','TKM'])->select('cms_aduan.*');

        return datatables()::of($list)

        ->addColumn('action', function ($list) {

            return '<div class="btn-group"><a href="/info-aduan/' . $list->id.'" class="btn btn-sm btn-info mr-2"><i class="fal fa-pencil"></i></a></div>';
        })

        ->editColumn('nama_pelapor', function ($list) {

            return $list->nama_pelapor ?? '';
        })

        ->editColumn('lokasi_aduan', function ($list) {

            return strtoupper($list->lokasi_aduan) ?? '';
        })

        ->editColumn('tarikh_laporan', function ($list) {

            return date(' d-m-Y ', strtotime($list->tarikh_laporan) );
        })

        ->editColumn('tarikh_selesai_aduan', function ($list) {

            return date(' d-m-Y ', strtotime($list->tarikh_selesai_aduan) );
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

        ->addColumn('tempoh', function ($list) {

            if(isset($list->tarikh_selesai_aduan))
            {
                $tempoh = Carbon::parse($list->tarikh_laporan)->diffInDays($list->tarikh_selesai_aduan)+1;

            } else {

                $tempoh = Carbon::parse($list->tarikh_laporan)->diffInDays(Carbon::now())+1;
            }

            return $tempoh.' hari';
        })

        ->rawColumns(['action', 'tahap_kategori', 'status_aduan', 'kategori_aduan', 'nama_pelapor', 'tarikh_laporan', 'lokasi_aduan','tarikh_selesai_aduan', 'tempoh'])
        ->make(true);
    }

    public function dataBertindihPelajar()
    {
        $std = User::where('category','STD')->pluck('id');

        $list = Aduan::whereIn('status_aduan', ['DP'])->whereIn('id_pelapor', $std)->with(['kategori','status','tahap'])->whereIn('kategori_aduan', ['AWM','ELK','MKL','PKH','TKM'])->select('cms_aduan.*');

        return datatables()::of($list)

        ->addColumn('action', function ($list) {

            return '<div class="btn-group"><a href="/info-aduan/' . $list->id.'" class="btn btn-sm btn-primary mr-2"><i class="fal fa-eye"></i></a></div>';
        })

        ->editColumn('nama_pelapor', function ($list) {

            return $list->nama_pelapor ?? '';
        })

        ->editColumn('lokasi_aduan', function ($list) {

            return strtoupper($list->lokasi_aduan) ?? '';
        })

        ->editColumn('tarikh_laporan', function ($list) {

            return date(' d-m-Y ', strtotime($list->tarikh_laporan) );
        })

        ->editColumn('tarikh_selesai_aduan', function ($list) {

            return date(' d-m-Y ', strtotime($list->tarikh_selesai_aduan) );
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

        ->addColumn('tempoh', function ($list) {

            if(isset($list->tarikh_selesai_aduan))
            {
                $tempoh = Carbon::parse($list->tarikh_laporan)->diffInDays($list->tarikh_selesai_aduan)+1;

            } else {

                $tempoh = Carbon::parse($list->tarikh_laporan)->diffInDays(Carbon::now())+1;
            }

            return $tempoh.' hari';
        })

        ->rawColumns(['action', 'tahap_kategori', 'status_aduan', 'kategori_aduan', 'nama_pelapor', 'tarikh_laporan', 'lokasi_aduan', 'tarikh_selesai_aduan', 'tempoh'])
        ->make(true);
    }

    // public function data_bertindih_luar()
    // {
    //     $merge = User::whereIn('category',['STF','STD'])->pluck('id')->toArray();

    //     $staff = Staff::where('staff_id', Auth::user()->id)->first();

    //     if($staff->staff_code == 'IITU') {

    //         $list = Aduan::whereIn('status_aduan', ['DP'])->whereNotIn('id_pelapor', $merge)->with(['kategori','status','tahap'])->whereIn('kategori_aduan', ['IITU-HDWR','IITU-NTWK','IITU-OPR_EMEL','IITU-NTWK WIRELESS'])->select('cms_aduan.*');
    //     } elseif($staff->staff_code == 'OFM' || $staff->staff_code == 'AA') {

    //         $list = Aduan::whereIn('status_aduan', ['DP'])->whereNotIn('id_pelapor', $merge)->with(['kategori','status','tahap'])->whereIn('kategori_aduan', ['AWM','ELK','MKL','PKH','TKM'])->select('cms_aduan.*');
    //     } else {

    //         $list = Aduan::whereIn('status_aduan', ['DP'])->whereNotIn('id_pelapor', $merge)->with(['kategori','status','tahap'])->select('cms_aduan.*');
    //     }

    //     return datatables()::of($list)
    //     ->addColumn('action', function ($list) {

    //         if($list->status_aduan == 'DJ') {
    //             return '<div class="btn-group"><a href="/info-aduan/' . $list->id.'" class="btn btn-sm btn-info mr-2"><i class="fal fa-pencil"></i></a>
    //                     <a data-page="/muaturun-borang' . $list->id.'" class="btn btn-sm btn-primary text-white mr-2" onclick="Print(this)"><i class="fal fa-file"></i></a></div>';
    //         } else {
    //             return '<div class="btn-group"><a href="/info-aduan/' . $list->id.'" class="btn btn-sm btn-info mr-2"><i class="fal fa-pencil"></i></a></div>';
    //         }
    //     })

    //     ->editColumn('id', function ($list) {

    //         return '#'.$list->id;
    //     })

    //     ->editColumn('nama_pelapor', function ($list) {

    //         return $list->nama_pelapor;
    //     })

    //     ->editColumn('tarikh_laporan', function ($list) {

    //         return date(' Y-m-d ', strtotime($list->tarikh_laporan) );
    //     })

    //     ->editColumn('kategori_aduan', function ($list) {

    //         return $list->kategori->nama_kategori ?? '';
    //     })

    //     ->editColumn('status_aduan', function ($list) {

    //         return '<span class="badge badge-duplicate">' . strtoupper($list->status->nama_status) . '</span>';
    //     })

    //     ->editColumn('tahap_kategori', function ($list) {

    //         if($list->tahap_kategori=='B')
    //         {
    //             return '<span class="low" data-toggle="tooltip" data-placement="top" title="BIASA">' . '</span>';
    //         }
    //         elseif($list->tahap_kategori=='S')
    //         {
    //             return '<span class="medium" data-toggle="tooltip" data-placement="top" title="SEGERA">' . '</span>';
    //         }
    //         else
    //         {
    //             return '<span class="none" data-toggle="tooltip" data-placement="top" title="BELUM DITENTUKAN">' . '</span>';
    //         }
    //     })

    //     ->rawColumns(['id', 'action', 'tahap_kategori', 'status_aduan', 'kategori_aduan', 'nama_pelapor', 'tarikh_laporan'])
    //     ->make(true);
    // }

    public function simpanStatus(Request $request)
    {
        $aduan = Aduan::where('id', $request->ide)->first();

        $aduan->update([
            'status_aduan'           => $request->status_aduan,
            'catatan_pembaikan'      => $request->catatan_pembaikan,
        ]);

        $data_pengadu = [
            'nama_penerima'     => $aduan->nama_pelapor,
            'pembuka'           => 'Aduan anda telah selesai dilakukan pembaikan. Berikut adalah maklumat aduan:',
            'tiket_aduan'       => $aduan->id,
            'lokasi_aduan'      => strtoupper($aduan->lokasi_aduan),
            'kategori_aduan'    => $aduan->kategori->nama_kategori,
            'jenis_kerosakan'   => strtoupper($aduan->jenis->jenis_kerosakan),
            'sebab_kerosakan'   => strtoupper($aduan->sebab->sebab_kerosakan),
            'tarikh'            => date(' d/m/Y ', strtotime($aduan->tarikh_laporan)),
            'tarikh_selesai'    => date(' d/m/Y ', strtotime($aduan->tarikh_selesai_aduan)),
            'penutup'           => 'Anda perlu membuat pengesahan atas pembaikan yang telah dilakukan.
                                    Sila log masuk ke sistem INTEC Digital Services (IDS) untuk melakukan pengesahan.',
        ];

        Mail::send('aduan.emel-aduan', $data_pengadu, function ($message) use ($aduan) {
            $message->subject('E-Aduan: Pengesahan Pembaikan Aduan');
            $message->from(Auth::user()->email);
            $message->to($aduan->emel_pelapor);
        });

        AduanLog::create([
            'name'              => 'default',
            'description'       => 'E-Aduan : Pengesahan Pembaikan Aduan Admin',
            'subject_id'        => $aduan->id,
            'subject_type'      => 'App\Aduan',
            'properties'        => json_encode($request->all()),
            'creator_id'        => Auth::user()->id,
            'creator_type'      => 'App\User',
        ]);

        Session::flash('simpanCatatan', 'Maklumat pengesahan pembaikan telah dihantar dan direkodkan.');

        return redirect()->back();
    }

    public function padamGambar($id, $id_aduan)
    {
        $aduan = Aduan::where('id',$id_aduan)->first();

        $imej = ImejPembaikan::find($id);

        $imej->delete();

        AduanLog::create([
            'name'              => 'default',
            'description'       => 'E-Aduan : Padam Imej Pembaikan',
            'subject_id'        => $imej->id,
            'subject_type'      => 'App\ImejPembaikan',
            'properties'        => json_encode($imej),
            'creator_id'        => Auth::user()->id,
            'creator_type'      => 'App\User',
        ]);

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

        AduanLog::create([
            'name'              => 'default',
            'description'       => 'E-Aduan : Penghantaran Notis Kepada Pengadu',
            'subject_id'        => $aduan->id,
            'subject_type'      => 'App\Aduan',
            'properties'        => json_encode($request->all()),
            'creator_id'        => Auth::user()->id,
            'creator_type'      => 'App\User',
        ]);

        Session::flash('notis', 'Notis aduan telah berjaya dihantar. Notis akan dipaparkan dalam senarai aduan pengadu.');

        return redirect()->back();
    }

    public function senaraiTeknikal()
    {
        $status = StatusAduan::whereIn('kod_status', ['BS','DJ','TD'])->get();

        return view('aduan.juruteknik.teknikal-aduan', compact('status'));
    }

    public function teknikal()
    {
        $stf = User::where('category','STF')->pluck('id');

        $list = JuruteknikBertugas::where('juruteknik_bertugas', Auth::user()->id)->whereHas('aduan', function($query) use($stf){
            $query->whereIn('id_pelapor', $stf)->whereIn('status_aduan', ['DJ','TD']);
        })->with(['juruteknik','aduan.kategori','aduan.tahap','aduan.status','aduan'])->select('cms_juruteknik.*');

        return datatables()::of($list)

        ->addColumn('action', function ($list) {

            if($list->aduan->status_aduan=='DJ') {
                return '<div class="btn-group"><a href="/info-aduan/' . $list->id_aduan.'" class="btn btn-sm btn-primary mr-2"><i class="fal fa-eye"></i></a>
                        <a data-page="/muaturun-borang' . $list->id_aduan.'" class="btn btn-sm btn-info text-white" onclick="Print(this)"><i class="fal fa-file"></i></a></div>';
            } else {
                return '<a href="/info-aduan/' . $list->id_aduan.'" class="btn btn-sm btn-primary"><i class="fal fa-eye"></i></a>';
            }
        })

        ->editColumn('nama_pelapor', function ($list) {

            return $list->aduan->nama_pelapor ?? '';
        })

        ->editColumn('lokasi_aduan', function ($list) {

            return strtoupper($list->aduan->lokasi_aduan) ?? '';
        })

        ->editColumn('tarikh_laporan', function ($list) {

            return date(' d-m-Y ', strtotime($list->aduan->tarikh_laporan) );
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

        ->rawColumns(['action', 'tahap_kategori', 'status_aduan', 'kategori_aduan', 'nama_pelapor', 'tempoh', 'tarikh_laporan','notis', 'lokasi_aduan'])
        ->make(true);
    }

    public function teknikalPelajar()
    {
        $std = User::where('category','STD')->pluck('id');

        $list = JuruteknikBertugas::where('juruteknik_bertugas', Auth::user()->id)->whereHas('aduan', function($query) use($std) {
            $query->whereIn('id_pelapor', $std)->whereIn('status_aduan', ['DJ','TD']);
        })->with(['juruteknik','aduan.kategori','aduan.tahap','aduan.status','aduan'])->select('cms_juruteknik.*');

        return datatables()::of($list)
        ->addColumn('action', function ($list) {

            if($list->aduan->status_aduan=='DJ') {
                return '<div class="btn-group"><a href="/info-aduan/' . $list->id_aduan.'" class="btn btn-sm btn-primary mr-2"><i class="fal fa-eye"></i></a>
                        <a data-page="/muaturun-borang' . $list->id_aduan.'" class="btn btn-sm btn-info text-white" onclick="Print(this)"><i class="fal fa-file"></i></a></div>';
            } else {
                return '<a href="/info-aduan/' . $list->id_aduan.'" class="btn btn-sm btn-primary"><i class="fal fa-eye"></i></a>';
            }

        })

        ->editColumn('nama_pelapor', function ($list) {

            return $list->aduan->nama_pelapor ?? '';
        })

        ->editColumn('lokasi_aduan', function ($list) {

            return strtoupper($list->aduan->lokasi_aduan) ?? '';
        })

        ->editColumn('tarikh_laporan', function ($list) {

            return date(' d-m-Y ', strtotime($list->aduan->tarikh_laporan) );
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

        ->rawColumns(['action', 'tahap_kategori', 'status_aduan', 'kategori_aduan', 'nama_pelapor', 'tempoh', 'tarikh_laporan','notis','lokasi_aduan'])
        ->make(true);
    }

    // public function teknikal_luar()
    // {
    //     $merge = User::whereIn('category',['STF','STD'])->pluck('id')->toArray();

    //     $list = JuruteknikBertugas::where('juruteknik_bertugas', Auth::user()->id)->whereHas('aduan', function($query) use($merge) {
    //         $query->whereNotIn('id_pelapor', $merge)->whereIn('status_aduan', ['DJ','TD']);
    //     })->with(['juruteknik','aduan.kategori','aduan.tahap','aduan.status','aduan'])->get();

    //     return datatables()::of($list)
    //     ->addColumn('action', function ($list) {

    //         if($list->aduan->status_aduan=='DJ') {
    //             return '<div class="btn-group"><a href="/info-aduan/' . $list->id_aduan.'" class="btn btn-sm btn-info mr-2"><i class="fal fa-pencil"></i></a>
    //                     <a data-page="/muaturun-borang' . $list->id_aduan.'" class="btn btn-sm btn-primary text-white" onclick="Print(this)"><i class="fal fa-file"></i></a></div>';
    //         } else {
    //             return '<a href="/info-aduan/' . $list->id_aduan.'" class="btn btn-sm btn-info"><i class="fal fa-pencil"></i></a>';
    //         }

    //     })

    //     ->editColumn('id', function ($list) {

    //         return '#'.$list->id_aduan;
    //     })

    //     ->editColumn('nama_pelapor', function ($list) {

    //         return $list->aduan->nama_pelapor;
    //     })

    //     ->editColumn('tarikh_laporan', function ($list) {

    //         return date(' Y-m-d ', strtotime($list->aduan->tarikh_laporan) );
    //     })

    //     ->editColumn('kategori_aduan', function ($list) {

    //         return $list->aduan->kategori->nama_kategori ?? '';
    //     })

    //     ->editColumn('status_aduan', function ($list) {

    //         if($list->aduan->status_aduan=='BS')
    //         {
    //             return '<span class="badge badge-new">' . strtoupper($list->aduan->status->nama_status) . '</span>';
    //         }
    //         if($list->aduan->status_aduan=='DJ')
    //         {
    //             return '<span class="badge badge-sent">' . strtoupper($list->aduan->status->nama_status) . '</span>';
    //         }
    //         else
    //         {
    //             return '<span class="badge badge-done">' . strtoupper($list->aduan->status->nama_status) . '</span>';
    //         }

    //     })

    //     ->editColumn('tempoh', function ($list) {

    //         if(isset($list->aduan->tarikh_selesai_aduan))
    //         {
    //             $tempoh = Carbon::parse($list->aduan->tarikh_laporan)->diffInDays($list->aduan->tarikh_selesai_aduan);

    //         } else {

    //             $tempoh = Carbon::parse($list->aduan->tarikh_laporan)->diffInDays(Carbon::now());
    //         }

    //         return $tempoh.' hari';
    //     })

    //     ->editColumn('tahap_kategori', function ($list) {

    //         if($list->aduan->tahap_kategori=='B')
    //         {
    //             return '<span class="low" data-toggle="tooltip" data-placement="top" title="BIASA">' . '</span>';
    //         }
    //         elseif($list->aduan->tahap_kategori=='S')
    //         {
    //             return '<span class="medium" data-toggle="tooltip" data-placement="top" title="SEGERA">' . '</span>';
    //         }
    //         else
    //         {
    //             return '<span class="none" data-toggle="tooltip" data-placement="top" title="BELUM DITENTUKAN">' . '</span>';
    //         }
    //     })

    //     ->addColumn('notis', function ($list) {

    //         return '<a href="" class="btn btn-sm btn-warning" data-target="#crud-modals" data-toggle="modal" data-id="'. $list->id.'" data-notis="'. $list->aduan->notis_juruteknik.'"><i class="fal fa-pencil"></i></a>';
    //     })

    //     ->rawColumns(['id', 'action', 'tahap_kategori', 'status_aduan', 'kategori_aduan', 'nama_pelapor', 'tempoh', 'tarikh_laporan','notis'])
    //     ->make(true);
    // }

    public function senaraiTeknikalSelesai()
    {
        $status = StatusAduan::whereIn('kod_status', ['AS','LK','LU'])->get();

        return view('aduan.juruteknik.teknikal-selesai', compact('status'));
    }

    public function teknikalSelesai()
    {
        $stf = User::where('category','STF')->pluck('id');

        $list = JuruteknikBertugas::where('juruteknik_bertugas', Auth::user()->id)->whereHas('aduan', function($query) use($stf) {
            $query->whereIn('id_pelapor', $stf)->whereIn('status_aduan', ['AS','LK','LU']);
        })->with(['juruteknik','aduan.kategori','aduan.tahap','aduan.status','aduan'])->select('cms_juruteknik.*');

        return datatables()::of($list)

        ->addColumn('action', function ($list) {

            return '<a href="/info-aduan/' . $list->id_aduan.'" class="btn btn-sm btn-primary"><i class="fal fa-eye"></i></a>';
        })

         ->editColumn('nama_pelapor', function ($list) {

            return $list->aduan->nama_pelapor ?? '';
        })

        ->editColumn('lokasi_aduan', function ($list) {

            return strtoupper($list->aduan->lokasi_aduan) ?? '';
        })

        ->editColumn('tarikh_laporan', function ($list) {

            return date(' d-m-Y ', strtotime($list->aduan->tarikh_laporan) );
        })

        ->editColumn('tarikh_selesai_aduan', function ($list) {

            return date(' d-m-Y ', strtotime($list->aduan->tarikh_selesai_aduan) );
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

        ->addColumn('tempoh', function ($list) {

            if(isset($list->aduan->tarikh_selesai_aduan))
            {
                $tempoh = Carbon::parse($list->aduan->tarikh_laporan)->diffInDays($list->aduan->tarikh_selesai_aduan)+1;

            } else {

                $tempoh = Carbon::parse($list->aduan->tarikh_laporan)->diffInDays(Carbon::now())+1;
            }

            return $tempoh.' hari';
        })

        ->editColumn('pengesahan_pembaikan', function ($list) {

            if($list->aduan->pengesahan_pembaikan=='Y')
            {
                return '<span class="low" data-toggle="tooltip" data-placement="top" title="DISAHKAN">' . '</span>';
            }
            else
            {
                return '<span class="high" data-toggle="tooltip" data-placement="top" title="BELUM DISAHKAN">' . '</span>';
            }
        })

        ->rawColumns(['tarikh_selesai_aduan', 'action', 'tahap_kategori', 'status_aduan', 'kategori_aduan', 'nama_pelapor',
        'tarikh_laporan', 'lokasi_aduan', 'pengesahan_pembaikan', 'tempoh'])
        ->make(true);
    }

    public function teknikalSelesaiPelajar()
    {
        $std = User::where('category','STD')->pluck('id');

        $list = JuruteknikBertugas::where('juruteknik_bertugas', Auth::user()->id)->whereHas('aduan', function($query) use($std) {
            $query->whereIn('id_pelapor', $std)->whereIn('status_aduan', ['AS','LK','LU']);
        })->with(['juruteknik','aduan.kategori','aduan.tahap','aduan.status','aduan'])->select('cms_juruteknik.*');

        return datatables()::of($list)

        ->addColumn('action', function ($list) {

            return '<a href="/info-aduan/' . $list->id_aduan.'" class="btn btn-sm btn-primary"><i class="fal fa-eye"></i></a>';
        })

        ->editColumn('nama_pelapor', function ($list) {

            return $list->aduan->nama_pelapor ?? '';
        })

        ->editColumn('lokasi_aduan', function ($list) {

            return strtoupper($list->aduan->lokasi_aduan) ?? '';
        })

        ->editColumn('tarikh_laporan', function ($list) {

            return date(' d-m-Y ', strtotime($list->aduan->tarikh_laporan) );
        })

        ->editColumn('tarikh_selesai_aduan', function ($list) {

            return date(' d-m-Y ', strtotime($list->aduan->tarikh_selesai_aduan) );
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

        ->addColumn('tempoh', function ($list) {

            if(isset($list->aduan->tarikh_selesai_aduan))
            {
                $tempoh = Carbon::parse($list->aduan->tarikh_laporan)->diffInDays($list->aduan->tarikh_selesai_aduan)+1;

            } else {

                $tempoh = Carbon::parse($list->aduan->tarikh_laporan)->diffInDays(Carbon::now())+1;
            }

            return $tempoh.' hari';
        })

        ->editColumn('pengesahan_pembaikan', function ($list) {

            if($list->aduan->pengesahan_pembaikan=='Y')
            {
                return '<span class="low" data-toggle="tooltip" data-placement="top" title="DISAHKAN">' . '</span>';
            }
            else
            {
                return '<span class="high" data-toggle="tooltip" data-placement="top" title="BELUM DISAHKAN">' . '</span>';
            }
        })

        ->rawColumns(['tarikh_selesai_aduan', 'action', 'tahap_kategori', 'status_aduan', 'kategori_aduan', 'nama_pelapor',
        'tarikh_laporan', 'lokasi_aduan', 'pengesahan_pembaikan', 'tempoh'])
        ->make(true);
    }

    // public function teknikal_selesai_luar()
    // {
    //     $merge = User::whereIn('category',['STF','STD'])->pluck('id')->toArray();

    //     $list = JuruteknikBertugas::where('juruteknik_bertugas', Auth::user()->id)->whereHas('aduan', function($query) use($merge) {
    //         $query->whereNotIn('id_pelapor', $merge)->whereIn('status_aduan', ['AS','LK','LU']);
    //     })->with(['juruteknik','aduan.kategori','aduan.tahap','aduan.status','aduan'])->get();

    //     return datatables()::of($list)
    //     ->addColumn('action', function ($list) {

    //         if($list->aduan->status_aduan=='DJ') {
    //             return '<div class="btn-group"><a href="/info-aduan/' . $list->id_aduan.'" class="btn btn-sm btn-info mr-2"><i class="fal fa-pencil"></i></a>
    //                     <a data-page="/muaturun-borang' . $list->id_aduan.'" class="btn btn-sm btn-primary text-white" onclick="Print(this)"><i class="fal fa-file"></i></a></div>';
    //         } else {
    //             return '<a href="/info-aduan/' . $list->id_aduan.'" class="btn btn-sm btn-info"><i class="fal fa-pencil"></i></a>';
    //         }
    //     })

    //     ->editColumn('id', function ($list) {

    //         return '#'.$list->id_aduan;
    //     })

    //     ->editColumn('nama_pelapor', function ($list) {

    //         return $list->aduan->nama_pelapor;
    //     })

    //     ->editColumn('tarikh_laporan', function ($list) {

    //         return date(' Y-m-d ', strtotime($list->aduan->tarikh_laporan) );
    //     })

    //     ->editColumn('kategori_aduan', function ($list) {

    //         return $list->aduan->kategori->nama_kategori ?? '';
    //     })

    //     ->editColumn('status_aduan', function ($list) {

    //         if($list->aduan->status_aduan=='AS')
    //         {
    //             return '<span class="badge badge-success">' . strtoupper($list->aduan->status->nama_status) . '</span>';
    //         }
    //         if($list->aduan->status_aduan=='LK')
    //         {
    //             return '<span class="badge badge-success2">' . strtoupper($list->aduan->status->nama_status) . '</span>';
    //         }
    //         else
    //         {
    //             return '<span class="badge badge-success2">' . strtoupper($list->aduan->status->nama_status) . '</span>';
    //         }
    //     })

    //     ->editColumn('tahap_kategori', function ($list) {

    //         if($list->aduan->tahap_kategori=='B')
    //         {
    //             return '<span class="low" data-toggle="tooltip" data-placement="top" title="BIASA">' . '</span>';
    //         }
    //         elseif($list->aduan->tahap_kategori=='S')
    //         {
    //             return '<span class="medium" data-toggle="tooltip" data-placement="top" title="SEGERA">' . '</span>';
    //         }
    //         else
    //         {
    //             return '<span class="none" data-toggle="tooltip" data-placement="top" title="BELUM DITENTUKAN">' . '</span>';
    //         }
    //     })

    //     ->rawColumns(['id', 'action', 'tahap_kategori', 'status_aduan', 'kategori_aduan', 'nama_pelapor', 'tarikh_laporan'])
    //     ->make(true);
    // }

    public function senaraiTeknikalKiv()
    {
        $status = StatusAduan::whereIn('kod_status', ['AK'])->get();

        return view('aduan.juruteknik.teknikal-kiv', compact('status'));
    }

    public function teknikalKiv()
    {
        $stf = User::where('category','STF')->pluck('id');

        $list = JuruteknikBertugas::where('juruteknik_bertugas', Auth::user()->id)->whereHas('aduan', function($query) use($stf) {
            $query->whereIn('id_pelapor', $stf)->whereIn('status_aduan', ['AK']);
        })->with(['juruteknik','aduan.kategori','aduan.tahap','aduan.status','aduan'])->select('cms_juruteknik.*');

        return datatables()::of($list)

        ->addColumn('action', function ($list) {

            return '<a href="/info-aduan/' . $list->id_aduan.'" class="btn btn-sm btn-primary"><i class="fal fa-eye"></i></a>';
        })

        ->editColumn('nama_pelapor', function ($list) {

            return $list->aduan->nama_pelapor ?? '';
        })

        ->editColumn('lokasi_aduan', function ($list) {

            return strtoupper($list->aduan->lokasi_aduan) ?? '';
        })

        ->editColumn('tarikh_laporan', function ($list) {

            return date(' d-m-Y ', strtotime($list->aduan->tarikh_laporan) );
        })

        ->editColumn('tarikh_selesai_aduan', function ($list) {

            return date(' d-m-Y ', strtotime($list->aduan->tarikh_selesai_aduan) );
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

        ->addColumn('tempoh', function ($list) {

            if(isset($list->aduan->tarikh_selesai_aduan))
            {
                $tempoh = Carbon::parse($list->aduan->tarikh_laporan)->diffInDays($list->aduan->tarikh_selesai_aduan)+1;

            } else {

                $tempoh = Carbon::parse($list->aduan->tarikh_laporan)->diffInDays(Carbon::now())+1;
            }

            return $tempoh.' hari';
        })

        ->rawColumns(['lokasi_aduan', 'action', 'tahap_kategori', 'status_aduan', 'kategori_aduan', 'nama_pelapor',
        'tarikh_laporan','tarikh_selesai_aduan','tempoh'])
        ->make(true);
    }

    public function teknikalKivPelajar()
    {
        $std = User::where('category','STD')->pluck('id');

        $list = JuruteknikBertugas::where('juruteknik_bertugas', Auth::user()->id)->whereHas('aduan', function($query) use($std) {
            $query->whereIn('id_pelapor', $std)->whereIn('status_aduan', ['AK']);
        })->with(['juruteknik','aduan.kategori','aduan.tahap','aduan.status','aduan'])->select('cms_juruteknik.*');

        return datatables()::of($list)

        ->addColumn('action', function ($list) {

            return '<a href="/info-aduan/' . $list->id_aduan.'" class="btn btn-sm btn-primary"><i class="fal fa-eye"></i></a>';
        })

        ->editColumn('nama_pelapor', function ($list) {

            return $list->aduan->nama_pelapor ?? '';
        })

        ->editColumn('lokasi_aduan', function ($list) {

            return strtoupper($list->aduan->lokasi_aduan) ?? '';
        })

        ->editColumn('tarikh_laporan', function ($list) {

            return date(' d-m-Y ', strtotime($list->aduan->tarikh_laporan) );
        })

        ->editColumn('tarikh_selesai_aduan', function ($list) {

            return date(' d-m-Y ', strtotime($list->aduan->tarikh_selesai_aduan) );
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

        ->addColumn('tempoh', function ($list) {

            if(isset($list->aduan->tarikh_selesai_aduan))
            {
                $tempoh = Carbon::parse($list->aduan->tarikh_laporan)->diffInDays($list->aduan->tarikh_selesai_aduan)+1;

            } else {

                $tempoh = Carbon::parse($list->aduan->tarikh_laporan)->diffInDays(Carbon::now())+1;
            }

            return $tempoh.' hari';
        })

        ->rawColumns(['lokasi_aduan', 'action', 'tahap_kategori', 'status_aduan', 'kategori_aduan', 'nama_pelapor',
        'tarikh_laporan','tarikh_selesai_aduan','tempoh'])
        ->make(true);
    }

    // public function teknikal_kiv_luar()
    // {
    //     $merge = User::whereIn('category',['STF','STD'])->pluck('id')->toArray();

    //     $list = JuruteknikBertugas::where('juruteknik_bertugas', Auth::user()->id)->whereHas('aduan', function($query) use($merge) {
    //         $query->whereNotIn('id_pelapor', $merge)->whereIn('status_aduan', ['AK']);
    //     })->with(['juruteknik','aduan.kategori','aduan.tahap','aduan.status','aduan'])->get();

    //     return datatables()::of($list)
    //     ->addColumn('action', function ($list) {

    //         if($list->aduan->status_aduan=='DJ') {
    //             return '<div class="btn-group"><a href="/info-aduan/' . $list->id_aduan.'" class="btn btn-sm btn-info mr-2"><i class="fal fa-pencil"></i></a>
    //                     <a data-page="/muaturun-borang' . $list->id_aduan.'" class="btn btn-sm btn-primary text-white" onclick="Print(this)"><i class="fal fa-file"></i></a></div>';
    //         } else {
    //             return '<a href="/info-aduan/' . $list->id_aduan.'" class="btn btn-sm btn-info"><i class="fal fa-pencil"></i></a>';
    //         }
    //     })

    //     ->editColumn('id', function ($list) {

    //         return '#'.$list->id_aduan;
    //     })

    //     ->editColumn('nama_pelapor', function ($list) {

    //         return $list->aduan->nama_pelapor;
    //     })

    //     ->editColumn('tarikh_laporan', function ($list) {

    //         return date(' Y-m-d ', strtotime($list->aduan->tarikh_laporan) );
    //     })

    //     ->editColumn('kategori_aduan', function ($list) {

    //         return $list->aduan->kategori->nama_kategori ?? '';
    //     })

    //     ->editColumn('status_aduan', function ($list) {

    //         return '<span class="badge badge-kiv">' . strtoupper($list->aduan->status->nama_status) . '</span>';
    //     })

    //     ->editColumn('tahap_kategori', function ($list) {

    //         if($list->aduan->tahap_kategori=='B')
    //         {
    //             return '<span class="low" data-toggle="tooltip" data-placement="top" title="BIASA">' . '</span>';
    //         }
    //         elseif($list->aduan->tahap_kategori=='S')
    //         {
    //             return '<span class="medium" data-toggle="tooltip" data-placement="top" title="SEGERA">' . '</span>';
    //         }
    //         else
    //         {
    //             return '<span class="none" data-toggle="tooltip" data-placement="top" title="BELUM DITENTUKAN">' . '</span>';
    //         }
    //     })

    //     ->rawColumns(['id', 'action', 'tahap_kategori', 'status_aduan', 'kategori_aduan', 'nama_pelapor', 'tarikh_laporan'])
    //     ->make(true);
    // }

    public function senaraiTeknikalBertindih()
    {
        $status = StatusAduan::whereIn('kod_status', ['DP'])->get();

        return view('aduan.juruteknik.teknikal-bertindih', compact('status'));
    }

    public function teknikalBertindih()
    {
        $stf = User::where('category','STF')->pluck('id');

        $list = JuruteknikBertugas::where('juruteknik_bertugas', Auth::user()->id)->whereHas('aduan', function($query) use($stf) {
            $query->whereIn('id_pelapor', $stf)->whereIn('status_aduan', ['DP']);
        })->with(['juruteknik','aduan.kategori','aduan.tahap','aduan.status','aduan'])->select('cms_juruteknik.*');

        return datatables()::of($list)

        ->addColumn('action', function ($list) {

            return '<a href="/info-aduan/' . $list->id_aduan.'" class="btn btn-sm btn-primary"><i class="fal fa-eye"></i></a>';
        })

        ->editColumn('nama_pelapor', function ($list) {

            return $list->aduan->nama_pelapor ?? '';
        })

        ->editColumn('lokasi_aduan', function ($list) {

            return strtoupper($list->aduan->lokasi_aduan) ?? '';
        })

        ->editColumn('tarikh_laporan', function ($list) {

            return date(' d-m-Y ', strtotime($list->aduan->tarikh_laporan) );
        })

        ->editColumn('tarikh_selesai_aduan', function ($list) {

            return date(' d-m-Y ', strtotime($list->aduan->tarikh_selesai_aduan) );
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

        ->addColumn('tempoh', function ($list) {

            if(isset($list->aduan->tarikh_selesai_aduan))
            {
                $tempoh = Carbon::parse($list->aduan->tarikh_laporan)->diffInDays($list->aduan->tarikh_selesai_aduan)+1;

            } else {

                $tempoh = Carbon::parse($list->aduan->tarikh_laporan)->diffInDays(Carbon::now())+1;
            }

            return $tempoh.' hari';
        })

        ->rawColumns(['lokasi_aduan', 'action', 'tahap_kategori', 'status_aduan', 'kategori_aduan', 'nama_pelapor',
        'tarikh_laporan','tarikh_selesai_aduan','tempoh'])
        ->make(true);
    }

    public function teknikalBertindihPelajar()
    {
        $std = User::where('category','STD')->pluck('id');

        $list = JuruteknikBertugas::where('juruteknik_bertugas', Auth::user()->id)->whereHas('aduan', function($query) use($std) {
            $query->whereIn('id_pelapor', $std)->whereIn('status_aduan', ['DP']);
        })->with(['juruteknik','aduan.kategori','aduan.tahap','aduan.status','aduan'])->select('cms_juruteknik.*');

        return datatables()::of($list)
        ->addColumn('action', function ($list) {

            return '<a href="/info-aduan/' . $list->id_aduan.'" class="btn btn-sm btn-primary"><i class="fal fa-eye"></i></a>';
        })

        ->editColumn('nama_pelapor', function ($list) {

            return $list->aduan->nama_pelapor ?? '';
        })

        ->editColumn('lokasi_aduan', function ($list) {

            return strtoupper($list->aduan->lokasi_aduan) ?? '';
        })

        ->editColumn('tarikh_laporan', function ($list) {

            return date(' d-m-Y ', strtotime($list->aduan->tarikh_laporan) );
        })

        ->editColumn('tarikh_selesai_aduan', function ($list) {

            return date(' d-m-Y ', strtotime($list->aduan->tarikh_selesai_aduan) );
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

        ->addColumn('tempoh', function ($list) {

            if(isset($list->aduan->tarikh_selesai_aduan))
            {
                $tempoh = Carbon::parse($list->aduan->tarikh_laporan)->diffInDays($list->aduan->tarikh_selesai_aduan)+1;

            } else {

                $tempoh = Carbon::parse($list->aduan->tarikh_laporan)->diffInDays(Carbon::now())+1;
            }

            return $tempoh.' hari';
        })

        ->rawColumns(['lokasi_aduan', 'action', 'tahap_kategori', 'status_aduan', 'kategori_aduan', 'nama_pelapor',
        'tarikh_laporan','tarikh_selesai_aduan','tempoh'])
        ->make(true);
    }

    // public function teknikal_bertindih_luar()
    // {
    //     $merge = User::whereIn('category',['STF','STD'])->pluck('id')->toArray();

    //     $list = JuruteknikBertugas::where('juruteknik_bertugas', Auth::user()->id)->whereHas('aduan', function($query) use($merge) {
    //         $query->whereNotIn('id_pelapor', $merge)->whereIn('status_aduan', ['DP']);
    //     })->with(['juruteknik','aduan.kategori','aduan.tahap','aduan.status','aduan'])->get();

    //     return datatables()::of($list)
    //     ->addColumn('action', function ($list) {

    //         if($list->aduan->status_aduan=='DJ') {
    //             return '<div class="btn-group"><a href="/info-aduan/' . $list->id_aduan.'" class="btn btn-sm btn-info mr-2"><i class="fal fa-pencil"></i></a>
    //                     <a data-page="/muaturun-borang' . $list->id_aduan.'" class="btn btn-sm btn-primary text-white" onclick="Print(this)"><i class="fal fa-file"></i></a></div>';
    //         } else {
    //             return '<a href="/info-aduan/' . $list->id_aduan.'" class="btn btn-sm btn-info"><i class="fal fa-pencil"></i></a>';
    //         }
    //     })

    //     ->editColumn('id', function ($list) {

    //         return '#'.$list->id_aduan;
    //     })

    //     ->editColumn('nama_pelapor', function ($list) {

    //         return $list->aduan->nama_pelapor;
    //     })

    //     ->editColumn('tarikh_laporan', function ($list) {

    //         return date(' Y-m-d ', strtotime($list->aduan->tarikh_laporan) );
    //     })

    //     ->editColumn('kategori_aduan', function ($list) {

    //         return $list->aduan->kategori->nama_kategori ?? '';
    //     })

    //     ->editColumn('status_aduan', function ($list) {

    //         return '<span class="badge badge-duplicate">' . strtoupper($list->aduan->status->nama_status) . '</span>';
    //     })

    //     ->editColumn('tahap_kategori', function ($list) {

    //         if($list->aduan->tahap_kategori=='B')
    //         {
    //             return '<span class="low" data-toggle="tooltip" data-placement="top" title="BIASA">' . '</span>';
    //         }
    //         elseif($list->aduan->tahap_kategori=='S')
    //         {
    //             return '<span class="medium" data-toggle="tooltip" data-placement="top" title="SEGERA">' . '</span>';
    //         }
    //         else
    //         {
    //             return '<span class="none" data-toggle="tooltip" data-placement="top" title="BELUM DITENTUKAN">' . '</span>';
    //         }
    //     })

    //     ->rawColumns(['id', 'action', 'tahap_kategori', 'status_aduan', 'kategori_aduan', 'nama_pelapor', 'tarikh_laporan'])
    //     ->make(true);
    // }

    // Export & PDF

    public function pdfAduan(Request $request, $id)
    {
        $aduan = Aduan::where('id', $id)->first();

        $resit = ResitAduan::where('id_aduan', $id)->get();

        $imej = ImejAduan::where('id_aduan', $id)->get();

        $gambar = ImejPembaikan::where('id_aduan', $id)->get();

        $juruteknik = JuruteknikBertugas::where('id_aduan', $id)->orderBy('jenis_juruteknik', 'ASC')->get();

        $alatan_ganti = AlatanPembaikan::where('id_aduan', $id)->get();

        $stok_pembaikan = StokPembaikan::where('id_aduan', $id)->get();

        $pengadu = User::where('id', $aduan->id_pelapor)->first();

        return view('aduan.aduan-pdf', compact('aduan', 'resit', 'imej', 'gambar', 'juruteknik','alatan_ganti','pengadu','stok_pembaikan'));
    }

    public function muaturunBorang(Request $request, $id)
    {
        $aduan = Aduan::where('id', $id)->first();

        $resit = ResitAduan::where('id_aduan', $id)->get();

        $imej = ImejAduan::where('id_aduan', $id)->get();

        $gambar = ImejPembaikan::where('id_aduan', $id)->get();

        $juruteknik = JuruteknikBertugas::where('id_aduan', $id)->orderBy('jenis_juruteknik', 'ASC')->get();

        $pengadu = User::where('id', $aduan->id_pelapor)->first();

        return view('aduan.juruteknik.borang-manual', compact('aduan', 'resit', 'imej', 'gambar', 'juruteknik', 'pengadu'));
    }

    public function laporanAduan()
    {
        $senarai_bulan_tahun = Aduan::select(DB::raw('MONTH(tarikh_laporan) as month'), DB::raw('YEAR(tarikh_laporan) as year'))
                ->groupBy(DB::raw('MONTH(tarikh_laporan)'), DB::raw('YEAR(tarikh_laporan)'))->orderBy(DB::raw('YEAR(tarikh_laporan)'), 'ASC')
                ->orderBy(DB::raw('MONTH(tarikh_laporan)'), 'ASC')->get();

        $senarai_bulan = $senarai_bulan_tahun->pluck('month')->unique()->sort();

        $senarai_tahun = $senarai_bulan_tahun->pluck('year')->unique()->sort();

        $senarai_kategori = KategoriAduan::whereIn('kod_kategori', ['AWM','ELK','MKL','PKH','TKM'])->get();

        $senarai_status = StatusAduan::all();

        $senarai_tahap = TahapKategori::all();

        $juruteknik = JuruteknikBertugas::whereHas('aduan', function($query){
            $query->whereIn('kategori_aduan', ['AWM','ELK','MKL','PKH','TKM']);
        })->distinct('juruteknik_bertugas')->pluck('juruteknik_bertugas')->toArray();

        $senarai_juruteknik = Staff::whereIn('staff_id', $juruteknik)->whereIn('staff_code', ['OFM', 'AA'])->get();

        return view('aduan.laporan-aduan', compact('senarai_bulan','senarai_tahun', 'senarai_kategori',
        'senarai_status', 'senarai_tahap','senarai_juruteknik'));
    }

    public function laporanAduanExcel($params)
    {
        $paramArray = explode('/', $params);

        $tahun = $paramArray[0] ?? null;

        $bulan = $paramArray[1] ?? null;

        $kategori = $paramArray[2] ?? null;

        $jenis = $paramArray[3] ?? null;

        $sebab = $paramArray[4] ?? null;

        $status = isset($paramArray[5]) ? explode(',', $paramArray[5]) : null;

        $tahap = $paramArray[6] ?? null;

        $kategoriPengadu = $paramArray[7] ?? null;

        $pengadu = $paramArray[8] ?? null;

        if (Auth::user()->hasPermissionTo('view complaint - admin')) {

            $juruteknik = $paramArray[9] ?? null;
        } else {

            $juruteknik = Auth::user()->id;
        }

        return Excel::download(
            new eAduanFacilityAllExport($tahun, $bulan, $kategori, $jenis, $sebab, $status, $tahap, $kategoriPengadu, $pengadu, $juruteknik),
            'Laporan Aduan.xlsx'
        );
    }

    public function dataLaporanAduan(Request $request)
    {
        $tahun = $request->input('tahun');

        $bulan = $request->input('bulan');

        $kategori = $request->input('kategori');

        $jenis = $request->input('jenis');

        $sebab = $request->input('sebab');

        $status = (array) $request->input('status');

        $tahap = $request->input('tahap');

        $kategoriPengadu = $request->input('kategoriPengadu');

        $pengadu = $request->input('pengadu');

        if (Auth::user()->hasPermissionTo('view complaint - admin')) {
            $juruteknik = $request->input('juruteknik');
        } else {
            $juruteknik = Auth::user()->id;
        }

        $data = Aduan::
            when($tahun, function ($query) use ($tahun) {
                $query->whereYear('tarikh_laporan', $tahun);
            })
            ->when($bulan, function ($query) use ($bulan) {
                $query->whereMonth('tarikh_laporan', $bulan);
            })
            ->when($kategori, function ($query) use ($kategori) {
                if ($kategori != 'null' && $kategori != '') {

                    $query->where('kategori_aduan', $kategori);

                } else {

                    $query->whereIn('kategori_aduan', ['AWM','ELK','MKL','PKH','TKM']);
                }
            })
            ->when($jenis, function ($query) use ($jenis) {
                $query->where('jenis_kerosakan', $jenis);
            })
            ->when($sebab, function ($query) use ($sebab) {
                $query->where('sebab_kerosakan', $sebab);
            })
            ->when($tahap, function ($query) use ($tahap) {
                $query->where('tahap_kategori', $tahap);
            })
            ->when($status, function ($query) use ($status) {
                $query->whereIn('status_aduan', $status);
            })
            ->when($kategoriPengadu, function ($query) use ($kategoriPengadu) {
                if ($kategoriPengadu == 'STF') {

                    $staffIds = User::select('id')->where('category', 'STF')->pluck('id')->toArray();

                    $query->whereIn('id_pelapor', $staffIds)->whereNull('deleted_at');

                } elseif ($kategoriPengadu == 'STD') {

                    $studentIds = User::select('id')->where('category', 'STD')->pluck('id')->toArray();

                    $query->whereIn('id_pelapor', $studentIds)->whereNull('deleted_at');
                }
            })
            ->when($pengadu, function ($query) use ($pengadu) {
                $query->where('id_pelapor', $pengadu);
            })
            ->when($juruteknik, function ($query) use ($juruteknik) {
                $query->whereHas('juruteknik', function ($query) use ($juruteknik) {
                    $query->where('juruteknik_bertugas', $juruteknik);
                });
            })
        ->whereNotIn('status_aduan', ['AB'])
        ->whereIn('kategori_aduan', ['AWM','ELK','MKL','PKH','TKM'])
        ->with(['kategori', 'jenis', 'sebab', 'tahap', 'status','pengadu'])
        ->select('cms_aduan.*');

        return datatables()::of($data)

        ->editColumn('kategori_aduan', function ($data) {

            return isset($data->kategori->nama_kategori) ? strtoupper($data->kategori->nama_kategori) : '<div style="color:red;">--</div>';
        })

        ->editColumn('jenis_kerosakan', function ($data) {

            return isset($data->jenis->jenis_kerosakan) ? strtoupper($data->jenis->jenis_kerosakan) : '<div style="color:red;">--</div>';
        })

        ->editColumn('sebab_kerosakan', function ($data) {

            return isset($data->sebab->sebab_kerosakan) ? strtoupper($data->sebab->sebab_kerosakan) : '<div style="color:red;">--</div>';
        })

        ->editColumn('tahap_kategori', function ($data) {

            return isset($data->tahap->jenis_tahap) ? strtoupper($data->tahap->jenis_tahap) : '<div style="color:red;">--</div>';
        })

        ->addColumn('tarikh_laporan', function ($data) {

            return isset($data->tarikh_laporan) ? date('d/m/Y', strtotime($data->tarikh_laporan)) : '<div style="color:red;">--</div>';
        })

        ->addColumn('tarikh_selesai_aduan', function ($data) {

            return isset($data->tarikh_selesai_aduan) ? date('d/m/Y', strtotime($data->tarikh_selesai_aduan)) : '<div style="color:red;">--</div>';
        })

        ->editColumn('status_aduan', function ($data) {

            return isset($data->status->nama_status) ? strtoupper($data->status->nama_status) : '<div style="color:red;">--</div>';
        })

        ->rawColumns(['kategori_aduan', 'jenis_kerosakan', 'sebab_kerosakan', 'tahap_kategori', 'tarikh_laporan', 'tarikh_selesai_aduan', 'status_aduan'])

        ->make(true);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
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
