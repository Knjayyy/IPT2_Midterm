@extends('base')

@section('content')
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold">Add a Courier</h1>
        <a href="{{ route('dashboard') }}" class="btn btn-secondary">Back to All Couriers</a>
    </div>

    <div class="card col-md-4 mx-auto">
        <div class="card-body">
            <form action="{{ route('courier.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="details">Details:</label>
                    <textarea class="form-control" id="details" name="details" rows="3"></textarea>
                </div>
                <div class="form-group">
                    <label for="release_date">Release Date:</label>
                    <input type="date" class="form-control" id="release_date" name="release_date">
                </div>
                <button type="submit" class="btn btn-primary mt-3">Save</button>
            </form>

            {{-- <a href="{{ route('dashboard') }}" class="d-block mt-3">Back to All Couriers</a> --}}
        </div>
    </div>
</div>
@endsection
