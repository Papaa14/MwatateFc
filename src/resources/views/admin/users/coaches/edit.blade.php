@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Coach</h1>
        <a href="{{ route('coaches.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Back to Coaches
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Edit Coach Information</h6>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('coaches.update', $coach->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Full Name *</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $coach->name) }}" required>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email">Email Address *</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $coach->email) }}" required>
                            @error('email')
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
                            <label for="phone">Phone Number</label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone', $coach->phone) }}">
                            @error('phone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="specialization">Specialization *</label>
                            <select class="form-control @error('specialization') is-invalid @enderror" id="specialization" name="specialization" required>
                                <option value="">Select Specialization</option>
                                <option value="Fitness" {{ old('specialization', $coach->specialization) == 'Fitness' ? 'selected' : '' }}>Fitness</option>
                                <option value="Yoga" {{ old('specialization', $coach->specialization) == 'Yoga' ? 'selected' : '' }}>Yoga</option>
                                <option value="Nutrition" {{ old('specialization', $coach->specialization) == 'Nutrition' ? 'selected' : '' }}>Nutrition</option>
                                <option value="CrossFit" {{ old('specialization', $coach->specialization) == 'CrossFit' ? 'selected' : '' }}>CrossFit</option>
                                <option value="Personal Training" {{ old('specialization', $coach->specialization) == 'Personal Training' ? 'selected' : '' }}>Personal Training</option>
                            </select>
                            @error('specialization')
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
                            <label for="photo">Profile Photo</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input @error('photo') is-invalid @enderror" id="photo" name="photo" accept="image/*">
                                <label class="custom-file-label" for="photo">Choose new file (leave blank to keep current)</label>
                                @error('photo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            @if($coach->photo_url)
                                <small class="form-text text-muted">Current: <a href="{{ $coach->photo_url }}" target="_blank">View photo</a></small>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="certifications">Certifications</label>
                            <input type="text" class="form-control @error('certifications') is-invalid @enderror" id="certifications" name="certifications" value="{{ old('certifications', $coach->certifications) }}">
                            @error('certifications')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="bio">Bio</label>
                    <textarea class="form-control @error('bio') is-invalid @enderror" id="bio" name="bio" rows="3">{{ old('bio', $coach->bio) }}</textarea>
                    @error('bio')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="years_experience">Years of Experience</label>
                            <input type="number" class="form-control @error('years_experience') is-invalid @enderror" id="years_experience" name="years_experience" value="{{ old('years_experience', $coach->years_experience) }}" min="0">
                            @error('years_experience')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="custom-control custom-switch pt-4">
                                <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" value="1" {{ old('is_active', $coach->is_active) ? 'checked' : '' }}>
                                <label class="custom-control-label" for="is_active">Active Coach</label>
                            </div>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Update Coach</button>
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