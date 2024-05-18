@extends('layout.app')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active" aria-current="page">Pets</li>
@endsection

@section('header') Pets @endsection

@section('content')
    <div class="row mb-3">
        <div class="col">
            <a class="btn btn-success" href="{{ route('pets.create') }}" title="Create new pet">
                Create new pet
            </a>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col">
            <table class="table table-bordered table-striped table-responsive">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @if(empty($pets))
                        <tr>
                            <td class="text-center" colspan="4">No pets found.</td>
                        </tr>
                    @else
                        @foreach($pets as $pet)
                            <tr>
                                <td>{{ $pet['id'] }}</td>
                                <td>{{ $pet['name'] }}</td>
                                <td>{{ $pet['category']['name'] }}</td>
                                <td>
                                    <a class="btn btn-warning" href="{{ route('pets.edit', ['id' => $pet['id']]) }}">
                                        Edit
                                    </a>
                                    <button class="btn btn-danger delete-pet-btn" data-bs-toggle="modal"
                                            data-route="{{ route('pets.destroy', ['id' => $pet['id']]) }}"
                                            data-bs-target="#delete-pet-modal"
                                    >
                                        Delete
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    <!-- Delete Pet Modal -->
    <div class="modal fade" id="delete-pet-modal" tabindex="-1" aria-labelledby="delete-pet-modal-label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="delete-pet-modal-label">Pet deleting</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form id="delete-pet-form" action="" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Yes, delete it</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        const deletePetForm = document.querySelector('#delete-pet-form');
        const petDeleteBtns = document.querySelectorAll('.delete-pet-btn');

        for (const petDeleteBtn of petDeleteBtns) {
            petDeleteBtn.addEventListener('click', () => {
                console.log(petDeleteBtn.dataset.route);
                deletePetForm.action = petDeleteBtn.dataset.route;
            });
        }
    </script>
@endsection
