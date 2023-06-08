@extends('layout.layout')
@section('title', 'Update Color')
@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="offset-md-3 col-md-6">
                <!-- general form elements -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Update Color</h3>
                    </div>

                    {{-- check error --}}
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <!-- /.card-header -->
                    <!-- form start -->
                    <form role="form" action="{{ url('color/postEdit') }}" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="card-body">
                            <div class="form-group">
                                <label for="txt-name">Color Id</label>
                                <input type="text" class="form-control" name="id" readonly value="{{$color->id}}">
                            </div>
                            <div class="form-group">
                                <label for="txt-name">Color Name</label>
                                <input type="text" class="form-control" id="txt-name" name="color_name" value="{{$color->name}}">
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