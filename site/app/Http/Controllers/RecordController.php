<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Record;
use App\Models\RecordItem;

class RecordController extends Controller
{
    public function index()
    {
        $record = Record::where('i_record_id', 0)->get();
        return view('record.index', compact('record'));
    }

    public function createForm()
    {
        return view('record.createForm');
    }

    public function create(Request $req)
    {
        Record::insert([
            'c_order_number' => $req->c_order_number,
            'c_part_number' => $req->c_part_number,
            'c_part_name' => $req->c_part_name,
            'c_customer' => $req->c_customer,
            'i_qty' => $req->i_qty,
            'i_sampling_qty' => $req->i_sampling_qty,
            'd_record_date' => $req->d_record_date,
            'c_ncr_number' => $req->c_ncr_number,
            'c_8d_report_no' => $req->c_8d_report_no,

        ]);
        return redirect()->route('record');
    }

}
