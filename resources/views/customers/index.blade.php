@extends('layout')

@section('content')
    <h1>Add New Customer</h1>
    <form action="{{ route('customers.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="phone_number">Phone Number:</label>
            <input type="text" class="form-control" id="phone_number" name="phone_number" required>
        </div>
        <div class="form-group">
            <label for="address">Address:</label>
            <textarea class="form-control" id="address" name="address" required></textarea>
        </div>
        <div class="form-group">
            <label for="registration_date">Registration Date:</label>
            <input type="date" class="form-control" id="registration_date" name="registration_date" required>
        </div>
        <div class="form-group">
            <label for="customer_type">Customer Type:</label>
            <input type="text" class="form-control" id="customer_type" name="customer_type" required>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection
