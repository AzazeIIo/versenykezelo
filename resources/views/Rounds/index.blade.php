@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header text-white">
                    <span style="padding-right:1rem">
                        <a href="{{ url('competitions') }}">
                            <svg role="img" xmlns="http://www.w3.org/2000/svg" width="25" height="25" aria-labelledby="backBtn" fill="currentColor" class="bi bi-arrow-return-left" viewBox="0 0 16 16">
                                <text class="visually-hidden" font-size="0">Back to competitions</text>
                                <path fill-rule="evenodd" d="M14.5 1.5a.5.5 0 0 1 .5.5v4.8a2.5 2.5 0 0 1-2.5 2.5H2.707l3.347 3.346a.5.5 0 0 1-.708.708l-4.2-4.2a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 8.3H12.5A1.5 1.5 0 0 0 14 6.8V2a.5.5 0 0 1 .5-.5"/>
                            </svg>
                        </a>
                    </span>
                    <span>    
                        {{ $competition['name'] }} – {{ $competition['year'] }} rounds
                    </span>
                </div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if(auth()->check() && auth()->user()->is_admin)
                        <div>
                            <h2 class="text-center">New round</h2>
                            <div class="text-center" id="errorMsgContainer"></div>
                            <form method="POST" id="newRoundForm" class="m-3">
                                @csrf

                                <div class="row mb-3">
                                    <label for="round_number" class="col-md-4 col-form-label text-md-end">{{ __('Round Number') }}</label>

                                    <div class="col-md-6">
                                        <input id="round_number" type="number" class="form-control @error('round_number') is-invalid @enderror" name="round_number" value="{{ old('round_number') }}" required autocomplete="round_number" autofocus>

                                        @error('round_number')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="date" class="col-md-4 col-form-label text-md-end">{{ __('Date') }}</label>

                                    <div class="col-md-6">
                                        <input id="date" type="date" class="form-control @error('date') is-invalid @enderror" name="date" required autocomplete="date">

                                        @error('date')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">

                                <input type="hidden" name="_competition_id" id="competition_id" value="{{ $competition['id'] }}">
                                <input type="hidden" name="_route" id="route" value="{{ route('competitions.rounds.store', $competition['id']) }}">

                                <div class="row mb-0">
                                    <div class="col center">
                                        <button id="newRoundSubmit" type="submit" class="btn btn-primary">
                                            {{ __('Create') }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    @endif
                    <div class="competitionData">
                        <p>Available languages for this competition: {{ $competition['languages'] }}</p>
                        <p>Points for a right answer: {{ $competition['right_ans'] }}</p>
                        <p>Points for a wrong answer: {{ $competition['wrong_ans'] }}</p>
                        <p>Points for a empty answer: {{ $competition['empty_ans'] }}</p>
                    </div>
                    <ul id="round_list">
                        @if(count($rounds) == 0)
                            <p id="emptyList">No round has been assigned to this competition yet.</p>
                        @endif
                        @foreach($rounds as $round)
                            <li><a href="/competitions/{{$competition['id']}}/rounds/{{$round['id']}}/competitors">Round {{$round['round_number']}} – {{$round['date']}}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
