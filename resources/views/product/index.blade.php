@extends('layout.layout')
@section('content')
@if (session('message'))
<div class="alert alert-success">
    {{ session('message') }}
</div>
@endif


@if (session('error'))
<div class="alert alert-danger">
    {{ session('error') }}
</div>
@endif
    <div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">
      <span style="font-size: 30px ; color:blue">List Of Product</span> 
    </div>
    <div class="top-nav clearfix">
      <!--search & user info start-->
      <ul class="nav pull-right top-menu">
          <li class="dropdown">
              <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                  <b class="caret"></b>
              </a>
              <ul class="dropdown-menu">
                  <li><a href="{{URL::to('/best-seller')}}"><i class="fa fa-key"></i>Best Seller</a></li>
                  <li><a href="{{URL::to('/outof-quan')}}"><i class="fa fa-key"></i>Out of Quantity</a></li>
              </ul>
          </li>
          <!-- user login dropdown end -->
         
      </ul>
      <!--search & user info end-->
  </div>
    <div class="table-responsive">                 
      <table id="allproduct" class="table table-bordered table-hover">
        <thead>
          <tr>
            <th>Name</th>
            <th>Type</th>
            <th>Price</th>
            <th>Category</th>   
            <th>Subcategory</th>  
            <th>Material</th>
            <th>Status</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          @foreach( $products as $pro)
          <tr>
            <td>{{ $pro->product_name }}</td>
            <td>{{ $pro->product_type }}</td>
            <td>{{ $pro->product_price }}</td>
           
            <td>{{ $pro->category->category_name }}</td>
            <td>{{ $pro->subcategory->subcategory_name }}</td>
            <td>{{ $pro->product_material }}</td>
            <td>
              @if ($pro->product_status == 0)
              Hide
              @elseif ($pro->product_status == 1)
              Show
              @elseif ($pro->product_status == 2)
              New
              @elseif ($pro->product_status == 3)
              Sale
              @endif
          </td>
                <td class="text-center">
              <a class="btn btn-primary btn-sm" href="{{ url('product/edit-product/'.$pro->id) }}">
                <i class="fas fa-pencil-alt"></i> Edit
              </a>
              <a onclick='return confirm("Are you sure you want to delete?")' class="btn btn-info btn-sm" href="{{URL::to('product/delete/'.$pro->id)}}">
                  <i class="fas fa-trash"></i> Delete
              </a>
              <a class="btn btn-danger btn-sm" href="{{ url('product/update-color/'.$pro->id) }}">
                <i class="fas fa-pencil-alt"></i> Create Color Size Quantity
              </a>
              <a class="btn btn-info btn-sm" href="{{ url('image/create/'.$pro->id) }}">
                <i class="fas fa-pencil-alt"></i> Upload Image
              </a>
          {{-- </div> --}}
            </td>
          </tr>
          @endforeach
        </tbody>
        <tfoot>
          <tr>
            <th>Name</th>
            <th>Type</th>
            <th>Price</th>
            <th>Category</th>   
            <th>Subcategory</th>  
            <th>Material</th>
            <th>Status</th>
            <th></th>
          </tr>
        </tfoot>
      </table>
    </div>
  </div>
</div>


@endsection

@section('script-content')
<script>
    $(function () {
        $('#allproduct').DataTable();
    });
</script>
@endsection