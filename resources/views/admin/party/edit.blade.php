@extends('layouts.admin')

@section('content')
    <div class="container-fluid pt-4 px-4">
        <div class="bg-light text-center rounded p-4">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h6 class="mb-0">Edit Party</h6>
                <a href="{{ route('admin.party.index') }}" class="btn btn-primary">Back</a>
            </div>

            <form method="POST" action="{{ route('admin.party.update', $party->id) }}">
                @csrf
                @method('put')
                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" name="name" value="{{ $party->name }}" >
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="number" class="form-control" name="phone" value="{{ $party->phone }}" >
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="role" class="form-label">Address</label>
                        <input type="text" class="form-control" name="address" value="{{ $party->address }}">
                    </div>

                </div>
                <div class="mb-3">
                    <button type="submit" class="btn btn-primary float-end">Update</button>
                </div>
            </form>
        </div>
    </div>
@endsection
