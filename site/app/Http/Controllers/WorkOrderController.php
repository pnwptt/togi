<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WorkOrder;
use App\Models\PartName;
use App\Models\Form;
use App\Models\Checklist;

class WorkOrder extends Controller
{
    public function findWorkOrder(Request $req) {
      $wo = WorkOrder::where('c_workorder', $req->c_workorder)->first();
      if ($wo) {
        $partName = PartName::where('n_part_name', $wo->c_series)->first();
        if ($partName) {
          $form = Form::where('i_series_id', $partName->i_series_id)->where('i_status', 1)->first();
          if ($form) {
            $mesurementChecklist = Checklist::getChecklistByErrorcodeType($form->i_form_id, 1);
            $testSpecificationChecklist = Checklist::getChecklistByErrorcodeType($form->i_form_id, 2);
            $series = $partName->getSeries->n_series_name;
            return compact('workOrder', 'series', 'mesurement', 'testSpecification');
          }
        }
      }
    }


}
