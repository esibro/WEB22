<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Timeslots;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent;
use Illuminate\Support\Facades\DB;


class CourseController extends Controller
{
    public function index() : JsonResponse{
        $courses = Course::with(['users', 'timeslots'])->get();
        return response()->json($courses, 200);
    }

    public function findBySubject(string $subject):Course {
        $course = Course::where('subject', $subject)
            ->with(['users', 'timeslots'])
            ->first();
        return $course;
    }

    public function checkSubject(string $subject){
        $course = Course::where('subject', $subject)->first();
        return $course != null ?
            response()->json(true, 200) :
            response()->json(false, 200);
    }

    public function findByDescription(string $description){
        $course = Course::with(['users', 'timeslots'])
            ->where('description', 'LIKE', '%'. $description .'%')->get();
        return $course;
    }

    public function save (Request $request) : JsonResponse {
        $request = $this->parseRequest($request);
        DB::beginTransaction();
        try {
            $course = Course::create($request->all());

            //save date
            if (isset($request['timeslots']) && is_array(['timeslots'])) {
                foreach ($request['timeslots'] as $dt) {
                    $date = Timeslots::firstOrNew([
                        'date' => $dt['date']
                    ]);
                    $course->timeslots()->save($date);
                }
            }

            //save user
            if (isset($request['users']) && is_array(['users'])) {
                foreach ($request['users'] as $usr) {
                    $user = User::firstOrNew([
                        'firstname' => $usr['firstname'],
                        'lastname' => $usr['lastname'],
                        'email' => $usr['email'],
                        'description' => $usr['description'],
                        'password' => $usr['password'],
                        'role' => $usr['role'],
                    ]);

                    $course->users()->save($user);
                }
            }

            DB::commit();
            return response()->json($course, 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json('Saving course failed:(' .$e->getMessage(), 420);
        }
    }

    public function update(Request $request, string $subject) : JsonResponse
    {
        DB::beginTransaction();
        try {
            $course = Course::with(['users', 'timeslots'])
                ->where('subject', $subject)->first();
            if ($course != null) {
                $request = $this->parseRequest($request);
                $course->update($request->all());
                //delete all old dates
                $course->timeslots()->delete();
                // save dates
                if (isset($request['timeslots']) && is_array($request['timeslots'])) {
                    foreach ($request['timeslots'] as $dt) {
                        $date = Timeslots::firstOrNew(['date'=>$dt['date']]);
                        $course->timeslots()->save($date);
                    }
                }
                //update users
                $ids = [];
                if (isset($request['users']) && is_array($request['users'])) {
                    foreach ($request['users'] as $usr) {
                        array_push($ids,$usr['id']);
                    }
                }
                $course->users()->sync($ids);
                $course->save();
            }
            DB::commit();
            $course1 = Course::with(['users', 'timeslots'])
                ->where('subject', $subject)->first();
            // return a vaild http response
            return response()->json($course1, 201);
        }
        catch (\Exception $e) {
            // rollback all queries
            DB::rollBack();
            return response()->json("updating Course failed: " . $e->getMessage(), 420);
        }
    }

    public function delete(string $subject) : JsonResponse
    {
        $course = Course::where('subject', $subject)->first();
        if ($course != null) {
            $course->delete();
        } else
            throw new \Exception("Course couldn't be deleted - it does not exist");
        return response()->json('Course (' . $subject . ') successfully deleted', 200);
    }

    private function parseRequest (Request $request) : Request {
        $date = new \DateTime($request->published);
        $request['published'] = $date;
        return $request;
    }

    public function show(Course $course) {
        return view('courses.show', compact('course'));
    }
}
