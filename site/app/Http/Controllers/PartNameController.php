<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PartName;
use App\Series;

class PartNameController extends Controller
{
    public function index(){
        $partnameList = PartName::where('i_part_name_deleted', 0)->get();
        return view('partName.index', compact('partnameList'));
    }

    public function createForm() {
        $seriesList = Series::where('i_series_deleted', 0)->get();
        return view('partName.createForm', compact('seriesList'));
    }

    public function editForm($id) {
        $partName = PartName::where('i_part_name_id', $id)->first();
        return view('partName.editForm', compact('partName'));
    }
    
    public function create(Request $req) {
        PartName::insert([
            'i_series_id' => $req->i_series_id,
            'n_part_name' => $req->n_part_name,
            'i_part_name_deleted' => 0,
        ]);
        return redirect()->route('partName');
    }
        
    public function edit(Request $req) {
        PartName::where('i_part_name_id', $req->i_part_name_id)->update([
            'i_series_id' => $req->i_series_id,
            'n_part_name' => $req->i_part_name_id,
        ]);
        return redirect()->route('partName');
    }

    public function delete($id) {
        PartName::where('i_part_name_id', $id)->update(['i_part_name_deleted' => 1]);
        return redirect()->route('partName');
    }
}
