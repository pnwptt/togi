<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Errorcode;
// use App\ErrorcodeType;

class ErrorcodeController extends Controller
{
    public function index(){
        $errorcodelist = Errorcode::where('c_errorcode_deleted', 0)->get();

        // $typeall = ErrorcodeType::find()->orderBy('n_errorcode_type asc')->all();
        // $type = ArrayHelper::map($typeall, 'i_errorcode_type_id', 'n_errorcode_type');
        return view('errorcode.index', compact('errorcodeList'));
    }

    public function createForm() {
        return view('errorcode.createForm');
    }

    public function create(Request $req) {
        Errorcode::insert([ 
            'c_rank' => $req->c_rank,
            'c_code' => $req->c_code,
            'n_errorcode' => $req->n_errorcode,
            'i_errorcode_type_id' => $req->i_errorcode_type_id,
            'c_errorcode_deleted' => 0,
        ]);
        return redirect()->route('errorcode');
    }

    public function delete($id){
        Errorcode::where('i_errorcode_id', $id)->update(['c_errorcode_deleted'=> 1]);
        return redirect()->route('errorcode');
    }
}