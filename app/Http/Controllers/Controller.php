<?php

namespace App\Http\Controllers;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="Api documentation",
 *      description="Api documentation",
 *  @OA\Contact(
 *   email=" [email protected]",
 * ),
 * )
 *
 * @OA\Server(
 *  url="http://localhost:8000",
 * description="Local server"
 * )
 * @OA\Tag(
 * name="Auth",
 * description="Everything about authentication",
 * )
 * @OA\Tag(
 * name="Users",
 * description="Everything about users",
 * )
 * @OA\Tag(
 * name="Posts",
 * description="Everything about posts",
 * )
 */
abstract class Controller
{
    //
}
