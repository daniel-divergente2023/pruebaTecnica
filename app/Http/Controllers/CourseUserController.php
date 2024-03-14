<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CourseUserController extends Controller
{
    public function assignCourseToUser(Request $request, $userId)
    {
        $user = User::findOrFail($userId);
        $user->courses()->attach($request->course_id);
        return response()->json($user->courses, 201);
    }
}
