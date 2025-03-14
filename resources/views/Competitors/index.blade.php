@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ $competition['name'] }} – {{ $competition['year'] }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if(auth()->check() && auth()->user()->is_admin)
                        <div>
                            <div>
                                You are an admin.
                                teszt
                            </div>
                            <div>
                                <h2>New round</h2>
                                <div id="errorMsgContainer"></div>
                                <form method="POST" id="form">
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
                                        <div class="col-md-6 offset-md-4">
                                            <button id="newRoundSubmit" type="submit" class="btn btn-primary">
                                                {{ __('Create') }}
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endif
                    <div id="round_list">
                        @foreach($users as $user)
                            <h3><a href="/competitions/{{$competition['id']}}/rounds">{{$user}}</a></h3>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
