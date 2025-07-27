<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">Team Members</h6>
        <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#inviteUserModal">
            <i class="fas fa-user-plus fa-sm"></i> Invite User
        </button>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Last Active</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($teamMembers as $member)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img class="rounded-circle mr-2" width="30" height="30" src="{{ $member->avatar_url }}" alt="{{ $member->name }}">
                                    {{ $member->name }}
                                </div>
                            </td>
                            <td>{{ $member->email }}</td>
                            <td>
                                @foreach($member->roles as $role)
                                    <span class="badge badge-primary">{{ $role->name }}</span>
                                @endforeach
                            </td>
                            <td>
                                @if($member->is_active)
                                    <span class="badge badge-success">Active</span>
                                @else
                                    <span class="badge badge-secondary">Inactive</span>
                                @endif
                            </td>
                            <td>{{ $member->last_active_at ? $member->last_active_at->diffForHumans() : 'Never' }}</td>
                            <td>
                                <button class="btn btn-sm btn-info edit-member-btn" data-id="{{ $member->id }}" data-toggle="tooltip" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                @if(auth()->id() !== $member->id)
                                    <button class="btn btn-sm btn-danger delete-member-btn" data-id="{{ $member->id }}" data-toggle="tooltip" title="Remove">
                                        <i class="fas fa-user-times"></i>
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

<!-- Team Statistics -->
<div class="row">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Total Team Members</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $teamStats['total_members'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Active Members</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $teamStats['active_members'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-user-check fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Pending Invitations</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $teamStats['pending_invites'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-envelope fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Admin Members</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $teamStats['admin_members'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-user-shield fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Invite User Modal -->
<div class="modal fade" id="inviteUserModal" tabindex="-1" role="dialog" aria-labelledby="inviteUserModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="inviteUserModalLabel">Invite New Team Member</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="inviteUserForm" action="{{ route('admin.settings.team.invite') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="inviteEmail">Email Address</label>
                        <input type="email" class="form-control" id="inviteEmail" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="inviteRole">Role</label>
                        <select class="form-control" id="inviteRole" name="role" required>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="inviteMessage">Personal Message (Optional)</label>
                        <textarea class="form-control" id="inviteMessage" name="message" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Send Invitation</button>
                </div>
            </form>
        </div>
    </div>
</div>

@section('scripts')
    <script>
        // Delete team member
        $('.delete-member-btn').click(function() {
            const memberId = $(this).data('id');
            
            if(confirm('Are you sure you want to remove this team member?')) {
                $.ajax({
                    url: "{{ route('admin.settings.team.remove', '') }}/" + memberId,
                    method: 'DELETE',
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        toastr.success('Team member removed successfully');
                        location.reload();
                    },
                    error: function(xhr) {
                        toastr.error('Error removing team member');
                    }
                });
            }
        });
    </script>
@endsection