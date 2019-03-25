<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Models;
use App\Models\Series;

class ModelsController extends Controller
{
  public function index()
  {
    $modelList = Models::where('i_models_deleted', 0)->get();
    return view('models.index', compact('modelList'));
  }

  public function createForm()
  {
    $series = Series::where('i_series_deleted', 0)->get();
    return view('models.createForm', compact('series'));
  }

  public function editForm($id)
  {
    $series = Series::where('i_series_deleted', 0)->get();
    $models = Models::where('i_models_id', $id)->first();
    return view('models.editForm', compact('series', 'models'));
  }

  public function create(Request $req)
  {
    $models = Models::where('n_models_name', $req->n_models_name)->first();
    if ($models) {
        return redirect()->route('models')->with('error', 'Create Fail!')->with('message', "Model: $req->n_models_name is already taken.");
    } else {
      Models::insert([
        'n_models_name' => $req->n_models_name, 
        'i_models_deleted' => 0,
        'i_pallet_qty' => $req->i_pallet_qty
      ]);
    }
    return redirect()->route('models');
  }

  public function edit(Request $req)
  {
    $models = Models::where('n_models_name', $req->n_models_name)->first();
    if ($models) {
        return redirect()->route('models')->with('error', 'Create Fail!')->with('message', "Model: $req->n_models_name is already taken.");
    } else {
      Models::where('i_models_id', $req->i_models_id)->update([
        'n_models_name' => $req->n_models_name,
        'i_pallet_qty' => $req->i_pallet_qty
      ]);
    }
    return redirect()->route('models');
  }

  public function delete($id)
  {
    Models::where('i_models_id', $id)->update(['i_models_deleted' => 1]);
    return redirect()->route('models');
  }
} 
