@extends('layout.layout')
@section('title', 'Update Order')
@section('content')
<style>
    .muted {
            opacity: 0.5;
        }
        .clickable {
      cursor: pointer;
      padding: 10px;
      background-color: blue;
      color: white;
      display: inline-block;
    }
</style>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var statusInput = document.getElementById('status');
        var nextButton = document.getElementById('btn-next');
        var currentStatus = parseInt(statusInput.value);
        
        if (currentStatus === 2) {
                nextButton.style.display = "none";   
            }
        else
        {
            nextButton.style.display = "inline-block";
            nextButton.addEventListener('click', function() {
            currentStatus++;
            statusInput.value = currentStatus;
            nextButton.style.display = "none";
        });
        }
        
    });
    
</script>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="offset-md-3 col-md-6">
                <!-- general form elements -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Update Order</h3>
                    </div>

                    {{-- check error --}}
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <!-- /.card-header -->
                    <!-- form start -->
                    <form role="form" action="{{ url('order/postEdit') }}" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="card-body"> 
                            <div class="form-group">
                                <label for="txt-name">Order Id</label>
                                <input type="text" class="form-control" name="id" value="{{$order->id}}" readonly>
                            </div>
                            <div class="form-group">
                                <label for="txt-name">Order Status</label>
                                <input type="text" class="form-control" id="status" name="status"  value="{{$order->status}}" readonly   >
                                <div id="btn-next" class="clickable" style="display:none" >Next</div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
                <!-- /.card -->
            </div>
        </div>
    </div>
</section>
@endsection
@section('script-content')
<script>
    ClassicEditor
        .create( document.querySelector( '.ck-editor' ) )
        .catch( error => {
            console.error( error );
        } );

</script>
@endsection