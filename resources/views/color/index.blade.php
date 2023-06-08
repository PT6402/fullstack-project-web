@extends('layout.layout')
@section('title', 'Color List')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>List Color</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">List Color</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-12">
            <div class="card">
                @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                @endif

                @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                @endif
                <div class="card-header">
                    <h3 class="card-title">List Color</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="Color" class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>Color Id</th>
                            <th>Color Name</th>
                            <th>Color Code</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($colors as $c)
                        <tr>
                            <td>{{ $c->id }}</td>
                            <td>{{ $c->color_name }}</td>
                            <td>{{ $c->color_code }}</td>
                            <td class="text-right">
                                <a class="btn btn-info btn-sm" href="{{ url('color/edit/'.$c->id) }}">
                                    <i class="fas fa-pencil-alt"></i> Edit
                                </a>
                                <a class="btn btn-danger btn-sm" href="{{ url('color/delete/'.$c->id) }}"
                                    onclick='return confirm("Are you sure???")'>
                                    <i class="fas fa-trash"></i> Delete
                                </a>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <th>Color Id</th>
                            <th>Color Name</th>
                            <th>Image</th>
                            <th></th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</section>
@endsection
@section('script-content')
<script>
    $(function () {
        $('#Color').DataTable();
    });
</script>
@endsection