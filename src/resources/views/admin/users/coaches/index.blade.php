@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Coaches Management</h1>
        <a href="{{ route('coaches.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> Add New Coach
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Coaches List</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="coachesTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Photo</th>
                            <th>Name</th>
                            <th>Specialization</th>
                            <th>Status</th>
                            <th>Joined Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($coaches as $coach)
                        <tr>
                            <td class="text-center">
                                <img src="{{ $coach->photo_url ?: asset('images/default-coach.png') }}" alt="{{ $coach->name }}" class="rounded-circle" width="40" height="40">
                            </td>
                            <td>{{ $coach->name }}</td>
                            <td>{{ $coach->specialization }}</td>
                            <td>
                                <span class="badge badge-{{ $coach->is_active ? 'success' : 'secondary' }}">
                                    {{ $coach->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td>{{ $coach->created_at->format('M d, Y') }}</td>
                            <td>
                                <a href="{{ route('coaches.show', $coach->id) }}" class="btn btn-info btn-sm" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('coaches.edit', $coach->id) }}" class="btn btn-warning btn-sm" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button class="btn btn-danger btn-sm delete-coach" data-id="{{ $coach->id }}" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this coach? This action cannot be undone.
            </div>
            <div class="modal-footer">
                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete Coach</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Initialize DataTable
        $('#coachesTable').DataTable({
            responsive: true,
            columnDefs: [
                { orderable: false, targets: [0, 5] }
            ]
        });

        // Delete coach confirmation
        $('.delete-coach').click(function() {
            const coachId = $(this).data('id');
            $('#deleteForm').attr('action', `/admin/coaches/${coachId}`);
            $('#deleteModal').modal('show');
        });
    });
</script>
@endsection