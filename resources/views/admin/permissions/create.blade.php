@extends('layouts.admin')

@section('content')
    <div class="container-fluid pt-4 px-4">
        <div class="bg-light text-center rounded p-4">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h6 class="mb-0">Add Permission</h6>
                <a href="{{ route('admin.permissions.index') }}" class="btn btn-primary">Back</a>
            </div>
            <div class="table-responsive">
                <form method="POST" action="{{ route('admin.permissions.store') }}">
                    @csrf
                    <div class="text-start">
                        <strong>Name</strong>
                        <input type="text" class="form-control" id="name" name="name"
                            required>
                    </div>
                   
                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary float-end">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

