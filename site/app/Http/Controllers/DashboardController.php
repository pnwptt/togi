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
    $models = Models::get();

    $years = DB::select(DB::raw("SELECT DISTINCT date_part('year', d_record_date) AS year FROM b_record ORDER BY year DESC"));

    // Start Prepare data
      $curDate = date('Y-m-d');
      $curYear = date('Y');

      for ($i = 0; $i < 12; $i++) {
        $palletBarTotal[$i] = 0;
        $palletBarReject[$i] = 0;
        $machineBarTotal[$i] = 0;
        $machineBarFail[$i] = 0;
      }

      $month_number = $this->mySql ? "month(d_record_date)" : "date_part('month', d_record_date)";
    // End Prepare data


    // Start palletBar
      $palletBarSql = "
        SELECT 
          ${month_number} AS month_number, 
          COUNT(i_record_pallet_id) AS total_pallet, 
          SUM(i_record_pallet_status) AS total_reject 
        FROM b_models 
          INNER JOIN b_record ON b_record.i_models_id = b_models.i_models_id 
          INNER JOIN b_record_pallet ON b_record_pallet.i_record_id = b_record.i_record_id
        WHERE b_record.d_record_date BETWEEN '${curYear}-01-01' AND '${curYear}-12-31'
        GROUP BY ${month_number}
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
          ${month_number} AS month_number, 
          COUNT(c_machine_no) AS total_machine,
          MAX(fail) AS total_fail
        FROM ( 
          SELECT 
            c_machine_no, 
            MAX(d_record_date) as d_record_date, 
            MAX(i_total_rjmc) AS fail
          FROM b_models 
            INNER JOIN b_record ON b_record.i_models_id = b_models.i_models_id 
            INNER JOIN b_record_item ON b_record_item.i_record_id = b_record.i_record_id
          GROUP BY c_machine_no
        ) AS machines
        WHERE machines.d_record_date BETWEEN '${curYear}-01-01' AND '${curYear}-12-31'
        GROUP BY ${month_number}
      ";
      $machineBarData = DB::select(DB::raw($machineBarSql));

      foreach ($machineBarData as $value) {
        $machineBarTotal[$value->month_number - 1] = $value->total_machine;
        $machineBarFail[$value->month_number - 1] = $value->total_fail;
      }
    // End machineBar


    // Start lineChart
      for ($i = 1; $i <= 12; $i++) {
        $dateCal = $this->mySql ? 
          "(SELECT '${curYear}-${i}-1' - INTERVAL 1 YEAR + INTERVAL 1 MONTH) AND (SELECT LAST_DAY('${curYear}-${i}-1'))" : 
          "(SELECT (('${curYear}-${i}-1')::DATE - INTERVAL '1 YEAR - 1 MONTH')::DATE) AND (SELECT (date_trunc('MONTH',('${curYear}-${i}-1')::date) + INTERVAL '1 MONTH - 1 DAY')::DATE)";
        $palletLineSql = "
          SELECT 
            ${month_number} AS month_number, 
            COUNT(i_record_pallet_id) AS total_pallet, 
            SUM(i_record_pallet_status) AS total_reject 
          FROM b_models 
            INNER JOIN b_record ON b_record.i_models_id = b_models.i_models_id 
            INNER JOIN b_record_pallet ON b_record_pallet.i_record_id = b_record.i_record_id
          WHERE b_record.d_record_date BETWEEN ${dateCal}
          GROUP BY ${month_number}
        ";
        $palletTmp = DB::select(DB::raw($palletLineSql));
        $palletRawData[] = count($palletTmp) > 0 ? $palletTmp[0] : (object) array('month_number' => $i, 'total_pallet' => 0, 'total_reject' => 0);

        $palletLineRed[] = $palletBarTotal[$i-1] > 0 ? number_format(($palletBarReject[$i-1] / $palletBarTotal[$i-1]) * 100, 2) : 0;
        $palletLineBlue[] = $palletRawData[$i-1]->total_pallet > 0 ? number_format((($palletRawData[$i-1]->total_reject * 12) / ($palletRawData[$i-1]->total_pallet * 12)) * 100, 2) : 0;

        $machineLineSql = "
          SELECT 
            ${month_number} AS month_number, 
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
          WHERE machines.d_record_date BETWEEN ${dateCal}
          GROUP BY ${month_number}
        ";
        $machineTmp = DB::select(DB::raw($machineLineSql));
        $machineRawData[] = count($machineTmp) > 0 ? $machineTmp[0] : (object) array('month_number' => $i, 'total_machine' => 0, 'total_fail' => 0);

        $machineLineRed[] = $machineBarTotal[$i-1] > 0 ? number_format(($machineBarFail[$i-1] / $machineBarTotal[$i-1]) * 100, 2) : 0;
        $machineLineBlue[] = $machineRawData[$i-1]->total_machine > 0 ? number_format((($machineRawData[$i-1]->total_fail * 12) / ($machineRawData[$i-1]->total_machine * 12)) * 100, 2) : 0;
      }
    // End lineChart


    // Start topErrorcode
      $topErrorcodeSql = "
        SELECT
          b_errorcode.i_errorcode_id, 
          b_errorcode.c_code,
          b_errorcode.n_errorcode,
          CASE WHEN record_item.qty IS NULL THEN 0 ELSE record_item.qty END + CASE WHEN record_failure.qty IS NULL THEN 0 ELSE record_failure.qty END AS qty
        FROM b_errorcode 
        LEFT JOIN (
          SELECT 
            i_errorcode_id, 
            SUM(i_record_item_fail) AS qty 
          FROM b_checklists cl
            INNER JOIN b_record_item rcit ON rcit.i_checklist_id = cl.i_checklist_id 
            INNER JOIN b_record rc ON rc.i_record_id = rcit.i_record_id 
          WHERE rc.d_record_date BETWEEN '${curYear}-01-01' AND '${curYear}-12-31' 
            AND rcit.i_record_item_fail != 0 
          GROUP BY i_errorcode_id
          ORDER BY qty DESC, i_errorcode_id ASC
        ) AS record_item ON record_item.i_errorcode_id = b_errorcode.i_errorcode_id 
        LEFT JOIN (
          SELECT 
            i_errorcode_id, 
            SUM(i_record_failure) AS qty 
          FROM b_record_failure rf
            INNER JOIN b_record rc ON rc.i_record_id = rf.i_record_id 
          WHERE rc.d_record_date BETWEEN '${curYear}-01-01' AND '${curYear}-12-31' 
            AND i_record_failure != 0 
          GROUP BY i_errorcode_id
          ORDER BY qty DESC, i_errorcode_id ASC
        ) AS record_failure ON record_failure.i_errorcode_id = b_errorcode.i_errorcode_id
        WHERE CASE WHEN record_item.qty IS NULL THEN 0 ELSE record_item.qty END + CASE WHEN record_failure.qty IS NULL THEN 0 ELSE record_failure.qty END > 0
        ORDER BY qty DESC, b_errorcode.i_errorcode_id ASC
      ";
      $topErrorcodeData = DB::select(DB::raw($topErrorcodeSql));

      $i = 0; 
      $top5ErrorcodeBarLabels = [];
      $top5ErrorcodeBarData = [];
      foreach ($topErrorcodeData as $key => $value) {
        if ($i == 5) {
          break;
        }
        $top5ErrorcodeBarLabels[$value->i_errorcode_id] = $value->c_code;
        $top5ErrorcodeBarData[$value->i_errorcode_id] = $value->qty;
        $i++;
      }
    // End topErrorcode

    // echo ($topErrorcodeSql);
    // echo json_encode($topErrorcodeFailureData);
    return view('dashboard', compact('models', 'years', 'palletBarTotal', 'palletBarReject', 'machineBarTotal', 'machineBarFail', 'palletLineRed', 'palletLineBlue', 'machineLineRed', 'machineLineBlue', 'topErrorcodeData', 'top5ErrorcodeBarLabels', 'top5ErrorcodeBarData'));
  }

  public function getChartData (Request $req)
  {
    $curYear = date('Y');

    $barModelId = $req->barModelId;
    $barDateFrom = $req->barDateFrom;
    $barDateTo = $req->barDateTo;

    $lineModelId = $req->lineModelId;
    $lineYear = $req->lineYear;

    $top5ModelId = $req->top5ModelId;
    $top5DateFrom = $req->top5DateFrom;
    $top5DateTo = $req->top5DateTo;


    // Start Prepare data
      $barDateFrom = $barDateFrom ? $barDateFrom : "${curYear}-01-01";
      $barDateTo = $barDateTo ? $barDateTo : "${curYear}-12-31";
      $top5DateFrom = $top5DateFrom ? $top5DateFrom : "${curYear}-01-01";
      $top5DateTo = $top5DateTo ? $top5DateTo : "${curYear}-12-31";

      $month_number_pallet = $this->mySql ? "MONTH(b_record.d_record_date)" : "date_part('MONTH', b_record.d_record_date)";
      $month_number_machine = $this->mySql ? "MONTH(tab.d_record_date)" : "date_part('MONTH', tab.d_record_date)";

      $whereModelBar = $barModelId != 'all' ? "AND b_record.i_models_id = ${barModelId}" : '';
      $whereModelPalletLine = $lineModelId != 'all' ? "AND b_record.i_models_id = ${lineModelId}" : '';
      $whereModelMachineLine = $lineModelId != 'all' ? "WHERE b_record.i_models_id = ${lineModelId}" : '';
      $whereModelTop5 = $top5ModelId != 'all' ? "AND rc.i_models_id = ${top5ModelId}" : '';

      for ($i = 0; $i < 12; $i++) {
        $palletBarTotal[] = 0;
        $palletBarReject[] = 0;
        $machineBarTotal[] = 0;
        $machineBarFail[] = 0;
      }
    // End Prepare data


    // Start palletBar
      $palletBarSql = "
        SELECT 
          ${month_number_pallet} AS grouping, 
          COUNT(i_record_pallet_id) AS total_pallet, 
          SUM(i_record_pallet_status) AS total_reject 
        FROM b_models
          INNER JOIN b_record ON b_record.i_models_id = b_models.i_models_id 
          INNER JOIN b_record_pallet ON b_record_pallet.i_record_id = b_record.i_record_id
        WHERE d_record_date BETWEEN '${barDateFrom}' AND '${barDateTo}' ${whereModelBar}
        GROUP BY ${month_number_pallet}
      ";
      $palletBarData = DB::select(DB::raw($palletBarSql));

      foreach ($palletBarData as $value) {
        $palletBarTotal[$value->grouping-1] = $value->total_pallet;
        $palletBarReject[$value->grouping-1] = $value->total_reject;
      }
      $palletBar = compact('palletBarLabels', 'palletBarTotal', 'palletBarReject');
    // End palletBar

    // Start machineBar
      $machineBarSql = "
        SELECT 
          ${month_number_machine} AS grouping,
          COUNT(c_machine_no) AS total_machine,
          MAX(fail) AS total_fail
        FROM ( 
          SELECT 
            c_machine_no, 
            MAX(d_record_date) as d_record_date, 
            MAX(i_total_rjmc) AS fail 
          FROM b_models 
            INNER JOIN b_record ON b_record.i_models_id = b_models.i_models_id 
            INNER JOIN b_record_item ON b_record_item.i_record_id = b_record.i_record_id
          WHERE b_record.d_record_date BETWEEN '${barDateFrom}' AND '${barDateTo}' ${whereModelBar}
          GROUP BY c_machine_no
        ) AS tab
        GROUP BY ${month_number_machine}
      ";
      $machineBarData = DB::select(DB::raw($machineBarSql));

      foreach ($machineBarData as $value) {
        $machineBarTotal[$value->grouping-1] = $value->total_machine;
        $machineBarFail[$value->grouping-1] = $value->total_fail;
      }
      $machineBar = compact('machineBarLabels', 'machineBarTotal', 'machineBarFail');
    // End machineBar


    // Start lineChart
      for ($i = 1; $i <= 12; $i++) {
        $dateCal = $this->mySql ? 
          "(SELECT '${lineYear}-${i}-1' - INTERVAL 1 YEAR + INTERVAL 1 MONTH) AND (SELECT LAST_DAY('${lineYear}-${i}-1'))" : 
          "(SELECT (('${lineYear}-${i}-1')::DATE - INTERVAL '1 YEAR - 1 MONTH')::DATE) AND (SELECT (date_trunc('MONTH',('${lineYear}-${i}-1')::date) + INTERVAL '1 MONTH - 1 DAY')::DATE)";
        
        $palletLineSql = "
          SELECT 
            ${month_number_pallet} AS month_number, 
            COUNT(i_record_pallet_id) AS total_pallet, 
            SUM(i_record_pallet_status) AS total_reject 
          FROM b_models 
            INNER JOIN b_record ON b_record.i_models_id = b_models.i_models_id 
            INNER JOIN b_record_pallet ON b_record_pallet.i_record_id = b_record.i_record_id
          WHERE b_record.d_record_date BETWEEN ${dateCal} ${whereModelPalletLine}
          GROUP BY ${month_number_pallet}
        ";
        $palletTmp = DB::select(DB::raw($palletLineSql));
        $palletRawData[] = count($palletTmp) > 0 ? $palletTmp[0] : (object) array('month_number' => $i, 'total_pallet' => 0, 'total_reject' => 0);

        $palletLineRed[] = $palletBarTotal[$i-1] > 0 ? number_format(($palletBarReject[$i-1] / $palletBarTotal[$i-1]) * 100, 2) : 0;
        $palletLineBlue[] = $palletRawData[$i-1]->total_pallet > 0 ? number_format((($palletRawData[$i-1]->total_reject * 12) / ($palletRawData[$i-1]->total_pallet * 12)) * 100, 2) : 0;

        $machineLineSql = "
          SELECT 
            ${month_number_machine} AS month_number, 
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
            ${whereModelMachineLine}
            GROUP BY c_machine_no
          ) AS tab
          WHERE tab.d_record_date BETWEEN ${dateCal}
          GROUP BY ${month_number_machine}
        ";
        $machineTmp = DB::select(DB::raw($machineLineSql));
        $machineRawData[] = count($machineTmp) > 0 ? $machineTmp[0] : (object) array('month_number' => $i, 'total_machine' => 0, 'total_fail' => 0);

        $machineLineRed[] = $machineBarTotal[$i-1] > 0 ? number_format(($machineBarFail[$i-1] / $machineBarTotal[$i-1]) * 100, 2) : 0;
        $machineLineBlue[] = $machineRawData[$i-1]->total_machine > 0 ? number_format((($machineRawData[$i-1]->total_fail * 12) / ($machineRawData[$i-1]->total_machine * 12)) * 100, 2) : 0;
      }
      $palletLine = compact('palletLineRed', 'palletLineBlue');
      $machineLine = compact('machineLineRed', 'machineLineBlue');
    // End lineChart


    // Start topErrorcode
      $topErrorcodeSql = "
        SELECT
          b_errorcode.c_code,
          b_errorcode.n_errorcode,
          CASE WHEN record_item.qty IS NULL THEN 0 ELSE record_item.qty END + CASE WHEN record_failure.qty IS NULL THEN 0 ELSE record_failure.qty END AS qty
        FROM b_errorcode 
        LEFT JOIN (
          SELECT 
            i_errorcode_id, 
            SUM(i_record_item_fail) AS qty 
          FROM b_checklists cl
            INNER JOIN b_record_item rcit ON rcit.i_checklist_id = cl.i_checklist_id 
            INNER JOIN b_record rc ON rc.i_record_id = rcit.i_record_id 
          WHERE rc.d_record_date BETWEEN '${top5DateFrom}' AND '${top5DateTo}' 
            AND rcit.i_record_item_fail != 0 
            ${whereModelTop5}
          GROUP BY i_errorcode_id
          ORDER BY qty DESC, i_errorcode_id ASC
        ) AS record_item ON record_item.i_errorcode_id = b_errorcode.i_errorcode_id 
        LEFT JOIN (
          SELECT 
            i_errorcode_id, 
            SUM(i_record_failure) AS qty 
          FROM b_record_failure rf
            INNER JOIN b_record rc ON rc.i_record_id = rf.i_record_id 
          WHERE rc.d_record_date BETWEEN '${top5DateFrom}' AND '${top5DateTo}' 
            AND i_record_failure != 0 
            ${whereModelTop5}
          GROUP BY i_errorcode_id
          ORDER BY qty DESC, i_errorcode_id ASC
        ) AS record_failure ON record_failure.i_errorcode_id = b_errorcode.i_errorcode_id
        WHERE CASE WHEN record_item.qty IS NULL THEN 0 ELSE record_item.qty END + CASE WHEN record_failure.qty IS NULL THEN 0 ELSE record_failure.qty END > 0
        ORDER BY qty DESC, b_errorcode.i_errorcode_id ASC
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

    $chartData = compact('palletBar', 'machineBar', 'palletLine', 'machineLine', 'topErrorcode');
    echo json_encode($chartData);
  }
}
