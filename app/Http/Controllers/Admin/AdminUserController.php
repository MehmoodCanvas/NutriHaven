<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Members;

class AdminUserController extends Controller
{
    public function index()
    {
        $members = Members::orderBy('member_id', 'DESC')->get();
        return view('admin.users', compact('members'));
    }

    public function edit($id)
    {
        $member = Members::findOrFail($id);
        return view('admin.user-edit', compact('member'));
    }

    public function update(Request $request, $id)
    {
        $member = Members::findOrFail($id);

        $request->validate([
            'member_full_name' => 'required|string|max:255',
            'member_email' => 'required|email|unique:member,member_email,' . $id . ',member_id',
            'member_gender' => 'nullable|string',
            'member_age' => 'nullable|integer|min:1',
            'member_weight' => 'nullable|numeric|min:1',
            'member_weight_unit' => 'nullable|in:lbs,kg',
            'member_height_ft' => 'nullable|numeric',
            'member_height_in' => 'nullable|numeric',
            'member_goal' => 'nullable|string',
            'member_exp' => 'nullable|string',
            'member_excerise_place' => 'nullable|string',
            'member_status' => 'nullable|string',
        ]);

        $member->update($request->only([
            'member_full_name', 'member_email', 'member_gender', 'member_age',
            'member_weight', 'member_weight_unit', 'member_height_ft', 'member_height_in',
            'member_goal', 'member_exp', 'member_excerise_place', 'member_status'
        ]));

        flash()->success('Member updated successfully!');
        return redirect()->back();
    }

    public function destroy($id)
    {
        $member = Members::findOrFail($id);
        $member->delete();
        flash()->success('Member deleted successfully!');
        return redirect()->back();
    }
}
