<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Faculty;
use App\Models\Course;
use App\Models\Department;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            'students' => Student::count(),
            'faculties' => Faculty::count(),
            'courses' => Course::count(),
            'departments' => Department::count(),
        ];

        return view('admin.dashboard', $data);
    }
}
