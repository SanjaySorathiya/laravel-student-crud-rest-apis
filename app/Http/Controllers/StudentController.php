<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
  // List Students
  public function getAllStudents()
  {
    $students = Student::orderBy('id','desc')->get()->toJson(JSON_PRETTY_PRINT);
    return response($students, 200);
  }

  // Create Student
  public function createStudent(Request $request) 
  {
    $validator = Validator::make($request->all(), [
        'name'                   => 'required|string|max:50',
        'surname'                => 'required|string|max:50',
        'identification_no'      => 'required|string|max:10',
        'dob'                    => 'required|date|date_format:Y-m-d',
        'registered_on'          => 'required|date|date_format:Y-m-d',
    ], [
        'name.required'               => 'Name is required',
        'surname.required'            => 'Surname is required',
        'identification_no.required'  => 'Identification No is required',
        'dob.required'                => 'Date of Birth is required',
        'registered_on.required'      => 'Registered on date is required',
    ]);

    if ($validator->fails()) {
        return response()->json(['message' => $validator->errors(), 'data'=>[], 'status' =>false], 200);
    }
    
    $student = new Student;
    $student->name              = strip_tags($request->name);
    $student->surname           = strip_tags($request->surname);
    $student->identification_no = $request->identification_no;
    $student->country           = $request->country;
    $student->dob               = $request->dob;
    $student->registered_on     = $request->registered_on;
    $student->save();

    return response()->json(["message" => "Student record created"], 200);
  }

  // Student Details
  public function getStudent($id)
  {
    if (Student::where('id', $id)->exists()) {
      $student = Student::where('id', $id)->get()->toJson(JSON_PRETTY_PRINT);
      return response($student, 200);
    } else {
      return response()->json(["message" => "Student not found"], 200);
    }
  }

  // Update Student
  public function updateStudent(Request $request, $id)
  {
    $validator = Validator::make($request->all(), [
        'name'                   => 'required|string|max:50',
        'surname'                => 'required|string|max:50',
        'identification_no'      => 'required|string|max:10|unique:students,identification_no,'.$id,
        'dob'                    => 'required|date|date_format:Y-m-d',
        'registered_on'          => 'required|date|date_format:Y-m-d',
    ], [
        'name.required'               => 'Name is required',
        'surname.required'            => 'Surname is required',
        'identification_no.required'  => 'Identification No is required',
        'dob.required'                => 'Date of Birth is required',
        'registered_on.required'      => 'Registered on date is required',
    ]);

    if ($validator->fails()) {
        return response()->json(['message' => $validator->errors(), 'data'=>[], 'status' =>false], 200);
    }

    if (Student::where('id', $id)->exists()) {
      $student = Student::find($id);

      $student->name              = is_null($request->name) ? $student->name : strip_tags($request->name);
      $student->surname           = is_null($request->surname) ? $student->surname : strip_tags($request->surname);
      $student->identification_no = is_null($request->identification_no) ? $student->identification_no : $request->identification_no;
      $student->country           = is_null($request->country) ? $student->country : $request->country;
      $student->dob               = is_null($request->dob) ? $student->dob : $request->dob;
      $student->registered_on     = is_null($request->registered_on) ? $student->registered_on : $request->registered_on;
      
      $student->save();

      return response()->json(["message" => "records updated successfully"], 200);
    } else {
      return response()->json(["message" => "Student not found"], 200);
    }
  }

  // Delete Student
  public function deleteStudent ($id)
  {
    if(Student::where('id', $id)->exists()) {
      $student = Student::find($id);
      $student->delete();

      return response()->json(["message" => "Record deleted"], 202);
    } else {
      return response()->json(["message" => "Student not found"], 200);
    }
  }

  // Search Student(s)
  public function findStudents(Request $request)
  {
    $name              = $request->name ?? "";
    $surname           = $request->surname ?? "";
    $identification_no = $request->identification_no ?? "";
    $country           = $request->country ?? "";
    $dob               = $request->dob ?? "";
    $registered_on     = $request->registered_on ?? "";

    $result = Student::when($name, function ($query, $name) {
                            $query->orWhere('name', 'LIKE', '%'.$name.'%');
                        })
                      ->when($surname, function ($query, $surname) {
                          $query->orWhere('surname', 'LIKE', '%'.$surname.'%');
                      })
                      ->when($identification_no, function ($query, $identification_no) {
                          $query->orWhere('identification_no', $identification_no);
                      })
                      ->when($country, function ($query, $country) {
                          $query->orWhere('country', 'LIKE', '%'.$country.'%');
                      })
                      ->when($dob, function ($query, $dob) {
                          $query->whereDate('dob', $dob);
                      })
                      ->when($registered_on, function ($query, $registered_on) {
                          $query->whereDate('registered_on', $registered_on);
                      })
                      ->get();
    
    if(isset($result) && is_object($result) && $result->count() > 0) {
      return response($result->toJson(JSON_PRETTY_PRINT), 200);
    } else {
      return response()->json(["message" => "Student not found"], 200);
    }
  }  
}