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
                        <input type="text" class="form-control" name="name" required />
                    </div>
                    <div class="col-md-6">
                        <label for="type" class="form-label">Type</label>
                        <input type="text" class="form-control" name="type" required />
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-6">
                        <label for="party" class="form-label">Party</label>
                        {{-- <input type="text" class="form-control" name="party" required /> --}}
                        <select name="party" id="party" class="form-control" required>
                            <option value="">Select party</option>
                            @foreach ($parties as $party)
                                <option value="{{ $party->id }}">{{ $party->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="net_weight" class="form-label d-flex justify-content-between">
                            <span>Net Weight Per Box</span>
                            <div>
                                <b>Box has equal Weight ?</b>
                                <input type="checkbox" name="is_equal_weight" onchange="isEqualWeight()"
                                    id="is_equal_weight" />
                            </div>
                        </label>
                        <input class="form-control" name="net_weight" id="net_weight" disabled />
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
