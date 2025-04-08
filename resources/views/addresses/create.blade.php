<!-- resources/views/addresses/create.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Add New Address</h1>
        
        <form action="{{ route('address.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="phone">Phone</label>
                <input type="text" name="phone" id="phone" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="locality">Locality</label>
                <input type="text" name="locality" id="locality" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="address">Address</label>
                <textarea name="address" id="address" class="form-control" required></textarea>
            </div>

            <div class="form-group">
                <label for="city">City</label>
                <input type="text" name="city" id="city" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="state">State</label>
                <input type="text" name="state" id="state" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="zip">Zip Code</label>
                <input type="text" name="zip" id="zip" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="landmark">Landmark</label>
                <input type="text" name="landmark" id="landmark" class="form-control">
            </div>

            <div class="form-group">
                <label for="isdefault">
                    <input type="checkbox" name="isdefault" id="isdefault"> Set as Default Address
                </label>
            </div>

            <button type="submit" class="btn btn-primary">Save Address</button>
        </form>
    </div>
@endsection
