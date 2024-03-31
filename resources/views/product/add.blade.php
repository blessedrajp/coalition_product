@extends('layouts.layout')
@section('content')
<form id="productForm">
        <!-- <input type="hidden" name="_token" value="{{ csrf_token() }}"> -->
            <div class="form-group">
                <label for="productName">Product Name:</label>
                <input type="text" class="form-control" id="productName" required>
            </div>
            <div class="form-group">
                <label for="quantity">Quantity in Stock:</label>
                <input type="number" class="form-control" id="quantity" required>
            </div>
            <div class="form-group">
                <label for="price">Price per Item:</label>
                <input type="number" class="form-control" id="price" required>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
</form>
<Script>
    $(document).ready(function(){
    // loadProducts();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#productForm').submit(function(e){
        e.preventDefault();
        var productName = $('#productName').val();
        console.log(productName);
        var quantity = $('#quantity').val();
        var price = $('#price').val();
        $.ajax({
            type: 'POST',
            url: '{{route("product.store")}}',
            // url:'/store',
            data: {
                productName: productName,
                quantity: quantity,
                price: price
            },
            success: function(response){
                loadProducts();
                $('#productName').val('');
                $('#quantity').val('');
                $('#price').val('');
            }
        });
    });

});

    </Script>
@endsection