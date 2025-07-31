@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">System Settings</h1>
        </div>

        <div class="row">
            <!-- Settings Navigation -->
            <div class="col-lg-3 mb-4">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Settings Menu</h6>
                    </div>
                    <div class="card-body">
                        <div class="nav flex-column nav-pills" id="settingsTab" role="tablist" aria-orientation="vertical">
                            <a class="nav-link active" id="general-tab" data-toggle="pill" href="#general" role="tab" aria-controls="general" aria-selected="true">
                                <i class="fas fa-cog fa-fw mr-2"></i>General Settings
                            </a>
                            <a class="nav-link" id="permissions-tab" data-toggle="pill" href="#permissions" role="tab" aria-controls="permissions" aria-selected="false">
                                <i class="fas fa-user-shield fa-fw mr-2"></i>Permissions
                            </a>
                            <a class="nav-link" id="team-tab" data-toggle="pill" href="#team" role="tab" aria-controls="team" aria-selected="false">
                                <i class="fas fa-users fa-fw mr-2"></i>Team Information
                            </a>
                            <a class="nav-link" id="email-tab" data-toggle="pill" href="#email" role="tab" aria-controls="email" aria-selected="false">
                                <i class="fas fa-envelope fa-fw mr-2"></i>Email Settings
                            </a>
                            <a class="nav-link" id="security-tab" data-toggle="pill" href="#security" role="tab" aria-controls="security" aria-selected="false">
                                <i class="fas fa-lock fa-fw mr-2"></i>Security
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Settings Content -->
            <div class="col-lg-9 mb-4">
                <div class="tab-content" id="settingsTabContent">
                    <!-- General Settings Tab -->
                    <div class="tab-pane fade show active" id="general" role="tabpanel" aria-labelledby="general-tab">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">General System Settings</h6>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('admin.settings.update') }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    
                                    <div class="form-group row">
                                        <label for="site_name" class="col-sm-3 col-form-label">Site Name</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="site_name" name="site_name" value="{{ $settings['site_name'] ?? '' }}">
                                        </div>
                                    </div>
                                    
                                    <div class="form-group row">
                                        <label for="site_email" class="col-sm-3 col-form-label">Site Email</label>
                                        <div class="col-sm-9">
                                            <input type="email" class="form-control" id="site_email" name="site_email" value="{{ $settings['site_email'] ?? '' }}">
                                        </div>
                                    </div>
                                    
                                    <div class="form-group row">
                                        <label for="timezone" class="col-sm-3 col-form-label">Timezone</label>
                                        <div class="col-sm-9">
                                            <select class="form-control" id="timezone" name="timezone">
                                                @foreach(timezone_identifiers_list() as $tz)
                                                    <option value="{{ $tz }}" {{ ($settings['timezone'] ?? '') == $tz ? 'selected' : '' }}>{{ $tz }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group row">
                                        <label for="maintenance_mode" class="col-sm-3 col-form-label">Maintenance Mode</label>
                                        <div class="col-sm-9">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input" id="maintenance_mode" name="maintenance_mode" {{ ($settings['maintenance_mode'] ?? false) ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="maintenance_mode"></label>
                                            </div>
                                            <small class="form-text text-muted">When enabled, only administrators can access the site.</small>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group row">
                                        <div class="col-sm-9 offset-sm-3">
                                            <button type="submit" class="btn btn-primary">Save Changes</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Permissions Tab -->
                    <div class="tab-pane fade" id="permissions" role="tabpanel" aria-labelledby="permissions-tab">
                        @include('admin.settings.permissions')
                    </div>

                    <!-- Team Info Tab -->
                    <div class="tab-pane fade" id="team" role="tabpanel" aria-labelledby="team-tab">
                        @include('admin.settings.team-info')
                    </div>

                    <!-- Email Settings Tab -->
                    <div class="tab-pane fade" id="email" role="tabpanel" aria-labelledby="email-tab">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Email Configuration</h6>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('admin.settings.email.update') }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    
                                    <div class="form-group row">
                                        <label for="mail_driver" class="col-sm-3 col-form-label">Mail Driver</label>
                                        <div class="col-sm-9">
                                            <select class="form-control" id="mail_driver" name="mail_driver">
                                                <option value="smtp" {{ ($settings['mail_driver'] ?? '') == 'smtp' ? 'selected' : '' }}>SMTP</option>
                                                <option value="mailgun" {{ ($settings['mail_driver'] ?? '') == 'mailgun' ? 'selected' : '' }}>Mailgun</option>
                                                <option value="ses" {{ ($settings['mail_driver'] ?? '') == 'ses' ? 'selected' : '' }}>Amazon SES</option>
                                                <option value="postmark" {{ ($settings['mail_driver'] ?? '') == 'postmark' ? 'selected' : '' }}>Postmark</option>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group row">
                                        <label for="mail_host" class="col-sm-3 col-form-label">SMTP Host</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="mail_host" name="mail_host" value="{{ $settings['mail_host'] ?? '' }}">
                                        </div>
                                    </div>
                                    
                                    <div class="form-group row">
                                        <label for="mail_port" class="col-sm-3 col-form-label">SMTP Port</label>
                                        <div class="col-sm-9">
                                            <input type="number" class="form-control" id="mail_port" name="mail_port" value="{{ $settings['mail_port'] ?? '' }}">
                                        </div>
                                    </div>
                                    
                                    <div class="form-group row">
                                        <label for="mail_username" class="col-sm-3 col-form-label">SMTP Username</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="mail_username" name="mail_username" value="{{ $settings['mail_username'] ?? '' }}">
                                        </div>
                                    </div>
                                    
                                    <div class="form-group row">
                                        <label for="mail_password" class="col-sm-3 col-form-label">SMTP Password</label>
                                        <div class="col-sm-9">
                                            <input type="password" class="form-control" id="mail_password" name="mail_password" placeholder="Leave blank to keep current password">
                                        </div>
                                    </div>
                                    
                                    <div class="form-group row">
                                        <label for="mail_encryption" class="col-sm-3 col-form-label">Encryption</label>
                                        <div class="col-sm-9">
                                            <select class="form-control" id="mail_encryption" name="mail_encryption">
                                                <option value="tls" {{ ($settings['mail_encryption'] ?? '') == 'tls' ? 'selected' : '' }}>TLS</option>
                                                <option value="ssl" {{ ($settings['mail_encryption'] ?? '') == 'ssl' ? 'selected' : '' }}>SSL</option>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group row">
                                        <div class="col-sm-9 offset-sm-3">
                                            <button type="button" class="btn btn-info" id="testEmailBtn">Send Test Email</button>
                                            <button type="submit" class="btn btn-primary">Save Changes</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Security Tab -->
                    <div class="tab-pane fade" id="security" role="tabpanel" aria-labelledby="security-tab">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Security Settings</h6>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('admin.settings.security.update') }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    
                                    <div class="form-group row">
                                        <label for="password_policy" class="col-sm-3 col-form-label">Password Policy</label>
                                        <div class="col-sm-9">
                                            <div class="custom-control custom-checkbox mb-2">
                                                <input type="checkbox" class="custom-control-input" id="password_min_length" name="password_min_length" {{ ($settings['password_min_length'] ?? false) ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="password_min_length">Require minimum 8 characters</label>
                                            </div>
                                            <div class="custom-control custom-checkbox mb-2">
                                                <input type="checkbox" class="custom-control-input" id="password_mixed_case" name="password_mixed_case" {{ ($settings['password_mixed_case'] ?? false) ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="password_mixed_case">Require mixed case letters</label>
                                            </div>
                                            <div class="custom-control custom-checkbox mb-2">
                                                <input type="checkbox" class="custom-control-input" id="password_numbers" name="password_numbers" {{ ($settings['password_numbers'] ?? false) ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="password_numbers">Require numbers</label>
                                            </div>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="password_special_chars" name="password_special_chars" {{ ($settings['password_special_chars'] ?? false) ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="password_special_chars">Require special characters</label>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group row">
                                        <label for="login_attempts" class="col-sm-3 col-form-label">Login Attempts</label>
                                        <div class="col-sm-9">
                                            <input type="number" class="form-control" id="login_attempts" name="login_attempts" value="{{ $settings['login_attempts'] ?? 5 }}" min="1" max="10">
                                            <small class="form-text text-muted">Number of failed attempts before account is locked</small>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group row">
                                        <label for="session_timeout" class="col-sm-3 col-form-label">Session Timeout</label>
                                        <div class="col-sm-9">
                                            <div class="input-group">
                                                <input type="number" class="form-control" id="session_timeout" name="session_timeout" value="{{ $settings['session_timeout'] ?? 30 }}" min="1" max="1440">
                                                <div class="input-group-append">
                                                    <span class="input-group-text">minutes</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group row">
                                        <label for="two_factor_auth" class="col-sm-3 col-form-label">Two-Factor Auth</label>
                                        <div class="col-sm-9">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input" id="two_factor_auth" name="two_factor_auth" {{ ($settings['two_factor_auth'] ?? false) ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="two_factor_auth">Enable two-factor authentication for admin users</label>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group row">
                                        <div class="col-sm-9 offset-sm-3">
                                            <button type="submit" class="btn btn-primary">Save Changes</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // Test email functionality
        $('#testEmailBtn').click(function() {
            $.ajax({
                url: "{{ route('admin.settings.email.test') }}",
                method: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    email: "{{ auth()->user()->email }}"
                },
                beforeSend: function() {
                    $('#testEmailBtn').prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Sending...');
                },
                success: function(response) {
                    toastr.success('Test email sent successfully!');
                },
                error: function(xhr) {
                    toastr.error('Error sending test email: ' + xhr.responseJSON.message);
                },
                complete: function() {
                    $('#testEmailBtn').prop('disabled', false).text('Send Test Email');
                }
            });
        });

        // Switch tabs based on URL hash
        if(window.location.hash) {
            $('a[href="' + window.location.hash + '"]').tab('show');
        }

        // Change hash for page-reload
        $('a[data-toggle="pill"]').on('shown.bs.tab', function (e) {
            window.location.hash = e.target.hash;
        });
    </script>
@endsection