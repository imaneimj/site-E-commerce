@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Delete Address</h1>

        <form action="{{ route('address.delete', $address->id) }}" method="POST">
            @csrf
            @method('DELETE') <!-- This will override POST with DELETE -->

            <p>Are you sure you want to delete this address?</p>
            <p><strong>{{ $address->name }}</strong><br>{{ $address->address }}</p>

            <button type="submit" class="btn btn-danger">Delete</button>
            <a href="{{ route('address.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
@endsection
