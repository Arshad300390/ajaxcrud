<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function addStudent(Request $request)
    {
        $file = $request->file('file');
        $fileName = time() . '' . $file->getClientOriginalName();
        $filePath = $file->storeAs('images', $fileName, 'public');
        $student = new Student;
        $student->name = $request->name;
        $student->email = $request->email;
        $student->file = $filePath;
        $student->save();
        return response()->json(['res' => 'Student Created Successfully']);

    }
    public function getStudents()
    {
        $students = Student::all();
        return response()->json(['students' => $students]);

    }
    public function delStudent(Request $request)
    {
        Student::find($request->id)->delete();
        return response()->json(['students' => "record deleted"]);

    }
}
