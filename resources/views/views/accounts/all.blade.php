@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-sm-10 col-sm-offset-1 col-xs-12">
            <accounts :types="{{ collect($types)->toJson() }}"></accounts>
        </div>
    </div>
@endsection