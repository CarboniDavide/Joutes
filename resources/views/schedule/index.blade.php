@extends('barebone')

@section('content')
    <div class="container-fluid">
        <div class="schedule" data-tournament="{{ $tournament_id }}">

        </div>
    </div>
@stop

@section('scripts')
    <script src="{{ asset('js/class/schedule.js') }}"></script>
    <script src="{{ asset('js/schedule.js') }}"></script>
@endsection
