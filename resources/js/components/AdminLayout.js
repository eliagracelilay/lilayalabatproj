import React from 'react';

const AdminLayout = ({ children, user }) => {
    const handleSignOut = () => {
        // Create a form and submit it for logout
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '/logout';
        
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = csrfToken;
        
        form.appendChild(csrfInput);
        document.body.appendChild(form);
        form.submit();
    };

    return (
        <div className="admin-shell">
            <div className="row g-3">
                <div className="col-md-3">
                    <div className="side-card p-3">
                        <div className="side-heading">Admin Dashboard</div>
                        
                        <a href="/admin/dashboard" className={`side-link ${window.location.pathname === '/admin/dashboard' || window.location.pathname === '/admin' ? 'active' : ''}`}>
                            <span>📊</span> Dashboard
                        </a>
                        
                        <a href="/admin/students" className={`side-link ${window.location.pathname === '/admin/students' ? 'active' : ''}`}>
                            <span>🎓</span> Student
                        </a>
                        
                        <a href="/admin/faculties" className={`side-link ${window.location.pathname === '/admin/faculties' ? 'active' : ''}`}>
                            <span>🧑‍🏫</span> Faculty
                        </a>
                        
                        <a href="/admin/reports" className={`side-link ${window.location.pathname === '/admin/reports' ? 'active' : ''}`}>
                            <span>📋</span> Reports
                        </a>
                        
                        <a href="/admin/settings" className={`side-link ${window.location.pathname === '/admin/settings' ? 'active' : ''}`}>
                            <span>⚙️</span> System Settings
                        </a>
                        
                        <div className="side-footer mt-4">
                            <a href="/admin/profile" className="admin-section" style={{ textDecoration: 'none', color: 'inherit' }}>
                                <div className="small text-muted mb-1">Administrator</div>
                                <div className="small fw-semibold">Admin</div>
                            </a>
                            <button 
                                onClick={handleSignOut}
                                className="btn btn-outline-danger btn-sm mt-2 w-100"
                                style={{ fontSize: '0.875rem' }}
                            >
                                🚪 Sign Out
                            </button>
                        </div>
                    </div>
                </div>
                
                <div className="col-md-9">
                    <div className="mini-card p-4">
                        {children}
                    </div>
                </div>
            </div>
        </div>
    );
};

export default AdminLayout;
