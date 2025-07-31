<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">Role Permissions</h6>
        <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#addRoleModal">
            <i class="fas fa-plus fa-sm"></i> Add Role
        </button>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Role</th>
                        <th>Users</th>
                        <th>Permissions</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($roles as $role)
                        <tr>
                            <td>
                                <strong>{{ $role->name }}</strong>
                                @if($role->is_default)
                                    <span class="badge badge-info ml-2">Default</span>
                                @endif
                            </td>
                            <td>{{ $role->users_count }}</td>
                            <td>
                                @foreach($role->permissions->take(3) as $permission)
                                    <span class="badge badge-secondary">{{ $permission->name }}</span>
                                @endforeach
                                @if($role->permissions->count() > 3)
                                    <span class="badge badge-light">+{{ $role->permissions->count() - 3 }} more</span>
                                @endif
                            </td>
                            <td>
                                <button class="btn btn-sm btn-info edit-role-btn" data-id="{{ $role->id }}" data-toggle="tooltip" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                @if(!$role->is_default)
                                    <button class="btn btn-sm btn-danger delete-role-btn" data-id="{{ $role->id }}" data-toggle="tooltip" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Permissions Matrix -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Permissions Matrix</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Permission</th>
                        @foreach($roles as $role)
                            <th>{{ $role->name }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach($permissions as $permission)
                        <tr>
                            <td>{{ $permission->name }}</td>
                            @foreach($roles as $role)
                                <td class="text-center">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input permission-checkbox" 
                                               id="perm-{{ $permission->id }}-role-{{ $role->id }}"
                                               data-permission="{{ $permission->id }}" 
                                               data-role="{{ $role->id }}"
                                               {{ $role->hasPermission($permission->name) ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="perm-{{ $permission->id }}-role-{{ $role->id }}"></label>
                                    </div>
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add Role Modal -->
<div class="modal fade" id="addRoleModal" tabindex="-1" role="dialog" aria-labelledby="addRoleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addRoleModalLabel">Add New Role</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addRoleForm" action="{{ route('admin.settings.roles.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="roleName">Role Name</label>
                        <input type="text" class="form-control" id="roleName" name="name" required>
                    </div>
                    <div class="form-group">
                        <label>Permissions</label>
                        <div class="permission-list" style="max-height: 300px; overflow-y: auto;">
                            @foreach($permissions as $permission)
                                <div class="custom-control custom-checkbox mb-2">
                                    <input type="checkbox" class="custom-control-input" id="perm-{{ $permission->id }}" name="permissions[]" value="{{ $permission->id }}">
                                    <label class="custom-control-label" for="perm-{{ $permission->id }}">{{ $permission->name }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="isDefault" name="is_default">
                        <label class="custom-control-label" for="isDefault">Set as default role for new users</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Role</button>
                </div>
            </form>
        </div>
    </div>
</div>

@section('scripts')
    <script>
        // Update role permissions via AJAX
        $('.permission-checkbox').change(function() {
            const roleId = $(this).data('role');
            const permissionId = $(this).data('permission');
            const isChecked = $(this).is(':checked');
            
            $.ajax({
                url: "{{ route('admin.settings.roles.update-permission') }}",
                method: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    role_id: roleId,
                    permission_id: permissionId,
                    action: isChecked ? 'grant' : 'revoke'
                },
                success: function(response) {
                    toastr.success('Permission updated successfully');
                },
                error: function(xhr) {
                    toastr.error('Error updating permission');
                    // Revert checkbox on error
                    $('.permission-checkbox[data-role="' + roleId + '"][data-permission="' + permissionId + '"]')
                        .prop('checked', !isChecked);
                }
            });
        });

        // Delete role
        $('.delete-role-btn').click(function() {
            const roleId = $(this).data('id');
            
            if(confirm('Are you sure you want to delete this role? Users with this role will be assigned the default role.')) {
                $.ajax({
                    url: "{{ route('admin.settings.roles.destroy', '') }}/" + roleId,
                    method: 'DELETE',
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        toastr.success('Role deleted successfully');
                        location.reload();
                    },
                    error: function(xhr) {
                        toastr.error('Error deleting role');
                    }
                });
            }
        });
    </script>
@endsection