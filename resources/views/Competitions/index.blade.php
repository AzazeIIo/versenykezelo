@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Competitions') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if(auth()->check() && auth()->user()->is_admin)
                        <div>
                            You are an admin.
                        </div>
                        <div>
                            <h2>New competition</h2>
                            <div id="errorMsgContainer"></div>
                            <form method="POST" id="form">
                                @csrf

                                <div class="row mb-3">
                                    <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>

                                    <div class="col-md-6">
                                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="year" class="col-md-4 col-form-label text-md-end">{{ __('Year') }}</label>

                                    <div class="col-md-6">
                                        <input id="year" type="number" class="form-control @error('year') is-invalid @enderror" name="year" required autocomplete="year">

                                        @error('year')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="row mb-3">
                                    <label for="languages" class="col-md-4 col-form-label text-md-end">{{ __('Available languages') }}</label>

                                    <div class="col-md-6">
                                        <input id="languages" type="text" class="form-control @error('languages') is-invalid @enderror" name="languages" required autocomplete="languages">

                                        @error('languages')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="row mb-3">
                                    <label for="right_ans" class="col-md-4 col-form-label text-md-end">{{ __('Points for right answer') }}</label>

                                    <div class="col-md-6">
                                        <input id="right_ans" type="number" class="form-control @error('right_ans') is-invalid @enderror" name="right_ans" required autocomplete="right_ans">

                                        @error('right_ans')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="row mb-3">
                                    <label for="wrong_ans" class="col-md-4 col-form-label text-md-end">{{ __('Points for wrong answer') }}</label>

                                    <div class="col-md-6">
                                        <input id="wrong_ans" type="number" class="form-control @error('wrong_ans') is-invalid @enderror" name="wrong_ans" required autocomplete="wrong_ans">

                                        @error('wrong_ans')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="row mb-3">
                                    <label for="empty_ans" class="col-md-4 col-form-label text-md-end">{{ __('Points for empty answer') }}</label>

                                    <div class="col-md-6">
                                        <input id="empty_ans" type="number" class="form-control @error('empty_ans') is-invalid @enderror" name="empty_ans" required autocomplete="empty_ans">

                                        @error('empty_ans')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">

                                <div class="row mb-0">
                                    <div class="col-md-6 offset-md-4">
                                        <button id="submit" type="submit" class="btn btn-primary">
                                            {{ __('Create') }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    @endif
                    <div id="competition_list">
                        @foreach($competitions as $competition)
                            <h3><a href="/competitions/{{$competition['id']}}/rounds">{{ $competition['name'] }} – {{ $competition['year'] }}</a></h3>
                            @foreach($competition['rounds'] as $round)
                                <p>Round {{$round['round_number']}} – {{$round['date']}}</p>
                            @endforeach
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
