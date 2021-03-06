@extends('layouts.app')

@section('content')
    <div class="card-header">
        <h3 class="card-title">{{ Auth::user()->name }}</h3>
    </div>

    <h1>タスク一覧</h1>

    @if (count($tasks) > 0)
    
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>id</th>
                    <th>タスク</th>
                    <th>status</th>
                    <th>ユーザー</th>
                </tr>
            </thead>
            <tbody>
                  @foreach ($tasks ?? '' as $task)
                <tr>
                    {{-- タスク詳細ページへのリンク --}}
                    <td>{!! link_to_route('tasks.show', $task->id, ['task' => $task->id]) !!}</td>
                    <td>{{ $task->content }}</td>
                    <td>{{ $task->status }}</td>
                    <td>{{ $task->user_id }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    {{-- タスク作成ページへのリンク --}}
    {!! link_to_route('tasks.create', '新規タスクの作成', [], ['class' => 'btn btn-primary']) !!}
    {{-- ログアウトへのリンク --}}
    {!! link_to_route('logout.get', 'Logout', [], ['class' => 'btn btn-primary']) !!}
@endsection