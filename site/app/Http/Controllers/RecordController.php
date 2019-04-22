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
use App\Models\Checklist;

class RecordController extends Controller
{
    public function index() 
    {
        $c_user = session()->get('c_user');
        $records = DB::select(DB::raw("
            SELECT * 
            FROM (
                SELECT c_order_number, MAX(d_record_date) AS insp_date, MAX(c_part_number) AS c_part_number, MAX(c_customer) AS c_customer, MAX(i_qty) as i_qty, SUM(i_total_rjmc) AS total_rjmc, c_approve_date
                FROM b_record
                GROUP BY c_order_number, c_approve_date
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
            INNER JOIN (
                SELECT c_order_number, SUM(CASE WHEN c_checkby = '$c_user' THEN 1 ELSE 0 END) AS can_edit
                FROM b_record INNER JOIN b_record_pallet ON b_record_pallet.i_record_id = b_record.i_record_id
                GROUP BY c_order_number
            ) d ON d.c_order_number = a.c_order_number
            ORDER BY insp_date DESC
        "));

        return view('record.index', compact('records'));
    }

    public function createForm()
    {
        return view('record.createForm');
    }

    public function editForm(Request $req)
    {
        $record = DB::table('b_record')->join('b_models', 'b_models.i_models_id', '=', 'b_record.i_models_id')
            ->where('c_order_number', $req->wo)
            ->where('c_checkby', session()->get('c_user'))
            ->first();
        if ($record) {
            $mesurementChecklist = Checklist::getChecklistByModelsId($record->i_models_id, 1);
            $testSpecificationChecklist = Checklist::getChecklistByModelsId($record->i_models_id, 2);
            $failureSymptomChecklist = RecordFailure::getChecklistByRecordId($record->i_record_id);

            $machineList = RecordItem::getMachinesByRecordId($record->i_record_id);

            $recordMesurementItems = RecordItem::getRecordItemByRecordId($record->i_record_id, 1);
            $recordMesurementDetails = RecordRejectDetail::getDetailByRecordId($record->i_record_id, 1);

            $recordTestSpecificationItems = RecordItem::getRecordItemByRecordId($record->i_record_id, 2);
            $recordTestSpecificationDetails = RecordRejectDetail::getDetailByRecordId($record->i_record_id, 2);

            $recordFailure = RecordFailure::getRecordItemByRecordId($record->i_record_id);
            $recordFailureDetails = RecordFailureDetail::getDetailByRecordId($record->i_record_id);
            $recordPallet = RecordPallet::getPalletByRecordId($record->i_record_id);
            // echo json_encode($recordFailure);
            return view('record.editForm', compact(
                'record', 'mesurementChecklist', 'testSpecificationChecklist', 'failureSymptomChecklist', 
                'machineList', 'recordMesurementItems', 'recordTestSpecificationItems', 
                'recordMesurementDetails', 'recordTestSpecificationDetails', 
                'recordFailure', 'recordFailureDetails', 'recordPallet'
            ));
        } else {
            return redirect()->route('record')->with('error', 'Permission denied!');
        }
    }

    public function create(Request $req)
    {
        DB::beginTransaction();
        try {
            $today = date('Y-m-d');

            $i_record_id = Record::insertGetId([
                'c_order_number' => $req->c_order_number,
                'c_part_number' => $req->c_part_number,
                'c_series' => $req->c_series,
                'c_customer' => $req->c_customer,
                'i_qty' => $req->i_qty,
                'i_sampling_qty' => $req->i_sampling_qty,
                'c_checkby' => session()->get('c_user'),
                'd_record_date' => $today,
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
                    'd_record_item_date' => $today,
                    'i_checklist_id' => $msm['i_checklist_id'],
                    'i_record_id' => $i_record_id,
                    'c_machine_no' => $msm['machineNo'],
                    'i_record_item_fail' => $msm['fail'] ? 1 : 0
                ];
            }
            foreach ($req->testSpecification as $tspec) {
                $recordItems[] = [
                    'i_record_item_value' => $tspec['value'],
                    'd_record_item_date' => $today,
                    'i_checklist_id' => $tspec['i_checklist_id'],
                    'i_record_id' => $i_record_id,
                    'c_machine_no' => $tspec['machineNo'],
                    'i_record_item_fail' => $tspec['fail'] ? 1 : 0
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
                if ($failrjdt['i_errorcode_id']) {
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
    }

    public function edit(Request $req) 
    {
        DB::beginTransaction();
        try {
            $today = date('Y-m-d');

            Record::where('i_record_id', $req->i_record_id)->update([
                'c_order_number' => $req->c_order_number,
                'c_part_number' => $req->c_part_number,
                'c_series' => $req->c_series,
                'c_customer' => $req->c_customer,
                'i_qty' => $req->i_qty,
                'i_sampling_qty' => $req->i_sampling_qty,
                'c_checkby' => session()->get('c_user'),
                'd_record_date' => $today,
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
                    'd_record_item_date' => $today,
                    'i_checklist_id' => $msm['i_checklist_id'],
                    'i_record_id' => $req->i_record_id,
                    'c_machine_no' => $msm['machineNo'],
                    'i_record_item_fail' => $msm['fail'] ? 1 : 0
                ];
            }
            foreach ($req->testSpecification as $tspec) {
                $recordItems[] = [
                    'i_record_item_value' => $tspec['value'],
                    'd_record_item_date' => $today,
                    'i_checklist_id' => $tspec['i_checklist_id'],
                    'i_record_id' => $req->i_record_id,
                    'c_machine_no' => $tspec['machineNo'],
                    'i_record_item_fail' => $tspec['fail'] ? 1 : 0
                ];
            }
            RecordItem::where('i_record_id', $req->i_record_id)->delete();
            RecordItem::insert($recordItems);

            $rejectDetailItem = [];
            foreach ($req->mesurementRejectDetail as $msmrjdt) {
                $rejectDetailItem[] = [
                    'i_record_id' => $req->i_record_id,
                    'i_checklist_id' => $msmrjdt['i_checklist_id'],
                    'c_detail' => $msmrjdt['value']
                ];
            }
            foreach ($req->testSpecificationRejectDetail as $tspecrjdt) {
                $rejectDetailItem[] = [
                    'i_record_id' => $req->i_record_id,
                    'i_checklist_id' => $tspecrjdt['i_checklist_id'],
                    'c_detail' => $tspecrjdt['value']
                ];
            }
            RecordRejectDetail::where('i_record_id', $req->i_record_id)->delete();
            RecordRejectDetail::insert($rejectDetailItem);


            $failureItem = [];
            foreach ($req->failureSymptom as $fail) {
                if ($fail['i_errorcode_id']) {
                    $failureItem[] = [
                        'i_record_id' => $req->i_record_id,
                        'i_errorcode_id' => $fail['i_errorcode_id'],
                        'c_machine_no' => $fail['machineNo'],
                        'i_record_failure' => $fail['value']
                    ];
                }
            }
            RecordFailure::where('i_record_id', $req->i_record_id)->delete();
            RecordFailure::insert($failureItem);

            $failureDetailItem = [];
            foreach ($req->failureSymptomRejectDetail as $failrjdt) {
                if ($failrjdt['i_errorcode_id']) {
                    $failureDetailItem[] = [
                        'i_record_id' => $req->i_record_id,
                        'i_errorcode_id' => $failrjdt['i_errorcode_id'],
                        'c_detail' => $failrjdt['value']
                    ];
                }
            }
            RecordFailureDetail::where('i_record_id', $req->i_record_id)->delete();
            RecordFailureDetail::insert($failureDetailItem);

            $palletItem = [];
            foreach ($req->palletList as $pallet) {
                $palletItem[] = [
                    'i_record_id' => $req->i_record_id,
                    'i_record_pallet_status' => $pallet['status']
                ];
            }
            RecordPallet::where('i_record_id', $req->i_record_id)->delete();
            RecordPallet::insert($palletItem);

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function viewRecord(Request $req) 
    {
        // echo json_encode($record);

        $recordIds = DB::table('b_record')->join('b_models', 'b_models.i_models_id', '=', 'b_record.i_models_id')
            ->select('i_record_id', 'c_checkby', 'c_remark')
            ->where('c_order_number', $req->wo)
            ->get();
        $c_remark = [];
        if (count($recordIds) > 0) {
            foreach ($recordIds as $value) {
                $ids[] = $value->i_record_id;
                $c_checkby[] = $value->c_checkby;
                if($value->c_remark) {
                    $c_remark[] = $value->c_remark;
                }
            }
            $record = DB::table('b_record')
                ->join('b_models', 'b_models.i_models_id', '=', 'b_record.i_models_id')
                ->select(DB::raw("
                    c_order_number, c_series, c_approveby, c_approve_date,
                    MAX(c_part_number) AS c_part_number, 
                    MAX(c_customer) AS c_customer, 
                    MAX(c_8d_report_no) AS c_8d_report_no,
                    MAX(c_ncr_number) AS c_ncr_number, 
                    MAX(i_qty) AS i_qty, 
                    MAX(d_record_date) AS d_record_date,
                    MIN(i_judgement) AS i_judgement,
                    SUM(i_total_rjmc) AS i_total_rjmc,
                    MAX(i_pallet_qty) AS i_pallet_qty,
                    b_models.i_models_id,
                    b_models.n_models_name
                "))
                ->where('c_order_number', $req->wo)
                ->groupBy('c_order_number', 'c_series', 'c_approveby', 'c_approve_date', 'b_models.i_models_id', 'b_models.n_models_name')
                ->first();
            $i_sampling_qty = DB::table('b_record')
                ->join('b_record_item', 'b_record_item.i_record_id', '=', 'b_record.i_record_id')
                ->select(DB::raw("COUNT(DISTINCT c_machine_no) AS i_sampling_qty"))
                ->whereIn('b_record.i_record_id', $ids)
                ->first()->i_sampling_qty;
            $mesurementChecklist = Checklist::getChecklistByModelsId($record->i_models_id, 1);
            $testSpecificationChecklist = Checklist::getChecklistByModelsId($record->i_models_id, 2);
            $failureSymptomChecklist = RecordFailure::getChecklistByRecordIdIn($ids);
            // echo json_encode($mesurementChecklist);

            $machineList = RecordItem::getMachinesByRecordIdIn($ids);

            $recordMesurementItems = RecordItem::getRecordItemByRecordIdIn($ids, 1);
            $recordMesurementDetails = RecordRejectDetail::getDetailByRecordIdIn($ids, 1);

            $recordTestSpecificationItems = RecordItem::getRecordItemByRecordIdIn($ids, 2);
            $recordTestSpecificationDetails = RecordRejectDetail::getDetailByRecordIdIn($ids, 2);

            $recordFailure = RecordFailure::getRecordItemByRecordIdIn($ids);
            $recordFailureDetails = RecordFailureDetail::getDetailByRecordIdIn($ids);
            $recordPallet = RecordPallet::getPalletByRecordIdIn($ids);

            return view('record.viewRecord', compact(
                'record', 'c_checkby', 'c_remark', 'i_sampling_qty',
                'mesurementChecklist', 'testSpecificationChecklist', 'failureSymptomChecklist', 
                'machineList', 'recordMesurementItems', 'recordTestSpecificationItems', 
                'recordMesurementDetails', 'recordTestSpecificationDetails', 
                'recordFailure', 'recordFailureDetails', 'recordPallet'
            ));
        }
    }

    public function approve(Request $req)
    {
        if (session()->get('admin')) {
            DB::beginTransaction();
            try {
                Record::where('c_order_number', $req->wo)
                ->whereNull('c_approveby')
                ->whereNull('c_approve_date')
                ->update([
                    'c_approveby' => session()->get('c_user'),
                    'c_approve_date' => date('Y-m-d')
                ]);

                DB::commit();
                return redirect()->route('record');
            } catch (Exception $e) {
                DB::rollback();
                return redirect()->route('record')->with('error', 'Ops! something went wrong.')->with('message', 'Please try again.');
            }
        } else {
            return redirect()->route('record')->with('error', 'Permission denied!');
        }
    }
}
