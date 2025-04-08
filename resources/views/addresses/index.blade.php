@extends('layouts.app')

@section('content')
<style>
    .table > :not(caption) > tr > th {
        padding: 0.625rem 1.5rem .625rem !important;
        background-color:rgb(177, 115, 74) !important;   
    }
    .table > tr > td {
        padding: 0.625rem 1.5rem .625rem !important;
    }
    .table-bordered > :not(caption) > tr > th, .table-bordered > :not(caption) > tr > td {
        border-width: 1px 1px;
        border-color:rgb(177, 115, 74);
    }
    .table > :not(caption) > tr > td {
        padding: .8rem 1rem !important;
    }
</style>

<main class="pt-90">
    <div class="mb-4 pb-4"></div>
    <section class="my-account container">
        <h2 class="page-title">Addresses</h2>
        <div class="row">
            <div class="col-lg-2">
                @include('user.account-nav')
            </div>
            <div class="col-lg-10">
                <div class="wg-table table-all-user">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Address</th>
                                    <th>Locality</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($addresses as $address)
                                    <tr>
                                        <td>{{$address->name}}</td>
                                        <td>{{$address->phone}}</td>
                                        <td>{{$address->address}}, {{$address->city}}, {{$address->state}}, {{$address->zip}}</td>
                                        <td>{{$address->locality}}</td>
                                        <td class="text-center">
                                            <a href="{{ route('address.edit', $address->id) }}" class="btn btn-info">Edit</a>
                                            
                                            <form action="{{ route('address.delete', $address->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection
