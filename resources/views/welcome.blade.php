@extends('layouts.app')

@section('content')
     @if (Auth::check())
        <div class="row">
            <aside class="col-sm-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{ Auth::user()->name }}</h3>
                    </div>
                   
                </div>
            </aside>
            <div class="col-sm-8">
                
                {{-- 投稿一覧 --}}
                @include('tasks.tasklist')
            </div>
        </div>
    @else
        <div class="center jumbotron">
            <div class="text-center">
                <h1>TaskList</h1>
                {{-- ユーザ登録ページへのリンク --}}
                {!! link_to_route('signup.get', 'Sign up now!', [], ['class' => 'btn btn-lg btn-primary']) !!}
                {{-- ログインページへのリンク --}}
                {!! link_to_route('login', 'login', [], ['class' => 'btn btn-lg btn-primary']) !!}
            </div>
        </div>
    @endif
@endsection