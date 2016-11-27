@extends('layouts.side-search')

@section('content')
    <accounts :types="{{ collect($types)->toJson() }}"></accounts>
@endsection