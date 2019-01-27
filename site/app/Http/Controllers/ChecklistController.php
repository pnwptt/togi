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
      $errorcode = Errorcode::where('i_errorcode_deleted', 0)->get();
      return view('checklist.createForm', compact('seriesList', 'errorcode'));
    }

    public function editForm($id) {
      $seriesList = Series::where('i_series_deleted', 0)->get();
      $errorcode = Errorcode::where('i_errorcode_deleted', 0)->get();
      $form = Form::where('i_forms_id', $id)->first();
      $checklist = Checklist::where('i_forms_id', $id)->get();
      return view('checklist.editForm', compact('seriesList', 'errorcode', 'form', 'checklist'));
    }

    public function create(Request $req) {
      try {
        $formId = Form::insertGetId([
          'i_series_id' => $req->i_series_id,
          'i_forms_deleted' => 0,
          'd_forms_created' => DB::raw('CURRENT_TIMESTAMP')
        ]);
        foreach ($req->errorcodeList as $errorcode) {
          Checklist::insert([
            'i_forms_id' => $formId,
            'i_errorcode_id' => $errorcode['id'],
            'f_minvalue' => $errorcode['min'],
            'f_maxvalue' => $errorcode['max'],
            'i_errorcode_deleted' => 0
          ]);
        }
      } catch (Exception $e) {
        throw $e;
      }
      return 'success';
    }

    public function edit(Request $req) {
      try {
        Form::where('i_forms_id', $req->i_forms_id)->update([
          'i_series_id' => $req->i_series_id
        ]);
        foreach ($req->errorcodeList as $errorcode) {
          Checklist::insert([
            'i_forms_id' => $formId,
            'i_errorcode_id' => $errorcode['id'],
            'f_minvalue' => $errorcode['min'],
            'f_maxvalue' => $errorcode['max'],
            'i_errorcode_deleted' => 0
          ]);
        }
      } catch (Exception $e) {
        throw $e;
      }
      return 'success';
    }

    public function checkerrorcode() {
      if(isset($_GET['code'])) {
        return Errorcode::where('c_code', $_GET['code'])->first();
      }
      return null;
    }
}
