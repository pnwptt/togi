<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;
use App\Form;
use App\Checklist;
use App\Series;

class ChecklistController extends Controller
{
    public function index() {
      $checklists = Form::where('i_forms_deleted', 0)->get();
      return view('checklist.index', compact('checklists'));
    }

    public function createForm() {
      $seriesList = Series::where('i_series_deleted', 0)->get();
      return view('checklist.createForm', compact('seriesList'));
    }

    public function create(Request $req) {
      $id = Form::insertGetId([
        'i_series_id' => $req->i_series_id,
        'c_forms_deleted' => 0,
        'd_forms_created' => DB::raw('CURRENT_TIMESTAMP')
      ]);
      return redirect()->route('checklistList', $id);
    }
}
