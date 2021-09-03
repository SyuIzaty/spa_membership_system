<?php

namespace App\Imports;

use App\Files;
use Carbon\Carbon;
use App\Asset;
use Illuminate\Support\Facades\Mail;
use App\Custodian;
use App\AssetTrail;
use Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;
use Maatwebsite\Excel\Concerns\WithValidation;

class AssetImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $code = Carbon::now()->format('Y').mt_rand(100000, 999999);

        $asset = Asset::create([
            'asset_code_type'           => $row['code_type'],
            'finance_code'              => $row['finance_asset_code'],
            'asset_code'                => $code,
            'asset_name'                => $row['asset_name'],
            'asset_type'                => $row['asset_type'],
            'serial_no'                 => $row['serial_no'],
            'model'                     => $row['model'],
            'brand'                     => $row['brand'],
            'total_price'               => $row['price'],
            'lo_no'                     => $row['lo_no'],
            'io_no'                     => $row['invoice_no'],
            'do_no'                     => $row['do_no'],
            'purchase_date'             => $row['purchase_date'],
            'vendor_name'               => $row['vendor'],
            'remark'                    => $row['remark'],
            'status'                    => $row['status'],
            'availability'              => $row['availability'],
            'storage_location'          => $row['storage'],
            'set_package'               => $row['package'],
            'custodian_id'              => $row['custodian'],
            'created_by'                => Auth::user()->id,
        ]);

        $trail = AssetTrail::create([
            'asset_id'              => $asset->id,
            'asset_type'            => $asset->asset_type,
            'asset_code'            => $asset->asset_code,
            'asset_code_type'       => $asset->asset_code_type,
            'finance_code'          => $asset->finance_code,
            'asset_name'            => $asset->asset_name, 
            'serial_no'             => $asset->serial_no, 
            'model'                 => $asset->model,
            'brand'                 => $asset->brand,
            'status'                => $asset->status,
            'inactive_date'         => $asset->inactive_date,
            'availability'          => $asset->availability,
            'purchase_date'         => $asset->purchase_date,
            'vendor_name'           => $asset->vendor_name,
            'lo_no'                 => $asset->lo_no,
            'do_no'                 => $asset->do_no,
            'io_no'                 => $asset->io_no,
            'total_price'           => $asset->total_price,
            'remark'                => $asset->remark,
            'set_package'           => $asset->set_package,
            'storage_location'      => $asset->storage_location,
            'custodian_id'          => $asset->custodian_id, 
            'created_by'            => $asset->created_by,
            'updated_by'            => Auth::user()->id,
        ]);

        $custodian = Custodian::create([
            'asset_id'         => $asset->id,
            'custodian_id'     => $asset->custodian_id,
            'assigned_by'      => Auth::user()->id,
            'verification'     => '0',
            'status'           => '1',
        ]);

        if(isset($custodian->staff->staff_email))
        {
            $data = [
                'receiver_name'     => $custodian->staff->staff_name,
                'assign_date'       => date(' j F Y ', strtotime( $custodian->created_at )),
                'details'           => $asset->asset_code.' : '.$asset->asset_name,
            ];

            Mail::send('inventory.verify-mail', $data, function($message) use ($custodian) {
                $message->to($custodian->staff->staff_email)->subject('Asset Custodian Verification');
                $message->from(Auth::user()->email);
            });
        }

        // return new Asset([
        //     //
        // ]);
    }

    public function rules(): array
    {
        return [

            // 'asset_code_type' => 'required',
        ];
    }
}
