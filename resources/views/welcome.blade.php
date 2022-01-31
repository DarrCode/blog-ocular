@extends('layouts.app')

@section('content')
    <posts-component
        user="{{ $check == true ? 'auth' : 'guest' }}"
    ></posts-component>
@endsection