@extends('layouts.admin')

@section('content')
    <div class="container-fluid pt-4 px-4">
        <div class="bg-light text-center rounded p-4">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h6 class="mb-0">Edit Quality</h6>
                <a href="{{ route('admin.quality.index') }}" class="btn btn-primary">Back</a>
            </div>
            <div class="table-responsive">
                <form method="POST" action="{{ route('admin.quality.update', $quality->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" name="name" value="{{$quality->name}}" >
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="type" class="form-label">Type</label>
                            <input type="type" class="form-control" name="type" value="{{$quality->type}}" >
                        </div>
                    </div>

                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary float-end">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
