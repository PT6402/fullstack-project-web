@extends('layout.layout')
@section('content')

@if (session('message'))
<div class="alert alert-success">
    {{ session('message') }}
</div>
@endif

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @php
                $errorMessages = $errors->all();
            @endphp
            <li>{!! implode('</li><li>', $errorMessages) !!}</li>
        </ul>
    </div>
@endif


<div class="row">
            <div class="col-lg-12">
                    <section class="panel">
                        {{-- <header class="panel-heading">
                           Thêm sản phẩm
                        </header> --}}
                         <?php
                            $message = Session::get('message');
                            if($message){
                                echo '<span class="text-alert">'.$message.'</span>';
                                Session::put('message',null);
                            }
                            ?>
                        <div class="panel-body">

                            <div class="position-center">
                                <form role="form" action="{{URL::to('image/postEdit')}}" method="post" enctype="multipart/form-data">
                                    {{ csrf_field() }}

                                
                                 <div class="form-group">
                                    <label for="exampleInputEmail1">Image</label>
                                    <input type="file" name="product_image[]" class="form-control" id="image" multiple value="{{ old('product_image[]') }}">
                                </div>
                               
                                <input type="hidden" name="image_id[]" value="{{$id}}">

    
                                <button type="submit" name="add_product" class="btn btn-info">Edit Image</button>
                                </form>
                            </div>

                        </div>
                    </section>

            </div>
@endsection
@section ('script-content')
<script>
      ClassicEditor
        .create( document.querySelector( '.ck-editor' ) )
        .catch( error => {
            console.error( error );
        } );

</script>
@endsection