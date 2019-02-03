<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Series;
use App\PartName;

class SeriesController extends Controller
{
  public function index() {
    $seriesList = Series::where('i_series_deleted', 0)->get();
    return view('series.index', compact('seriesList'));
  }

  public function createForm() {
    $partName = PartName::where('i_part_name_deleted', 0)->get();
    return view('series.createForm', compact('partName'));
  }

  public function editForm($id) {
    $partName = PartName::where('i_part_name_deleted', 0)->get();
    $series = Series::where('i_series_id', $id)->first();
    return view('series.editForm', compact('partName', 'series'));
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
