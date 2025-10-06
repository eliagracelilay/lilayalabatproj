<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Department;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $q = request('q');
        $courses = Course::with('department')
            ->when($q, function($query) use ($q) {
                $query->where('code', 'like', "%$q%");
                $query->orWhere('title', 'like', "%$q%");
            })
            ->orderBy('code')
            ->paginate(10)
            ->withQueryString();

        return view('admin.courses.index', compact('courses','q'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $departments = Department::orderBy('name')->pluck('name','id');
        return view('admin.courses.create', compact('departments'));
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
            'department_id' => 'required|exists:departments,id',
            'code' => 'required|string|max:50|unique:courses,code',
            'title' => 'required|string|max:255',
            'units' => 'nullable|integer|min:1|max:10',
            'status' => 'nullable|string|max:24',
        ]);

        Course::create($data);

        return redirect()->route('admin.courses.index')->with('success', 'Course created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function show(Course $course)
    {
        return redirect()->route('admin.courses.edit', $course);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function edit(Course $course)
    {
        $departments = Department::orderBy('name')->pluck('name','id');
        return view('admin.courses.edit', compact('course','departments'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Course $course)
    {
        $data = $request->validate([
            'department_id' => 'required|exists:departments,id',
            'code' => 'required|string|max:50|unique:courses,code,' . $course->id,
            'title' => 'required|string|max:255',
            'units' => 'nullable|integer|min:1|max:10',
            'status' => 'nullable|string|max:24',
        ]);

        $course->update($data);

        return redirect()->route('admin.courses.index')->with('success', 'Course updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function destroy(Course $course)
    {
        $course->delete();
        return redirect()->route('admin.settings.index')->with(['success' => 'Course archived.', 'tab' => 'security']);
    }

    public function restore($id)
    {
        $course = Course::withTrashed()->findOrFail($id);
        if ($course->trashed()) {
            $course->restore();
            return redirect()->route('admin.settings.index')->with(['success' => 'Course restored.', 'tab' => 'security']);
        }
        return back();
    }
}

