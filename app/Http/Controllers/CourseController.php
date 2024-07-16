<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (auth()->user()->hasRole('admin')) {
            $courses = Course::orderBy('updated_at', 'desc')->take(10)->get();
        } else {
            $courses = auth()->user()->courses;
        }

        $teachers = User::role('teacher')->take(6)->get();
        $studentsCount = Student::count();
        $teachersCount = User::role('teacher')->count();
        $coursesCount = Course::count();

        return view('dashboard', compact('courses', 'studentsCount', 'coursesCount', 'teachersCount', 'teachers'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        return view('course.show', compact('course'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Course $course)
    {
        $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
        ]);

        $course->update($request->all());
    }
}
