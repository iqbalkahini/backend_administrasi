<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StudentClass;

class StudentClassController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = StudentClass::with('schools')->get();
        return response()->json([
            "Response" => [
                "message"=> $data
            ]
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            "name" => "required|string|max:255",
            "school_id" => "required|exists:schools,id"
        ]);

        $existingClass = StudentClass::where('name', $validated['name'])->first();

        if ($existingClass) {
            return response()->json([
                'Response' => [
                    'message' => "Class with name "  . $validated['name'] . " already exists."
                ]
            ], 400); 
        }

        $studentClass = StudentClass::create($validated);

        return response()->json([
            'Response' => [
                'message' => 'New Student Class has been created.'
            ]
        ], 201);
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $showClassById = StudentClass::with("schools")->where("id", $id)->get()->first();

        if(is_null($showClassById)) {
            return response()->json([
                "Response" => [
                    "message" => "Class not found, so not deleted."
                ]
            ], 200);
        }

        return response()->json([
            "Response" => [
                "data" => $showClassById
            ]
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
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'school_id' => 'required|exists:schools,id',
        ]);

        $studentClass = StudentClass::where("id",$id)->get()->first();

        if (is_null($studentClass)) {
            return response()->json([
                'Response' => [
                    'message' => 'Class not found, so not deleted.'
                ]
            ], 200);
        }

        $existingClass = StudentClass::where([['school_id', $validated['school_id']], ["name", $validated["name"]]])->first();

        if ($existingClass) {
            return response()->json([
                'Response' => [
                    'message' => 'Class with name ' . $validated['name'] . ' already exists.'
                ]
            ], 200);
        }

        $studentClass->update($validated);

        return response()->json([
            'Response' => [
                'message' => 'Class has been updated.',
            ]
        ], 200);
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $studentClass = StudentClass::where("id",$id)->get()->first();

        if (is_null($studentClass)) {
            return response()->json([
                'Response' => [
                    'message' => 'Student Class not found.'
                ]
            ], 404); 
        }

        $studentClass->delete();

        return response()->json([
            'Response' => [
                'message' => 'Student Class deleted successfully.'
            ]
        ], 200);
    }
}
