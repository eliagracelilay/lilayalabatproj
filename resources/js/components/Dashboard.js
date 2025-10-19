import React from 'react';
import AdminLayout from './AdminLayout';

const Dashboard = ({ stats }) => {

    return (
        <AdminLayout>
            <div className="dashboard-container">
                {/* Main Statistics Cards */}
                <div className="row g-3 mb-4 stats-grid">
                    <div className="col-12 col-md-4">
                        <div className="stats-card">
                            <div className="stats-header">
                                <div className="stats-label">System Health</div>
                                <div className="stats-icon">📈</div>
                            </div>
                            <div className="stats-value">99.9%</div>
                            <div className="stats-change">
                                <span className="stats-trend">↑ +0.1% Uptime this month</span>
                            </div>
                        </div>
                    </div>
                    <div className="col-12 col-md-4">
                        <div className="stats-card">
                            <div className="stats-header">
                                <div className="stats-label">Active Users</div>
                                <div className="stats-icon">👥</div>
                            </div>
                            <div className="stats-value">{(stats?.students || 0) + (stats?.faculties || 0)}</div>
                            <div className="stats-change">
                                <span className="stats-trend">↑ +0.1% Students + Faculty</span>
                            </div>
                        </div>
                    </div>
                    <div className="col-12 col-md-4">
                        <div className="stats-card">
                            <div className="stats-header">
                                <div className="stats-label">Calendar</div>
                                <div className="stats-icon">📅</div>
                            </div>
                            <div className="stats-description">No upcoming events</div>
                        </div>
                    </div>
                </div>


                {/* Academic Overview Section */}
                <div className="overview-section">
                    <div className="overview-card">
                        <div className="overview-title">Academic Overview</div>
                        <div className="overview-grid">
                            <a className="overview-item" href="/admin/students">
                                <div className="overview-item-content">
                                    <div className="overview-icon student-icon">🎓</div>
                                    <div className="overview-label">Students</div>
                                </div>
                                <div className="overview-count">{stats?.students ?? 0}</div>
                            </a>
                            <a className="overview-item" href="/admin/faculties">
                                <div className="overview-item-content">
                                    <div className="overview-icon faculty-icon">👥</div>
                                    <div className="overview-label">Faculty</div>
                                </div>
                                <div className="overview-count">{stats?.faculties ?? 0}</div>
                            </a>
                            <a className="overview-item" href="/admin/courses">
                                <div className="overview-item-content">
                                    <div className="overview-icon course-icon">📚</div>
                                    <div className="overview-label">Courses</div>
                                </div>
                                <div className="overview-count">{stats?.courses ?? 0}</div>
                            </a>
                            <a className="overview-item" href="/admin/departments">
                                <div className="overview-item-content">
                                    <div className="overview-icon department-icon">🏢</div>
                                    <div className="overview-label">Departments</div>
                                </div>
                                <div className="overview-count">{stats?.departments ?? 0}</div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </AdminLayout>
    );
};

export default Dashboard;
