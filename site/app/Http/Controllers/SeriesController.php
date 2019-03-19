<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Series;
use App\Models\Models;

class SeriesController extends Controller
{
    public function index()
    {
        $seriesList = Series::where('i_series_deleted', 0)->get();
        return view('series.index', compact('seriesList'));
    }

    public function createForm()
    {
        $modelList = Models::where('i_models_deleted', 0)->get();
        return view('series.createForm', compact('modelList'));
    }

    public function editForm($id)
    {
        $modelList = Models::where('i_models_deleted', 0)->get();
        $series = Series::where('i_series_id', $id)->first();
        return view('series.editForm', compact('modelList', 'series'));
    }
    
    public function create(Request $req)
    {
        $series = Series::where('n_series', $req->n_series)->first();
        if ($series) {
            return redirect()->route('models')->with('error', 'Create Fail!')->with('message', "Sereis: $req->n_series is already taken.");
        } else {
            Series::insert([
                'i_models_id' => $req->i_models_id,
                'n_series' => $req->n_series,
                'i_series_deleted' => 0,
            ]);
        }
        return redirect()->route('models');
    }
        
    public function edit(Request $req)
    {
        $series = Series::where('i_series_id', '!=', $req->i_series_id)->where('n_series', $req->n_series)->first();
        if ($series) {
            return redirect()->route('models')->with('error', 'Edit Fail!')->with('message', "Series : $req->n_series is already taken.");
        } else {
            Series::where('i_series_id', $req->i_series_id)->update([
                'i_models_id' => $req->i_models_id,
                'n_series' => $req->n_series
            ]);
        }
        return redirect()->route('models');
    }

    public function delete($id)
    {
        Series::where('i_series_id', $id)->update(['i_series_deleted' => 1]);
        return redirect()->route('models');
    }
}
