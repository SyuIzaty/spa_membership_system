<?php

namespace App\Http\Controllers\Inventory;

use Asset;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AssetSearchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function asset_search(Request $request)
    {
        $integer = substr($request->asset_code, -10);

        $data = $data2 = $data3 = '';

        if ($request->asset_code) {
            $result = new Asset();

            if ($request->asset_code != "") {
                $result = $result->where('asset_code', $integer);
            }

            $data = $result->first();
        }

        if ($request->ajax()) {
            return view('inventory.asset.asset-search-detail', compact('data', 'request'));
        }

        return view('inventory.asset.asset-search', compact('data', 'request'));
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
