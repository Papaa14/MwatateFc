@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Players Management</h1>
        <a href="{{ route('players.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> Add New Player
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
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Players List</h6>
            <div class="dropdown no-arrow">
                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" 
                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-filter fa-sm fa-fw text-gray-400"></i> Filters
                </a>
                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                    <form class="px-3 py-2">
                        <div class="form-group mb-2">
                            <label for="statusFilter">Status</label>
                            <select class="form-control form-control-sm" id="statusFilter">
                                <option value="">All Players</option>
                                <option value="active">Active</option>
                                <option value="injured">Injured</option>
                                <option value="suspended">Suspended</option>
                                <option value="retired">Retired</option>
                            </select>
                        </div>
                        <div class="form-group mb-2">
                            <label for="positionFilter">Position</label>
                            <select class="form-control form-control-sm" id="positionFilter">
                                <option value="">All Positions</option>
                                @foreach(['Goalkeeper', 'Defender', 'Midfielder', 'Forward'] as $position)
                                <option value="{{ $position }}">{{ $position }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm btn-block">Apply Filters</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="playersTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Player</th>
                            <th>Position</th>
                            <th>Team</th>
                            <th>Age</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($players as $player)
                        <tr>
                            <td>{{ $player->jersey_number }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="{{ $player->photo_url ?: asset('images/default-player.png') }}" 
                                         class="rounded-circle mr-2" width="40" height="40" 
                                         alt="{{ $player->full_name }}">
                                    <div>
                                        <div class="font-weight-bold">{{ $player->full_name }}</div>
                                        <small class="text-muted">{{ $player->nationality }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $player->position }}</td>
                            <td>{{ $player->team->name ?? 'Free Agent' }}</td>
                            <td>{{ $player->age }}</td>
                            <td>
                                @if($player->status == 'active')
                                    <span class="badge badge-success">Active</span>
                                @elseif($player->status == 'injured')
                                    <span class="badge badge-warning">Injured</span>
                                @elseif($player->status == 'suspended')
                                    <span class="badge badge-danger">Suspended</span>
                                @else
                                    <span class="badge badge-secondary">Retired</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('players.show', $player->id) }}" class="btn btn-info btn-sm" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('players.edit', $player->id) }}" class="btn btn-warning btn-sm" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button class="btn btn-danger btn-sm delete-player" data-id="{{ $player->id }}" title="Delete">
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
                <h5 class="modal-title" id="deleteModalLabel">Confirm Player Deletion</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this player? This action cannot be undone.</p>
                <p class="text-danger"><strong>Warning:</strong> All associated statistics and records will also be deleted.</p>
            </div>
            <div class="modal-footer">
                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete Player</button>
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
        $('#playersTable').DataTable({
            responsive: true,
            columnDefs: [
                { orderable: false, targets: [6] }
            ],
            order: [[1, 'asc']]
        });

        // Delete player confirmation
        $('.delete-player').click(function() {
            const playerId = $(this).data('id');
            $('#deleteForm').attr('action', `/admin/players/${playerId}`);
            $('#deleteModal').modal('show');
        });

        // Apply filters
        $('#statusFilter, #positionFilter').change(function() {
            const status = $('#statusFilter').val();
            const position = $('#positionFilter').val();
            
            // You would typically make an AJAX call here to filter the players
            // For now, we'll just reload the page with query parameters
            if(status || position) {
                window.location.href = "{{ route('players.index') }}?" + $.param({
                    status: status,
                    position: position
                });
            } else {
                window.location.href = "{{ route('players.index') }}";
            }
        });
    });
</script>
@endsection