@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header text-white">
                    <span style="padding-right:1rem">
                        <a href="{{ route('competitions.rounds.index', $competition['id']) }}">
                            <svg role="img" xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-arrow-return-left" viewBox="0 0 16 16">
                                <text class="visually-hidden" font-size="0">Back to rounds</text>
                                <path fill-rule="evenodd" d="M14.5 1.5a.5.5 0 0 1 .5.5v4.8a2.5 2.5 0 0 1-2.5 2.5H2.707l3.347 3.346a.5.5 0 0 1-.708.708l-4.2-4.2a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 8.3H12.5A1.5 1.5 0 0 0 14 6.8V2a.5.5 0 0 1 .5-.5"/>
                            </svg>
                        </a>
                    </span>
                    <span>
                        {{ $competition['name'] }} – {{ $competition['year'] }} Round {{$round['round_number']}} competitors
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
                            <h2 class="text-center">New competitor</h2>
                            <div class="text-center" id="errorMsgContainer"></div>
                            <div class="container">
                                @foreach ($users as $user)
                                    <div class="row m-1 addCompetitorRow">
                                        <div class="col-6">
                                            {{ $user['username'] }}
                                        </div>
                                        <div class="col-6 buttonColumn">
                                            <form method="POST" class="newCompetitorForm">
                                                @csrf
                                                <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                                                <input type="hidden" name="round_id" id="round_id" value="{{$round['id']}}">
                                                <input type="hidden" name="_route" id="route" value="{{ route('competitions.rounds.competitors.store', [$competition['id'], $round['id']]) }}">
                                                <button type="submit" id="{{ $user['id'] }}" class="btn btn-primary addBtn">
                                                    Add
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            {{$users->links()}}
                        </div>
                    @endif
                    <div class="container">
                        <ul id="competitor_list">
                            @if(count($competitors) == 0)
                                <p>No competitor has been assigned to this round yet.</p>
                            @endif
                            @foreach($competitors as $user)
                                <li id="competitor{{ $user['id'] }}" class="row addCompetitorRow">
                                    <div class="col-6">
                                        <p>{{$user['username']}}</p>
                                    </div>
                                    @if(auth()->check() && auth()->user()->is_admin)
                                        <div class="col-6 buttonColumn">
                                            <form method="POST" class="removeCompetitorForm">
                                                @csrf
                                                @method('DELETE')
                                                <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                                                <input type="hidden" name="_route" id="delroute{{ $user['id'] }}" value="{{ route('competitions.rounds.competitors.destroy', [$competition['id'], $round['id'], $user['id']]) }}">
                                                <button type="submit" id="del{{ $user['id'] }}" class="btn btn-primary removeBtn">
                                                    Remove
                                                </button>
                                            </form>
                                        </div>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
