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
                                <th>{{ __('guard_name') }}</th>
                                <th>{{ __('created_at') }}</th>
                                <th>{{ __('updated_at') }}</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <td>{{ $role->name }}</td>
                                <td>{{ $role->guard_name }}</td>
                                <td>{{ $role->created_at }}</td>
                                <td>{{ $role->updated_at }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
