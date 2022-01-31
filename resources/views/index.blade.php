@extends('layouts.app')

@section('content')
    <post-component
        :post="{{ $post }}"
        user="{{ $check == true ? 'auth' : 'guest' }}"
    ></post-component>
@endsection