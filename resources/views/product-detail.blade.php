@extends('layouts.app')

@section('title', $product->name . ' - Chi tiết sản phẩm')

@section('content')
    @include('partials.home.product-detail')
@endsection
