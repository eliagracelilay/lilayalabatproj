import React, { useState, useEffect } from 'react';
import AdminLayout from './AdminLayout';

const ReportsIndex = () => {
    const [results, setResults] = useState([]);
    const [departments, setDepartments] = useState([]);
    const [courses, setCourses] = useState([]);
    const [filters, setFilters] = useState({
        type: 'students',
        department_id: '',
        course_id: ''
    });
    const [summary, setSummary] = useState({});
    const [loading, setLoading] = useState(false);

    useEffect(() => {
        fetchDepartments();
        fetchCourses();
    }, []);

    useEffect(() => {
        if (filters.type) {
            generateReport();
        }
    }, [filters]);

    const fetchDepartments = async () => {
        try {
            const response = await fetch('/api/departments');
            const data = await response.json();
            setDepartments(data || []);
        } catch (error) {
            console.error('Error fetching departments:', error);
        }
    };

    const fetchCourses = async () => {
        try {
            const response = await fetch('/api/courses');
            const data = await response.json();
            setCourses(data || []);
        } catch (error) {
            console.error('Error fetching courses:', error);
        }
    };

    const generateReport = async () => {
        try {
            setLoading(true);
            const params = new URLSearchParams(filters);
            const response = await fetch(`/api/admin/reports?${params}`);
            const data = await response.json();
            
            console.log('Reports API Response:', data); // Debug log
            
            if (data.error) {
                console.error('Reports API Error:', data.error);
            }
            
            setResults(data.results || []);
            setSummary(data.summary || {});
        } catch (error) {
            console.error('Error generating report:', error);
        } finally {
            setLoading(false);
        }
    };

    const handleFilterChange = (key, value) => {
        setFilters(prev => ({
            ...prev,
            [key]: value
        }));
    };

    const handleGenerateDocument = (e) => {
        e.preventDefault();
        generateReport();
    };

    const getTableHeaders = () => {
        switch (filters.type) {
            case 'students':
                return ['Name', 'Email', 'Department', 'Course', 'Academic Year', 'Status'];
            case 'faculties':
                return ['Name', 'Email', 'Department', 'Position', 'Status'];
            case 'courses':
                return ['Code', 'Title', 'Department', 'Status'];
            default:
                return ['Code', 'Name', 'Location', 'Status'];
        }
    };

    const renderTableRow = (row) => {
        switch (filters.type) {
            case 'students':
                return (
                    <>
                        <td className="student-name">
                            {row.full_name}
                            {row.suffix && <span className="text-muted"> {row.suffix}</span>}
                        </td>
                        <td>{row.email || '—'}</td>
                        <td>{row.department?.name || '—'}</td>
                        <td>{row.course?.title || '—'}</td>
                        <td>{row.academic_year ? `${row.academic_year.start_year} - ${row.academic_year.end_year}` : '—'}</td>
                        <td><span className={`status-text status-${row.status?.toLowerCase()}`}>{row.status}</span></td>
                    </>
                );
            case 'faculties':
                return (
                    <>
                        <td className="faculty-name">
                            {row.full_name}
                            {row.suffix && <span className="text-muted"> {row.suffix}</span>}
                        </td>
                        <td>{row.email || '—'}</td>
                        <td>{row.department?.name || '—'}</td>
                        <td>{row.position || '—'}</td>
                        <td><span className={`status-text status-${row.status?.toLowerCase()}`}>{row.status}</span></td>
                    </>
                );
            case 'courses':
                return (
                    <>
                        <td>{row.code}</td>
                        <td>{row.title}</td>
                        <td>{row.department?.name || '—'}</td>
                        <td><span className={`status-text status-${row.status?.toLowerCase()}`}>{row.status}</span></td>
                    </>
                );
            default:
                return (
                    <>
                        <td>{row.code}</td>
                        <td>{row.name}</td>
                        <td>{row.location}</td>
                        <td><span className={`status-text status-${row.status?.toLowerCase()}`}>{row.status}</span></td>
                    </>
                );
        }
    };

    return (
        <AdminLayout>
            <div className="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h4 className="mb-0">Reports</h4>
                    <div className="text-muted small">Generate summaries and export data</div>
                </div>
            </div>

            <div className="reports-container">
                <div className="report-settings">
                    <div className="report-pill">⚙️ Report Settings</div>
                    <div className="report-panel">
                        <form onSubmit={handleGenerateDocument} className="row g-3">
                            <div className="col-md-4">
                                <label className="form-label">Report Type</label>
                                <select 
                                    value={filters.type}
                                    onChange={(e) => handleFilterChange('type', e.target.value)}
                                    className="form-select"
                                >
                                    <option value="students">Student Report</option>
                                    <option value="faculties">Faculty Report</option>
                                    <option value="courses">Course Report</option>
                                    <option value="departments">Department Report</option>
                                </select>
                            </div>
                            <div className="col-md-4">
                                <label className="form-label">Filter by Department</label>
                                <select 
                                    value={filters.department_id}
                                    onChange={(e) => handleFilterChange('department_id', e.target.value)}
                                    className="form-select"
                                >
                                    <option value="">All</option>
                                    {departments.map(dept => (
                                        <option key={dept.id} value={dept.id}>{dept.name}</option>
                                    ))}
                                </select>
                            </div>
                            <div className="col-md-4">
                                <label className="form-label">Filter by Course</label>
                                <select 
                                    value={filters.course_id}
                                    onChange={(e) => handleFilterChange('course_id', e.target.value)}
                                    className="form-select"
                                >
                                    <option value="">All</option>
                                    {courses.map(course => (
                                        <option key={course.id} value={course.id}>{course.title}</option>
                                    ))}
                                </select>
                            </div>
                            <div className="col-12 d-flex justify-content-end">
                                <button type="submit" className="report-generate">
                                    Generate Document
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                {/* Applied Filters section removed per request */}

                <div className="report-table">
                    <div className="report-card card">
                        <div className="table-responsive">
                            <table className="table align-middle mb-0">
                                <thead>
                                    <tr>
                                        {getTableHeaders().map(header => (
                                            <th key={header}>{header}</th>
                                        ))}
                                    </tr>
                                </thead>
                                <tbody>
                                    {loading ? (
                                        <tr>
                                            <td colSpan={getTableHeaders().length} className="text-center py-4">
                                                <div className="spinner-border spinner-border-sm" role="status">
                                                    <span className="visually-hidden">Loading...</span>
                                                </div>
                                            </td>
                                        </tr>
                                    ) : results.length > 0 ? (
                                        results.map((row, index) => (
                                            <tr key={index}>
                                                {renderTableRow(row)}
                                            </tr>
                                        ))
                                    ) : (
                                        <tr>
                                            <td colSpan={getTableHeaders().length} className="empty-state">
                                                <div className="empty-icon">📊</div>
                                                <div className="empty-message">No report data found</div>
                                                <div className="empty-submessage">Try adjusting your filters or report type</div>
                                            </td>
                                        </tr>
                                    )}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </AdminLayout>
    );
};

export default ReportsIndex;
