@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Delete Coach</h1>
        <a href="{{ route('coaches.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Back to Coaches
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3 bg-danger">
            <h6 class="m-0 font-weight-bold text-white">Confirm Deletion</h6>
        </div>
        <div class="card-body">
            <div class="alert alert-danger">
                <strong>Warning!</strong> You are about to delete a coach. This action cannot be undone.
            </div>

            <div class="row">
                <div class="col-md-4 text-center">
                    <img src="{{ $coach->photo_url ?: asset('images/default-coach.png') }}" alt="{{ $coach->name }}" class="rounded-circle mb-3" width="150" height="150">
                    <h4>{{ $coach->name }}</h4>
                    <p class="text-muted">{{ $coach->specialization }}</p>
                </div>
                <div class="col-md-8">
                    <h5>Coach Details</h5>
                    <ul class="list-group list-group-flush mb-4">
                        <li class="list-group-item"><strong>Email:</strong> {{ $coach->email }}</li>
                        @if($coach->phone)
                            <li class="list-group-item"><strong>Phone:</strong> {{ $coach->phone }}</li>
                        @endif
                        <li class="list-group-item"><strong>Status:</strong> 
                            <span class="badge badge-{{ $coach->is_active ? 'success' : 'secondary' }}">
                                {{ $coach->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </li>
                        <li class="list-group-item"><strong>Joined:</strong> {{ $coach->created_at->format('M d, Y') }}</li>
                    </ul>

                    <h5>Impact of Deletion</h5>
                    <ul>
                        <li>All associated sessions with this coach will be marked as "No Coach"</li>
                        <li>Clients assigned to this coach will need to be reassigned</li>
                        <li>This coach's profile will be permanently removed</li>
                    </ul>
                </div>
            </div>

            <form method="POST" action="{{ route('coaches.destroy', $coach->id) }}" class="mt-4">
                @csrf
                @method('DELETE')
                
                <div class="form-group">
                    <label for="confirm_name">Type the coach's name to confirm deletion</label>
                    <input type="text" class="form-control" id="confirm_name" name="confirm_name" placeholder="Enter coach's name exactly as shown" required>
                </div>

                <div class="form-group">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="confirm_backup" name="confirm_backup" required>
                        <label class="custom-control-label text-danger" for="confirm_backup">
                            I understand this action cannot be undone and I have made necessary backups
                        </label>
                    </div>
                </div>

                <button type="submit" class="btn btn-danger" id="deleteButton" disabled>
                    <i class="fas fa-trash"></i> Permanently Delete Coach
                </button>
                <a href="{{ route('coaches.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.getElementById('confirm_name').addEventListener('input', function(e) {
        const deleteButton = document.getElementById('deleteButton');
        const confirmCheckbox = document.getElementById('confirm_backup');
        
        if (e.target.value === "{{ $coach->name }}" && confirmCheckbox.checked) {
            deleteButton.disabled = false;
        } else {
            deleteButton.disabled = true;
        }
    });

    document.getElementById('confirm_backup').addEventListener('change', function(e) {
        const deleteButton = document.getElementById('deleteButton');
        const nameInput = document.getElementById('confirm_name');
        
        if (e.target.checked && nameInput.value === "{{ $coach->name }}") {
            deleteButton.disabled = false;
        } else {
            deleteButton.disabled = true;
        }
    });
</script>
@endsection