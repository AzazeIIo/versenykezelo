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
                            </div>
                            <div>
                                <h2>New competitor</h2>
                                <div id="errorMsgContainer"></div>
                                <div class="container m-2">
                                    @foreach ($users as $user)
                                        <div class="row m-1">
                                            <div class="col-4">
                                                {{ $user['username'] }}
                                            </div>
                                            <div class="col-8">
                                                <form method="POST">
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
                        </div>
                    @endif
                    <div id="competitor_list">
                        <h3>Round {{$round['round_number']}} competitors</h3>
                        @foreach($competitors as $user)
                            <p>{{$user['username']}}</p>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
