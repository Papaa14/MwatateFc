@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Player</h1>
        <a href="{{ route('players.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Back to Players
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Edit Player Information</h6>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('players.update', $player->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="first_name">First Name *</label>
                            <input type="text" class="form-control @error('first_name') is-invalid @enderror" 
                                   id="first_name" name="first_name" value="{{ old('first_name', $player->first_name) }}" required>
                            @error('first_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="last_name">Last Name *</label>
                            <input type="text" class="form-control @error('last_name') is-invalid @enderror" 
                                   id="last_name" name="last_name" value="{{ old('last_name', $player->last_name) }}" required>
                            @error('last_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="jersey_number">Jersey Number *</label>
                            <input type="number" class="form-control @error('jersey_number') is-invalid @enderror" 
                                   id="jersey_number" name="jersey_number" 
                                   value="{{ old('jersey_number', $player->jersey_number) }}" 
                                   min="1" max="99" required>
                            @error('jersey_number')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="position">Position *</label>
                            <select class="form-control @error('position') is-invalid @enderror" 
                                    id="position" name="position" required>
                                <option value="">Select Position</option>
                                <option value="Goalkeeper" {{ old('position', $player->position) == 'Goalkeeper' ? 'selected' : '' }}>Goalkeeper</option>
                                <option value="Defender" {{ old('position', $player->position) == 'Defender' ? 'selected' : '' }}>Defender</option>
                                <option value="Midfielder" {{ old('position', $player->position) == 'Midfielder' ? 'selected' : '' }}>Midfielder</option>
                                <option value="Forward" {{ old('position', $player->position) == 'Forward' ? 'selected' : '' }}>Forward</option>
                            </select>
                            @error('position')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="status">Status *</label>
                            <select class="form-control @error('status') is-invalid @enderror" 
                                    id="status" name="status" required>
                                <option value="active" {{ old('status', $player->status) == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="injured" {{ old('status', $player->status) == 'injured' ? 'selected' : '' }}>Injured</option>
                                <option value="suspended" {{ old('status', $player->status) == 'suspended' ? 'selected' : '' }}>Suspended</option>
                                <option value="retired" {{ old('status', $player->status) == 'retired' ? 'selected' : '' }}>Retired</option>
                            </select>
                            @error('status')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="birth_date">Birth Date *</label>
                            <input type="date" class="form-control @error('birth_date') is-invalid @enderror" 
                                   id="birth_date" name="birth_date" 
                                   value="{{ old('birth_date', $player->birth_date->format('Y-m-d')) }}" required>
                            @error('birth_date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="nationality">Nationality *</label>
                            <select class="form-control @error('nationality') is-invalid @enderror" 
                                    id="nationality" name="nationality" required>
                                <option value="">Select Nationality</option>
                                @foreach($countries as $country)
                                    <option value="{{ $country }}" {{ old('nationality', $player->nationality) == $country ? 'selected' : '' }}>
                                        {{ $country }}
                                    </option>
                                @endforeach
                            </select>
                            @error('nationality')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="height">Height (cm)</label>
                            <input type="number" class="form-control @error('height') is-invalid @enderror" 
                                   id="height" name="height" 
                                   value="{{ old('height', $player->height) }}" min="100" max="250">
                            @error('height')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="team_id">Team</label>
                            <select class="form-control @error('team_id') is-invalid @enderror" 
                                    id="team_id" name="team_id">
                                <option value="">Free Agent</option>
                                @foreach($teams as $team)
                                    <option value="{{ $team->id }}" {{ old('team_id', $player->team_id) == $team->id ? 'selected' : '' }}>
                                        {{ $team->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('team_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="photo">Player Photo</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input @error('photo') is-invalid @enderror" 
                                       id="photo" name="photo" accept="image/*">
                                <label class="custom-file-label" for="photo">Choose new file (leave blank to keep current)</label>
                                @error('photo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            @if($player->photo_url)
                                <small class="form-text text-muted">Current: <a href="{{ $player->photo_url }}" target="_blank">View photo</a></small>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="biography">Biography</label>
                    <textarea class="form-control @error('biography') is-invalid @enderror" 
                              id="biography" name="biography" rows="3">{{ old('biography', $player->biography) }}</textarea>
                    @error('biography')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="is_captain" name="is_captain" 
                               value="1" {{ old('is_captain', $player->is_captain) ? 'checked' : '' }}>
                        <label class="custom-control-label" for="is_captain">Team Captain</label>
                    </div>
                </div>

                <div class="form-group">
                    <label>Statistics</label>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="goals">Goals</label>
                                <input type="number" class="form-control" id="goals" name="goals" 
                                       value="{{ old('goals', $player->goals) }}" min="0">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="assists">Assists</label>
                                <input type="number" class="form-control" id="assists" name="assists" 
                                       value="{{ old('assists', $player->assists) }}" min="0">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="matches_played">Matches Played</label>
                                <input type="number" class="form-control" id="matches_played" name="matches_played" 
                                       value="{{ old('matches_played', $player->matches_played) }}" min="0">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="yellow_cards">Yellow Cards</label>
                                <input type="number" class="form-control" id="yellow_cards" name="yellow_cards" 
                                       value="{{ old('yellow_cards', $player->yellow_cards) }}" min="0">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="red_cards">Red Cards</label>
                                <input type="number" class="form-control" id="red_cards" name="red_cards" 
                                       value="{{ old('red_cards', $player->red_cards) }}" min="0">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="clean_sheets">Clean Sheets</label>
                                <input type="number" class="form-control" id="clean_sheets" name="clean_sheets" 
                                       value="{{ old('clean_sheets', $player->clean_sheets) }}" min="0">
                            </div>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Update Player</button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Display the filename when a file is selected
    document.querySelector('.custom-file-input').addEventListener('change', function(e) {
        var fileName = document.getElementById("photo").files[0]?.name || "Choose file";
        var nextSibling = e.target.nextElementSibling;
        nextSibling.innerText = fileName;
    });
</script>
@endsection