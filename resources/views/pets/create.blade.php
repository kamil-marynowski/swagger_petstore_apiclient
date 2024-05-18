@extends('layout.app')

@section('breadcrumbs')
@endsection

@section('header') Create new pet @endsection

@section('content')
    <div class="row mb-3">
        <form action="{{ route('pets.store') }}" method="post">
            @csrf
            <input id="category-name" type="hidden" name="category_name" value="DOG">
            <div class="row mb-3">
                <div class="col-xs-12 col-sm-12 col-md-6">
                    <div class="form-group mb-3">
                        <label class="form-label fw-bold" for="category-id">Category<span class="text-danger">*</span></label>
                        <select id="category-id" class="form-select" name="category_id">
                            @foreach(\App\Enums\PetCategories::cases() as $petCategory)
                                <option value="{{ $petCategory->value }}">{{ $petCategory->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-6">
                    <div class="form-group mb-3">
                        <label class="form-label fw-bold" for="status">Status<span class="text-danger">*</span></label>
                        <select id="status" class="form-select" name="status">
                            @foreach(\App\Enums\PetStatuses::cases() as $status)
                                <option value="{{ $status->value }}"
                                        @if($status->value === 'available') selected @endif
                                >
                                    {{ $status->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('status')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col">
                    <div class="form-group mb-3">
                        <label class="form-label fw-bold" for="name">Name<span class="text-danger">*</span></label>
                        <input id="" class="form-control" type="text" name="name" value="{{ old('name') }}">
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col">
                    <button class="btn btn-success float-end" type="submit">Add</button>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
    <script>
        const categorySelect = document.querySelector('#category-id');
        const categoryName   = document.querySelector('#category-name');
        categorySelect.addEventListener('change', () => {
            categoryName.value = categorySelect.options[categorySelect.selectedIndex].innerText;
        });
    </script>
@endsection
