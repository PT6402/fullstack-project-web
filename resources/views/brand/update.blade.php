@extends('layout.layout')
@section('title', 'Update Brand')
@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="offset-md-3 col-md-6">
                <!-- general form elements -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Update Brand</h3>
                    </div>

                    {{-- check error --}}
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <!-- /.card-header -->
                    <!-- form start -->
                    <form role="form" action="{{ url('brand/postEdit') }}" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="card-body">
                            <div class="form-group">
                                <label for="txt-name">Brand Id</label>
                                <input type="text" class="form-control" name="id" readonly value="{{$brand->id}}">
                            </div>
                            <div class="form-group">
                                <label for="txt-name">Brand Name</label>
                                <input type="text" class="form-control" id="txt-name" name="name" value="{{$brand->name}}">
                            </div>
                            <div class="form-group">
                                <img src="{{url('images/'.$brand->image)}}" alt="{{$brand->image}}">
                                <br>
                                <label for="image">Choose Image</label>
                                <div class="input-group">
                                    <input type="file" id="image" name="image">
                                </div>
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