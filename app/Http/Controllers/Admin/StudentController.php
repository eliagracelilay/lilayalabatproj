<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Department;
use App\Models\Course;
use App\Models\AcademicYear;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $q = request('q');
        $students = Student::with('department')
            ->when($q, function($query) use ($q) {
                $query->where('student_no', 'like', "%$q%");
                $query->orWhere('first_name', 'like', "%$q%");
                $query->orWhere('last_name', 'like', "%$q%");
            })
            ->orderBy('last_name')
            ->paginate(10)
            ->withQueryString();

        return view('admin.students.index', compact('students', 'q'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $departments = Department::orderBy('name')->pluck('name','id');
        $courses = Course::orderBy('title')->pluck('title','id');
        $academicYears = AcademicYear::orderByDesc('start_year')->get()->mapWithKeys(function($ay){
            return [$ay->id => $ay->start_year.' - '.$ay->end_year];
        });
        return view('admin.students.create', compact('departments','courses','academicYears'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'student_no' => 'required|string|max:50|unique:students,student_no',
            'first_name' => 'required|string|max:100',
            'last_name'  => 'required|string|max:100',
            'suffix'     => 'nullable|string|max:20',
            'sex'        => 'nullable|string|max:16',
            'birthdate'  => 'nullable|date',
            'email'      => 'required|email|max:255|unique:users,email',
            'contact_number' => 'nullable|string|max:50',
            'address'    => 'nullable|string',
            'department_id' => 'nullable|exists:departments,id',
            'course_id'  => 'nullable|exists:courses,id',
            'academic_year_id' => 'nullable|exists:academic_years,id',
            'year_level' => 'nullable|integer|min:1|max:6',
            'status'     => 'nullable|string|max:24',
        ]);

        // Create a linked user account (required by schema)
        $user = User::create([
            'name' => $data['first_name'].' '.$data['last_name'],
            'email' => $data['email'],
            'password' => Hash::make('password'),
        ]);
        if ($user) {
            if ($role = Role::where('name', 'student')->first()) {
                $user->roles()->syncWithoutDetaching([$role->id]);
            }
            $data['user_id'] = $user->id;
        }

        Student::create($data);

        return redirect()->route('admin.students.index')->with('success', 'Student created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function show(Student $student)
    {
        return redirect()->route('admin.students.edit', $student);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function edit(Student $student)
    {
        $departments = Department::orderBy('name')->pluck('name','id');
        $courses = Course::orderBy('title')->pluck('title','id');
        $academicYears = AcademicYear::orderByDesc('start_year')->get()->mapWithKeys(function($ay){
            return [$ay->id => $ay->start_year.' - '.$ay->end_year];
        });
        return view('admin.students.edit', compact('student','departments','courses','academicYears'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Student $student)
    {
        $data = $request->validate([
            'student_no' => 'required|string|max:50|unique:students,student_no,' . $student->id,
            'first_name' => 'required|string|max:100',
            'last_name'  => 'required|string|max:100',
            'suffix'     => 'nullable|string|max:20',
            'sex'        => 'nullable|string|max:16',
            'birthdate'  => 'nullable|date',
            'email'      => 'required|email|max:255|unique:users,email,' . ($student->user_id ?? 'NULL'),
            'contact_number' => 'nullable|string|max:50',
            'address'    => 'nullable|string',
            'department_id' => 'nullable|exists:departments,id',
            'course_id'  => 'nullable|exists:courses,id',
            'academic_year_id' => 'nullable|exists:academic_years,id',
            'year_level' => 'nullable|integer|min:1|max:6',
            'status'     => 'nullable|string|max:24',
        ]);

        // Ensure linked user exists and is updated
        if ($student->user_id) {
            $user = User::find($student->user_id);
            if ($user) {
                $user->update([
                    'name' => $data['first_name'].' '.$data['last_name'],
                    'email' => $data['email'],
                ]);
            }
        } else {
            $user = User::create([
                'name' => $data['first_name'].' '.$data['last_name'],
                'email' => $data['email'],
                'password' => Hash::make('password'),
            ]);
            if ($role = Role::where('name', 'student')->first()) {
                $user->roles()->syncWithoutDetaching([$role->id]);
            }
            $data['user_id'] = $user->id;
        }

        $student->update($data);

        return redirect()->route('admin.students.index')->with('success', 'Student updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy(Student $student)
    {
        $student->delete();
        return redirect()->route('admin.settings.index')->with(['success' => 'Student archived.', 'tab' => 'security']);
    }

    public function restore($id)
    {
        $student = Student::withTrashed()->findOrFail($id);
        if ($student->trashed()) {
            $student->restore();
            return redirect()->route('admin.settings.index')->with(['success' => 'Student restored.', 'tab' => 'security']);
        }
        return back();
    }
}

