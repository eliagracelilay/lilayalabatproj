import React, { useState } from 'react';
import AdminLayout from './AdminLayout';

const Profile = ({ user }) => {
    const [activeTab, setActiveTab] = useState('info');
    const initialUser = (typeof window !== 'undefined' && window.adminUser) ? window.adminUser : (user || {});
    const initialProfile = (typeof window !== 'undefined' && window.adminProfile) ? window.adminProfile : {};
    const split = (initialUser?.name || '').trim().split(' ');
    const initialFirst = initialProfile?.first_name ?? (split[0] || '');
    const initialLast = initialProfile?.last_name ?? (split.slice(1).join(' ') || '');
    const [form, setForm] = useState({
        first_name: initialFirst,
        last_name: initialLast,
        email: initialUser?.email || '',
        phone: initialProfile?.phone || ''
    });
    // Avatar upload removed per request
    const [editing, setEditing] = useState(false);
    const [saving, setSaving] = useState(false);

    const handleTabChange = (tab) => {
        setActiveTab(tab);
    };

    const handlePasswordSubmit = (e) => {
        e.preventDefault();
        alert('This is a demo UI. Hook into your update password route.');
    };

    const handleChange = (key, value) => {
        setForm(prev => ({ ...prev, [key]: value }));
    };

    // Avatar upload removed per request

    const handleSave = async () => {
        try {
            setSaving(true);
            const fd = new FormData();
            fd.append('first_name', form.first_name || '');
            fd.append('last_name', form.last_name || '');
            fd.append('email', form.email || '');
            fd.append('phone', form.phone || '');
            // CSRF + method spoofing for Laravel web routes
            const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            fd.append('_token', csrf);
            fd.append('_method', 'PUT');
            // No avatar upload
            const res = await fetch('/api/admin/profile', {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': csrf
                },
                credentials: 'same-origin',
                body: fd
            });
            const data = await res.json().catch(() => ({}));
            if (res.ok && data.success) {
                const u = data.user || {};
                if (typeof window !== 'undefined') window.adminUser = u;
                if (typeof window !== 'undefined') window.adminProfile = {
                    first_name: u.first_name || '',
                    last_name: u.last_name || '',
                    phone: u.phone || ''
                };
                setForm({
                    first_name: u.first_name || '',
                    last_name: u.last_name || '',
                    email: u.email || '',
                    phone: u.phone || ''
                });
                setEditing(false);
                alert('Profile updated successfully');
            } else {
                const errors = data?.errors || {};
                const errList = Object.entries(errors).flatMap(([k, v]) => Array.isArray(v) ? v : [String(v)]);
                const msg = data?.message || (errList.length ? errList.join('\n') : 'Update failed');
                alert(msg);
            }
        } catch (e) {
            alert('Error updating profile');
        } finally {
            setSaving(false);
        }
    };

    const handleCancel = () => {
        setForm({
            first_name: initialFirst,
            last_name: initialLast,
            email: initialUser?.email || '',
            phone: initialUser?.phone || ''
        });
        // No avatar state to reset
        setEditing(false);
    };


    return (
        <AdminLayout>
            <div style={{ background: '#f7f7fb', padding: '16px', borderRadius: '12px' }}>
                <div className="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h4 className="mb-0">Profile</h4>
                        <div className="text-muted small">Manage your administrator account</div>
                    </div>
                </div>

                <div className="profile-container">
                    <div className="profile-tabbar">
                        <button 
                            className={`tab-pill ${activeTab === 'info' ? 'active' : ''}`}
                            onClick={() => handleTabChange('info')}
                        >
                            👤 Admin Info
                        </button>
                        <button 
                            className={`tab-pill ${activeTab === 'security' ? 'active' : ''}`}
                            onClick={() => handleTabChange('security')}
                        >
                            🔒 Security
                        </button>
                    </div>
                </div>

                <div className="profile-shell">
                    {activeTab === 'info' && (
                        <div className="profile-section active">
                            <div className="section-header">
                                <div className="section-title">Profile Information</div>
                                <div className="section-description">
                                    Ensure that all personal and contact records are accurate and up to date.
                                </div>
                            </div>
                            <div className="profile-info">
                                <div className="profile-header">
                                    <div className="profile-avatar" style={{ overflow: 'hidden', borderRadius: '50%', width: 56, height: 56, background: '#eef', display: 'flex', alignItems: 'center', justifyContent: 'center' }}>👤</div>
                                    <div className="profile-details">
                                        <div className="profile-name">{`${form.first_name || ''}${form.last_name ? ' ' : ''}${form.last_name || ''}` || 'Administrator'}</div>
                                        <div className="profile-role">Admin</div>
                                        <div className="profile-email">{form.email}</div>
                                    </div>
                                </div>
                                <div className="profile-fields">
                                    <div className="row g-4">
                                        <div className="col-md-6">
                                            <div className="profile-field">
                                                <label className="field-label">First Name</label>
                                                <input className="form-control field-input" value={form.first_name} onChange={(e) => handleChange('first_name', e.target.value)} disabled={!editing} />
                                            </div>
                                        </div>
                                        <div className="col-md-6">
                                            <div className="profile-field">
                                                <label className="field-label">Last Name</label>
                                                <input className="form-control field-input" value={form.last_name} onChange={(e) => handleChange('last_name', e.target.value)} disabled={!editing} />
                                            </div>
                                        </div>
                                        <div className="col-md-6">
                                            <div className="profile-field">
                                                <label className="field-label">Email Address</label>
                                                <input className="form-control field-input" value={form.email} onChange={(e) => handleChange('email', e.target.value)} disabled={!editing} />
                                            </div>
                                        </div>
                                        <div className="col-md-6">
                                            <div className="profile-field">
                                                <label className="field-label">Phone Number</label>
                                                <input className="form-control field-input" value={form.phone} placeholder="—" onChange={(e) => handleChange('phone', e.target.value)} disabled={!editing} />
                                            </div>
                                        </div>
                                        <div className="col-md-6">
                                            <div className="profile-field">
                                                <label className="field-label">Account Created</label>
                                                <input className="form-control field-input" value={initialUser?.created_at ? new Date(initialUser.created_at).toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' }) : ''} disabled />
                                            </div>
                                        </div>
                                        <div className="col-md-6">
                                            <div className="profile-field">
                                                <label className="field-label">Role</label>
                                                <input className="form-control field-input" value="Admin" disabled />
                                            </div>
                                        </div>
                                        {/* Avatar upload removed */}
                                    </div>
                                </div>
                                <div className="d-flex gap-2 mt-3">
                                    {!editing ? (
                                        <>
                                            <button className="btn btn-primary" onClick={() => setEditing(true)}>Edit Profile</button>
                                        </>
                                    ) : (
                                        <>
                                            <button className="btn btn-primary" onClick={handleSave} disabled={saving}>{saving ? 'Saving...' : 'Save Changes'}</button>
                                            <button className="btn btn-outline-secondary" onClick={handleCancel} disabled={saving}>Cancel</button>
                                        </>
                                    )}
                                </div>
                            </div>
                        </div>
                    )}

                    {activeTab === 'security' && (
                        <div className="profile-section active">
                            <div className="section-header">
                                <div className="section-title">Security</div>
                                <div className="section-description">
                                    Update your password to keep your account secure.
                                </div>
                            </div>
                            <div className="profile-security">
                                <div className="security-info">
                                    <span className="security-icon">🔒</span>
                                    <p className="security-text">
                                        For security purposes, please enter your current password before setting a new one.
                                    </p>
                                </div>
                                <form className="security-form" onSubmit={handlePasswordSubmit}>
                                    <div className="row g-3">
                                        <div className="col-md-6">
                                            <div className="security-field">
                                                <label className="form-label">Current Password</label>
                                                <input 
                                                    type="password" 
                                                    className="form-control" 
                                                    placeholder="••••••••" 
                                                />
                                            </div>
                                        </div>
                                        <div className="col-md-6"></div>
                                        <div className="col-md-6">
                                            <div className="security-field">
                                                <label className="form-label">New Password</label>
                                                <input 
                                                    type="password" 
                                                    className="form-control" 
                                                    placeholder="••••••••" 
                                                />
                                            </div>
                                        </div>
                                        <div className="col-md-6">
                                            <div className="security-field">
                                                <label className="form-label">Confirm New Password</label>
                                                <input 
                                                    type="password" 
                                                    className="form-control" 
                                                    placeholder="••••••••" 
                                                />
                                            </div>
                                        </div>
                                    </div>
                                    <div className="security-actions">
                                        <button type="submit" className="btn btn-primary">
                                            Update Password
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    )}
                </div>
            </div>
        </AdminLayout>
    );
};

export default Profile;
