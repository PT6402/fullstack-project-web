@extends('layout.layout')
@section('title', 'View Brand')
@section('content')

<section class="content">
    <div class="container-fluid">
        <h1 class="Category-name">{{$categorys->category_name}}</h1>
        
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
            @foreach($categorys->subcategories as $p)
            <tr>
                <td>{{ $p->id }}</td>
                
                      
            </tr>
            @endforeach
            </tbody>
        </table>

    </div>
</section>
@endsection