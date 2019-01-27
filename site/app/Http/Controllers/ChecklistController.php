<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;
use App\Form;
use App\Checklist;
use App\Series;
use App\Errorcode;

class ChecklistController extends Controller
{
    public function index() {
      $forms = Form::where('i_forms_deleted', 0)->get();
      return view('checklist.index', compact('forms'));
    }

    public function createForm() {
      $seriesList = Series::where('i_series_deleted', 0)->get();
      $measurementErrorcode = Errorcode::where('i_errorcode_type_id', 1)->where('i_errorcode_deleted', 0)->get();
      $testSpecificationErrorcode = Errorcode::where('i_errorcode_type_id', 2)->where('i_errorcode_deleted', 0)->get();
      return view('checklist.createForm', compact('seriesList', 'measurementErrorcode', 'testSpecificationErrorcode'));
    }

    public function create(Request $req) {
      $id = Form::insertGetId([
        'i_series_id' => $req->i_series_id,
        'c_forms_deleted' => 0,
        'd_forms_created' => DB::raw('CURRENT_TIMESTAMP')
      ]);
      return redirect()->route('checklist');
    }

    public function checkerrorcode() {
      if(isset($_GET['code'])) {
        return Errorcode::where('c_code', $_GET['code'])->where('i_errorcode_type_id', $_GET['type'])->first();
      }
      return null;
    }
}
