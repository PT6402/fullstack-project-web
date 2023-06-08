@extends('layout.layout')
@section('content')
<div class="row">
    <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                   Update Product
                </header>
                 <?php
                    $message = Session::get('message');
                    if($message){
                        echo '<span class="text-alert">'.$message.'</span>';
                        Session::put('message',null);
                    }
                    ?>

                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="panel-body">

                    <div class="position-center">
                        @foreach($edit_product as $pro)
                        {{-- <form role="form" action="{{ url('product/update-product' .$pro->id) }}" method="post" enctype="multipart/form-data"> --}}
                            <form role="form" action="{{URL::to('product/update-product/'.$pro->id)}}" method="post" enctype="multipart/form-data">
                                {{ csrf_field() }}
                 
                            <div class="form-group">
                                <label for="exampleInputEmail1">Product Name</label>
                                <input type="text" data-validation="length" data-validation-length="min3" data-validation-error-msg="Minimum 3 letters required" name="product_name" class="form-control" onkeyup="ChangeToSlug();" id="slug" value="{{$pro->product_name}}">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Product ID</label>
                                <input type="text" data-validation="length" data-validation-length="min3" data-validation-error-msg="Minimum 3 letters required" name="product_id" class="form-control" onkeyup="ChangeToSlug();" id="slug" value="{{  $pro -> id  }}" readonly>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Type</label>
                                <input type="text" data-validation="length"  name="product_type" class="form-control "    value="{{$pro->product_type}}"> 
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Material</label>
                                <input type="text" data-validation="length"  name="product_material" class="form-control " id="slug" onkeyup="ChangeToSlug();"   value="{{$pro->product_material}}"> 
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">PRODUCT_STATUS</label>
                                <input type="number" data-validation="number" data-validation-error-msg="" name="product_status" class="form-control" id="exampleInputEmail1"    value="{{$pro->product_status}}">
                            </div>


                            <div class="form-group">
                                <label for="exampleInputEmail1">Product Description</label>
                                <input type="text" data-validation="length" data-validation-length="min10" data-validation-error-msg="Minimum 10 letters required" name="product_description" class="form-control" id="exampleInputEmail1" value="{{$pro->product_description}}" >
                            </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1">Image</label>
                            <input type="file" name="product_image[]" class="form-control" id="image" multiple   value="{{ $pro->images }}" >
                            @foreach($pro->images as $image)
                            <img width="150px" src="{{ 'fontend/Image/' . $image->url }}" alt="">
                            @endforeach
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Quantity</label>
                            <input type="text" data-validation="number" data-validation-error-msg="Làm ơn điền số lượng" name="product_quantity" class="form-control" id="convert_slug" value="{{$colorsize_product->quantity}}" required>
                        </div>
            
                        <div class="form-group">
                            <label for="exampleInputEmail1">Price</label>
                            <input type="text" value="{{ $pro->product_price}}" name="product_price" class="form-control" id="exampleInputEmail1" required  value="{{$pro->product_price}}">
                        </div>

                        <div class="form-group">
                            <label for="exampleInputPassword1">SubCategory</label>
                              <select name="subcategory_id" class="form-control input-sm m-bot15">
                                    @foreach($subcate_product as $c)
                                    <option value="{{$c->id}}"   @if($pro->subcategory_id  == $c->id) selected @endif  >{{$c->subcategory_name}}   </option>
                                    @endforeach
                                </select>
                                    
                            </select>
                        </div>
                      
                        <div class="form-group">
                            <label for="exampleInputPassword1"> Category</label>
                              <select name="category_id" class="form-control input-sm m-bot15">
                                
                                @foreach($cate_product as $s)
                                    <option value="{{$s->id}}" @if($pro->category_id  == $s->id) selected @endif >{{$s->category_name}}</option>
                                    @endforeach
                                    
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputPassword1"> Color</label>
                              <select name="color_id" class="form-control input-sm m-bot15">
                                
                                @foreach($color_product as $co)
                                    <option value="{{$co->id}}" @if($colorsize_product->color_id   == $co->id) selected @endif >{{$co->color_name}}</option>
                                    @endforeach
                                    
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputPassword1"> Size</label>
                              <select name="size_id" class="form-control input-sm m-bot15">
                                
                                @foreach($size_product as $si)
                                    <option value="{{$si->id}}" @if($colorsize_product->size_id  == $si->id) selected @endif >{{$si->size_name}}</option>
                                    @endforeach
                                    
                            </select>
                        </div>
                        
        
                       
                        <button type="submit" name="add_product" class="btn btn-info">Update Product</button>
                        </form>
                        @endforeach
                    </div>

                </div>
            </section>

    </div>
@endsection