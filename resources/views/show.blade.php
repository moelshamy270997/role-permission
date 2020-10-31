@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card-body mt-xl-5">
                    <table class="table m-0">
                        <thead class="card-header">
                            <tr>
                                <th>{{ __('name') }}</th>
                                <th>{{ __('e-mail') }}</th>
                                <th>{{ __('created_at') }}</th>
                                <th>{{ __('updated_at') }}</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->created_at }}</td>
                                <td>{{ $user->updated_at }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
