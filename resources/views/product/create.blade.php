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
                                <form role="form" action="{{URL::to('product/postCreate')}}" method="post" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Product Name</label>
                                    <input type="text" data-validation="length" value="{{ old('product_name') }}" name="product_name" class="form-control " id="slug" placeholder="Product Name" onkeyup="ChangeToSlug();">
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Type</label>
                                    <input type="text" data-validation="length" value="{{ old('product_type') }}" name="product_type" class="form-control " id="slug" placeholder="Product Type" onkeyup="ChangeToSlug();">
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Material</label>
                                    <input type="text" data-validation="length" value="{{ old('product_material') }}" name="product_material" class="form-control " id="slug" placeholder="Material" onkeyup="ChangeToSlug();">
                                </div>


                                <div class="form-group">
                                    <label for="exampleInputEmail1">Product Description</label>
                                    <textarea class="form-control" rows="3" value="{{ old('product_description') }}" name="product_description"></textarea>

                                     {{-- <textarea class="form-control ck-editor" rows="5" name="product_description" placeholder="Enter ..."></textarea> --}}
                                </div>


                                {{-- <div class="form-group">
                                    <label for="exampleInputEmail1">Image</label>
                                    <input type="file" name="product_image[]" class="form-control" id="image" multiple value="{{ old('product_image[]') }}">
                                </div> --}}


                                 {{-- <div class="form-group">
                                    <label for="exampleInputEmail1">Quantity</label>
                                    <input type="number" data-validation="number" data-validation-error-msg="Enter quantity" name="product_quantity" class="form-control" id="exampleInputEmail1" placeholder="Enter Quantity" value="{{ old('product_quantity') }}">
                                </div> --}}

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Product Status</label>
                                    {{-- <input type="number" data-validation="number" data-validation-error-msg="" name="product_status" class="form-control" id="exampleInputEmail1" placeholder="Product Status" value="{{ old('product_status') }}"> --}}
                                    <select name="product_status" class="form-control input-sm m-bot15">
                                            <option value="0">Show</option>
                                            <option value="1">Hide</option>
                                            <option value="2">New</option>
                                            <option value="3">Sale</option>
                                    </select>
                                </div>

                                {{-- <div class="form-group">
                                    <label for="exampleInputEmail1">Product Status</label>
                                    <input type="text" data-validation="text" data-validation-error-msg="" name="product_status" class="form-control" id="exampleInputEmail1" placeholder="Product Status" value="{{ old('product_status') }}">
                                    @if (isset($product))
                                        <span>{{ $statusLabels[$product->product_status] }}</span>
                                    @endif
                                </div> --}}

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Price</label>
                                    <input type="number" name="product_price" class="form-control " id="product_price" value="{{ old('product_price') }}">
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputPassword1">SubCategory</label>
                                      <select name="subcategory_id" class="form-control input-sm m-bot15">
                                            @foreach($subcate_product as $c)
                                            <option value="{{$c->id}}">{{$c->subcategory_name}}</option>
                                            @endforeach
                                        </select>

                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1"> Category</label>
                                      <select name="category_id" class="form-control input-sm m-bot15">

                                        @foreach($cate_product as $s)
                                            <option value="{{$s->id}}">{{$s->category_name}}</option>
                                            @endforeach

                                    </select>
                                </div>

                                {{-- <div class="form-group">
                                    <label for="exampleInputPassword1"> Color</label>
                                      <select name="color_id" class="form-control input-sm m-bot15">

                                        @foreach($color_product as $co)
                                            <option value="{{$co->id}}">{{$co->color_name}}</option>
                                            @endforeach

                                    </select>
                                </div> --}}

                                {{-- <div class="form-group">
                                    <label for="exampleInputPassword1"> Size</label>
                                      <select name="size_id" class="form-control input-sm m-bot15">

                                        @foreach($size_product as $si)
                                            <option value="{{$si->id}}">{{$si->size_name}}</option>
                                            @endforeach
                                    </select>
                                </div> --}}

                                {{-- <div class="form-group">
                                    <label for="exampleInputPassword1">Size</label>
                                    <select name="size_id[]" class="form-control input-sm m-bot15" multiple>
                                        @foreach($size_product as $si)
                                            <option value="{{$si->id}}">{{$si->size_name}}</option>
                                        @endforeach
                                    </select>
                                </div> --}}


                                <button type="submit" name="add_product" class="btn btn-info">Add Product</button>
                                </form>
                            </div>

                        </div>
                    </section>

            </div>
@endsection
{{-- @section ('script-content')
<script>
      ClassicEditor
        .create( document.querySelector( '.ck-editor' ) )
        .catch( error => {
            console.error( error );
        } );

</script>
@endsection --}}
