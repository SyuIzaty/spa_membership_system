<?php

namespace App\Imports;

use Auth;
use App\Files;
use App\Asset;
use Session;
use App\InventoryLog;
use App\Custodian;
use App\AssetTrail;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class AssetImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    public function rules(): array
    {
        return [
            'code_type'             => 'required',
            'finance_asset_code'    => 'nullable',
            'asset_name'            => 'required',
            'asset_type'            => 'required',
            'asset_class'           => 'required',
            'serial_no'             => 'required',
            'model'                 => 'nullable',
            'brand'                 => 'nullable',
            'price'                 => 'nullable',
            'lo_no'                 => 'nullable',
            'invoice_no'            => 'nullable',
            'do_no'                 => 'nullable',
            'purchase_date'         => 'nullable',
            'vendor'                => 'nullable',
            'acquisition'           => 'nullable',
            'location'              => 'nullable',
            'remark'                => 'nullable',
            'status'                => 'required',
            'availability'          => 'nullable',
            'package'               => 'required',
            'custodian'             => 'required',
        ];
    }

    public function model(array $row)
    {
        try {
            $code = Carbon::now()->format('Y') . mt_rand(100000, 999999);

            $asset = Asset::create([
                'asset_code_type'           => $row['code_type'],
                'finance_code'              => $row['finance_asset_code'],
                'asset_code'                => $code,
                'asset_name'                => $row['asset_name'],
                'asset_type'                => $row['asset_type'],
                'asset_class'               => $row['asset_class'],
                'serial_no'                 => $row['serial_no'],
                'model'                     => $row['model'],
                'brand'                     => $row['brand'],
                'total_price'               => $row['price'],
                'lo_no'                     => $row['lo_no'],
                'io_no'                     => $row['invoice_no'],
                'do_no'                     => $row['do_no'],
                'purchase_date'             => $row['purchase_date'],
                'vendor_name'               => $row['vendor'],
                'acquisition_type'          => $row['acquisition'],
                'remark'                    => $row['remark'],
                'status'                    => $row['status'],
                'availability'              => $row['availability'],
                'space_room_id'             => $row['location'],
                'set_package'               => $row['package'],
                'custodian_id'              => $row['custodian'],
                'created_by'                => Auth::user()->id,
            ]);

            $trail = AssetTrail::create([
                'asset_id'              => $asset->id,
                'asset_type'            => $asset->asset_type,
                'asset_class'           => $asset->asset_class,
                'asset_code'            => $asset->asset_code,
                'asset_code_type'       => $asset->asset_code_type,
                'finance_code'          => $asset->finance_code,
                'asset_name'            => $asset->asset_name,
                'serial_no'             => $asset->serial_no,
                'model'                 => $asset->model,
                'brand'                 => $asset->brand,
                'status'                => $asset->status,
                'inactive_date'         => $asset->inactive_date,
                'inactive_reason'       => $asset->inactive_reason,
                'inactive_remark'       => $asset->inactive_remark,
                'availability'          => $asset->availability,
                'purchase_date'         => $asset->purchase_date,
                'vendor_name'           => $asset->vendor_name,
                'lo_no'                 => $asset->lo_no,
                'do_no'                 => $asset->do_no,
                'io_no'                 => $asset->io_no,
                'total_price'           => $asset->total_price,
                'remark'                => $asset->remark,
                'acquisition_type'      => $asset->acquisition_type,
                'set_package'           => $asset->set_package,
                'space_room_id'         => $asset->space_room_id,
                'custodian_id'          => $asset->custodian_id,
                'created_by'            => $asset->created_by,
                'updated_by'            => Auth::user()->id,
            ]);

            $custodian = Custodian::create([
                'asset_id'         => $asset->id,
                'custodian_id'     => $asset->custodian_id,
                'assigned_by'      => Auth::user()->id,
                'verification'     => '1',
                'verification_date'=> Carbon::now(),
                'status'           => '2',
            ]);

            InventoryLog::create([
                'name'            => 'default',
                'description'     => 'Upload Asset Data',
                'subject_id'      => $asset->id,
                'subject_type'    => 'App\Asset',
                'properties'      => json_encode($row),
                'creator_id'      => Auth::user()->id,
                'creator_type'    => 'App\User',
            ]);

            Session::flash('success', 'Asset Data Imported Successfully');

        } catch (\Exception $e) {

            Session::flash('error', 'Asset Data Import Failed: ' . $e->getMessage());
            return null;
        }
    }
}
