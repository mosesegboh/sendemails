@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-2">
                <!-- Sidebar -->
                <div class="card">
                    <div class="card-header">{{ __('Navigation') }}</div>
                    <div class="card-body">
                        <div class="d-flex flex-column align-items-center">
                            <a href="/home" class="btn btn-primary mb-2">
                                <i class="fas fa-tachometer-alt"></i> Dashboard
                            </a>
                            <a href="#" class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#exampleModalGroup">
                                <i class="fas fa-plus"></i> Add Group
                            </a>
                            <a href="#" class="btn btn-primary mb-2 addEmailButton" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                <i class="fas fa-plus"></i> Add Email
                            </a>
                            <a href="#" class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#exampleModalTemplate">
                                <i class="fas fa-book"></i> Add Template
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!--Add Customer Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModal" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Add Email</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form>
                                <div class="form-group row mb-3">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">Email</label>
                                    <div class="col-sm-10">
                                        <input type="email" name="email" class="form-control" id="inputEmail3" placeholder="Email">
                                    </div>
                                </div>

                                <div class="form-group row mb-3">
                                    <label for="firstName" class="col-sm-2 col-form-label">First</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="firstName" class="form-control" id="firstName" placeholder="First Name">
                                    </div>
                                </div>

                                <div class="form-group row mb-3">
                                    <label for="lastName" class="col-sm-2 col-form-label">Last</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="lastName" class="form-control" id="lastName" placeholder="Last Name">
                                    </div>
                                </div>

                                <fieldset class="form-group mb-3">
                                    <div class="row">
                                        <legend class="col-form-label col-sm-2 pt-0">Sex</legend>
                                        <div class="col-sm-10">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="male" id="male" value="male" checked>
                                                <label class="form-check-label" for="gridRadios1">
                                                    Male
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="female" id="female" value="female">
                                                <label class="form-check-label" for="gridRadios2">
                                                    Female
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>

                                <div class="form-group row mb-3">
                                    <label for="lastName" class="col-sm-2 col-form-label">Select Group</label>
                                    <div class="col-sm-10">
                                        <select class="custom-select form-control" >
                                            <option selected>Select Group</option>
                                            <option value="1">One</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-10">
                                        <button type="submit" class="btn btn-primary">Add Group</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Group Modal -->
            <div class="modal fade" id="exampleModalGroup" tabindex="-1" aria-labelledby="exampleModalGroup" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Add Group</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div id="responseMessage" class="text-center mb-2"></div>
                            <div id="groupRoute" data-store-url="{{ route('groups.store') }}"></div>
                            <form action="{{ route('groups.store') }}" method="post" id="addGroupForm">
                                @csrf
                                <div class="form-group row mb-3">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">Name</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="groupName" class="form-control" id="groupName" placeholder="Group Name">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-10">
                                        <button type="submit" class="btn btn-primary">Add Group</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Email Template Modal -->
            <div class="modal fade" id="exampleModalTemplate" tabindex="-1" aria-labelledby="exampleModalTemplate" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Add Email Template</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form>
                                <div class="form-group row mb-3">
                                    <label for="subject" class="col-sm-2 col-form-label">Subject</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="subject" class="form-control" id="subject" placeholder="Subject">
                                    </div>
                                </div>

                                <div class="form-group row mb-3">
                                    <label for="body" class="col-sm-2 col-form-label">Body</label>
                                    <div class="col-sm-10">
                                        <textarea name="body" class="form-control" id="body" rows="20"></textarea>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-10">
                                        <button type="submit" class="btn btn-primary">Add Template</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <div id="responseMessageTable" class="text-center mb-2"></div>
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Group Name</th>
                                <th scope="col">Edit</th>
                                <th scope="col">Remove</th>
                            </tr>
                            </thead>
                            <tbody id="groupsTableBody">
                            @forelse($emails as $email)
                                <tr>
                                    <th scope="row">{{ $group->id }}</th>
                                    <td>{{ $group->name }}</td>
                                    <td>
                                        <a href="#" class="mb-2 editGroupButton"
                                           data-id="{{ $group->id }}"
                                           data-name="{{ $group->name }}"
                                        >
                                            <i class="fas fa-pen"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="#" class="mb-2 deleteGroupButton"
                                           data-id="{{ $group->id }}"
                                        >
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center align-middle">The table is empty.</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
