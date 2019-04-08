<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\Record;
use App\Models\RecordItem;
use App\Models\RecordRejectDetail;
use App\Models\RecordFailure;
use App\Models\RecordFailureDetail;
use App\Models\RecordPallet;

class RecordController extends Controller
{
    public function index() 
    {
        $records = DB::select(DB::raw('
            SELECT * 
            FROM (
                SELECT c_order_number, MAX(d_record_date) AS insp_date, c_part_number, c_customer, i_qty, SUM(i_total_rjmc) AS total_rjmc 
                FROM b_record
                GROUP BY c_order_number, c_part_number, c_customer, i_qty
            ) a 
            INNER JOIN (
                SELECT c_order_number, COUNT(DISTINCT c_machine_no) AS sampling_qty
                FROM b_record INNER JOIN b_record_item ON b_record_item.i_record_id = b_record.i_record_id
                GROUP BY c_order_number
            ) b ON b.c_order_number = a.c_order_number
            INNER JOIN (
                SELECT c_order_number, COUNT(i_record_pallet_id) AS pallet_qty, SUM(i_record_pallet_status) AS rework
                FROM b_record INNER JOIN b_record_pallet ON b_record_pallet.i_record_id = b_record.i_record_id
                GROUP BY c_order_number
            ) c ON c.c_order_number = a.c_order_number
            ORDER BY insp_date DESC
        '));

        return view('record.index', compact('records'));
    }

    public function createForm()
    {
        return view('record.createForm');
    }

    public function create(Request $req)
    {
        DB::beginTransaction();
        try {
            $i_record_id = Record::insertGetId([
                'c_order_number' => $req->c_order_number,
                'c_part_number' => $req->c_part_number,
                'c_series' => $req->c_series,
                'c_customer' => $req->c_customer,
                'i_qty' => $req->i_qty,
                'i_sampling_qty' => $req->i_sampling_qty,
                'c_checkby' => $req->c_user,
                'd_record_date' => $req->today,
                'i_judgement' => $req->judgement,
                'c_ncr_number' => $req->c_ncr_number,
                'c_8d_report_no' => $req->c_8d_report_no,
                'i_total_rjmc' => $req->totalRJMC,
                'c_remark' => $req->remark,
                'i_models_id' => $req->i_models_id
            ]);

            $recordItems = [];
            foreach ($req->mesurement as $msm) {
                $recordItems[] = [
                    'i_record_item_value' => $msm['value'],
                    'd_record_item_date' => $req->today,
                    'i_checklist_id' => $msm['i_checklist_id'],
                    'i_record_id' => $i_record_id,
                    'c_machine_no' => $msm['machineNo']
                ];
            }
            foreach ($req->testSpecification as $tspec) {
                $recordItems[] = [
                    'i_record_item_value' => $tspec['value'],
                    'd_record_item_date' => $req->today,
                    'i_checklist_id' => $tspec['i_checklist_id'],
                    'i_record_id' => $i_record_id,
                    'c_machine_no' => $tspec['machineNo']
                ];
            }
            RecordItem::insert($recordItems);

            $rejectDetailItem = [];
            foreach ($req->mesurementRejectDetail as $msmrjdt) {
                $rejectDetailItem[] = [
                    'i_record_id' => $i_record_id,
                    'i_checklist_id' => $msmrjdt['i_checklist_id'],
                    'c_detail' => $msmrjdt['value']
                ];
            }
            foreach ($req->testSpecificationRejectDetail as $tspecrjdt) {
                $rejectDetailItem[] = [
                    'i_record_id' => $i_record_id,
                    'i_checklist_id' => $tspecrjdt['i_checklist_id'],
                    'c_detail' => $tspecrjdt['value']
                ];
            }
            RecordRejectDetail::insert($rejectDetailItem);


            $failureItem = [];
            foreach ($req->failureSymptom as $fail) {
                if ($fail['i_errorcode_id']) {
                    $failureItem[] = [
                        'i_record_id' => $i_record_id,
                        'i_errorcode_id' => $fail['i_errorcode_id'],
                        'c_machine_no' => $fail['machineNo'],
                        'i_record_failure' => $fail['value']
                    ];
                }
            }
            RecordFailure::insert($failureItem);

            $failureDetailItem = [];
            foreach ($req->failureSymptomRejectDetail as $failrjdt) {
                if ($fail['i_errorcode_id']) {
                    $failureDetailItem[] = [
                        'i_record_id' => $i_record_id,
                        'i_errorcode_id' => $failrjdt['i_errorcode_id'],
                        'c_detail' => $failrjdt['value']
                    ];
                }
            }
            RecordFailureDetail::insert($failureDetailItem);

            $palletItem = [];
            foreach ($req->palletList as $pallet) {
                $palletItem[] = [
                    'i_record_id' => $i_record_id,
                    'i_record_pallet_status' => $pallet['status']
                ];
            }
            RecordPallet::insert($palletItem);

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
        
        return 'eiei';
    }

}
