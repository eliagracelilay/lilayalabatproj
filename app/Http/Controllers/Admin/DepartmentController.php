<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $q = request('q');
        $departments = Department::when($q, function($query) use ($q) {
                $query->where('code', 'like', "%$q%");
                $query->orWhere('name', 'like', "%$q%");
            })
            ->orderBy('code')
            ->paginate(10)
            ->withQueryString();

        return view('admin.departments.index', compact('departments','q'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.departments.create');
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
            'code' => 'required|string|max:20|unique:departments,code',
            'name' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'status' => 'nullable|string|max:24',
        ]);

        Department::create($data);

        return redirect()->route('admin.departments.index')->with('success', 'Department created.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function edit(Department $department)
    {
        return view('admin.departments.edit', compact('department'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Department $department)
    {
        $data = $request->validate([
            'code' => 'required|string|max:20|unique:departments,code,' . $department->id,
            'name' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'status' => 'nullable|string|max:24',
        ]);

        $department->update($data);

        return redirect()->route('admin.departments.index')->with('success', 'Department updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function destroy(Department $department)
    {
        $department->delete();
        return redirect()->route('admin.departments.index')->with('success', 'Department archived.');
    }

    public function restore($id)
    {
        $department = Department::withTrashed()->findOrFail($id);
        if ($department->trashed()) {
            $department->restore();
            return back()->with('success', 'Department restored.');
        }
        return back();
    }
}
