<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Series;

class SeriesController extends Controller
{
  public function index() {
    $seriesList = Series::where('i_series_deleted', 0)->get();
    return view('series.index', compact('seriesList'));
  }

  public function createForm() {
    return view('series.createForm');
  }

  public function editForm($id) {
    $series = Series::where('i_series_id', $id)->first();
    return view('series.editForm', compact('series'));
  }

  public function create(Request $req) {
    Series::insert([
      'n_series_name' => $req->n_series_name, 
      'i_series_deleted' => 0,
      'i_pallet_qty' => $req->i_pallet_qty
    ]);
    return redirect()->route('series');
  }

  public function edit(Request $req){
    Series::where('i_series_id', $req->i_series_id)->update([
      'n_series_name' => $req->n_series_name,
      'i_pallet_qty' => $req->i_pallet_qty
    ]);
    return redirect()->route('errorcode');
  }

  public function delete($id) {
    Series::where('i_series_id', $id)->update(['i_series_deleted' => 1]);
    return redirect()->route('series');
  }
} 
