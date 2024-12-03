<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\City;
use App\Models\School;

class CitiesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cities = City::select("id", "name")->get();
        if(count($cities) === 0) {
            return response()->json([
                "Response" => [
                    "message" => "City not found"
                ]
            ], 200);
            
        }
        return response()->json([
            "Response" => [
                "data" => $cities
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
            'name' => 'required|string|max:255'
        ]);

        $city = City::select()->where("name", $validated)->get();
        if(count($city) === 1 ) {
            return response()->json([
                "Response"=> [
                    "message"=> "City with name Kota {$validated['name']} is already created."
                ]
            ], 200);
        }

        $postCity = City::create($validated);
        return response()->json([
            "Response" => [
                "message"=> "New City has been created."
            ]
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = City::with('schools')->find($id);

        // city not found
        if(is_null($data)) {
            return response()->json([
                "Response" => [
                     "message"=> "City not found, so not deleted."
                ]
            ], 200);
        }

        return response()->json([
            "Response" => [
                "data" => $data
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
            "name"=> "required|string|max:255"
        ]);

        $city = City::select()->where("name", $validated)->get();

        $cityById = City::select()->where("id",$id)->get();
        if(count($cityById) === 1 ) {
            if(count($city) === 1 ) {
                return response()->json([
                    "Response"=> [
                        "message"=> "City with name Kota {$validated['name']} is already created."
                    ]
                ], 200);
            }else {
                City::where('id', $id)->update(['name'=>$validated["name"]]);
    
                return response()->json(["Response"=> [
                    "message" => "City has been updated."
                ]], 200);
            }
        }else {
            return response()->json([
                "Response"=> [
                    "message" => "City not found, so not deleted."
                ]
            ], 200);
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $city = City::find($id);
        if(!is_null($city)) {
            $city->delete();
            return response()->json([
                "Response"=> [
                    "message" => "City has been deleted."
                ]
            ], 200);
        }else {
            return response()->json([
                "Response"=> [
                    "message" => "City not found, so not deleted."
                ]
            ], 200);
        }
    }
}
