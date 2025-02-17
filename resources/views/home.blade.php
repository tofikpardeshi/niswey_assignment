@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <div class="row">
                            <div class="col-md-12 d-flex justify-content-between">
                                <a href="{{ url('add-contact-page') }}" class="btn btn-info">Add Contact</a>
                                <form action="{{ route('contacts.importXml') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="d-flex gap-2 align-items-center">
                                        <input type="file" name="xml_file" id="xml_file"
                                            class="form-control @error('xml_file') is-invalid @enderror"
                                            style="max-width: 300px;">
                                        <button type="submit" class="btn btn-primary">Import XML</button>
                                    </div>
                                    <!-- Validation Error Message -->
                                    @error('xml_file')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </form>
                            </div>
                            <div class="col-md-12">
                                <h3>Import Data</h3>
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th scope="col">S. Number</th>
                                            <th scope="col">First Name</th>
                                            <th scope="col">Last Name</th>
                                            <th scope="col">Number</th>
                                            <th scope="col">Created By</th>
                                            <th scope="col">Updated By</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $i = 1;
                                        @endphp
                                        @foreach ($getContacts as $getContact)
                                            @php
                                                $createdByName = App\Models\User::where(
                                                    'id',
                                                    $getContact->user_id,
                                                )->value('name');

                                                $updatedByName = App\Models\User::where(
                                                    'id',
                                                    $getContact->updated_by,
                                                )->value('name');
                                            @endphp
                                            <tr>
                                                <td>{{ $i++ }}</td>
                                                <td>{{ $getContact->first_name }}</td>
                                                <td>{{ $getContact->last_name }}</td>
                                                <td>{{ $getContact->phone }}</td>
                                                <td>{{ $createdByName ?? 'N/A' }}</td>
                                                <td>{{ $updatedByName ?? 'N/A' }}</td>
                                                <td>
                                                    <a href="{{ url('edit-contact/' . $getContact->id) }}"
                                                        class="btn btn-warning">Edit</a>
                                                    <a href="{{ url('delete-contact/' . $getContact->id) }}"
                                                        class="btn btn-danger">Delete</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
