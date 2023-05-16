<?php

namespace App\Http\Controllers;

use App\Equipment;
use App\EquipmentRent;
use App\EquipmentStaff;
use App\Exports\ICTRentalExport;
use App\Exports\ICTRentalExportByYear;
use App\Exports\ICTRentalExportByYearMonth;
use App\Staff;
use App\User;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;

class TestController extends Controller
{

    public function index()
    {
        $staff = Staff::where('staff_id', Auth::user()->id)->first();
        $equipment = Equipment::all(); //name model;
        return view('test.test', compact('equipment', 'staff'));
    }
    public function store(Request $request)
    {
        // dd($request->hpno);
        $validated = $request->validate([
            'hpno' => 'required|numeric|digits_between:10,11',
            'room_no' => 'required|numeric',
            'rentdate' => 'required|date|after_or_equal:' . now()->format('Y-m-d'),
            'retdate' => 'required|date|after_or_equal:rentdate', // Set the validation rule to be greater than or equal to 'rentdate'
            'purpose' => 'required',

        ], [
            'hpno.numeric' => 'phone number should be numeric.',
            'hpno.required' => 'phone number required.',
            'hpno.digits_between' => 'phone number should be between 10 until 11.',
            'room_no.required' => 'The room number is required.',
            'room_no.numeric' => 'The room number must be in numeric',
            'rentdate.required' => 'The rental date is required',
            'retdate.required' => 'The return date is required',
            'rentdate.required' => 'The return date is required',
            'retdate.after_or_equal' => 'The return date must a same day or after a rental date',
            'purpose.required' => 'purpose is required',

        ]);

        $data = EquipmentStaff::create([ //store in equipment staff and take it from user
            'staff_id' => Auth::user()->id,
            'hp_no' => $request->hpno,
            'rent_date' => $request->rentdate,
            'return_date' => $request->retdate,
            'purpose' => $request->purpose,
            'room_no' => $request->room_no,
            'name' => auth()->user()->name,
            'status' => 'Pending',
        ]);
        foreach ($request->sn as $test => $value) {
            if (isset($value)) {
                EquipmentRent::create([
                    'users_id' => $data->id,
                    'equipments_id' => $test, //used to store the ID of the equipment
                    'ser_no' => $value, //to store a single piece of information specific to the rented equipment
                    'desc' => $request->des[$test],

                ]);
            }

        }

        $image = $request->upload_img;
        $paths = storage_path()."/rent/";
        
        if (isset($image)) {
            for($y = 0; $y < count($image); $y++)
            {
                $originalsName = $image[$y]->getClientOriginalName();
                $fileSizes = $image[$y]->getSize();
                $fileNames = $originalsName;
                Storage::disk('minio')->put("/rent/".$fileNames,file_get_contents($image[$y]));
                EquipmentStaff::create([
                    'staff_id' => Auth::user()->id,
                    'upload_img'  => date('dmyhi').' - '.$originalsName,
                    'web_path'      =>"app/rent/".date('dmyhi').' - '.$fileNames,
                ]);
            }
        }
        
        $file = $request->doc;
        $path=storage_path()."/doc/";
        
        if (isset($file)) {
        
            for($x = 0; $x < count($file) ; $x ++)
            {
                $originalName = $file[$x]->getClientOriginalName();
                $fileSize = $file[$x]->getSize();
                $fileName = $originalName;
                Storage::disk('minio')->put("/doc/".$fileName,file_get_contents($file[$x]));
                EquipmentStaff::create([
                    'staff_id' => Auth::user()->id,
                    'nama_fail' => date('dmyhi').' - '.$originalName,
                    'saiz_fail' => $fileSize,
                    'web_path'  => "app/doc/".date('dmyhi').' - '.$fileName,
                ]);
            }
        }
        
        // $imageString = implode(',', $image);
        // $fileString = implode(',', $file);

        // return response()->json(['success' => 'Your error message here']); // add this line
        return redirect()->back();
    }
    public function showApplication(Request $request)
    {
        // $equipment = Equipment::all();

        // $selectedequipment = $request->equipment;

        $data = EquipmentStaff::where('staff_id', Auth::user()->id)->get();

        return view('test.detail', compact('data'));
    }
    public function show(Request $request)
    {
        $equipment = Equipment::all();
        $equipment_rent = EquipmentRent::all();
        $user = EquipmentStaff::all();
        // dd($request->status);

        $selectedequipment = $request->equipment;
        $count = EquipmentStaff::
            whereIn('status', ['Approved', 'Pending', 'Rejected'])
            ->whereNotNull('staff_id')
            ->whereYear('rent_date', Carbon::now()->year)
            ->get()
            ->count();
        $count2 = EquipmentStaff::
            whereIn('status', ['Rejected', 'Approved'])
            ->whereNotNull('staff_id')
            ->whereYear('rent_date', Carbon::now()->year)
            ->get()
            ->count();
        $count3 = EquipmentStaff::
            where('status', 'Pending')
            ->whereNotNull('staff_id')
            ->whereYear('rent_date', Carbon::now()->year)
            ->get()
            ->count();

        return view('test.view_record', compact('equipment', 'equipment_rent', 'user', 'selectedequipment', 'count', 'count2', 'count3'))
        // ->with('count', $count)
        ->with('currentYear', Carbon::now()->year);
    }
    public function edit($id)
    {
        $equipments = Equipment::all();
        $user = EquipmentStaff::where('id', $id)->first(); //search one user
        $staff = Staff::where('staff_id', $user->staff_id)->first(); //query(eloquent)
        $rent = EquipmentRent::where('users_id', $id)->get(); //retrive data in equipment rent (more than 1)
        // $name = $staff->staff_name;

        // Pass the equipment record to the edit_record view
        return view('test.edit_record', compact('user', 'staff', 'equipments', 'rent', 'id'));
    }

    public function declareDelete($id)
    {
        $delRent = EquipmentRent::where('users_id', $id)->get(); //get the equipment data

        foreach ($delRent as $delRents) {
            $delRents->delete();
        }

        $data = EquipmentStaff::find($id); //get the equipment staff data
        $data->delete();
        $data = EquipmentRent::find($users_id);
        $data->delete();
        return response()->json(['success' => 'Declaration Form Successfully Deleted']);
    }
    public function own_data(Request $request)
    {
        $data = EquipmentStaff::where('staff_id', Auth::user()->id)->get();

        return datatables()::of($data)

            ->editColumn('sid', function ($data) {
                return isset($data->id) ? $data->id : "";
            })
            ->editColumn('staff', function ($data) {
                return isset($data->staff_id) ? $data->staff_id : "";
            })
            ->editColumn('name', function ($data) {

                return isset($data->name) ? $data->name : "";
            })
            ->editColumn('phone', function ($data) {
                return isset($data->hp_no) ? $data->hp_no : "";
            })
            ->editColumn('renDate', function ($data) {
                return isset($data->rent_date) ? $data->rent_date : "";
            })

            ->editColumn('retDate', function ($data) {
                return isset($data->return_date) ? $data->return_date : "";
            })
            ->editColumn('sta', function ($data) {
                return isset($data->status) ? $data->status : "";
            })

            ->addColumn('action', function ($data) {
                return '<div class="btn-group">
                    <a href="/downloadPDF/' . $data->id . '" class="btn btn-warning btn-sm mr-1"><i class="ni ni-note"></i> Download</a>
                </div>';
            })
                                    
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);
    }
    public function downloadPDF(Request $request, $id)
    {
        $application = EquipmentStaff::with(['staff'])->where('id', $id)->first();
        $equipments = Equipment::all();
        $user = EquipmentStaff::where('id', $id)->first(); //search one user
        $staff = Staff::where('staff_id', $user->staff_id)->first(); //query(eloquent)
        $rent = EquipmentRent::where('users_id', $id)->get(); //retrive data in equipment rent (more than 1)
        // $name = $staff->staff_name;

        // Pass the equipment record to the edit_record view
        return view('test.download', compact('application','user', 'staff', 'equipments', 'rent', 'id'));


    }

    public function data_rental(Request $request)
    { //declaration

        $cond = "1";

        if ($request->equipment && $request->equipment != "All") {
            $cond .= " AND (equipments_id = '" . $request->equipment . "')";
        }

        $data = EquipmentRent::whereRaw($cond)->with('equipmentStaff')->get();

        $equipment_rent = EquipmentStaff::with('staff')->select('equipment_staffs.*'); //join table equipmentStaff and equipment & create join function in model

        return datatables()::of($data)

            ->editColumn('sid', function ($data) {
                return isset($data->equipmentStaff->id) ? $data->equipmentStaff->id : "";
            })
            ->editColumn('staff', function ($data) {
                return isset($data->equipmentStaff->staff_id) ? $data->equipmentStaff->staff_id : "";
            })
            ->editColumn('name', function ($data) {

                return isset($data->equipmentStaff->name) ? $data->equipmentStaff->name : "";
            })
            ->editColumn('phone', function ($data) {
                return isset($data->equipmentStaff->hp_no) ? $data->equipmentStaff->hp_no : "";
            })
            ->editColumn('renDate', function ($data) {
                return isset($data->equipmentStaff->rent_date) ? $data->equipmentStaff->rent_date : "";
            })

            ->editColumn('retDate', function ($data) {
                return isset($data->equipmentStaff->return_date) ? $data->equipmentStaff->return_date : "";
            })
            ->editColumn('sta', function ($data) {
                return isset($data->equipmentStaff->status) ? $data->equipmentStaff->status : "";
            })

            ->addColumn('action', function ($data) {
                $deleteBtn = '';
                if ($data->equipmentStaff->status == 'Pending') {
                    $deleteBtn = '<button class="btn btn-sm btn-danger btn-delete" data-remote="declareDelete/' . $data->equipmentStaff->id . '"><i class="fal fa-trash"></i> </button>';
                }

                return '<div class="btn-group"><a href="/edit_record/' . $data->equipmentStaff->id . '" class="btn btn-warning btn-sm mr-1"><i class="ni ni-note"></i> </a>' . $deleteBtn . '</div>';
            })

            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);
    }
    public function operationVerifyApplication(Request $request)
    {
        $user = EquipmentStaff::where('id', $request->id)->first(); //search one user
        $user->update([
            'status' => 'Approved',
        ]);
        // $user_email = $user->staff->staff_email;
        // $user_name = $user->staff->staff_name;

        // $data = [
        //     'receiver' => 'Assalamualaikum & Good Day, Sir/Madam/Mrs./Mr./Ms. ' . $user_name,
        //     'emel' => 'Your ICT Rrntal application has been approved on ' . date(' j F Y ', strtotime(Carbon::now()->toDateTimeString())),
        // ];

        // Mail::send('test.email', $data, function ($message) use ($user_email) {
        //     $message->subject('ICT Rental Application: Approved');
        //     $message->from('nabilahwahid894@gmail.com');
        //     $message->to($user_email);
        // });
        // if ($updateSuccessful) {
        //     return response()->json(['message' => 'Application verified successfully.']);
        // } else {
        //     return response()->json(['message' => 'Failed to verify application.']);
        // }
           return redirect()->back()->with('message', 'Verified');
        // return response()->json(['success' => 'Successful Assign!']);
    }
    public function operationRejectApplication(Request $request)
    {
        $user = EquipmentStaff::where('id', $request->id)->first(); //search one user
        $user->update([
            'status' => 'Rejected',
        ]);
        // $user_email = $user->staff->staff_email;
        // $user_name = $user->staff->staff_name;

        // $data = [
        //     'receiver' => 'Assalamualaikum & Good Day, Sir/Madam/Mrs./Mr./Ms. ' . $user_name,
        //     'emel' => 'Your ICT Rrntal application has been Rejected on ' . date(' j F Y ', strtotime(Carbon::now()->toDateTimeString())),
        // ];

        // Mail::send('test.email', $data, function ($message) use ($user_email) {
        //     $message->subject('ICT Rental Application: Rejected');
        //     $message->from('nabilahwahid894@gmail.com');
        //     $message->to($user_email);
        // });
        return redirect()->back()->with('message', 'Verified');

        // return response()->json(['success' => 'Successful Assign!']);
    }

    public function report(Request $request)
    {
        $year = EquipmentStaff::with('staff')->select('equipment_staffs.*')
            ->orderBy('created_at', 'ASC')
            ->pluck('created_at')
            ->map(function ($date) {
                return Carbon::parse($date)->format('Y');
            })
            ->unique(); //year selection

        return view('test.report', compact('year'));
    }
    public function getYear($year)
    {

        $month = EquipmentStaff::whereIn('status', ['Approved', 'Rejected'])
            ->whereYear('rent_date', '=', $year)
            ->orderBy('rent_date', 'ASC')
            ->pluck('rent_date')
            ->map(function ($date) {
                return Carbon::parse($date)->format('F'); // F is to represent the full textual representation of a month
            })
            ->unique(); //month selection

        return response()->json($month);
    }
    public function reportbyYear(Request $request)
    {
        $list = EquipmentStaff::whereIn('id', $request->id)->whereYear('rent_date', '=', $request->year)->get();

        return datatables()::of($list)

            ->editColumn('sid', function ($equipment_rent) {
                return isset($equipment_rent->id) ? $equipment_rent->id : "";
            })
            ->editColumn('staff', function ($equipment_rent) {
                return isset($equipment_rent->staff_id) ? $equipment_rent->staff_id : "";
            })
            ->editColumn('name', function ($equipment_rent) {

                return isset($equipment_rent->name) ? $equipment_rent->name : "";
            })
            ->editColumn('phone', function ($equipment_rent) {
                return isset($equipment_rent->hp_no) ? $equipment_rent->hp_no : "";
            })
            ->editColumn('renDate', function ($list) {
                $date = Carbon::createFromFormat('equipment_rent->rent_date')->format('d/m/Y');
                return $date;
            })
            ->editColumn('retDate', function ($equipment_rent) {
                return isset($equipment_rent->return_date) ? $equipment_rent->return_date : "";
            })
            ->editColumn('sta', function ($equipment_rent) {
                return isset($equipment_rent->status) ? $equipment_rent->status : "";
            })
        // ->addIndexColumn()
            ->make(true);
    }
    public function ICTRentalReport()
    {
        return Excel::download(new ICTRentalExport(), 'ICT Rental Report.xlsx');
    }
    public function ICTRentReportYear($year)
    {
        return Excel::download(new ICTRentalExportByYear($year), 'ICT Rental Report ' . $year . '.xlsx');
    }
    public function ICTRentReportYearMonth($year, $month)
    {
        return Excel::download(new ICTRentalExportByYearMonth($year, $month), 'ICT Rental Report ' . $month . ' ' . $year . '.xlsx');
    }

    public function allReport(Request $request)
    {
        $list = EquipmentStaff::whereIn('status', ['Approved', 'Rejected'])->get();

        return datatables()::of($list)

            ->editColumn('sid', function ($equipment_rent) {
                return isset($equipment_rent->id) ? $equipment_rent->id : "";
            })
            ->editColumn('staff', function ($equipment_rent) {
                return isset($equipment_rent->staff_id) ? $equipment_rent->staff_id : "";
            })
            ->editColumn('name', function ($equipment_rent) {

                return isset($equipment_rent->name) ? $equipment_rent->name : "";
            })
            ->editColumn('phone', function ($equipment_rent) {
                return isset($equipment_rent->hp_no) ? $equipment_rent->hp_no : "";
            })
            ->editColumn('renDate', function ($equipment_rent) {
                return isset($equipment_rent->rent_date) ? $equipment_rent->rent_date : "";
            })
            ->editColumn('retDate', function ($equipment_rent) {
                return isset($equipment_rent->return_date) ? $equipment_rent->return_date : "";
            })
            ->editColumn('sta', function ($equipment_rent) {
                return isset($equipment_rent->status) ? $equipment_rent->status : "";
            })

            ->addIndexColumn()
            ->make(true);
    }
    public function reportYear(Request $request)
    {
        ///retrieve report by year
        $list = EquipmentStaff::whereIn('status', ['Approved', 'Rejected'])->whereYear('rent_date', '=', $request->year)->get();

        return datatables()::of($list)

            ->editColumn('sid', function ($equipment_rent) {
                return isset($equipment_rent->id) ? $equipment_rent->id : "";
            })
            ->editColumn('staff', function ($equipment_rent) {
                return isset($equipment_rent->staff_id) ? $equipment_rent->staff_id : "";
            })
            ->editColumn('name', function ($equipment_rent) {

                return isset($equipment_rent->name) ? $equipment_rent->name : "";
            })
            ->editColumn('phone', function ($equipment_rent) {
                return isset($equipment_rent->hp_no) ? $equipment_rent->hp_no : "";
            })
            ->editColumn('renDate', function ($equipment_rent) {
                $date = isset($equipment_rent->rent_date) ? Carbon::createFromFormat('Y-m-d', $equipment_rent->rent_date)->format('d/m/Y') : "";
                return $date;
            })
            ->editColumn('retDate', function ($equipment_rent) {
                return isset($equipment_rent->return_date) ? $equipment_rent->return_date : "";
            })
            ->editColumn('sta', function ($equipment_rent) {
                return isset($equipment_rent->status) ? $equipment_rent->status : "";
            })

            ->addIndexColumn()
            ->make(true);
    }
    public function reportMonthYear(Request $request)
    {
        //date() function is used to extract the month value from the timestamp,
        //which is then assigned to the variable $month
        $month = date('m', strtotime($request->month));

        $list = EquipmentStaff::whereIn('status', ['Approved', 'Rejected'])
            ->whereYear('rent_date', '=', $request->year)
            ->whereMonth('rent_date', '=', $month)
            ->get();

        return datatables()::of($list)

            ->editColumn('sid', function ($equipment_rent) {
                return isset($equipment_rent->id) ? $equipment_rent->id : "";
            })
            ->editColumn('staff', function ($equipment_rent) {
                return isset($equipment_rent->staff_id) ? $equipment_rent->staff_id : "";
            })
            ->editColumn('name', function ($equipment_rent) {
                return isset($equipment_rent->name) ? $equipment_rent->name : "";
            })
            ->editColumn('phone', function ($equipment_rent) {
                return isset($equipment_rent->hp_no) ? $equipment_rent->hp_no : "";
            })
            ->editColumn('renDate', function ($equipment_rent) {
                $date = isset($equipment_rent->rent_date) ? Carbon::createFromFormat('Y-m-d', $equipment_rent->rent_date)->format('d/m/Y') : "";
                return $date;
            })
            ->editColumn('retDate', function ($equipment_rent) {
                return isset($equipment_rent->return_date) ? $equipment_rent->return_date : "";
            })
            ->editColumn('sta', function ($equipment_rent) {
                return isset($equipment_rent->status) ? $equipment_rent->status : "";
            })
            ->make(true);
    }

}