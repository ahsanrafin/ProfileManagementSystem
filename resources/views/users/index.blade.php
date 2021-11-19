@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('List of Registered Users') }}</div>

                <div class="card-body">
                    <table class="table">
                        <thead class="thead-dark">
                          <tr>
                            <th scope="col">SL No.</th>
                            <th scope="col">Profile Image</th>
                            <th scope="col">Name</th>
                            <th scope="col">Father Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Eligible Actions</th>
                          </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $serial => $user)                                
                                <tr>
                                    <th scope="row">{{ $serial+1 }}</th>
                                    <td><img class="img-fluid rounded" style="max-width: 200px;" src="{{ url('/uploads/'. $user->profile_image) }}" alt="{{ $user->name }}"></td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->father_name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        @auth
                                            @if (auth()->user()->id == $user->id)   
                                                <a href="{{ route('user.edit', $user->id) }}" class="btn btn-primary">Edit</a>
                                            @endif
                                            @else
                                                <a href="#" class="btn btn-primary disabled">Edit</a>       
                                        @endauth
                                        
                                        @auth
                                            @if (auth()->user()->id == $user->id)   
                                                <button class="btn btn-danger disabled">Delete</button> 
                                            @else
                                                <button data-toggle="modal" data-target="#deleteUser{{ $user->id }}" class="btn btn-danger">Delete</button>    
                                            @endif       
                                        @endauth
                                    </td>
                                </tr>
                                <!-- Delete Modal -->
                                <div class="modal fade" id="deleteUser{{ $user->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Delete User</h5>
                                        <!-- Button trigger modal -->
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        </div>
                                        <form action="{{ route('user.destroy', $user->id) }}" method="POST">
                                            @csrf
                                            <div class="modal-body">
                                                <p>Are you want to delete ?? <span class="font-weight-bold text-danger text-outline-danger">{{ $user->name }}</span></p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-danger">Delete User</button>
                                            </div>
                                        </form>
                                    </div>
                                    </div>
                                </div>

                            @endforeach
                        </tbody>
                      </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
