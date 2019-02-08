<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PartName;
use App\Models\Series;

class PartNameController extends Controller
{
    public function index()
    {
        $partnameList = PartName::where('i_part_name_deleted', 0)->get();
        return view('partName.index', compact('partnameList'));
    }

    public function createForm()
    {
        $seriesList = Series::where('i_series_deleted', 0)->get();
        return view('partName.createForm', compact('seriesList'));
    }

    public function editForm($id)
    {
        $seriesList = Series::where('i_series_deleted', 0)->get();
        $partName = PartName::where('i_part_name_id', $id)->first();
        return view('partName.editForm', compact('seriesList', 'partName'));
    }
    
    public function create(Request $req)
    {
        $partname = PartName::where('n_part_name', $req->n_part_name)->first();
        if ($partname) {
            return redirect()->route('partName')->with('error', 'Create Fail!')->with('message', "Part Name: $req->n_part_name is already created.");
        } else {
            PartName::insert([
                'i_series_id' => $req->i_series_id,
                'n_part_name' => $req->n_part_name,
                'i_part_name_deleted' => 0,
            ]);
        }
        return redirect()->route('partName');
    }
        
    public function edit(Request $req)
    {
        $partname = PartName::where('i_part_name_id', '!=', $req->i_part_name_id)->where('n_part_name', $req->n_part_name)->first();
        if ($partname) {
            return redirect()->route('partName')->with('error', 'Edit Fail!')->with('message', "Part Name: $req->n_part_name is already created.");
        } else {
            PartName::where('i_part_name_id', $req->i_part_name_id)->update([
                'i_series_id' => $req->i_series_id,
                'n_part_name' => $req->n_part_name
            ]);
        }
        return redirect()->route('partName');
    }

    public function delete($id)
    {
        PartName::where('i_part_name_id', $id)->update(['i_part_name_deleted' => 1]);
        return redirect()->route('partName');
    }
}
