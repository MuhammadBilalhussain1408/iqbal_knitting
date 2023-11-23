@extends('layouts.admin')

@section('content')
    <div class="container-fluid pt-4 px-4">
        <div class="bg-light text-center rounded p-4">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h6 class="mb-0">Edit Permission</h6>
                <a href="{{ route('admin.permissions.index') }}" class="btn btn-primary">Back</a>
            </div>
            <div class="table-responsive">
                <form method="POST" action="{{ route('admin.permissions.update', $permission->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="text-start">
                        <strong>Name</strong>
                        <input type="text" class="form-control" id="name" name="name" value="{{ $permission->name }}"
                            required>
                    </div>
                    
                    <!-- Add other fields for role editing as needed -->

                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary float-end">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

