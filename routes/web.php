<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\StudentController as AdminStudentController;
use App\Http\Controllers\Admin\FacultyController as AdminFacultyController;
use App\Http\Controllers\Admin\CourseController as AdminCourseController;
use App\Http\Controllers\Admin\DepartmentController as AdminDepartmentController;
use App\Http\Controllers\Admin\ReportController as AdminReportController;
use App\Http\Controllers\Admin\SettingsController as AdminSettingsController;
use App\Http\Controllers\Admin\AcademicYearController as AdminAcademicYearController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('admin.dashboard');
    }
    return view('welcome');
});

Auth::routes();

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [AdminProfileController::class, 'index'])->name('profile');
    Route::resource('students', AdminStudentController::class);
    Route::resource('faculties', AdminFacultyController::class);
    Route::resource('courses', AdminCourseController::class);
    Route::resource('departments', AdminDepartmentController::class);
    Route::get('reports', [AdminReportController::class, 'index'])->name('reports.index');
    Route::get('reports/export/{type}', [AdminReportController::class, 'export'])->name('reports.export');
    Route::get('settings', [AdminSettingsController::class, 'index'])->name('settings.index');
    Route::post('academic-years/{id}/restore', [AdminAcademicYearController::class, 'restore'])->name('academic-years.restore');
    Route::post('students/{id}/restore', [AdminStudentController::class, 'restore'])->name('students.restore');
    Route::post('faculties/{id}/restore', [AdminFacultyController::class, 'restore'])->name('faculties.restore');
    Route::post('courses/{id}/restore', [AdminCourseController::class, 'restore'])->name('courses.restore');
    Route::post('departments/{id}/restore', [AdminDepartmentController::class, 'restore'])->name('departments.restore');
    Route::resource('academic-years', AdminAcademicYearController::class)->parameters([
        'academic-years' => 'academicYear'
    ])->except(['show']);
});
