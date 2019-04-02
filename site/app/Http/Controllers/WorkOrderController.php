<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Exception;
use App\Models\WorkOrder;
use App\Models\Series;
use App\Models\Form;
use App\Models\Checklist;

class WorkOrderController extends Controller
{
  public function findChecklist(Request $req) {
    $workOrder = WorkOrder::where('c_workorder', $req->c_workorder)->first();
    if ($workOrder) {
      $series = Series::where('n_series', $workOrder->c_series)->first();
      if ($series) {
        $form = Form::where('i_models_id', $series->i_models_id)->where('i_status', 1)->first();
        if ($form) {
          $mesurementChecklist = Checklist::getChecklistByErrorcodeType($form->i_form_id, 1);
          $testSpecificationChecklist = Checklist::getChecklistByErrorcodeType($form->i_form_id, 2);
          $models = $series->getModels;
          return compact('workOrder', 'models', 'mesurementChecklist', 'testSpecificationChecklist');
        } else {
          abort(400, 'Form not found.');          
        }
      } else {
        abort(400, 'Series not found.');
      }
    } else {
      abort(400, 'Work Order not found.');
    }
  }
}
