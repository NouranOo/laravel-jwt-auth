<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Post;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Validator;
class PostsController extends Controller
{
    use ApiResponseTrait;
    public function index ()
    {
        $posts = PostResource::collection(Post::paginate(2));
        return $this->apiResponse($posts );

    }
    public function show($id)
    {
        $post = Post::find($id);
        if($post) {
            return $this->returnSuccessPost($post);

        }else{
            return $this->notFoundResponse();
        }


    }
    public function delete($id)
    {
        $post = Post::find($id);
        if($post) {
            $post->delete();
            return $this->deletedResponse();

        }else{
            return $this->notFoundResponse();
        }
    }

    public function store(Request $request)
    {

        $validation = $this->validation($request);
        if ($validation instanceof Response){
            return $validation;
        }

        $post = Post::create($request->all());
        if($post) {
            return $this->createdResponse(new PostResource($post));

        }else{
          return $this->unKnown();
        }

    }

    public function update ($id ,Request $request)
    {
        $validation = $this->validation($request);
        if ($validation instanceof Response){
            return $validation;
        }

        $post = Post::find($id);
        if(!$post) {
            return $this->notFoundResponse();

        }
        $post->update($request->all());
        if($post) {
            return $this->returnSuccessPost($post);

        }else{
            return $this->apiResponse( null,'UnKnown Error', 400);
        }
    }

    public function validation($request )
    {
        return $this->apiValodation($request , [
            'title' => 'required',
            'body' => 'required',
        ]);
    }

}
