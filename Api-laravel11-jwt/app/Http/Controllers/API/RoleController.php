<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'roles' => Role::all()
        ], 200);
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required','string','max:255'],
            'description' => ['string','max:255'],
        ]);
        $role = Role::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);
        return response()->json([
            'role' => $role,
            'message' => 'role created successfully'
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        return Response()->json([
            'role' => Role::findOrFail($role->id),
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => ['required','string','max:255'],
            'description' => ['string','max:255'],
        ]);
        $role->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);
        return response()->json([
            'role' => $role,
           'message' => 'role updated successfully'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        $role->delete();
        return response()->json([
           'message' => 'role deleted successfully'
        ], 200);
    }
}
