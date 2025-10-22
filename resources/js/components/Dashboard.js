import React, { useEffect, useState } from 'react';
import AdminLayout from './AdminLayout';

const Dashboard = ({ stats }) => {
    const user = (typeof window !== 'undefined' && window.adminUser) ? window.adminUser : null;
    const initialStats = (typeof window !== 'undefined' && window.adminStats) ? window.adminStats : stats;
    const [liveStats, setLiveStats] = useState(initialStats || {});
    const [activity, setActivity] = useState({ today: { students_added: 0, faculties_added: 0, departments_added: 0, courses_added: 0 }, ts: null });

    // Derived values
    const activeUsers = (liveStats?.students ?? initialStats?.students ?? 0) + (liveStats?.faculties ?? initialStats?.faculties ?? 0);

    // Fetch today's activity and refresh periodically
    useEffect(() => {
        let isMounted = true;

        const fetchActivity = async () => {
            try {
                const res = await fetch('/api/admin/dashboard-activity', {
                    headers: { 'Accept': 'application/json' },
                    credentials: 'same-origin'
                });
                if (!res.ok) return;
                const data = await res.json();
                if (isMounted) setActivity(data);
            } catch (e) {
                // silent fail
            }
        };

        const fetchStats = async () => {
            try {
                const res = await fetch('/api/admin/dashboard-stats', {
                    headers: { 'Accept': 'application/json' },
                    credentials: 'same-origin'
                });
                if (!res.ok) return;
                const data = await res.json();
                if (isMounted) setLiveStats(data);
            } catch (e) {
                // silent fail
            }
        };

        fetchActivity();
        fetchStats();
        const id = setInterval(() => { fetchActivity(); fetchStats(); }, 10000);
        return () => { isMounted = false; clearInterval(id); };
    }, []);

    return (
        <AdminLayout>
            <div className="dash-wrap">
                {/* Header */}
                <div className="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h1 className="mb-1">Hello, Jasmine!</h1>
                        <div className="text-muted">Welcome Back!</div>
                    </div>
                </div>

                {/* Top stats cards - Active Users / Department / Calendar */}
                <div className="row g-3 mb-4">
                    <div className="col-12 col-md-4">
                        <div className="kpi kpi-purple">
                            <div className="kpi-icon" title="Active Users" aria-hidden="true">
                                {/* Users icon */}
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M16 11c1.657 0 3-1.79 3-4s-1.343-4-3-4-3 1.79-3 4 1.343 4 3 4zM8 11c1.657 0 3-1.79 3-4S9.657 3 8 3 5 4.79 5 7s1.343 4 3 4zm0 2c-2.673 0-8 1.337-8 4v2h10.5c-.64-.84-1-1.81-1-2.83 0-1.43.68-2.72 1.78-3.61C10.41 12.17 9.08 13 8 13zm8 0c-2.21 0-6 1.1-6 3.5S13.79 20 16 20s6-1.1 6-3.5S18.21 13 16 13z" fill="currentColor"/></svg>
                            </div>
                            <div className="kpi-title">Active Users</div>
                            <div className="kpi-sub">Students + Faculty</div>
                            <div className="kpi-value">{activeUsers}</div>
                        </div>
                    </div>
                    <div className="col-12 col-md-4">
                        <div className="kpi kpi-blue">
                            <div className="kpi-icon" title="Departments" aria-hidden="true">
                                {/* Departments/share icon */}
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M18 8a3 3 0 10-2.83-4H9a3 3 0 100 2h6.17A3 3 0 0018 8zM6 22a3 3 0 100-6 3 3 0 000 6zm12 0a3 3 0 100-6 3 3 0 000 6zM8.59 8.59L7.17 10l4.41 4.41 1.41-1.41L8.59 8.59zM12.41 9L11 10.41 15.59 15 17 13.59 12.41 9z" fill="currentColor"/></svg>
                            </div>
                            <div className="kpi-title">Department</div>
                            <div className="kpi-sub">Total Department</div>
                            <div className="kpi-value">{liveStats?.departments ?? initialStats?.departments ?? 0}</div>
                        </div>
                    </div>
                    <div className="col-12 col-md-4">
                        <div className="kpi kpi-pink">
                            <div className="kpi-icon" title="Calendar" aria-hidden="true">
                                {/* Calendar icon */}
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M7 2a1 1 0 011 1v1h8V3a1 1 0 112 0v1h1a2 2 0 012 2v13a2 2 0 01-2 2H4a2 2 0 01-2-2V6a2 2 0 012-2h1V3a1 1 0 112 0v1zm13 7H4v10h16V9zM6 11h3v3H6v-3zm5 0h3v3h-3v-3zm5 0h3v3h-3v-3z" fill="currentColor"/></svg>
                            </div>
                            <div className="kpi-title">Calendar</div>
                            <div className="kpi-sub">{new Date().toLocaleString('en-US', { month: 'long' })}</div>
                            <div className="kpi-value" style={{fontSize:'1.25rem'}}>Today {new Date().getDate()}</div>
                        </div>
                    </div>
                </div>

                {/* Recent Activities & Notifications in coral panel */}
                <div className="coral-panel">
                    <div className="row g-3">
                        <div className="col-12 col-lg-6">
                            <div className="inner-card">
                                <div className="inner-header d-flex justify-content-between align-items-center">
                                    <div className="inner-title">Recent Activities</div>
                                    <div className="inner-trend">↗ +0.1%</div>
                                </div>
                                <ul className="activity-list">
                                    <li><span className="a-icon">➕</span> Added <strong>{activity.today?.students_added ?? 0} Student{(activity.today?.students_added ?? 0) === 1 ? '' : 's'}</strong></li>
                                    <li><span className="a-icon">➕</span> Added <strong>{activity.today?.faculties_added ?? 0} Faculty</strong></li>
                                    <li><span className="a-icon">➕</span> Added <strong>{activity.today?.departments_added ?? 0} Department{(activity.today?.departments_added ?? 0) === 1 ? '' : 's'}</strong></li>
                                    <li><span className="a-icon">➕</span> Added <strong>{activity.today?.courses_added ?? 0} Course{(activity.today?.courses_added ?? 0) === 1 ? '' : 's'}</strong></li>
                                </ul>
                            </div>
                        </div>
                        <div className="col-12 col-lg-6">
                            <div className="inner-card">
                                <div className="inner-header d-flex justify-content-between align-items-center">
                                    <div className="inner-title">Notifications</div>
                                </div>
                                <ul className="notif-list">
                                    <li><span className="n-icon">📣</span> Enrollment for 2nd Semester is now open!</li>
                                    <li><span className="n-icon">🗓️</span> Faculty meeting scheduled on October 25, 2025 at 2:00 PM.</li>
                                    <li><span className="n-icon">🖥️</span> System maintenance on October 28, 2025, from 10 PM to 12 AM.</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </AdminLayout>
    );
};

export default Dashboard;
