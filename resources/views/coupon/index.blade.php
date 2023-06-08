@extends('layout.layout')
@section('title', 'Coupon List')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>List Coupon</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">List Coupon</li>
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
                    <h3 class="card-title">List Coupon</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="brand" class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>Coupon Id</th>
                            <th>Coupon Name</th>
                            <th>Coupon Code</th>
                            <th>Coupon Value</th>
                            <th>Coupon Start</th>
                            <th>Coupon End</th>
                            <th>Coupon Quantity</th>
                            <th>Used_count</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($coupons as $c)
                        <tr>
                            <td>{{ $c->id }}</td>
                            <td>{{ $c->name }}</td>
                            <td>{{ $c->code }}</td>
                            <td>{{ $c->value }}</td>
                            <td>{{ $c->start_date }}</td>
                            <td>{{ $c->end_date }}</td>
                            <td>{{ $c->quantity }}</td>
                            <td>{{ $c->used_count }}</td>

                            <td class="text-right">
                                {{-- <a class="btn btn-primary btn-sm" href="{{url('subcategory/view/' . $s->id)}}">
                                    <i class="fas fa-folder"></i> View
                                </a> --}}
                                <a class="btn btn-info btn-sm" href="{{ url('coupon/edit/'.$c->id) }}">
                                    <i class="fas fa-pencil-alt"></i> Edit
                                </a>
                                <a class="btn btn-danger btn-sm" href="{{ url('coupon/delete/'.$c->id) }}"
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
        $('#brand').DataTable();
    });
</script>
@endsection