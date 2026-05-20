<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Equipment;

class AdminEquipmentController extends Controller
{
    public function index()
    {
        $equipments = Equipment::orderBy('id', 'DESC')->get();
        return view('admin.equipments', compact('equipments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:equipments,name',
        ]);

        Equipment::create(['name' => $request->name]);
        flash()->success('Equipment created successfully!');
        return redirect()->back();
    }

    public function update(Request $request, $id)
    {
        $equipment = Equipment::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255|unique:equipments,name,' . $id,
        ]);

        $equipment->update(['name' => $request->name]);
        flash()->success('Equipment updated successfully!');
        return redirect()->back();
    }

    public function destroy($id)
    {
        $equipment = Equipment::findOrFail($id);
        $equipment->delete();
        flash()->success('Equipment deleted successfully!');
        return redirect()->back();
    }
}
