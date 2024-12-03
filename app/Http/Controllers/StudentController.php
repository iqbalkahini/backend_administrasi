<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\User;
use App\Models\City;
use App\Models\StudentClass;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $student = Student::with(["user","city", "school", "class"])->get();

        return response()->json([
            "Response"=> [
                "data"=> $student
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
        $user = $request->user();

        if(is_null($user)) {
            return response()->json([
                "Response"=> [
                    "message"=> "wrong kredensial."
                ]
            ], 200);
        }else {
                $validated = $request->validate([
                    "name" => "required|string|max:255",
                    "city_id" => "required|exists:city,id",
                    "school_id" => "required|exists:schools,id",
                    "class_id" => "required|exists:student_classes,id"
                ]);
        
                // $existingStudent = Student::with("class")->where("user_id", $user["id"])->get();
        
                // if( count($existingStudent)!==0) {
                //     $user->update(["name"=> $validated["name"]]);
                //     return response()->json([
                //         "Response"=> [
                //             // "message"=> "Student  with name ".  $existingStudent[0]["class"]["name"]  ." already created."
                //             "Students by the name of Iqbal Lazuardi in Class XII RPL 1 already exist"
                //         ]
                //     ], 200);
                // }
        
                $student = Student::create([
                    "city_id"=>$validated["city_id"],
                    "school_id"=>$validated["school_id"],
                    "class_id"=>$validated["class_id"],
                    "user_id"=>$user["id"]
                ]);
          
                $getUser = $request->user();
                $getUser->update(["name"=>$validated["name"]]);
        
                return response()->json([
                    "Response"=> [
                        "message"=> "new student has been created."
                    ]
                ], 200);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $student = Student::with(["user","city", "school", "class"])->where("id", $id)->get()->first();

        if(is_null($student)) {
            return response()->json([
                "Response"=> [
                    "data"=> "Student not found, so not deleted."
                ]
            ], 200);
        }

        return response()->json([
            "Response"=> [
                "data"=> $student
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
            "name" => "required|string|max:255",
            "city_id" => "required|exists:city,id",
            "school_id" => "required|exists:schools,id",
            "class_id" => "required|exists:student_classes,id"
        ]);

        $student = Student::where("id", $id)->get()->first();

        if(is_null($student)) {
            return response()->json([
                "Response"=> [
                    "message"=> "Student not found, so not deleted."
                ]
            ], 200);
        }

        $existingUserNamebyId = User::where("id", $student->user_id)->get()->first();

        if($student->class_id == $validated["class_id"] && $student->city_id == $validated["city_id"] && $student->school_id == $validated["school_id"] && $existingUserNamebyId["name"] == $validated["name"]) {
            return response()->json([
                "Response"=> [
                    "message"=> "Student with name " .$validated["name"]. " is already created."
                ]
            ], 200);
        }

        $student->update([
                "city_id" => $validated["city_id"],
                "school_id" => $validated["school_id"],
                "class_id" => $validated["class_id"]
            ]
        );

        $existingUserNamebyId->update(
            ["name" => $validated["name"]]
        );
        
        return response()->json([
            "Response" => [
                "message"=> "Student has been updated."
            ]
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $student = Student::where("id", $id)->get()->first();

        if($student==null) {
            return response()->json([
                "Response"=> [
                    "message"=>  "Student not found, so not deleted."
                ]
            ], 200);
        }

        $student->delete();
        return response()->json([
            "Response"=> [
                "message"=> "Student has been deleted."
            ]
        ], 200);
    }
}
