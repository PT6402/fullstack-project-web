<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cart</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-md">
        <div class="container">
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">                            
                        <a class="nav-link" href='{{url("front/product")}}'>Product</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href=''>Cart(0)</a>
                    </li>
                    
                </ul>
            </div>
        </div>
    </nav>
    
    <div class="container">
        
        <div id="cart" class="mb-3">
            <div class="row cart-header">
                <div class="col-md-5">Sản phẩm</div>
                <div class="col-md-2">Giá</div>
                <div class="col-md-1">Số lượng</div>
                <div class="col-md-2 text-right">Thành tiền</div> 
                <div class="col-md-2"></div>
            </div>
            @foreach($cart as $row)
            <form method="POST" action='{{url("front/cart/update")}}' class="row cart-item">
                @csrf
                <input type="hidden" name="id" value="{{ $row->id }}" />
                <input type="hidden" name="rowId" value="{{ $row->rowId }}" />
                <div class="col-md-5">
                    <div class="media">
                        <img class="mr-3 cart-item-image" src='{{url("images/". $row->options->image)}}' width="100px" height="100px"/>
                        <div class="media-body">
                            <p class="mt-2">Product1</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">0</div>
                <div class="col-md-1"><input type="number" name="qty" value="{{ $row->qty }}" min="1" max="10" class="form-control" /></div>
                <div class="col-md-2 text-right">0</div> 
                <div class="col-md-2">
                    <button type="submit" name="submit_button" value="update" class="btn btn-success btn-md">Update</button>
                    <a href='{{url("front/cart/delete/{$row->rowId}")}}' onclick='return confirm("Are you sure ?")' class="btn btn-danger btn-md">Delete</a>
                    
                </div>               
            </form>
            @endforeach
            <div class="row cart-item">
                <div class="col-md-10 text-right"><strong>Tổng cộng: 0</strong></div>
            </div>
        </div>
    
        <div class="row">
            <div class="col"><a href="product" class="btn btn-primary">Tiếp tục mua hàng</a></div>
            <div class="col text-right"><a href="checkout" class="btn btn-primary">Thanh toán</a></div>
        </div>

    </div>

</body>
</html>