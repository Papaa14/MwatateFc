@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Confirm Delete</h1>
        
        <div class="alert alert-danger">
            Are you sure you want to delete this item?
        </div>
        
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">{{ $item->name }}</h5>
                <p class="card-text">{{ $item->description }}</p>
            </div>
        </div>
        
        <form action="{{ route('items.destroy', $item->id) }}" method="POST">
            @csrf
            @method('DELETE')
            
            <button type="submit" class="btn btn-danger">Confirm Delete</button>
            <a href="{{ route('items.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
@endsection