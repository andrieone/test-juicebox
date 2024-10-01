<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;

class PostController extends BaseController
{
    /**
     * @OA\Get(
     *    path="/api/posts",
     *   tags={"Posts"},
     *  summary="Get all posts",
     * description="Get all posts",
     * @OA\Response(
     *   response=200,
     * description="Posts retrieved successfully",
     * @OA\JsonContent(
     *  @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/PostResource")),
     * ),
     * ),
     * )
     */
    public function index(): JsonResponse
    {
        $posts = Post::all()->paginate(10);

        return $this->sendResponse(new PostResource($posts), 'Posts retrieved successfully.');
    }

    /**
     * @OA\Post(
     *   path="/api/posts",
     * tags={"Posts"},
     * summary="Create a new post",
     * description="Create a new post",
     * @OA\RequestBody(
     *  required=true,
     * @OA\JsonContent(
     * required={"title","content"},
     * @OA\Property(property="title", type="string", format="title", example="Post Title", description="Title of the post"),
     * @OA\Property(property="content", type="string", format="content", example="Post Content", description="Content of the post"),
     * ),
     * ),
     * @OA\Response(
     * response=200,
     * description="Post created successfully",
     * @OA\JsonContent(
     * @OA\Property(property="data", type="object", ref="#/components/schemas/PostResource"),
     * ),
     * ),
     * )
     */
    public function store(Request $request): JsonResponse
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'title' => 'required',
            'content' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $post = Post::create($input);

        return $this->sendResponse(new PostResource($post), 'Post created successfully.');
    }

    /**
     * @OA\Get(
     *  path="/api/posts/{id}",
     * tags={"Posts"},
     * summary="Get a post",
     * description="Get a post",
     * @OA\Parameter(
     * name="id",
     * in="path",
     * required=true,
     * description="ID of the post",
     * @OA\Schema(
     * type="integer",
     * format="int64",
     * ),
     * ),
     * @OA\Response(
     * response=200,
     * description="Post retrieved successfully",
     * @OA\JsonContent(
     * @OA\Property(property="data", type="object", ref="#/components/schemas/PostResource"),
     * ),
     * ),
     * )
     */
    public function show($id): JsonResponse
    {
        $post = Post::find($id);

        if (is_null($post)) {
            return $this->sendError('Post not found.');
        }

        return $this->sendResponse(new PostResource($post), 'Post retrieved successfully.');
    }

    /**
     * @OA\Put(
     * path="/api/posts/{id}",
     * tags={"Posts"},
     * summary="Update a post",
     * description="Update a post",
     * @OA\Parameter(
     * name="id",
     * in="path",
     * required=true,
     * description="ID of the post",
     * @OA\Schema(
     * type="integer",
     * format="int64",
     * ),
     * ),
     * @OA\RequestBody(
     * required=true,
     * @OA\JsonContent(
     * required={"title","content"},
     * @OA\Property(property="title", type="string", format="title", example="Post Title", description="Title of the post"),
     * @OA\Property(property="content", type="string", format="content", example="Post Content", description="Content of the post"),
     * ),
     * ),
     * @OA\Response(
     * response=200,
     * description="Post updated successfully",
     * @OA\JsonContent(
     * @OA\Property(property="data", type="object", ref="#/components/schemas/PostResource"),
     * ),
     * ),
     * )
     */
    public function update(Request $request, Post $post): JsonResponse
    {
        $user = Auth::user();
        $input = $request->all();

        $validator = Validator::make($input, [
            'title' => 'required',
            'content' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $post->title = $input['title'];
        $post->content = $input['content'];
        $post->user_id = $user->id;
        $post->save();

        return $this->sendResponse(new PostResource($post), 'Post updated successfully.');
    }

    /**
     * @OA\Delete(
     * path="/api/posts/{id}",
     * tags={"Posts"},
     * summary="Delete a post",
     * description="Delete a post",
     * @OA\Parameter(
     * name="id",
     * in="path",
     * required=true,
     * description="ID of the post",
     * @OA\Schema(
     * type="integer",
     * format="int64",
     * ),
     * ),
     * @OA\Response(
     * response=200,
     * description="Post deleted successfully",
     * @OA\JsonContent(
     * @OA\Property(property="data", type="array", @OA\Items()),
     * ),
     * ),
     * )
     */
    public function destroy(Post $post): JsonResponse
    {
        $post->delete();

        return $this->sendResponse([], 'Post deleted successfully.');
    }
}
