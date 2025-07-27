@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1>Schedule New Training Session</h1>
            <p class="lead">Plan your team's training activities</p>
        </div>
        <div class="col-md-4 text-right">
            <a href="{{ route('trainings.index') }}" class="btn btn-secondary">Back to Sessions</a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('trainings.store') }}">
                @csrf

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="datetime">Date & Time</label>
                        <input type="datetime-local" class="form-control @error('datetime') is-invalid @enderror" 
                               id="datetime" name="datetime" value="{{ old('datetime') }}" required>
                        @error('datetime')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="duration">Duration (minutes)</label>
                        <input type="number" class="form-control @error('duration') is-invalid @enderror" 
                               id="duration" name="duration" value="{{ old('duration', 90) }}" min="30" max="180" required>
                        @error('duration')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="focus">Focus Area</label>
                        <select class="form-control @error('focus') is-invalid @enderror" id="focus" name="focus" required>
                            <option value="fitness" {{ old('focus') == 'fitness' ? 'selected' : '' }}>Fitness & Conditioning</option>
                            <option value="technical" {{ old('focus') == 'technical' ? 'selected' : '' }}>Technical Skills</option>
                            <option value="tactical" {{ old('focus') == 'tactical' ? 'selected' : '' }}>Tactical Work</option>
                            <option value="strategy" {{ old('focus') == 'strategy' ? 'selected' : '' }}>Game Strategy</option>
                            <option value="recovery" {{ old('focus') == 'recovery' ? 'selected' : '' }}>Recovery Session</option>
                        </select>
                        @error('focus')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="intensity">Planned Intensity</label>
                        <select class="form-control @error('intensity') is-invalid @enderror" id="intensity" name="intensity" required>
                            <option value="1" {{ old('intensity') == '1' ? 'selected' : '' }}>Light (Recovery)</option>
                            <option value="2" {{ old('intensity') == '2' ? 'selected' : '' }}>Moderate</option>
                            <option value="3" {{ old('intensity') == '3' ? 'selected' : '' }}>Standard</option>
                            <option value="4" {{ old('intensity') == '4' ? 'selected' : '' }}>High Intensity</option>
                            <option value="5" {{ old('intensity') == '5' ? 'selected' : '' }}>Maximum Effort</option>
                        </select>
                        @error('intensity')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="location">Location</label>
                        <input type="text" class="form-control @error('location') is-invalid @enderror" 
                               id="location" name="location" value="{{ old('location', 'Main Training Field') }}" required>
                        @error('location')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="coach_id">Lead Coach</label>
                        <select class="form-control @error('coach_id') is-invalid @enderror" id="coach_id" name="coach_id" required>
                            @foreach($coaches as $coach)
                                <option value="{{ $coach->id }}" {{ old('coach_id') == $coach->id ? 'selected' : '' }}>
                                    {{ $coach->name }} ({{ $coach->specialty }})
                                </option>
                            @endforeach
                        </select>
                        @error('coach_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="objectives">Session Objectives</label>
                    <textarea class="form-control @error('objectives') is-invalid @enderror" 
                              id="objectives" name="objectives" rows="3" required>{{ old('objectives') }}</textarea>
                    @error('objectives')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="notes">Additional Notes</label>
                    <textarea class="form-control" id="notes" name="notes" rows="2">{{ old('notes') }}</textarea>
                </div>

                <div class="form-group">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="equipment_needed" name="equipment_needed" {{ old('equipment_needed') ? 'checked' : '' }}>
                        <label class="form-check-label" for="equipment_needed">
                            Special equipment needed
                        </label>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Schedule Training Session</button>
            </form>
        </div>
    </div>
</div>
@endsection