@extends('layout.layout')
@section('title', 'Size List')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>List Size</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">List Size</li>
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
                    <h3 class="card-title">List Size</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="Size" class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>Id</th>
                            <th>Size Name</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($sizes as $s)
                        <tr>
                            <td>{{ $s->id }}</td>
                            <td>{{ $s->size_name }}</td>
                            
                            <td class="text-right">
                                <a class="btn btn-info btn-sm" href="{{ url('size/edit/'.$s->id) }}">
                                    <i class="fas fa-pencil-alt"></i> Edit
                                </a>
                                <a class="btn btn-danger btn-sm" href="{{ url('size/delete/'.$s->id) }}"
                                    onclick='return confirm("Are you sure???")'>
                                    <i class="fas fa-trash"></i> Delete
                                </a>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                        
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
        $('#Size').DataTable();
    });
</script>
@endsection