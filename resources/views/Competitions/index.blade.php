@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header text-white">{{ __('Competitions') }}</div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if(auth()->check() && auth()->user()->is_admin)
                        <div>
                            <h2 class="text-center">New competition</h2>
                            <div id="errorMsgContainer" class="text-center"></div>
                            <form method="POST" id="newCompetitionForm" class="m-3">
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

                                <div class="row mb-0 ">
                                    <div class="col center">
                                        <button id="submit" type="submit" class="btn btn-primary">
                                            {{ __('Create') }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    @endif
                    <ul id="competition_list">
                        @if(count($competitions) == 0)
                            <p>There are no competitions in the database yet.</p>
                        @endif
                        @foreach($competitions as $competition)
                            <li><a href="/competitions/{{$competition['id']}}/rounds">{{ $competition['name'] }} – {{ $competition['year'] }}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
