<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AuxEquipment;

class AdminAuxEquipmentController extends Controller
{
    public function index()
    {
        $auxEquipments = AuxEquipment::orderBy('id', 'DESC')->get();
        return view('admin.aux-equipments', compact('auxEquipments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:aux_equipments,name',
        ]);

        AuxEquipment::create(['name' => $request->name]);
        flash()->success('Aux Equipment created successfully!');
        return redirect()->back();
    }

    public function update(Request $request, $id)
    {
        $auxEquipment = AuxEquipment::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255|unique:aux_equipments,name,' . $id,
        ]);

        $auxEquipment->update(['name' => $request->name]);
        flash()->success('Aux Equipment updated successfully!');
        return redirect()->back();
    }

    public function destroy($id)
    {
        $auxEquipment = AuxEquipment::findOrFail($id);
        $auxEquipment->delete();
        flash()->success('Aux Equipment deleted successfully!');
        return redirect()->back();
    }
}
