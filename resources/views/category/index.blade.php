@extends('layout.layout')
@section('title', 'Category List')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>List Category</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">List Category</li>
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
                    <h3 class="card-title">List Category</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="category" class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>Category Id</th>
                            <th>Category Name</th>
                            <th>Category Status</th>
                            <th>Subcategory Count</th>
                           
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($categorys as $c)
                        <tr>
                            <td>{{ $c->id }}</td>
                            <td>{{ $c->category_name }}</td>
                            <td>{{ $c->category_status }}</td>
                            <td>{{ $c->subcategory_count }}</td>
                            
                            <td>
                                <a class="btn btn-info btn-sm" href="{{ url('category/edit/'.$c->id) }}">
                                    <i class="fas fa-pencil-alt"></i> Edit
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
        $('#brand').DataTable();
    });
</script>
@endsection