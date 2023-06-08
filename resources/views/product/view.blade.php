@extends('layout.layout')
@section('title', 'View Product')
@section('content')

<section class="content">
    <div class="container-fluid">
        <h1 class="product-name">{{$product->name}}</h1>
        <img src="images/{{$product->image}}" alt="{{$product->image}}"> 
        <h2>Price: $ {{$product->price}} </h2> 
        <h2>Description:</h2> {!! $product->description!!} 
    </div>
</section>
@endsection