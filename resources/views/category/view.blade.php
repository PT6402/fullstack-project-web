@extends('layout.layout')
@section('title', 'View Brand')
@section('content')

<section class="content">
    <div class="container-fluid">
        <h1 class="brand-name">{{$brand->name}}</h1>
        <img src="images/{{$brand->image}}" alt="{{$brand->image}}"> 
        <h3>Has products</h3>
        <table id="product" class="table table-bordered table-hover">
            <thead>
            <tr>
                <th>Product Id</th>
                <th>Product Name</th>
                <th>Price</th>
                <th>Image</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach($brand->products as $p)
            <tr>
                <td>{{ $p->id }}</td>
                <td>{{ $p->name }}</td>
                <td>{{ $p->price }}</td>
                <td><img width="100px" src="{{ url('images/'.$p->image) }}"/></td>      
            </tr>
            @endforeach
            </tbody>
            <tfoot>
            <tr>
                <th>Product Id</th>
                <th>Product Name</th>
                <th>Price</th>
                <th>Image</th>
                <th></th>
            </tr>
            </tfoot>
        </table>

    </div>
</section>
@endsection