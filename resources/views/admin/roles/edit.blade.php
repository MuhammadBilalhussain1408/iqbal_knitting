@extends('layouts.admin')

@section('content')

<div class="container-fluid pt-4 px-4">
    <div class="bg-light text-center rounded p-4">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h6 class="mb-0">Edit Role</h6>
            <button  href="{{ route('admin.role.index') }}" class="btn btn-primary">Back</button>
        </div>
        <div class="table-responsive">
            <form method="POST" action="{{ route('admin.role.update', $roles->id) }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ $roles->name }}" required>
                </div>

                <!-- Add other fields for role editing as needed -->

                <div class="mb-3">
                    <button type="submit" class="btn btn-primary float-end" >Update Role</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
