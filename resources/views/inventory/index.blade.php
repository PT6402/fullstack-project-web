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
    {{-- <div class="panel-heading">
        Hết Hàng
    </div> --}}
    {{-- <div class="row w3-res-tb">
      <div class="col-sm-5 m-b-xs">
        <a href="{{URL::to('inventory')}}"><i class="fa fa-key"></i>Product</a>
      </div>
      <div>
          
      </div>
      <div class="col-sm-4">
      </div>
      <div class="col-sm-3">
        <div class="input-group">
   
        </div>
      </div>
    </div> --}}
    <div class="table-responsive">
      <table id="outofPro" class="table table-striped b-t b-light">
        <thead>
          <tr>
            <th>Product Name</th>
            <th>Quantity</th>
            {{-- <th>Số lượng đã bán</th> --}}
            <th>Color</th>
            <th>Size</th>
            {{-- <th>Action</th> --}}
          </tr>
        </thead>
        <tbody>
            @foreach ($colorsize as $cl)
            <tr>
                <td>{{ $cl->product->product_name }}</td>
                <td>{{ $cl->quantity }}</td>
                <td>{{ $cl->color->color_name }}</td>
                <td>{{ $cl->size->size_name }}</td>
                {{-- <td>{{ number_format($out->prices->price,0,',','.') }}đ</td> --}}
                {{-- <td>
                  @if ($out->image && $out->image->first())
                     <img src="fontend/Image/{{ $out->image->first()->path }}" height="100" width="100" alt="{{ 'fontend/Image/' . $out->image->first()->path}}">
                  @endif
               </td> --}}
                {{-- <td>{{ $out->category->name }}</td>
                <td>{{ $out->brand->name }}</td> --}}
               
                <td>
                  {{-- <a class="btn btn-info btn-sm" href="{{URL::to('/edit-product/'.$out->product_id)}}">
                    <i class="fas fa-pencil-alt"></i> Edit
                </a>
                <a  onclick='return confirm("Chắc Hông Bạn Ơi ???")' class="btn btn-danger btn-sm" href="{{URL::to('/delete-product/'.$out->product_id)}}">
                  <i class="fas fa-trash" ></i> Delete
              </a> --}}
              </td>
              </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    <footer class="panel-footer">
      <div class="row">
        
        <div class="col-sm-5 text-center">
        </div>
        <div class="col-sm-7 text-right text-center-xs">                
          <ul class="pagination pagination-sm m-t-none m-b-none">
            {{-- {!!$products->links()!!} --}}
          </ul>
        </div>
      </div>
    </footer>
  </div>
</div>
@endsection
@section('script-content')
<script>
    $(function () {
        $('#outofPro').DataTable();
    });
</script>
@endsection


