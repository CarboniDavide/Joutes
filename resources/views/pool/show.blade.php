<!-- @author Dessaules Loïc -->

@extends('layout')

@section('content')

	<div class="container">
        <a href="{{URL::previous()}}"><i class="fa fa-4x fa-arrow-circle-left return" aria-hidden="true"></i></a>

		<h1>{{$pool->tournament->name}} - {{$pool->poolName}}</h1>

		<br>

		<div id="match-block">

			<h2>Matchs et Résultats</h2>
			<h3>{{Carbon\Carbon::parse($pool->games[0]->start_time)->format('d.m.Y')}}</h3>
			
			<table id="matches" data-tournament="{{$pool->tournament->id}}" data-pool="{{$pool->id}}">
				@foreach ($pool->games as $game)
					<tr data-game="{{$game->id}}">
						<?php // No teams - no score ?>
						@if (empty($game->contender1->team) || empty($game->contender2->team))
							<td class="contender1">À définir</td>
							<td class="score1"></td>
							<td class="separator">{{Carbon\Carbon::parse($game->start_time)->format('H:i')}}</td>
							<td class="score2"></td>
							<td class="contender2">À définir</td>
						@else
							<?php // teams - no score ?>
							@if(!isset($game->score_contender1) || !isset($game->score_contender2))
								<td class="contender1">{{$game->contender1->team->name}}</td>
								<td class="score1"></td>
								<td class="separator">{{Carbon\Carbon::parse($game->start_time)->format('H:i')}}</td>
								<td class="score2"></td>
								<td class="contender2">{{$game->contender2->team->name}}</td>
								@if($pool->isEditable())
									<td class="action"><i class="fa fa-lg fa-pencil" aria-hidden="true"></td>
								@endif
							@else
								<?php //teams and score ?>
								<td class="contender1">{{$game->contender1->team->name}}</td>
								<td class="score1">{{$game->score_contender1}}</td>
								<td class="separator"> - </td>
								<td class="score2">{{$game->score_contender2}}</td>
								<td class="contender2">{{$game->contender2->team->name}}</td>
								@if($pool->isEditable())
									<td class="action"><i class="fa fa-lg fa-pencil" aria-hidden="true"></td>
								@endif
							@endif
						@endif
					</tr>
				@endforeach
			</table>

			<h2>Classement actuel</h2>

			@if(sizeof($pool->rankings()) > 0)
				<table id="pool-rankings-table" class="table table-striped table-bordered translate" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th>#</th>
							<th>Équipes</th>
							<th>Pts</th>
							<th>G</th>
							<th>P</th>
							<th>N</th>
							<th>+/-</th>
						</tr>
					</thead>
					<tbody>
						@for ($i = 0; $i < sizeof($pool->rankings()); $i++)
							<tr>
								<td>{{$i+1}}</td>
								<td>{{$pool->rankings()[$i]["team"]}}</td>
								<td>{{$pool->rankings()[$i]["score"]}}</td>
								<td>{{$pool->rankings()[$i]["W"]}}</td>
								<td>{{$pool->rankings()[$i]["L"]}}</td>
								<td>{{$pool->rankings()[$i]["D"]}}</td>
								<td>{{$pool->rankings()[$i]["+-"]}}</td>
							</tr>
						@endfor
					</tbody>
				</table>
			@else
				Indisponible
			@endif
		</div>

	</div>
@stop