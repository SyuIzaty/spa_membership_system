<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAduanRequest extends FormRequest
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
            'nama_pelapor'          => 'required|min:10|max:255',
            'jawatan_pelapor'       => 'required',
            'emel_pelapor'          => 'required',
            'no_tel_pelapor'        => 'nullable|min:9|max:11|regex:/(\+?0)[0-46-9]-*[0-9]{7,8}/',
            'no_tel_bimbit_pelapor' => 'required|min:9|max:11|regex:/(\+?0)[0-46-9]-*[0-9]{7,8}/',
            'no_bilik_pelapor'      => '',
            'tarikh_laporan'        => '',
            'lokasi_aduan'          => 'required',
            'blok_aduan'            => 'required',
            'aras_aduan'            => 'required',
            'nama_bilik'            => 'required',
            'kategori_aduan'        => 'required',
            'jenis_kerosakan'       => 'required',
            'jk_penerangan'         => '',
            'sebab_kerosakan'       => 'required',
            'sk_penerangan'         => '',
            'maklumat_tambahan'     => '',
            'status_aduan'          => '',
        ];
    }
}
