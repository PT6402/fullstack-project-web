@extends('layout.layout')
@section('title', 'Order List')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>List Order</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">List Order</li>
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
                    <h3 class="card-title">List Order</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="brand" class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>User ID</th>
                            <th>Shipping Address</th>
                            <th>Customer Phone</th>
                            <th>Total Price</th>
                            <th>Discount ID</th>
                            <th>Status</th>
                            <th>Payment Method</th>
                            <th>Status Payment</th>

                        </tr>
                        </thead>
                        <tbody>
                        @foreach($orders as $o)
                        <tr>
                            <td>{{ $o->id }}</td>
                            <td>{{ $o->user_id }}</td>
                            <td>{{ $o->shipping_address }}</td>
                            <td>{{ $o->customer_phone }}</td>
                            <td>{{ $o->total_price }}</td>
                            <td>{{ $o->discount_id }}</td>
                            <td>{{ $o->status }}</td>
                            <td>{{ $o->payment_method }}</td>
                            <td>{{ $o->status_payment }}</td>
                            <td class="text-right">
                                <a class="btn btn-primary btn-sm" href="{{url('order/view/' . $o->id)}}">
                                    <i class="fas fa-folder"></i> View
                                </a>
                                <a class="btn btn-info btn-sm" href="{{ url('order/edit/'.$o->id) }}">
                                    <i class="fas fa-pencil-alt"></i> Edit
                                </a>
                                <a class="btn btn-danger btn-sm" href="{{ url('order/delete/'.$o->id) }}"
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