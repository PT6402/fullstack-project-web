@extends('layout.layout')
@section('title', 'Update Coupon')
@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="offset-md-3 col-md-6">
                <!-- general form elements -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Update Coupon</h3>
                    </div>

                    {{-- check error --}}
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <!-- /.card-header -->
                    <!-- form start -->
                    <form role="form" action="{{ url('coupon/postEdit') }}" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="card-body">
                            <div class="form-group">
                                <label for="txt-name">Coupon Id</label>
                                <input type="text" class="form-control" value="{{$coupon->id}}" id="txt-name" name="id" readonly >
                            </div>
                            <div class="form-group">
                                <label for="txt-name">Coupon Name</label>
                                <input type="text" class="form-control" value="{{$coupon->name}}" id="txt-name" name="name" placeholder="Input Coupon Name" >
                            </div>
                            <div class="form-group">
                                <label for="txt-name">Coupon Code</label>
                                <input type="text" class="form-control" value="{{$coupon->code}}" id="txt-name" name="code" placeholder="Input Coupon code" >
                            </div>
                            <div class="form-group">
                                <label for="txt-name">Coupon Value</label>
                                <input type="text" class="form-control"value="{{$coupon->value}}" id="txt-name" name="value" placeholder="Coupon Value" >
                            </div>
                            <div class="form-group">
                                <label for="txt-name">Coupon Start</label>
                                <input type="datetime-local" class="form-control" value="{{$coupon->start_date}}" id="txt-name" name="start_date" placeholder="Coupon Start" >
                            </div>
                            <div class="form-group">
                                <label for="txt-name">Coupon End</label>
                                <input type="datetime-local" class="form-control" value="{{$coupon->end_date}}" id="txt-name" name="end_date" placeholder="Coupon End" >
                            </div>
                            <div class="form-group">
                                <label for="txt-name">Quantity</label>
                                <input type="text" class="form-control" id="txt-name" value="{{$coupon->quantity}}" name="quantity" placeholder="Quantity" >
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
                <!-- /.card -->
            </div>
        </div>
    </div>
</section>
@endsection
@section('script-content')
<script>
    ClassicEditor
        .create( document.querySelector( '.ck-editor' ) )
        .catch( error => {
            console.error( error );
        } );
</script>
@endsection