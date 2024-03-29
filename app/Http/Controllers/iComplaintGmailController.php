<?php

namespace App\Http\Controllers;

use App\User;
use App\AduanKorporat;
use App\OauthIcomplaint;
use App\AduanKorporatLog;
use App\AduanKorporatFile;
use App\AduanKorporatUser;
use Illuminate\Http\Request;
use App\AduanKorporatCategory;
use App\AduanKorporatSubCategory;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;

class iComplaintGmailController extends Controller
{
    public function loginIComplaint()
    {
        return view('aduan-korporat-gmail-user.login');
    }

    public function main($id)
    {
        $user = session('user');

        return view('aduan-korporat-gmail-user.main', compact('user', 'id'));
    }

    public function formGmailUser($encryptID)
    {
        $decryptID = Crypt::decryptString($encryptID);
        $details = OauthIcomplaint::where('id', $decryptID)->first();

        $userCategory = AduanKorporatUser::whereNotIn('code', ['STF', 'STD'])->get();
        $category     = AduanKorporatCategory::all();
        $subcategory  = AduanKorporatSubCategory::all();

        return view('aduan-korporat-gmail-user.form', compact('userCategory', 'category', 'subcategory', 'encryptID', 'details'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'userCategory' => 'required',
            'user_phone'   => 'required|regex:/[0-9]/|min:10|max:11',
            'address'      => 'required',
            'category'     => 'required',
            'title'        => 'required',
            'description'  => 'required',
            'attachment.*' => 'file|mimes:jpeg,png,gif,pdf,doc,docx|max:2048',
        ], [
            'user_phone.min'        => 'Phone number does not match the format!',
            'user_phone.max'        => 'Phone number does not match the format!',
            'user_phone.regex'      => 'Phone number must be number only!',
            'user_phone.required'   => 'Phone number is required!',
            'attachment.*.required' => 'Attachment is required!',
            'attachment.*.file'     => 'Attachment must be a file!',
            'attachment.*.mimes'    => 'Attachment must be in image or document format (jpeg, png, gif, pdf, doc, docx)!',
            'attachment.*.max'      => 'Attachment size must not exceed 2MB!',
        ]);

        $decryptID = Crypt::decryptString($request->user_id);

        $data = AduanKorporat::create([
            'phone_no'      => $request->user_phone,
            'address'       => $request->address,
            'user_category' => $request->userCategory,
            'category'      => $request->category,
            'subcategory'   => $request->subcategory,
            'status'        => '1',
            'title'         => $request->title,
            'description'   => $request->description,
            'created_by'    => $decryptID,
        ]);


        $cat = AduanKorporatCategory::where('id', $request->category)->first();
        $ticket = date('dmY').$cat->code.$decryptID;

        AduanKorporat::where('id', $data->id)->update(['ticket_no' => $ticket]);

        AduanKorporatLog::create([
            'complaint_id'  => $data->id,
            'activity'      => 'Create new',
            'created_by'    =>  $decryptID
        ]);


        $file = $request->attachment;

        if (isset($file)) {
            foreach ($file as $f => $value) {
                $originalName = $value->getClientOriginalName();
                $fileName = time() . '-' . $value->getClientOriginalName();
                Storage::disk('minio')->put("/iComplaint/" . $fileName, file_get_contents($value));
                AduanKorporatFile::create([
                    'complaint_id'  => $data->id,
                    'original_name' => $originalName,
                    'upload'        => $fileName,
                    'web_path'      => "iComplaint/" . $fileName,
                    'created_by'    =>  $decryptID
                ]);
            }
        }

        // $admin = User::whereHas('roles', function ($query) {
        //     $query->where('id', 'EAK001'); // Admin
        // })->get();

        // foreach($admin as $a) {
        //     $admin_email = $a->email;

        //     $data = [
        //         'receiver' => 'Assalamualaikum & Good Day, Sir/Madam/Mrs./Mr./Ms. ' . $a->name,
        //         'emel'     => 'You have received new iComplaint on '.date(' j F Y ', strtotime(Carbon::now()->toDateTimeString())).'. Please log in to the IDS system for further action.',
        //     ];

        //     Mail::send('aduan-korporat.email', $data, function ($message) use ($admin_email) {
        //         $message->subject('New iComplaint');
        //         $message->from('corporate@intec.edu.my');
        //         $message->to($admin_email);
        //     });
        // }

        $encryptTicket = Crypt::encryptString($ticket);

        return redirect('end/'.$request->user_id.'/'.$encryptTicket);
    }

    public function end($id, $ticket)
    {
        return view('aduan-korporat-gmail-user.end', compact('ticket'));
    }

}
