<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Series;

class SeriesController extends Controller
{
  public function index() {
    $seriesList = Series::where('c_series_deleted', 0)->get();
    return view('series.index', compact('seriesList'));
  }

  public function createForm() {
    return view('series.createForm');
  }

  public function create(Request $req) {
    Series::insert([
      'n_series_name' => $req->n_series_name, 
      'c_series_deleted' => 0,
      'i_pallet_qty' => $req->i_pallet_qty,
      'c_series_code' => $req->c_series_code
    ]);
    return redirect()->route('series');
  }

  public function delete($id) {
    Series::where('i_series_id', $id)->update(['c_series_deleted' => 1]);
    return redirect()->route('series');
  }
} 
