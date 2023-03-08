<?php

namespace App\Http\Controllers\Library\Arkib;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\ArkibMain;
use App\ArkibAttachment;
use App\ArkibView;
use Carbon\Carbon;
use DB;

class ArkibDashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $years = ArkibMain::selectRaw("DATE_FORMAT(created_at, '%Y') year")
                ->groupBy('year')
                ->orderBy('year', 'desc')
                ->limit(3)->get();

        $selected_year = Carbon::now()->format('Y');

        $category = DB::table('arkib_mains as types')
        ->select('types.department_code', DB::raw('COUNT(claims.id) as count'), 'dept.name')
        ->leftJoin('arkib_attachments as claims','types.id','=','claims.arkib_main_id')
        ->leftJoin('department as dept','types.department_code','=','dept.id')
        ->where(DB::raw('YEAR(claims.created_at)'), '<=', $selected_year)
        ->where('claims.deleted_at',NULL)
        ->groupBy('types.department_code', 'dept.name')
        ->get();

        $results[] = ['Department','Total Document'];
        foreach ($category as $key => $value) {
            $results[++$key] = [$value->name, (int)$value->count];
        }

        // Start PieChart
        $type = DB::table('arkib_statuses as types')
        ->select('types.arkib_description','claims.status', DB::raw('COUNT(claims.status) as count'))
        ->leftJoin('arkib_mains as claims','types.arkib_status','=','claims.status')
        ->where(DB::raw('YEAR(claims.created_at)'), '<=', $selected_year)
        ->where('claims.deleted_at',NULL)
        ->groupBy('types.arkib_status', 'types.arkib_description', 'claims.status')
        ->get();

        $result[] = ['Type','Total'];
        foreach ($type as $key => $value) {
            $result[++$key] = [$value->arkib_description, (int)$value->count];
        }
        // End PieCart

        $arkib_rank = ArkibMain::select('department_code', DB::raw('COUNT(status) as total'))
                        ->where( DB::raw('YEAR(created_at)'), '<=', $selected_year )
                        ->groupBy('department_code')
                        ->limit(5)
                        ->orderBy('total', 'desc')
                        ->get();

        $view_rank = ArkibView::select('arkib_attachment_id', DB::raw('SUM(total) as total'))
                        ->where( DB::raw('YEAR(created_at)'), '=', $selected_year )
                        ->groupBy('arkib_attachment_id')
                        ->limit(5)
                        ->orderBy('total', 'desc')
                        ->get();

        $staff_rank = ArkibView::select('user_id', DB::raw('SUM(total) as total'))
                        ->where( DB::raw('YEAR(created_at)'), '=', $selected_year )
                        ->groupBy('user_id')
                        ->limit(5)
                        ->orderBy('total', 'desc')
                        ->get();

        return view('library.arkib.dashboard',compact('years','selected_year','arkib_rank','view_rank','staff_rank'))->with('type',json_encode($result))->with('category',json_encode($results))->with('arkib_no', 1)->with('staff_no', 1)->with('train_no', 1);
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
