<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent;
use Illuminate\Support\Facades\DB;


class CourseController extends Controller
{
    public function index() : JsonResponse{
        $courses = Course::with(['users', 'dates'])->get();
        return response()->json($courses, 200);
    }

    public function findBySubject(string $subject):Course {
        $course = Course::where('subject', $subject)
            ->with(['users', 'dates'])
            ->first();
        return $course;
    }


    public function show(Course $course) {
        return view('courses.show', compact('course'));
    }
}
