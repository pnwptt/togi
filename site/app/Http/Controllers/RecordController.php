<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Record;
use App\Models\RecordItem;
use App\Models\RecordRejectDetail;
use App\Models\RecordFailure;
use App\Models\RecordFailureDetail;

class RecordController extends Controller
{
    public function index()
    {
        $record = Record::where('i_record_id', 0)->get();
        return view('record.index', compact('record'));
    }

    public function createForm()
    {
        return view('record.createForm');
    }

    public function create(Request $req)
    {
        // try {
            // $i_record_id = Record::insertGetId([
            //     'c_order_number' => $req->c_order_number,
            //     'c_part_number' => $req->c_part_number,
            //     'c_series' => $req->c_series,
            //     'c_customer' => $req->c_customer,
            //     'i_qty' => $req->i_qty,
            //     'i_sampling_qty' => $req->i_sampling_qty,
            //     'c_checkby' => $req->c_user,
            //     'd_record_date' => $req->today,
            //     'i_judgement' => $req->judgement,
            //     'c_ncr_number' => $req->c_ncr_number,
            //     'c_8d_report_no' => $req->c_8d_report_no,
            //     'i_total_rjmc' => $req->totalRJMC,
            //     'c_remark' => $req->remark,
            //     'i_models_id' => $req->i_models_id
            // ]);

            // $recordItems = [];
            // foreach ($req->mesurement as $msm) {
            //     $recordItems[] = [
            //         'i_record_item_value' => $msm['value'],
            //         'd_record_item_date' => $req->today,
            //         'i_checklist_id' => $msm['i_checklist_id'],
            //         'i_record_id' => $i_record_id,
            //         'c_machine_no' => $msm['machineNo']
            //     ];
            // }
            // foreach ($req->testSpecification as $tspec) {
            //     $recordItems[] = [
            //         'i_record_item_value' => $tspec['value'],
            //         'd_record_item_date' => $req->today,
            //         'i_checklist_id' => $tspec['i_checklist_id'],
            //         'i_record_id' => $i_record_id,
            //         'c_machine_no' => $tspec['machineNo']
            //     ];
            // }
            // RecordItem::insert($recordItems);

            // $rejectDetailItem = [];
            // foreach ($req->mesurementRejectDetail as $msmrjdt) {
            //     $rejectDetailItem[] = [
            //         'i_record_id' => $i_record_id,
            //         'i_checklist_id' => $msmrjdt['i_checklist_id'],
            //         'c_detail' => $msmrjdt['value']
            //     ];
            // }
            // foreach ($req->testSpecificationRejectDetail as $tspecrjdt) {
            //     $rejectDetailItem[] = [
            //         'i_record_id' => $i_record_id,
            //         'i_checklist_id' => $tspecrjdt['i_checklist_id'],
            //         'c_detail' => $tspecrjdt['value']
            //     ];
            // }
            // RecordRejectDetail::insert($rejectDetailItem);

            // $failureDetailItem = [];
            // foreach ($req->mesurement as $msm) {
            //     $recordItems[] = [
            //         'i_record_item_value' => $msm->value,
            //         'd_record_item_date' => $req->today,
            //         'i_checklist_id' => $msm->i_checklist_id,
            //         'i_record_id' => $i_record_id,
            //         'c_machine_no' => $msm->machineNo
            //     ];
            // }

        // } catch (Exception $e) {
        //     throw $e;
        // }
        
        return 'eiei';
    }

}
