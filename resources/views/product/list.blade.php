@extends('layouts.app')

@section('content')
    <form action="{{ route("order.create") }}" method="POST">
        @csrf

        @if (\Session::has('success'))
            <div class="alert alert-success">
                <ul>
                    <li>{!! \Session::get('success') !!}</li>
                </ul>
            </div>
        @endif
        <div class="card">
            <div class="card-header">
                Products
            </div>

            <div class="card-body">
                <table class="table" id="products_table">
                    <thead>
                    <tr>
                        <th>Product</th>
                        <th>Quantity</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr id="product0">
                        <td>
                            <select name="products[]" class="form-control">
                                <option value="">-- choose product --</option>
                                @foreach ($products as $product)
                                    <option value="{{ $product->id }}">
                                        {{ $product->name }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <input type="number" name="quantities[]" class="form-control" value="1" required />
                        </td>
                    </tr>
                    <tr id="product1"></tr>
                    </tbody>
                </table>

                <div class="row">
                    <div class="col-md-12">
                        <button id="add_row" class="btn btn-default pull-left">+ Add Row</button>
                        <button id='delete_row' class="pull-right btn btn-danger">- Delete Row</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                Customer Details
            </div>

            <div class="card-body">
                <div class="form-group">
                    <label for="email">Email address:</label>
                    <input type="email" name="email" id="email" required/>
                </div>
                <div class="form-group">
                    <label for="shipping_address_1">Shipping address line 1:</label>
                    <input type="text" name="shipping_address_1" id="shipping_address_1" required/>
                </div>
                <div class="form-group">
                    <label for="shipping_address_2">Shipping address line 2:</label>
                    <input type="text" name="shipping_address_2" id="shipping_address_2" required/>
                </div>
                <div class="form-group">
                    <label for="shipping_address_3">Shipping address line 3:</label>
                    <input type="text" name="shipping_address_3" id="shipping_address_3" required/>
                </div>
                <div class="form-group">
                    <label for="city">City:</label>
                    <input type="text" name="city" id="city" required/>
                </div>
                <div class="form-group">
                    <label for="country_code">Country code:</label>
                    <input type="text" name="country_code" id="country_code" required/>
                </div>
                <div class="form-group">
                    <label for="zip_postal_code">Zip postal code:</label>
                    <input type="text" name="zip_postal_code" id="zip_postal_code" required/>
                </div>
            </div>
        </div>
        <div>
            <input class="btn btn-danger" type="submit" value="Place order">
        </div>
    </form>
@endsection
