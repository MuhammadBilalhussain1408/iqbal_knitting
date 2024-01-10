@extends('layouts.admin')

@section('content')
    <div class="container-fluid pt-4 px-4">
        <div class="bg-light text-center rounded p-4">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h6 class="mb-0">Add Party</h6>
                <a href="{{ route('admin.party.index') }}" class="btn btn-primary">Back</a>
            </div>

            <form method="POST" action="{{ route('admin.party.update', $party->id) }}">
                @csrf
                @method('put')
                <div class="row">
                   
                    <div class="col-md-6 mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" name="name" value="{{ $party->name }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" value="{{ $party->email }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="number" class="form-control" name="phone" value="{{ $party->phone }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="role" class="form-label">Address</label>
                        <input type="text" class="form-control" name="address" value="{{ $party->address }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="checkbox" class="form-label">Wastage</label>
                        <input type="checkbox" class="form-check-input" name="wastage_status" 
                               id="checkbox" @if($party->wastage_status) checked @endif onchange="toggleDropdown()">
                    </div>

                    <div class="col-md-4 mb-2">
                        <label for="dropdown" class="form-label">Wastage Percentage</label>
                        <select class="form-select" name="wastage_percentage" id="dropdown" 
                                @if(!$party->wastage_status) disabled @endif>
                            <option value="0.5" @if($party->wastage_percentage == 0.5) selected @endif>0.5</option>
                            <option value="1.0" @if($party->wastage_percentage == 1.0) selected @endif>1.0</option>
                            <option value="1.5" @if($party->wastage_percentage == 1.5) selected @endif>1.5</option>
                            <option value="2.0" @if($party->wastage_percentage == 2.0) selected @endif>2.0</option>
                        </select>
                    </div>
                </div>
                <div class="mb-3">
                    <button type="submit" class="btn btn-primary float-end">Update</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    function toggleDropdown() {
        var checkbox = document.getElementById("checkbox");
        var dropdown = document.getElementById("dropdown");

        dropdown.disabled = !checkbox.checked;

        if (!checkbox.checked) {
            
            dropdown.disabled = true;
        }
    }
</script>
@endpush