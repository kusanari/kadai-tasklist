<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Task;    // 追加

class TasksController extends Controller
{
    // getでtask/にアクセスされた場合の「一覧表示処理」
    public function index()
    {
        // タスク一覧を取得
        // $tasks = Task::all();
        
       
        // タスク一覧ビューでそれを表示
        // return view('tasks.index', [
        //     'tasks' => $tasks,
        // ]);
        $data = [];
        if (\Auth::check()) { // 認証済みの場合
            // 認証済みユーザを取得
            $user = \Auth::user();
            // ユーザのタスクの一覧を作成日時の降順で取得
            $tasks = $user->tasklist()->orderBy('created_at', 'desc')->paginate(10);

            $data = [
                'user' => $user,
                'tasks' => $tasks,//tasls<tasklistに変更
            ];
        return view('tasks.index', $data);    
        }
        else{
        // Welcomeビューでそれらを表示
        return view('welcome');
        // return view('tasks.index', $data);
        
        
        } 
    }


    // getでtasks/createにアクセスされた場合の「新規登録画面表示処理」
    public function create()
    {
    if (\Auth::check()) {    
        $task = new Task;

        // タスク作成ビューを表示
        return view('tasks.create', [
            'task' => $task,
        ]);
    }else{
        return redirect('/');
    }
    }

    // postでtasks/にアクセスされた場合の「新規登録処理」
    public function store(Request $request)
    {
        // バリデーション
        $request->validate([
            'status' => 'required|max:10',   // 追加
            'content' => 'required',   // 追加
            
        ]);
        // タスクを作成
        $task = new Task;
        $task->content = $request->content;
        $task->status = $request->status;
        $task->user_id = \Auth::user()->id;
        $task->save();

        // トップページへリダイレクトさせる
        return redirect('/');
    }
     // getでtasks/idにアクセスされた場合の「取得表示処理」
    public function show($id)
    {
     if (!\Auth::check()) {//   認証済みの場合
     
        return redirect('/');    
     }
    
        // idの値でタスクを検索して取得
        $task = Task::findOrFail($id);
        
        
        if (\Auth::id() === $task->user_id) {// 認証済みユーザ（閲覧者）がそのタスクの所有者である場合
        // タスク詳細ビューでそれを表示
       
            return view('tasks.show', [
            'task' => $task,
            ]);
            
        }else{
           
            return redirect('/');
        }
        
    }

    // getでtasks/id/editにアクセスされた場合の「更新画面表示処理」
    public function edit($id)
    {
        
    // idの値でタスクを検索して取得
        $task = \App\Task::findOrFail($id);

        // 認証済みユーザ（閲覧者）がそのタスクの所有者である場合は、タスクを表示
        if (\Auth::id() === $task->user_id) {

        // タスク編集ビューでそれを表示
        return view('tasks.edit', [
            'task' => $task,
        ]);
    }else{
     return redirect('/');    
    }
}
    // putまたはpatchでtasks/idにアクセスされた場合の「更新処理」
    public function update(Request $request, $id)
    {
        // idの値でタスクを検索して取得
        $task = Task::findOrFail($id);
        // バリデーション
        $request->validate([
            'status' => 'required|max:10',   // 追加
            'content' => 'required',
        ]);
        // タスクを更新
        $task->content = $request->content;
        $task->status = $request->status;
        $task->save();

        // 前のURLへリダイレクトさせる
        return back();
    }

    // deleteでtasks/idにアクセスされた場合の「削除処理」
    public function destroy($id)
    {
        // idの値でタスクを検索して取得
        $task = \App\Task::findOrFail($id);

        // 認証済みユーザ（閲覧者）がそのタスクの所有者である場合は、タスクを削除
        if (\Auth::id() === $task->user_id) {
            $task->delete();
        }

        // 前のURLへリダイレクトさせる
        return back();
    }
}