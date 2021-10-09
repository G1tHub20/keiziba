<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::all(); //Postモデルから（DB）全データを取得
        return view('posts.index', ['posts' => $posts]);
                                    // ↑indexブレイドで読込む変数名
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create'); //posts.createページ飛ばすだけ
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) //新規作成されたデータをDBに反映
    {
        $id = Auth::id(); //ログイン中ユーザーのIDを取得
        // Auth::user(); //ユーザーの全データを取得できる

        //インスタンス作成
        $post = new Post();

        $post->body = $request->body; //$requestのbody（投稿内容）を$postのbodyに格納
        $post->user_id = $id;

        $post->save(); //saveに入れることでDBに反映される

        return redirect()->to('/posts'); //リダイレクト（store時に使用）
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        $usr_id = $post->user_id;
        $user = DB::table('users')->where('id', $usr_id)->first();

        return view('posts.detail', ['post' => $post, 'user' => $user]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //レコードを検索
        $post = Post::findOrFail($id);

        return view('posts.edit', ['post' => $post], ['id' => $id]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request) //storeと似た記述
    {
        $id = $request->post_id;

        //レコードを検索
        $post = Post::findOrFail($id);

        $post->body = $request->body;

        //保存（更新）
        $post->save();

        return redirect()->to('/posts');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);
        //削除
        $post->delete();

        return redirect()->to('/posts');
    }
}
