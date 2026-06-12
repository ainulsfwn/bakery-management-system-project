<!DOCTYPE html>
<html>
<head>

    @include('admin.css')

    <style>
        label {
            display: inline-block;
            width: 200px;
            color: white;
        }

        .div_deg {
            padding: 10px;
        }
    </style>

</head>

<body>

@include('admin.header')
@include('admin.sidebar')

<div class="page-content">
<div class="page-header">
<div class="container-fluid">

<!-- SUCCESS MESSAGE -->
@if(session()->has('success'))
    <div class="alert alert-success">
        {{ session()->get('success') }}
    </div>
@endif

<!-- FORM -->
<form action="{{ url('/upload_food') }}"
      method="POST"
      enctype="multipart/form-data">

    @csrf

    <!-- FOOD TITLE -->
    <div class="div_deg">
        <label>Food Title</label>
        <input type="text" name="title" required>
    </div>

    <!-- FOOD DETAILS -->
    <div class="div_deg">
        <label>Food Details</label>
        <textarea name="details" rows="5" cols="40" required></textarea>
    </div>

    <!-- PRICE -->
    <div class="div_deg">
        <label>Price</label>
        <input type="text" name="price" required>
    </div>

    <!-- IMAGE -->
    <div class="div_deg">
        <label>Food Image</label>
        <input type="file" name="image" required>
    </div>

    <!-- SUBMIT -->
    <div class="div_deg">
        <input type="submit" value="Add Food" class="btn btn-warning">
    </div>

</form>

</div>
</div>
</div>

@include('admin.js')

</body>
</html>