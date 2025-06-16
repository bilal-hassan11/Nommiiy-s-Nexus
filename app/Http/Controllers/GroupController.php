<?php
namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GroupController extends Controller
{
    public function store(Request $request)
    {
        // $validator = Validator::make($request->all(), [
        //     'code' => 'required|string|unique:groups,code',
        //     'name' => 'required|string',
        //     'level' => 'required|integer',
        //     'status' => 'required|in:Default,Active,Inactive',
        //     'sequence' => 'required|integer',
        //     'remark' => 'nullable|string',
        //     'logo' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg|max:2048',
        // ]);

        // if ($validator->fails()) {
        //     return response()->json([
        //         'errors' => $validator->errors()
        //     ], 400);
        // }

        $logoPath = null;
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('logos', 'public');
        }

        $group = Group::create([
            'code' => $request->input('code'),
            'name' => $request->input('name'),
            'level' => $request->input('level'),
            'status' => $request->input('status'),
            'sequence' => $request->input('sequence'),
            'remark' => $request->input('remark'),
            'logo_path' => $logoPath,
        ]);

        return response()->json([
            'message' => 'Group created successfully!',
            'data' => $group,
        ], 201);
    }
}

?>
