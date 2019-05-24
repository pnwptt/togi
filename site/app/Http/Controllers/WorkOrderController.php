<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Exception;
use App\Models\WorkOrder;
use App\Models\Series;
use App\Models\Form;
use App\Models\Checklist;
use App\Models\Record;

class WorkOrderController extends Controller
{
  public function findChecklist(Request $req) {
    $c_user = session()->get('c_user');
    $record = Record::where('c_order_number', $req->c_workorder)->where('c_checkby', $c_user)->first();
    if ($record) {
      return compact('record'); 
    } else {
      $workOrder = WorkOrder::where('c_workorder_sell', $req->c_workorder)->whereNotNull('c_series')->first();
      if ($workOrder) {
        $series = Series::where('n_series', $workOrder->c_series)->first();
        if ($series) {
          $form = Form::where('i_models_id', $series->i_models_id)->where('i_status', 1)->first();
          if ($form) {
            $mesurementChecklist = Checklist::getChecklistByFromId($form->i_form_id, 1);
            $testSpecificationChecklist = Checklist::getChecklistByFromId($form->i_form_id, 2);
            $models = $series->getModels;
            return compact('form', 'workOrder', 'models', 'mesurementChecklist', 'testSpecificationChecklist');
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
}
