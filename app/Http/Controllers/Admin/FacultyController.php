<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faculty;
use App\Models\Department;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class FacultyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $q = request('q');
        $faculties = Faculty::with('department')
            ->when($q, function($query) use ($q) {
                $query->where('employee_no', 'like', "%$q%");
                $query->orWhere('first_name', 'like', "%$q%");
                $query->orWhere('last_name', 'like', "%$q%");
            })
            ->orderBy('last_name')
            ->paginate(10)
            ->withQueryString();

        return view('admin.faculties.index', compact('faculties','q'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $departments = Department::orderBy('name')->pluck('name','id');
        return view('admin.faculties.create', compact('departments'));
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
            'employee_no' => 'required|string|max:50|unique:faculties,employee_no',
            'first_name'  => 'required|string|max:100',
            'last_name'   => 'required|string|max:100',
            'suffix'      => 'nullable|string|max:20',
            'sex'         => 'nullable|string|max:16',
            'email'       => 'required|email|max:255|unique:users,email',
            'contact_number' => 'nullable|string|max:50',
            'address'     => 'nullable|string',
            'title'       => 'nullable|string|max:100',
            'position'    => 'nullable|string|max:100',
            'department_id' => 'nullable|exists:departments,id',
            'status'      => 'nullable|string|max:24',
        ]);

        // Create linked user and attach faculty role
        $user = User::create([
            'name' => $data['first_name'].' '.$data['last_name'],
            'email' => $data['email'],
            'password' => Hash::make('password'),
        ]);
        if ($user) {
            if ($role = Role::where('name', 'faculty')->first()) {
                $user->roles()->syncWithoutDetaching([$role->id]);
            }
            $data['user_id'] = $user->id;
        }

        Faculty::create($data);

        return redirect()->route('admin.faculties.index')->with('success', 'Faculty created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Faculty  $faculty
     * @return \Illuminate\Http\Response
     */
    public function show(Faculty $faculty)
    {
        return redirect()->route('admin.faculties.edit', $faculty);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Faculty  $faculty
     * @return \Illuminate\Http\Response
     */
    public function edit(Faculty $faculty)
    {
        $departments = Department::orderBy('name')->pluck('name','id');
        return view('admin.faculties.edit', compact('faculty','departments'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Faculty  $faculty
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Faculty $faculty)
    {
        $data = $request->validate([
            'employee_no' => 'required|string|max:50|unique:faculties,employee_no,' . $faculty->id,
            'first_name'  => 'required|string|max:100',
            'last_name'   => 'required|string|max:100',
            'suffix'      => 'nullable|string|max:20',
            'sex'         => 'nullable|string|max:16',
            'email'       => 'required|email|max:255|unique:users,email,' . ($faculty->user_id ?? 'NULL'),
            'contact_number' => 'nullable|string|max:50',
            'address'     => 'nullable|string',
            'title'       => 'nullable|string|max:100',
            'position'    => 'nullable|string|max:100',
            'department_id' => 'nullable|exists:departments,id',
            'status'      => 'nullable|string|max:24',
        ]);

        // Ensure linked user exists and is updated
        if ($faculty->user_id) {
            $user = User::find($faculty->user_id);
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
            if ($role = Role::where('name', 'faculty')->first()) {
                $user->roles()->syncWithoutDetaching([$role->id]);
            }
            $data['user_id'] = $user->id;
        }

        $faculty->update($data);

        return redirect()->route('admin.faculties.index')->with('success', 'Faculty updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Faculty  $faculty
     * @return \Illuminate\Http\Response
     */
    public function destroy(Faculty $faculty)
    {
        $faculty->delete();
        return redirect()->route('admin.settings.index')->with(['success' => 'Faculty archived.', 'tab' => 'security']);
    }

    public function restore($id)
    {
        $faculty = Faculty::withTrashed()->findOrFail($id);
        if ($faculty->trashed()) {
            $faculty->restore();
            return redirect()->route('admin.settings.index')->with(['success' => 'Faculty restored.', 'tab' => 'security']);
        }
        return back();
    }
}

