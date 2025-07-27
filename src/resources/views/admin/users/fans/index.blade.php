@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Fans Management</h1>
        <div class="d-flex">
            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm mr-2" data-toggle="modal" data-target="#exportModal">
                <i class="fas fa-download fa-sm text-white-50"></i> Export
            </a>
            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm" data-toggle="modal" data-target="#importModal">
                <i class="fas fa-upload fa-sm text-white-50"></i> Import
            </a>
        </div>
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
            <h6 class="m-0 font-weight-bold text-primary">Fans List</h6>
            <div class="dropdown no-arrow">
                <a class="dropdown-toggle" href="#" role="button" id="filterDropdown" 
                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-filter fa-sm fa-fw text-gray-400"></i>
                    Filters
                </a>
                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" 
                     aria-labelledby="filterDropdown">
                    <form class="px-3 py-2">
                        <div class="form-group mb-2">
                            <label for="statusFilter">Status</label>
                            <select class="form-control form-control-sm" id="statusFilter">
                                <option value="">All</option>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                                <option value="banned">Banned</option>
                            </select>
                        </div>
                        <div class="form-group mb-2">
                            <label for="dateFilter">Joined Date</label>
                            <select class="form-control form-control-sm" id="dateFilter">
                                <option value="">All Time</option>
                                <option value="today">Today</option>
                                <option value="week">This Week</option>
                                <option value="month">This Month</option>
                                <option value="year">This Year</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm btn-block">Apply</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="fansTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Fan</th>
                            <th>Email</th>
                            <th>Location</th>
                            <th>Status</th>
                            <th>Joined</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($fans as $fan)
                        <tr>
                            <td>#{{ $fan->id }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="{{ $fan->avatar_url ?: asset('images/default-avatar.png') }}" 
                                         class="rounded-circle mr-2" width="32" height="32" 
                                         alt="{{ $fan->name }}">
                                    {{ $fan->name }}
                                </div>
                            </td>
                            <td>{{ $fan->email }}</td>
                            <td>
                                @if($fan->city && $fan->country)
                                    {{ $fan->city }}, {{ $fan->country }}
                                @else
                                    <span class="text-muted">Not set</span>
                                @endif
                            </td>
                            <td>
                                @if($fan->is_banned)
                                    <span class="badge badge-danger">Banned</span>
                                @elseif($fan->is_active)
                                    <span class="badge badge-success">Active</span>
                                @else
                                    <span class="badge badge-secondary">Inactive</span>
                                @endif
                            </td>
                            <td>{{ $fan->created_at->format('M d, Y') }}</td>
                            <td>
                                <a href="{{ route('fans.show', $fan->id) }}" class="btn btn-info btn-sm" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <button class="btn btn-warning btn-sm toggle-status" 
                                        data-id="{{ $fan->id }}" 
                                        data-status="{{ $fan->is_active ? 'active' : 'inactive' }}"
                                        title="{{ $fan->is_active ? 'Deactivate' : 'Activate' }}">
                                    <i class="fas {{ $fan->is_active ? 'fa-toggle-on' : 'fa-toggle-off' }}"></i>
                                </button>
                                @if(!$fan->is_banned)
                                    <button class="btn btn-danger btn-sm ban-fan" 
                                            data-id="{{ $fan->id }}" 
                                            title="Ban">
                                        <i class="fas fa-ban"></i>
                                    </button>
                                @else
                                    <button class="btn btn-success btn-sm unban-fan" 
                                            data-id="{{ $fan->id }}" 
                                            title="Unban">
                                        <i class="fas fa-check-circle"></i>
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
</div>

<!-- Export Modal -->
<div class="modal fade" id="exportModal" tabindex="-1" role="dialog" aria-labelledby="exportModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exportModalLabel">Export Fans Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('fans.export') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="exportFormat">Format</label>
                        <select class="form-control" id="exportFormat" name="format" required>
                            <option value="csv">CSV</option>
                            <option value="xlsx">Excel</option>
                            <option value="pdf">PDF</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Columns to Export</label>
                        <div class="checkbox-list">
                            @foreach(['id', 'name', 'email', 'phone', 'city', 'country', 'status', 'joined_date'] as $column)
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="export{{ ucfirst($column) }}" 
                                       name="columns[]" value="{{ $column }}" checked>
                                <label class="custom-control-label" for="export{{ ucfirst($column) }}">
                                    {{ str_replace('_', ' ', ucfirst($column)) }}
                                </label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Export</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Import Modal -->
<div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="importModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="importModalLabel">Import Fans Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('fans.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="importFile">Select File</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="importFile" name="file" accept=".csv,.xlsx,.xls" required>
                            <label class="custom-file-label" for="importFile">Choose file</label>
                        </div>
                        <small class="form-text text-muted">Supported formats: CSV, Excel</small>
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="updateExisting" name="update_existing">
                            <label class="custom-control-label" for="updateExisting">Update existing fans</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Import</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Initialize DataTable
        $('#fansTable').DataTable({
            responsive: true,
            order: [[5, 'desc']],
            columnDefs: [
                { orderable: false, targets: [6] },
                { searchable: false, targets: [0, 3, 4, 5, 6] }
            ]
        });

        // Toggle fan status
        $('.toggle-status').click(function() {
            const fanId = $(this).data('id');
            const currentStatus = $(this).data('status');
            const newStatus = currentStatus === 'active' ? 'inactive' : 'active';
            
            $.ajax({
                url: "{{ route('fans.toggle-status', '') }}/" + fanId,
                method: 'PATCH',
                data: {
                    _token: "{{ csrf_token() }}",
                    status: newStatus
                },
                success: function(response) {
                    toastr.success(response.message);
                    setTimeout(() => { location.reload(); }, 1000);
                },
                error: function(xhr) {
                    toastr.error(xhr.responseJSON.message || 'Error updating status');
                }
            });
        });

        // Ban fan
        $('.ban-fan').click(function() {
            const fanId = $(this).data('id');
            
            if(confirm('Are you sure you want to ban this fan?')) {
                $.ajax({
                    url: "{{ route('fans.ban', '') }}/" + fanId,
                    method: 'PATCH',
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        toastr.success(response.message);
                        setTimeout(() => { location.reload(); }, 1000);
                    },
                    error: function(xhr) {
                        toastr.error(xhr.responseJSON.message || 'Error banning fan');
                    }
                });
            }
        });

        // Unban fan
        $('.unban-fan').click(function() {
            const fanId = $(this).data('id');
            
            if(confirm('Are you sure you want to unban this fan?')) {
                $.ajax({
                    url: "{{ route('fans.unban', '') }}/" + fanId,
                    method: 'PATCH',
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        toastr.success(response.message);
                        setTimeout(() => { location.reload(); }, 1000);
                    },
                    error: function(xhr) {
                        toastr.error(xhr.responseJSON.message || 'Error unbanning fan');
                    }
                });
            }
        });

        // Show filename in import modal
        $('#importFile').on('change', function() {
            const fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').html(fileName);
        });
    });
</script>
@endsection