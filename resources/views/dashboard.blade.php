@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">

                <div class="card-body">
                    @if(session('success-created'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success-created') }}
                        </div>


                    @elseif(session('success-deleted'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success-deleted') }}
                        </div>


                    @elseif(session('success-restored'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success-restored') }}
                        </div>
                    @endif
                </div>

                <div class="mt-xl-5">
                    @can('admin', Auth::user())
                        <div class="card-body float-right">
                            <a href="{{ route('user.create') }}">
                                <button class="btn btn-success btn-lg" type="button" data-toggle="tooltip" data-placement="top" title="create">Create User</button>
                            </a>
                        </div>
                    @endcan
                    <div class="card-body">
                        <h3>{{ __('Users Table') }}</h3>
                    </div>
                </div>

                <div class="card-body mt-xl-1">
                    <table class="table m-0">
                        <thead class="card-header">
                            <tr>
                                <th>{{ __('name') }}</th>
                                <th>{{ __('e-mail') }}</th>
                                <th>{{ __('created_at') }}</th>
                                <th>{{ __('updated_at') }}</th>
                                <th>{{ __('operations') }}</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->created_at }}</td>
                                    <td>{{ $user->updated_at }}</td>
                                    <td>
                                        @if($user->trashed())
                                            <li class="list-inline-item">
                                                <form action="{{ route('user.restore', ['id' => $user->id]) }}" method="POST">
                                                    @csrf
                                                    <button class="btn btn-dark btn-sm" type="submit" data-toggle="tooltip" data-placement="top" title="Restore">restore</button>
                                                </form>
                                            </li>
                                        @else
                                            <ul class="list-inline m-0">
                                                <li class="list-inline-item">
                                                    <a href="{{ route('user.show', $user->id) }}">
                                                        <button class="btn btn-success btn-sm" type="button" data-toggle="tooltip" data-placement="top" title="Show">show</button>
                                                    </a>
                                                </li>
                                                @can('admin', Auth::user())
                                                    <li class="list-inline-item">
                                                        <a href="{{ route('user.edit', $user->id) }}">
                                                            <button class="btn btn-primary btn-sm" type="button" data-toggle="tooltip" data-placement="top" title="Edit">edit</button>
                                                        </a>
                                                    </li>

                                                    <li class="list-inline-item">
                                                        <form action="{{ route('user.destroy', $user->id) }}" method="POST">
                                                            @method('delete')
                                                            @csrf
                                                            <a href="">
                                                                <button class="btn btn-danger btn-sm" type="submit" data-toggle="tooltip" data-placement="top" title="Delete">delete</button>
                                                            </a>
                                                        </form>
                                                    </li>
                                                @endcan
                                            </ul>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
