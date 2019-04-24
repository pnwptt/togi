<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Models;
use DB;


class DashboardController extends Controller
{
  private $mySql = false;
  private $month = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

  public function index ()
  {
    $year = date('Y');
    $models = Models::get();

    // Start Prepare data
    for ($i = 0; $i < 12; $i++) {
      $palletBarTotal[$i] = 0;
      $palletBarReject[$i] = 0;
      $machineBarTotal[$i] = 0;
      $machineBarFail[$i] = 0;
    }
    if ($this->mySql) {
      $month = "month(d_record_date)";
    } else {
      $month = "date_part('month', d_record_date)";
    }
    // End Prepare data


    // Start palletBar
    $palletBarSql = "
      SELECT 
        ${month} AS month_number, 
        COUNT(i_record_pallet_id) AS total_pallet, 
        SUM(i_record_pallet_status) AS total_reject 
      FROM b_models 
        INNER JOIN b_record ON b_record.i_models_id = b_models.i_models_id 
        INNER JOIN b_record_pallet ON b_record_pallet.i_record_id = b_record.i_record_id
      WHERE b_record.d_record_date BETWEEN '${year}-01-01' AND '${year}-12-31'
      GROUP BY ${month}
    ";
    $palletBarData = DB::select(DB::raw($palletBarSql));

    foreach ($palletBarData as $value) {
      $palletBarTotal[$value->month_number - 1] = $value->total_pallet;
      $palletBarReject[$value->month_number - 1] = $value->total_reject;
    }
    // End palletBar


    // Start machineBar
    $machineBarSql = "
      SELECT 
        ${month} AS month_number, 
        COUNT(c_machine_no) AS total_machine,
        SUM(fail) AS total_fail
      FROM ( 
        SELECT 
          c_machine_no, 
          MAX(d_record_date) as d_record_date, 
          MAX(i_record_item_fail) AS fail 
        FROM b_models 
          INNER JOIN b_record ON b_record.i_models_id = b_models.i_models_id 
          INNER JOIN b_record_item ON b_record_item.i_record_id = b_record.i_record_id
        GROUP BY c_machine_no
      ) AS machines
      WHERE machines.d_record_date BETWEEN '${year}-01-01' AND '${year}-12-31'
      GROUP BY ${month}
    ";
    $machineBarData = DB::select(DB::raw($machineBarSql));

    foreach ($machineBarData as $value) {
      $machineBarTotal[$value->month_number - 1] = $value->total_machine;
      $machineBarFail[$value->month_number - 1] = $value->total_fail;
    }
    // End machineBar

    // Start palletLine
    // for ($i = 0; $i < number_format(date('m')); $i++) {
    // }
    // $palletLineSql = "
    //   SELECT 
    //     ${month} AS month_number, 
    //     COUNT(c_machine_no) AS total_machine,
    //     SUM(fail) AS total_fail
    //   FROM ( 
    //     SELECT 
    //       c_machine_no, 
    //       MAX(d_record_date) as d_record_date, 
    //       MAX(i_record_item_fail) AS fail 
    //     FROM b_models 
    //       INNER JOIN b_record ON b_record.i_models_id = b_models.i_models_id 
    //       INNER JOIN b_record_item ON b_record_item.i_record_id = b_record.i_record_id
    //     GROUP BY c_machine_no
    //   ) AS machines
    //   WHERE machines.d_record_date BETWEEN '${year}-01-01' AND '${year}-${}-31'
    //   GROUP BY ${month}
    // ";
    // $palletLineData = DB::select(DB::raw($palletLineSql));
    // End palletLine

    // Start topErrorcode
    $topErrorcodeSql = "
      SELECT ec.i_errorcode_id, ec.c_code, ec.n_errorcode, SUM(i_record_item_fail) AS qty
      FROM b_errorcode ec
        INNER JOIN b_checklists cl ON cl.i_errorcode_id = ec.i_errorcode_id
        INNER JOIN b_record_item rcit ON rcit.i_checklist_id = cl.i_checklist_id
        INNER JOIN b_record rc ON rc.i_record_id = rcit.i_record_id
      WHERE rc.d_record_date BETWEEN '${year}-01-01' AND '${year}-12-31' AND rcit.i_record_item_fail != 0
      GROUP BY ec.i_errorcode_id, ec.c_code, ec.n_errorcode
      ORDER BY qty DESC, ec.i_errorcode_id ASC
    ";
    $topErrorcodeData = DB::select(DB::raw($topErrorcodeSql));

    $i = 0; 
    $top5ErrorcodeBarLabels = [];
    $top5ErrorcodeBarData = [];
    foreach ($topErrorcodeData as $key => $value) {
      if ($i == 5) {
        break;
      }
      $top5ErrorcodeBarLabels[] = $value->c_code;
      $top5ErrorcodeBarData[] = $value->qty;
      $i++;
    }
    // End topErrorcode


    // echo json_encode($top5ErrorcodeBarLabels);
    return view('dashboard', compact('models', 'palletBarTotal', 'palletBarReject', 'machineBarTotal', 'machineBarFail', 'topErrorcodeData', 'top5ErrorcodeBarLabels', 'top5ErrorcodeBarData'));
  }

  public function getChartData (Request $req)
  {
    $year = date('Y');

    $grouping = $req->grouping;
    $i_models_id = $req->i_models_id;
    $dateFrom = $req->dateFrom;
    $dateTo = $req->dateTo;


    // Start Prepare data
    if ($dateFrom == null) {
      $dateFrom = "${year}-01-01";
    }
    if ($dateTo == null) {
      $dateTo = "${year}-12-31";
    }

    if ($this->mySql) {
      $group = "${grouping}(d_record_date)";
    } else {
      $group = "date_part('${grouping}', d_record_date)";
    }

    $whereModel = '';
    if ($i_models_id != 'all') {
      $whereModel = "AND tab.i_models_id = ${i_models_id}";
    }
    // End Prepare data

    // Start palletBar
    $palletBarSql = "
      SELECT 
        ${group} AS grouping, 
        COUNT(i_record_pallet_id) AS total_pallet, 
        SUM(i_record_pallet_status) AS total_reject 
      FROM b_models tab
        INNER JOIN b_record ON b_record.i_models_id = tab.i_models_id 
        INNER JOIN b_record_pallet ON b_record_pallet.i_record_id = b_record.i_record_id
      WHERE b_record.d_record_date BETWEEN '${dateFrom}' AND '${dateTo}' ${whereModel}
      GROUP BY ${group}
    ";
    $palletBarData = DB::select(DB::raw($palletBarSql));

    $palletBarLabels = [];
    $palletBar1 = [];
    $palletBar2 = [];
    foreach ($palletBarData as $value) {
      if ($grouping == 'month') {
        $palletBarLabels[] = $this->month[$value->grouping - 1];
      } elseif ($grouping == 'week') {
        $palletBarLabels[] = $value->grouping;
      }
      $palletBar1[] = $value->total_pallet;
      $palletBar2[] = $value->total_reject;
    }
    $palletBar = compact('palletBarLabels', 'palletBar1', 'palletBar2');
    // End palletBar

    // Start machineBar
    $machineBarSql = "
      SELECT 
        ${group} AS grouping,
        COUNT(c_machine_no) AS total_machine,
        SUM(fail) AS total_fail
      FROM ( 
        SELECT 
          c_machine_no, 
          MAX(d_record_date) as d_record_date, 
          MAX(i_record_item_fail) AS fail 
        FROM b_models 
          INNER JOIN b_record ON b_record.i_models_id = b_models.i_models_id 
          INNER JOIN b_record_item ON b_record_item.i_record_id = b_record.i_record_id
        GROUP BY c_machine_no
      ) AS tab
      WHERE tab.d_record_date BETWEEN '${dateFrom}' AND '${dateTo}' $whereModel
      GROUP BY ${group}
    ";
    $machineBarData = DB::select(DB::raw($machineBarSql));

    $machineBarLabels = [];
    $machineBar1 = [];
    $machineBar2 = [];
    foreach ($machineBarData as $value) {
      if ($grouping == 'month') {
        $machineBarLabels[] = $this->month[$value->grouping - 1];
      } elseif ($grouping == 'week') {
        $machineBarLabels[] = $value->grouping;
      }
      $machineBar1[] = $value->total_machine;
      $machineBar2[] = $value->total_fail;
    }
    $machineBar = compact('machineBarLabels', 'machineBar1', 'machineBar2');
    // End machineBar

    // Start topErrorcode
    $topErrorcodeSql = "
      SELECT ec.i_errorcode_id, ec.c_code, ec.n_errorcode, SUM(i_record_item_fail) AS qty
      FROM b_errorcode ec
        INNER JOIN b_checklists cl ON cl.i_errorcode_id = ec.i_errorcode_id
        INNER JOIN b_record_item rcit ON rcit.i_checklist_id = cl.i_checklist_id
        INNER JOIN b_record tab ON tab.i_record_id = rcit.i_record_id
      WHERE tab.d_record_date BETWEEN '${dateFrom}' AND '${dateTo}' $whereModel AND rcit.i_record_item_fail != 0
      GROUP BY ec.i_errorcode_id, ec.c_code, ec.n_errorcode
      ORDER BY qty DESC, ec.i_errorcode_id ASC
    ";
    $topErrorcodeData = DB::select(DB::raw($topErrorcodeSql));

    $i = 0; 
    $top5ErrorcodeBarLabels = [];
    $top5ErrorcodeBarData = [];
    foreach ($topErrorcodeData as $key => $value) {
      if ($i == 5) {
        break;
      }
      $top5ErrorcodeBarLabels[] = $value->c_code;
      $top5ErrorcodeBarData[] = $value->qty;
      $i++;
    }
    $topErrorcode = compact('topErrorcodeData', 'top5ErrorcodeBarLabels', 'top5ErrorcodeBarData');
    // End topErrorcode

    $chartData = compact('palletBar', 'machineBar', 'topErrorcode');
    echo json_encode($chartData);
  }
}
