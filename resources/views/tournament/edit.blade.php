@extends('layout')

@section('content')
	<div id="container">
		<a href="{{ route('tournaments.index') }}"><img src="{{ asset("images/return-arrow.png") }}" alt="Retour en arrière" class="return"></a>	
		<h1>Modifier un tournoi</h1>

		@if ($errors->any() || isset($customErrors) || empty($dropdownList) /*DropDownList is empty if all court deleted*/)
			<div class="alert alert-danger">
				@if ($errors->any())
		            @foreach ($errors->all() as $error)
		                {{ $error }}<br>        
		            @endforeach
		        @endif
		        @if (isset($customErrors))
		        	@foreach ($customErrors as $customError)
		                {{ $customError }}<br>        
		            @endforeach
		        @endif
		        @if(empty($dropdownList)/*Sport is empty if we deleted all sport*/)
		        	Veuillez creer un sport et le lié à un terrain, ou en choisir un.
		        @endif
	        </div>
        @endif

		{{ Form::open(array('url' => route('tournaments.update', $tournament->id), 'method' => 'put', 'id' => 'formTournament')) }}

			{{ Form::label('name', 'Nom :') }}
			{{ Form::text('name', $tournament->name) }}
			<br>
			<br>
			{{ Form::label('Sport', 'Sport :') }}
			@if(!empty($dropdownList) && !empty($sport)/*Normal case : a sport is linked to the tournament*/)
				{{ Form::select('sport', $dropdownList, $sport->id, array('placeholder' => 'Sélectionner', 'class' => 'allSameStyle', 'id' => 'sport')) }}
			@else
				<!-- court doesn't exists ... -->
				{{ Form::select('sport', $dropdownList, null, array('placeholder' => 'Sélectionner', 'class' => 'allSameStyle', 'id' => 'sport')) }}
			
			@endif
			<br>
			(la liste contient uniquement les sports qui ont au minimum un terrain lié)
			<br>
			<br>
			{{ Form::label('startDate', 'Date de début :') }}
			{{ Form::date('startDate', $tournament->start_date, array('class' => 'allSameStyle')) }}
			<br>
			<br>
			{{ Form::label('startTime', 'Heure de début :') }}
			{{ Form::text('startTime', date("H:i", strtotime($tournament->start_time)), array('placeholder' => 'hh:mm')) }}
			<br>
			<br>
			{{ Form::label('endDate', 'Date de fin :') }}
			{{ Form::date('endDate', $tournament->end_date, array('class' => 'allSameStyle')) }}
			<br>
			<br>
			{{ Form::button('Enregistrer', array('class' => 'btn btn-success formSend')) }}
			
		{{ Form::close() }}

		<br>
		
		
	</div>
@stop