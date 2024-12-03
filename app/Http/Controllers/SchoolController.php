<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\School;

class SchoolController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = School::select()->with('city')->get();
        return response()->json([
            "Response" => [
                "message"=> $data
            ]
        ], 200);
    }

    // detail school
    public function detail(string $id)
    {
        $data  = School::with(['city', 'classes', "student"])->find($id);
        if(is_null($data)) {
            return response()->json([
                "Response" => [
                    "message"=> "School not found, so not deleted"
                ]
            ], 200);            
        }
        return response()->json([
            "Response" => [
                "data"=> $data
            ]
        ], 200);
    }

    // detail school clases
    public function clases(string $id)
    {
        $data  = School::with(['classes'])->find($id);
        if(is_null($data)) {
            return response()->json([
                "Response" => [
                    "message"=> "School not found, so not deleted"
                ]
            ], 200);            
        }
        return response()->json([
            "Response" => [
                "message"=> $data
            ]
        ], 200);
    }
    
    // detail school students
    public function students(string $id)
    {
        $data  = School::with(['student'])->where("id",$id)->get()->first();
        if(is_null($data)) {
            return response()->json([
                "Response" => [
                    "message"=> "School not found, so not deleted"
                ]
            ], 200);
        }
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
            "name"=>"required|string|max:255",
            "city_id"=>"required|exists:city,id"
        ]);

        $data = School::find($validated["city_id"]);
        $city = School::select()->where("name", $validated["name"])->get();
        if(!is_null($data) && count($city) !== 0) {
            return response()->json([
                "Response" => [
                    "message"=> "School with name Kota {$data["city"]["name"]} is already created."
                ]
            ], 200);
        }
        $school = School::create($validated);
        return response()->json([
            "Response" => [
                "message"=> "New School has been created."
            ]
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
            "name"=>"required|string|max:255"
        ]);

        $school = School::select()->where("id", $id)->get();
        $schoolByName = School::select()->where("name", $validated)->get();

        if(count($schoolByName)!==0){
            return response()->json([
                "Response" => [
                    "message"=> "School with name {$validated["name"]} is already created."
                ]
            ], 200);
        }else 
        if(count($school) !==0) {
            School::where('id', $id)->update(['name'=>$validated["name"]]);

            return response()->json([
                "Response" => [
                    "message"=> "School has been updated."
                ]
            ], 200);
        }else {
            return response()->json([
                "Response" => [
                    "message"=> "School not found, so not deleted."
                ]
            ], 200);
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $school = School::find($id);
        if(is_null($school)) {
            return response()->json([
                "Response" => [
                    "message"=> "School not found, so not deleted."
                ]
            ], 200);
        }
        $school->delete();
        return response()->json([
            "Response" => [
                "message"=> "School has been deleted."
            ]
        ], 200);
    }
}
