<?php

namespace App\Http\Controllers;


use App\Comment;
use Illuminate\Http\Request;
use App\Post;
use App\Zan;

class PostController extends Controller
{
    //文章列表
    public function index(\Illuminate\Contracts\Logging\Log $log)
    {
        //容器
        /*$app = app();
        $log = $app->make('log');
        $log->info('posts_index',['data'=>'this is data']);*/

        //注入
        //$log->info('posts_index',['data'=>'this is data']);

        //门脸
        \Log::info('posts_index',['data'=>'this is data']);

        $posts = Post::orderBy('created_at','desc')->withCount(['comments','zans'])->paginate(5);


        return view('post/index')->with(compact('posts'));
    }

    //文章详情（路由模型绑定）
    public function show(Post $post)
    {

        $post->load('comments');//模板中的评论变量预加载，渲染模板前就查库加载好，view只做展示，没有这步操作也view也可以使用，但有背mvc思想
        return view('post/show')->with(compact('post'));
    }


    //新建文章
    public function create()
    {
        return view('post/create');
    }

    //新建文章逻辑
    public function store(Request $request)
    {

        //验证
        $this->validate($request, [
            'title' => 'required|string|max:100|min:5',
            'content' => 'required|string|min:10'
        ]);


        //逻辑
        $user_id = \Auth::id(); //等于  \Auth::user()->name;

        $params = array_merge(request(['title','content']),compact('user_id'));


        Post::create($params);

        //渲染
        return redirect('/posts');
    }

    //修改文章
    public function edit(Post $post)
    {
        return view('post/edit')->with(compact('post'));
    }

    //修改文章逻辑
    public function update(Post $post,Request $request)
    {
        //验证
        $this->validate($request, [
            'title' => 'required|string|max:100|min:5',
            'content' => 'required|string|min:10'
        ]);

        $this->authorize('update',$post);

        //逻辑
        $post->title = request('title');
        $post->content = request('content');
        $post->save();
        //渲染
        return redirect("/posts/{$post->id}");
    }

    public function delete(Post $post)
    {
        //权限验证

        $this->authorize('delete',$post);
        $post->delete();

        return redirect('/posts');
    }


    public function imageUpload(Request $request)
    {
        $path = $request->file('wangEditorH5File')->storePublicly(md5(time()));
        return asset('storage/'.$path);
    }


    public function comment(Post $post)
    {
        //验证
        $this->validate(request(),[
            'content' => 'required|min:3'
        ]);



        //逻辑
        $comment = new Comment();
        $comment->user_id = \Auth::id();
        $comment->post_id = $post->id;
        $comment->content = request('content');
        $post->comments()->save($comment);


        //渲染
        return back();
    }

    public function zan(Post $post)
    {
        $param = [
          'user_id' => \Auth::id(),
          'post_id' => $post->id,
        ];
        Zan::firstOrCreate($param);

        return back();
    }

    public function unzan(Post $post)
    {
        //dd($post->zan(\Auth::id())->count());
        $post->zan(\Auth::id())->delete();

        return back();
    }
}
