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
                                <form role="form" action="{{URL::to('inventory/postedit')}}" method="post" enctype="multipart/form-data">
                                    {{ csrf_field() }}

                                    <div class="form-group">
                                    <label for="exampleInputPassword1"> Color</label>
                                      <select name="color_id" class="form-control input-sm m-bot15">
                                        
                                        @foreach($color_product as $co)
                                            <option value="{{$co->id}}" @if($colorsize_product->color_id == $co->id) selected @endif>{{$co->color_name}}</option>
                                            @endforeach
                                            
                                    </select>
                                </div>

                                 <div class="form-group">
                                    <label for="exampleInputPassword1"> Size</label>
                                      <select name="size_id" class="form-control input-sm m-bot15">
                                        
                                        @foreach($size_product as $si)
                                            <option value="{{$si->id}}" @if($colorsize_product->size_id == $si->id) selected @endif>{{$si->size_name}}</option>
                                            @endforeach  
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Quantity</label>
                                    <input type="number" data-validation="number" data-validation-error-msg="Enter quantity" name="product_quantity" class="form-control" id="exampleInputEmail1" placeholder="Enter Quantity" value="{{ $colorsize_product->quantity }}">
                                </div>

                                <input type="hidden" name="colorsize_id" value="{{$colorsize_product->id}}">

    
                                <button type="submit" name="add_product" class="btn btn-info">Update</button>
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