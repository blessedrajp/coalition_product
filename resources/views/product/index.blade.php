<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Inventory</title>
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <header>

    </header>

    <main>
    <div class="mt-4 parent seperator-parent">
        <div class="prohead d-flex justify-content-between">
            <h2>Product Inventory</h2>
        </div>
        <div class="seperator">
        <div class="add bg-secondary-emphasis">
            <h4>ADD PRODUCT</h4>
        <form id="productForm">
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
        </div>
        
        <br>
        <table class="table table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>S.no</th>
                    <th>Product Name</th>
                    <th>Quantity in Stock</th>
                    <th>Price per Item</th>
                    <th>Datetime Submitted</th>
                    <th>Total Value</th>
                </tr>
            </thead>
            <tbody id="productTableBody">
                @foreach($products as $product)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $product->product_name }}</td>
                    <td>{{ $product->quantity }}</td>
                    <td>{{ $product->price }}</td>
                    <td>{{ $product->datetime_submitted }}</td>
                    <td>{{ $product->quantity * $product->price }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="5" style="text-align: right;">Total:</td>
                    <td id="totalValue">
                        @php
                            $total = 0;
                            foreach($products as $product) {
                                $total += $product->quantity * $product->price;
                            }
                            echo $total;
                        @endphp
                    </td>
                </tr>
            </tfoot>
        </table>
        </div>
        
    </div>
    </main>
    

    <script>
        $(document).ready(function() {
            // loadProducts();

            $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });

            $('#productForm').submit(function(e) {
                e.preventDefault();
                var productName = $('#productName').val();
                var quantity = $('#quantity').val();
                var price = $('#price').val();
                $.ajax({
                    type: 'POST',
                    url: '{{ route("product.store") }}',
                    data: {
                        productName: productName,
                        quantity: quantity,
                        price: price
                    },
                    success: function(response) {
                        loadProducts();
                        $('#productName').val('');
                        $('#quantity').val('');
                        $('#price').val('');
                        Swal.fire({
								title: "Submited",
								text: "submited Sucessfully!",
								icon: "success"
							});
                    },
                    error:function(error){
							Swal.fire({
								title: "Failed!",
								text: "Unable to Submit.",
								icon: "success"
							});
						}
                });
            });

            // Function to load products for the table
            function loadProducts() {
                $.ajax({
                    type: 'GET',
                    url: '{{ route("product.data") }}', 
                    dataType: 'json',
                    success: function(response) {
                        $('#productTableBody').empty();
                        
                        $.each(response.products, function(index, product) {
                            var row = '<tr>' +
                                        '<td>' + (index + 1) + '</td>' +
                                        '<td>' + product.product_name + '</td>' +
                                        '<td>' + product.quantity + '</td>' +
                                        '<td>' + product.price + '</td>' +
                                        '<td>' + product.datetime_submitted + '</td>' +
                                        '<td>' + (product.quantity * product.price) + '</td>' +
                                    '</tr>';
                            $('#productTableBody').append(row);
                        });
                    }
                });
            }

            
            $(document).ready(function() {
                loadProducts(); 
            });

        });
    </script>
</body>
</html>
