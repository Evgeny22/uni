@extends('layouts.default')

@section('content')

    <section class="users component">

        <div class="row">

            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        Roles
                    </h3>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="sample_1">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    @if ($user->is('super_admin') or $user->is('mod'))
                                        <th>Action</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($roles as $role)
                                <tr>
                                    <td>{{ $role->display_name }}
                                    </td>
                                    @if ($user->is('super_admin') or $user->is('mod'))
                                        <td>
                                            <div class="comment-actions">
                                                <a href="{{ route('permissions.update', ['id' => $role->id ]) }}" class="btn btn-action btn-info">Edit Permissions</a>
                                            </div>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>

    </section>
    <script type="text/javascript" src="{{ app('request')->root() }}/vendors/datatables/js/jquery.dataTables.js"></script>
    <script type="text/javascript" src="{{ app('request')->root() }}/vendors/datatables/js/dataTables.bootstrap.js"></script>
    <script type="text/javascript" src="{{ app('request')->root() }}/js//custom_js/datatables_custom.js"></script>
@endsection
