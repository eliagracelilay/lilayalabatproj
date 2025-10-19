import React, { useState, useEffect } from 'react';
import AdminLayout from './AdminLayout';

const StudentsIndex = () => {
    const [students, setStudents] = useState([]);
    const [departments, setDepartments] = useState([]);
    const [courses, setCourses] = useState([]);
    const [filters, setFilters] = useState({
        q: '',
        department_filter: '',
        course_filter: ''
    });
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);

    useEffect(() => {
        fetchStudents();
        fetchDepartments();
        fetchCourses();
    }, [filters]);

    const fetchStudents = async () => {
        try {
            setLoading(true);
            const params = new URLSearchParams(filters);
            console.log('Fetching students with params:', params.toString());
            
            const response = await fetch(`/api/admin/students?${params}`, {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                credentials: 'same-origin'
            });
            
            console.log('Response status:', response.status);
            console.log('Response headers:', response.headers);
            
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            
            const data = await response.json();
            console.log('API Response:', data); // Debug log
            
            if (data.error) {
                console.error('API Error:', data.error);
                setStudents([]);
            } else {
                setStudents(data.students || []);
            }
        } catch (error) {
            console.error('Error fetching students:', error);
            setError(error.message);
            setStudents([]);
        } finally {
            setLoading(false);
        }
    };

    const fetchDepartments = async () => {
        try {
            const response = await fetch('/api/departments', {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                credentials: 'same-origin'
            });
            const data = await response.json();
            setDepartments(data || []);
        } catch (error) {
            console.error('Error fetching departments:', error);
        }
    };

    const fetchCourses = async () => {
        try {
            const response = await fetch('/api/courses', {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                credentials: 'same-origin'
            });
            const data = await response.json();
            setCourses(data || []);
        } catch (error) {
            console.error('Error fetching courses:', error);
        }
    };

    const handleFilterChange = (key, value) => {
        setFilters(prev => ({
            ...prev,
            [key]: value
        }));
    };

    const clearFilters = () => {
        setFilters({
            q: '',
            department_filter: '',
            course_filter: ''
        });
    };

    const hasActiveFilters = Object.values(filters).some(value => value !== '');

    const handleArchive = async (studentId) => {
        if (confirm('Archive this student?')) {
            try {
                const response = await fetch(`/api/admin/students/${studentId}/archive`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    credentials: 'same-origin'
                });

                const data = await response.json();

                if (response.ok) {
                    alert('Student archived successfully!');
                    fetchStudents(); // Refresh the list
                } else {
                    alert('Error: ' + (data.message || 'Something went wrong'));
                }
            } catch (error) {
                console.error('Error archiving student:', error);
                alert('Error archiving student. Please try again.');
            }
        }
    };

    return (
        <AdminLayout>
            {error && (
                <div className="alert alert-danger mb-3">
                    <strong>Error:</strong> {error}
                </div>
            )}
            <div className="d-flex justify-content-between align-items-center mb-3">
                <h4 className="mb-0">Students</h4>
                <a href="/admin/students/create" className="btn btn-sm btn-brand">＋ New Student</a>
            </div>

            <form className="student-filters">
                <div className="row filter-row">
                    <div className="col-auto">
                        <input 
                            type="text" 
                            value={filters.q}
                            onChange={(e) => handleFilterChange('q', e.target.value)}
                            className="form-control filter-input" 
                            placeholder="Search by ID/Name" 
                        />
                    </div>
                    <div className="col-auto">
                        <select 
                            value={filters.department_filter}
                            onChange={(e) => handleFilterChange('department_filter', e.target.value)}
                            className="form-select filter-select"
                        >
                            <option value="">All Departments</option>
                            {departments.map(dept => (
                                <option key={dept.id} value={dept.id}>{dept.name}</option>
                            ))}
                        </select>
                    </div>
                    <div className="col-auto">
                        <select 
                            value={filters.course_filter}
                            onChange={(e) => handleFilterChange('course_filter', e.target.value)}
                            className="form-select filter-select"
                        >
                            <option value="">All Courses</option>
                            {courses.map(course => (
                                <option key={course.id} value={course.id}>{course.title}</option>
                            ))}
                        </select>
                    </div>
                    {hasActiveFilters && (
                        <div className="col-auto">
                            <button 
                                type="button"
                                onClick={clearFilters}
                                className="btn btn-outline-danger clear-filters-btn"
                            >
                                Clear Filters
                            </button>
                        </div>
                    )}
                </div>
            </form>

            <div className="students-table">
                <div className="student-card card shadow-sm">
                    <div className="table-responsive">
                        <table className="table align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Department</th>
                                    <th>Course</th>
                                    <th>Academic Year</th>
                                    <th>Status</th>
                                    <th className="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                {loading ? (
                                    <tr>
                                        <td colSpan="7" className="text-center py-4">
                                            <div className="spinner-border spinner-border-sm" role="status">
                                                <span className="visually-hidden">Loading...</span>
                                            </div>
                                        </td>
                                    </tr>
                                ) : students.length > 0 ? (
                                    students.map(student => (
                                        <tr key={student.id}>
                                            <td className="student-name">
                                                {student.full_name}
                                                {student.suffix && <span className="text-muted"> {student.suffix}</span>}
                                            </td>
                                            <td>{student.email || '—'}</td>
                                            <td>{student.department?.name || '—'}</td>
                                            <td>{student.course?.title || '—'}</td>
                                            <td>{student.academic_year ? `${student.academic_year.start_year} - ${student.academic_year.end_year}` : '—'}</td>
                                            <td>
                                                <span className={`status-badge status-${student.status?.toLowerCase()}`}>
                                                    {student.status}
                                                </span>
                                            </td>
                                            <td className="text-end action-buttons">
                                                <a href={`/admin/students/${student.id}/edit`} className="btn btn-sm btn-edit">
                                                    Edit
                                                </a>
                                                <button 
                                                    onClick={() => handleArchive(student.id)}
                                                    className="btn btn-sm btn-archive"
                                                >
                                                    Archive
                                                </button>
                                            </td>
                                        </tr>
                                    ))
                                ) : (
                                    <tr>
                                        <td colSpan="7" className="empty-state">
                                            <div className="empty-icon">🎓</div>
                                            <div className="empty-message">No students found</div>
                                            <div className="empty-submessage">Try adjusting your search criteria</div>
                                        </td>
                                    </tr>
                                )}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </AdminLayout>
    );
};

export default StudentsIndex;
