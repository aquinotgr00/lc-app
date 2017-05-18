@extends('layouts.master')

@section('content')

    <ul>
    @if(isset($customers))
	@foreach($customers as $key => $value)
	<li>{{ $value->name  }} - {{ $value->getCustomerTypeDisplayName() }}</li>
	@endforeach
    @endif
    </ul>

@endsection
