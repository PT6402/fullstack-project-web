@extends('layout.layout')
@section('title', 'Create SubCategory')
@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="offset-md-3 col-md-6">
                <!-- general form elements -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Create Order</h3>
                    </div>

                    {{-- check error --}}
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <!-- /.card-header -->
                    <!-- form start -->
                    <form role="form" action="{{ url('subcategory/postCreate') }}" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="card-body">
                            <div class="form-group">
                                <label for="txt-name">SubCategory Name</label>
                                <input type="text" class="form-control" id="txt-name" name="subcategory_name" placeholder="Input SubCategory Name">
                            </div>
                            {{-- <div class="form-group">
                                <label for="txt-name">SubCategory Slug</label>
                                <input type="text" class="form-control" id="txt-name" name="subcategory_slug" placeholder="No input" readonly>
                            </div> --}}
                            <div class="form-group">
                                <label for="txt-name">Category Id</label>
                                {{-- <select name="category_id" class="form-control">
                                     @foreach ($categorys as $c)
                                        <option value="{{$c->category_id}}">{{$c->category_name}}</option>
                                    @endforeach 
                                 </select> --}} 
                                <input type="text" class="form-control" id="txt-name" name="category_id" placeholder="Input Category Id">
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