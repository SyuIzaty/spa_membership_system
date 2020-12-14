<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePembaikanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    protected function formatErrors(Validator $validator)
    {
        return $validator->errors()->all();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'laporan_pembaikan'        => 'required|min:10|max:255',
            'bahan_alat'               => 'required|min:10|max:255',
            'ak_upah'                  => '',
            'ak_bahan_alat'            => '',
            'jumlah_kos'               => '',
            'tarikh_selesai_aduan'     => 'required',
            'status_aduan'             => 'required',
        ];
    }
}
