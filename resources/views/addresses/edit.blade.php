@extends('layouts.app')

@section('content')
<main class="pt-90">
    <div class="mb-4 pb-4"></div>
    <section class="my-account container">
        <h2 class="page-title">Edit Address</h2>
        <div class="row">
            <div class="col-lg-2">
                @include('user.account-nav')
            </div>
            <div class="col-lg-10">
                <form action="{{ route('address.update', $address->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $address->name) }}" required>
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input type="text" name="phone" class="form-control" value="{{ old('phone', $address->phone) }}" required>
                    </div>
                    <div class="form-group">
                        <label for="address">Address</label>
                        <textarea name="address" class="form-control" required>{{ old('address', $address->address) }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="locality">Locality</label>
                        <input type="text" name="locality" class="form-control" value="{{ old('locality', $address->locality) }}" required>
                    </div>
                    <div class="form-group">
                        <label for="landmark">Landmark</label>
                        <input type="text" name="landmark" class="form-control" value="{{ old('landmark', $address->landmark) }}">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-success">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</main>
@endsection
