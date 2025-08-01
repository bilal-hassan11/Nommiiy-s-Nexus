<?php

namespace App\Http\Controllers;

use App\Models\MemberGroup;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class MemberGroupController extends Controller
{
    /**
     * Display a listing of the groups.
     */
    public function index()
    {
        $groups = Group::all();
        // Append logo_url to each group for frontend display
        $groups->each(function ($group) {
            $group->logo_url = $group->logo_url;
        });
        return response()->json($groups);
    }

    /**
     * Store a newly created group in storage.
     */
    public function store(Request $request)
    {   //dd($request->all());
        $validatedData = $request->validate([
            'code' => 'required|string|max:255|unique:groups,code',
            'name' => 'required|string|max:255|unique:groups,name',
            'level' => 'required|integer|min:1', // Assuming level should be at least 1
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048', // 2MB max
            'status' => ['required', Rule::in(['Default', 'Active', 'Inactive'])],
            'sequence' => 'required|integer|min:1|unique:groups,sequence',
            'remark' => 'nullable|string|max:1000',
        ]);

        $logoPath = null;
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('group_logos', 'public');
        }

        try {
            $group = MemberGroup::create([
                'code' => $validatedData['code'],
                'name' => $validatedData['name'],
                'level' => $validatedData['level'],
                'logo_path' => $logoPath,
                'status' => $validatedData['status'],
                'sequence' => $validatedData['sequence'],
                'remark' => $validatedData['remark'],
            ]);

            // Append the full URL for the logo before returning
            $group->logo_url = $group->logo_url;

            return response()->json(['message' => 'Member Group created successfully!', 'group' => $group], 201);

        } catch (\Illuminate\Database\QueryException $e) {
            // If the logo was stored but DB insertion failed, delete the logo
            if ($logoPath && Storage::disk('public')->exists($logoPath)) {
                Storage::disk('public')->delete($logoPath);
            }
            if ($e->errorInfo[1] === 1062) { // MySQL duplicate entry error code
                return response()->json(['message' => 'A group with this code, name, or sequence already exists.'], 409);
            }
            return response()->json(['message' => 'An error occurred while saving the group.', 'error' => $e->getMessage()], 500);
        } catch (\Exception $e) {
            // General catch-all for other errors
            if ($logoPath && Storage::disk('public')->exists($logoPath)) {
                Storage::disk('public')->delete($logoPath);
            }
            return response()->json(['message' => 'An unexpected error occurred.', 'error' => $e->getMessage()], 500);
        }
    }
}