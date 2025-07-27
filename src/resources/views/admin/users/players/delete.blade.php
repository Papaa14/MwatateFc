@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Delete Player</h1>
        <a href="{{ route('players.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Back to Players
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3 bg-danger">
            <h6 class="m-0 font-weight-bold text-white">Confirm Player Deletion</h6>
        </div>
        <div class="card-body">
            <div class="alert alert-danger">
                <strong>Warning!</strong> You are about to permanently delete this player and all associated data.
            </div>

            <div class="row">
                <div class="col-md-4 text-center">
                    <img src="{{ $player->photo_url ?: asset('images/default-player.png') }}" 
                         class="rounded-circle mb-3" width="150" height="150" 
                         alt="{{ $player->full_name }}">
                    <h4>{{ $player->full_name }}</h4>
                    <p class="text-muted">#{{ $player->jersey_number }} | {{ $player->position }}</p>
                    @if($player->team)
                        <p class="text-muted">{{ $player->team->name }}</p>
                    @endif
                </div>
                <div class="col-md-8">
                    <h5>Player Information</h5>
                    <ul class="list-group list-group-flush mb-4">
                        <li class="list-group-item"><strong>Age:</strong> {{ $player->age }}</li>
                        <li class="list-group-item"><strong>Nationality:</strong> {{ $player->nationality }}</li>
                        <li class="list-group-item"><strong>Status:</strong> 
                            <span class="badge badge-{{ $player->status == 'active' ? 'success' : 
                                                  ($player->status == 'injured' ? 'warning' : 
                                                  ($player->status == 'suspended' ? 'danger' : 'secondary')) }}">
                                {{ ucfirst($player->status) }}
                            </span>
                        </li>
                        <li class="list-group-item"><strong>Joined:</strong> {{ $player->created_at->format('M d, Y') }}</li>
                    </ul>

                    <h5>Data That Will Be Deleted</h5>
                    <ul>
                        <li>Player profile and all personal information</li>
                        <li>All match statistics and performance records</li>
                        <li>Any media associated with this player</li>
                        <li>All historical data and achievements</li>
                    </ul>
                </div>
            </div>

            <form method="POST" action="{{ route('players.destroy', $player->id) }}" class="mt-4">
                @csrf
                @method('DELETE')
                
                <div class="form-group">
                    <label for="confirm_name">Type the player's full name to confirm deletion</label>
                    <input type="text" class="form-control" id="confirm_name" name="confirm_name" 
                           placeholder="Enter exactly: {{ $player->full_name }}" required>
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
                    <i class="fas fa-trash"></i> Permanently Delete Player
                </button>
                <a href="{{ route('players.index') }}" class="btn btn-secondary">Cancel</a>
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
        
        if (e.target.value === "{{ $player->full_name }}" && confirmCheckbox.checked) {
            deleteButton.disabled = false;
        } else {
            deleteButton.disabled = true;
        }
    });

    document.getElementById('confirm_backup').addEventListener('change', function(e) {
        const deleteButton = document.getElementById('deleteButton');
        const nameInput = document.getElementById('confirm_name');
        
        if (e.target.checked && nameInput.value === "{{ $player->full_name }}") {
            deleteButton.disabled = false;
        } else {
            deleteButton.disabled = true;
        }
    });
</script>
@endsection