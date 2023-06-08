<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container">
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">                            
                        <a class="nav-link" href="">Product</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href='{{url("front/cart")}}'>Cart(0)</a>
                    </li>
                    
                </ul>
            </div>
        </div>
    </nav>
    
    <div class="container">
        
        <div class="row">
                @foreach($products as $item)
                <div class="col-md-4 mb-4">
                    <div class="card" >
                        <img src='{{url("images/$item->image")}}' class="card-img-top p-3" />
                        <div class="card-body">
                            <h5 class="card-title">Product1</h5>
                            <p class="product-price text-danger text-bold">100</p>
                            <form method="POST" action="{{url('front/cart/add')}}">
                                <!--@csrf-->
                                <input type="hidden" name="id" value="{{ $item->id }}" />
                                <button type="submit" class="btn btn-primary">Add to cart </button>
                            </form>
                            
                        </div>
                    </div>
                </div>
				@endforeach
        </div>
    </div>
</body>
</html>