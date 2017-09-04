@extends('layouts.app')

@section('content')
    <draft :current-max-bid="{{Auth::user()->getMaxBid()}}" :user="{{Auth::user()}}" :teams="{{$users}}"></draft>
@endsection