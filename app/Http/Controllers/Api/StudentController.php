<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::all();

        if ($students->count() > 0) {
            return Response()->json([
                'status' => 200,
                'students' => $students,
            ],200);
        } else {
            return Response()->json([
                'status' => 404,
                'students' => 'No Records Found',
            ],404);
        }
    }



    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'course' => 'required|string|max:255',
            'email' => 'required|email|max:199',
            'phone' => 'required|digits:10',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages()
            ], 422);
        } else {
            $student = Student::create([
                'name' => $request->name,
                'course' => $request->course,
                'email' => $request->email,
                'phone' => $request->phone,
            ]);

            if ($student) {
                return response()->json([
                    'status' => 200,
                    'message' => 'Student created successfully'
                ], 200);
            } else {
                return response()->json([
                    'status' => 500,
                    'errors' => 'Something went wrong!'
                ], 500);
            }
        }
    }



    public function show($id)
    {
        $student = Student::find($id);
        if ($student) {
            return response()->json([
                'status' => 200,
                'student' => $student
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'No Such Student Found!'
            ], 404);
        }
    }


    public function edit($id){
        $student = Student::find($id);
        if ($student) {
            return response()->json([
                'status' => 200,
                'student' => $student
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'No Such Student Found!'
            ], 404);
        }

    }


    public function update(Request $request,int $id){

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'course' => 'required|string|max:255',
            'email' => 'required|email|max:199',
            'phone' => 'required|digits:10',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages()
            ], 422);
        } else {


            $student = Student::find($id);
            if ($student) {
                $student->update([
                    'name' => $request->name,
                    'course' => $request->course,
                    'email' => $request->email,
                    'phone' => $request->phone,
                ]);

                return response()->json([
                    'status' => 200,
                    'message' => 'Student updated successfully'
                ], 200);
            } else {
                return response()->json([
                    'status' => 404,
                    'errors' => 'No Such Student Found!!'
                ], 404);
            }
        }

    }



    public function destroy($id){

        $student = Student::find($id);
        if($student){
            $student->delete();
            return response()->json([
                'status' => 200,
                'message' => 'Student deleted successfully'
            ], 200);
        }
        else{
            return response()->json([
                'status' => 404,
                'errors' => 'No Such Student Found!!'
            ], 404);
        }



    }





}
