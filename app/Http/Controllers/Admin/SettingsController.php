<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AcademicYear;
use App\Models\Student;
use App\Models\Faculty;
use App\Models\Course;
use App\Models\Department;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        $years = AcademicYear::orderByDesc('start_year')->get();
        $archivedYears = AcademicYear::onlyTrashed()->orderByDesc('start_year')->get();
        $archivedStudents = Student::onlyTrashed()->orderBy('last_name')->get();
        $archivedFaculties = Faculty::onlyTrashed()->orderBy('last_name')->get();
        $archivedCourses = Course::onlyTrashed()->orderBy('code')->get();
        $archivedDepartments = Department::onlyTrashed()->orderBy('code')->get();
        return view('admin.settings.index', compact('years', 'archivedYears', 'archivedStudents', 'archivedFaculties', 'archivedCourses', 'archivedDepartments'));
    }
}
