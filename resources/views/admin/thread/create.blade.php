@extends('layouts.admin')

@section('content')
    <div class="container-fluid pt-4 px-4">
        <div class="bg-light text-center rounded p-4">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h6 class="mb-0">Add Thread</h6>
                <a href="{{ route('admin.thread.index') }}" class="btn btn-primary">Back</a>
            </div>
            <form method="POST" action="{{ route('admin.thread.store') }}">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" name="name"  />
                    </div>
                    <div class="col-md-6">
                        <label for="type" class="form-label">Type</label>
                        <input type="text" class="form-control" name="type"  />
                    </div>
                </div>

                <div class="mb-3 mt-3">
                    <button type="submit" class="btn btn-primary float-end">Submit</button>
                </div>
            </form>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        function isEqualWeight() {
            let checkbox = $('#is_equal_weight').is(':checked');
            if (checkbox) {
                $('#net_weight').attr('disabled', false);
            } else {
                $('#net_weight').attr('disabled', true);
            }
        }

    </script>
@endpush
