import React, { useState } from 'react';
import AdminLayout from './AdminLayout';

const Profile = ({ user }) => {
    const [activeTab, setActiveTab] = useState('info');

    const handleTabChange = (tab) => {
        setActiveTab(tab);
    };

    const handlePasswordSubmit = (e) => {
        e.preventDefault();
        alert('This is a demo UI. Hook into your update password route.');
    };


    return (
        <AdminLayout>
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
                                    <div className="profile-avatar">👤</div>
                                    <div className="profile-details">
                                        <div className="profile-name">{user?.name || 'Administrator'}</div>
                                        <div className="profile-role">Admin</div>
                                        <div className="profile-email">{user?.email || ''}</div>
                                    </div>
                                </div>
                                <div className="profile-fields">
                                    <div className="row g-4">
                                        <div className="col-md-6">
                                            <div className="profile-field">
                                                <label className="field-label">First Name</label>
                                                <input 
                                                    className="form-control field-input" 
                                                    value={user?.name?.split(' ')[0] || ''} 
                                                    disabled 
                                                />
                                            </div>
                                        </div>
                                        <div className="col-md-6">
                                            <div className="profile-field">
                                                <label className="field-label">Last Name</label>
                                                <input 
                                                    className="form-control field-input" 
                                                    value={user?.name?.split(' ').slice(1).join(' ') || ''} 
                                                    disabled 
                                                />
                                            </div>
                                        </div>
                                        <div className="col-md-6">
                                            <div className="profile-field">
                                                <label className="field-label">Email Address</label>
                                                <input 
                                                    className="form-control field-input" 
                                                    value={user?.email || ''} 
                                                    disabled 
                                                />
                                            </div>
                                        </div>
                                        <div className="col-md-6">
                                            <div className="profile-field">
                                                <label className="field-label">Phone Number</label>
                                                <input 
                                                    className="form-control field-input" 
                                                    value="" 
                                                    placeholder="—" 
                                                    disabled 
                                                />
                                            </div>
                                        </div>
                                        <div className="col-md-6">
                                            <div className="profile-field">
                                                <label className="field-label">Account Created</label>
                                                <input 
                                                    className="form-control field-input" 
                                                    value={user?.created_at ? new Date(user.created_at).toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' }) : ''} 
                                                    disabled 
                                                />
                                            </div>
                                        </div>
                                        <div className="col-md-6">
                                            <div className="profile-field">
                                                <label className="field-label">Role</label>
                                                <input 
                                                    className="form-control field-input" 
                                                    value="Admin" 
                                                    disabled 
                                                />
                                            </div>
                                        </div>
                                    </div>
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
