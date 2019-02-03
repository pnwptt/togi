<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ErrorcodeType;

class ErrorcodeTypeController extends Controller
{
    public function index(){
        $errorcodetypeList = ErrorcodeType::where('i_errorcode_type_deleted', 0)->get();
        return view('errorcodetype.index', compact('errorcodetypeList'));
    }

    public function createForm() {
        return view('errorcodetype.createForm');
    }

    public function editForm($id) {
        $errorcodetype = ErrorcodeType::where('i_errorcode_type_id', $id)->first();
        return view('errorcodetype.editForm', compact('errorcodetype'));
    }

    public function create(Request $req) {
        ErrorcodeType::insert([
            'n_errorcode_type' => $req->n_errorcode_type,
            'i_errorcode_type_deleted' => 0,
        ]);
        return redirect()->route('errorcodetype');
    }

    public function edit(Request $req){
        ErrorcodeType::where('i_errorcode_type_id', $req->i_errorcode_type_id)->update([
            'n_errorcode_type' => $req->i_errorcode_type,
        ]);
        return redirect()->route('errorcodetype');
    }

    public function delete($id) {
        ErrorcodeType::where('i_errorcode_type_id', $id)->update(['i_errorcode_type_deleted' => 1]);
        return redirect()->route('errorcodetype');
    }
}
