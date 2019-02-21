<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;
use App\Models\Form;
use App\Models\Checklist;
use App\Models\Series;
use App\Models\Errorcode;

class ChecklistController extends Controller
{
    public function index()
    {
      $forms = Form::where('i_form_deleted', 0)->get();
      return view('checklist.index', compact('forms'));
    }

    public function createForm()
    {
      $seriesList = Series::where('i_series_deleted', 0)->get();
      $errorcode = Errorcode::where('i_errorcode_deleted', 0)->get();
      return view('checklist.createForm', compact('seriesList', 'errorcode'));
    }

    public function editForm($id)
    {
      $seriesList = Series::where('i_series_deleted', 0)->get();
      $errorcode = Errorcode::where('i_errorcode_deleted', 0)->get();
      $form = Form::where('i_form_id', $id)->first();
      $checklist = Checklist::where('i_form_id', $id)->where('i_checklist_deleted', 0)->get();
      return view('checklist.editForm', compact('seriesList', 'errorcode', 'form', 'checklist'));
    }

    public function create(Request $req)
    {
      try {
        // Insert New Form
        $formId = Form::insertGetId([
          'i_series_id' => $req->i_series_id,
          'i_form_deleted' => 0,
          'i_status' => 0,
          'd_form_created' => DB::raw('CURRENT_TIMESTAMP')
        ],'i_form_id');
        // Insert New Checklist
        foreach ($req->errorcodeList as $errorcode) {
          Checklist::insert([
            'i_form_id' => $formId,
            'i_errorcode_id' => $errorcode['id'],
            'f_min_value' => $errorcode['min'],
            'f_max_value' => $errorcode['max'],
            'i_checklist_deleted' => 0
          ]);
        }
      } catch (Exception $e) {
        throw $e;
      }
      return 'success';
    }
    
    public function edit(Request $req)
    {
      try {
        // Update New Form
        Form::where('i_form_id', $req->i_form_id)->update([
          'i_series_id' => $req->i_series_id
        ]);
        // Delete Old Checklist (Hard Delete)
        $checklistDeleted = Checklist::where('i_form_id', $req->i_form_id)->where('i_checklist_deleted', 1)->get();
        if (count($checklistDeleted) > 1) {
          $checklistDeletedIdList = [];
          foreach ($checklistDeleted as $errorcode) {
            array_push($checklistDeletedIdList, $errorcode->i_checklist_id);
          }
          Checklist::whereIn('i_checklist_id', $checklistDeletedIdList)->delete();
        }
        // Delete Old Checklist (Soft Delete)
        $checklist = Checklist::where('i_form_id', $req->i_form_id)->where('i_checklist_deleted', 0)->get();
        $checklistIdList = [];
        foreach ($checklist as $errorcode) {
          array_push($checklistIdList, $errorcode->i_checklist_id);
        }
        Checklist::whereIn('i_checklist_id', $checklistIdList)->update([
          'i_checklist_deleted' => 1
        ]);

        // Insert New Checklist
        foreach ($req->errorcodeList as $errorcode) {
          Checklist::insert([
            'i_form_id' => $req->i_form_id,
            'i_errorcode_id' => $errorcode['id'],
            'f_min_value' => $errorcode['min'],
            'f_max_value' => $errorcode['max'],
            'i_checklist_deleted' => 0,
          ]);
        }
      } catch (Exception $e) {
        throw $e;
      }
      return 'success';
    }

    public function delete($id)
    {
      try {
        Form::where('i_form_id', $id)->update([
          'i_form_deleted' => 1
        ]);
      } catch (Exception $e) {
        throw $e;
      }
      return redirect()->back();
    }

    public function checkerrorcode()
    {
      if(isset($_GET['code'])) {
        return Errorcode::where('c_code', $_GET['code'])->first();
      }
      return null;
    }

    public function status(Request $req)
    {
      try {
        $form = Form::where('i_form_id', $req->i_form_id)->first();
        $i_series_id = $form->i_series_id;
        Form::where('i_series_id', $i_series_id)->update([
          'i_status' => 0
        ]);
        if ($req->i_status && $form->d_effective_date) {
          Form::where('i_form_id', $req->i_form_id)->update([
            'i_status' => 1,
          ]);
        } else if ($req->i_status && !$form->d_effective_date) {
          Form::where('i_form_id', $req->i_form_id)->update([
            'i_status' => 1,
            'd_effective_date' => DB::raw('CURRENT_TIMESTAMP')
          ]);
        }
      } catch (Exception $e) {
        throw $e;
      }
    }
}
