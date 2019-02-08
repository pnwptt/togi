<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Errorcode;
use App\Models\ErrorcodeType;

class ErrorcodeController extends Controller
{
    public function index()
    {
        $errorcodeList = Errorcode::where('i_errorcode_deleted', 0)->get();
        return view('errorcode.index', compact('errorcodeList'));
    }

    public function createForm()
    {
        $types = ErrorcodeType::where('i_errorcode_type_deleted', 0)->get();
        return view('errorcode.createForm', compact('types'));
    }

    public function editForm($id)
    {
        $types = ErrorcodeType::where('i_errorcode_type_deleted', 0)->get();
        $errorcode = Errorcode::where('i_errorcode_id', $id)->first();
        return view('errorcode.editForm', compact('types', 'errorcode'));
    }

    public function create(Request $req)
    {
        $errorcode = Errorcode::where('c_code', $req->c_code)->first();
        if ($errorcode) {
          return redirect()->route('errorcode')->with('error', 'Create Fail!')->with('message', "Errorcode: $req->c_code is already created.");
        } else {
            Errorcode::insert([ 
                'c_rank' => $req->c_rank,
                'c_code' => $req->c_code,
                'n_errorcode' => $req->n_errorcode,
                'i_errorcode_type_id' => $req->i_errorcode_type_id,
                'i_errorcode_deleted' => 0,
            ]);
        } 
        return redirect()->route('errorcode');
    }

    public function edit(Request $req)
    {
        $errorcode = Errorcode::where('i_errorcode_id', '!=', $req->i_errorcode_id)->where('c_code', $req->c_code)->first();
        if ($errorcode) {
          return redirect()->route('errorcode')->with('error', 'Edit Fail!')->with('message', "Errorcode: $req->c_code is already created.");
        } else {
          Errorcode::where('i_errorcode_id', $req->i_errorcode_id)->update([
              'c_rank' => $req->c_rank,
              'c_code' => $req->c_code,
              'n_errorcode' => $req->n_errorcode,
              'i_errorcode_type_id' => $req->i_errorcode_type_id,
          ]);
        }
        return redirect()->route('errorcode');
    }

    public function delete($id)
    {
        Errorcode::where('i_errorcode_id', $id)->update(['i_errorcode_deleted'=> 1]);
        return redirect()->route('errorcode');
    }
}