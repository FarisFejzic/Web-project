<?php


/**
 * @OA\Get(
 *     path="/users",
 *     tags={"Users"},
 *     summary="List all users",
 *     @OA\Response(
 *         response=200,
 *         description="Success",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(ref="#/components/schemas/User")
 *         )
 *     )
 * )
 */ 

Flight::route('GET /users', function() {
    $service = Flight::users_service();
    Flight::json($service->get_all());
});

/**
 * @OA\Get(
 *     path="/users/{id}",
 *     tags={"Users"},
 *     summary="Get user by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Success",
 *         @OA\JsonContent(ref="#/components/schemas/User")
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="User not found"
 *     )
 * )
 */

Flight::route('GET /users/@id', function($id) {
    $service = Flight::users_service();
    Flight::json($service->get_by_id($id));
});

/**
 * @OA\Get(
 *     path="/users/email/{email}",
 *     tags={"Users"},
 *     summary="Get user by email",
 *     @OA\Parameter(
 *         name="email",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="string", format="email")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Success",
 *         @OA\JsonContent(ref="#/components/schemas/User")
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="User not found"
 *     )
 * )
 */

Flight::route('GET /users/email/@email', function($email) {
    $service = Flight::users_service();
    Flight::json($service->get_by_email($email));
});

/**
 * @OA\Post(
 *     path="/users",
 *     tags={"Users"},
 *     summary="Create a user",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(ref="#/components/schemas/UserInput")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="User created,
 *         @OA\JsonContent(ref="#/components/schemas/User")
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Invalid input"
 *     )
 * )
 */

Flight::route('POST /users', function() {
    $service = Flight::users_service();
    $data = Flight::request()->data->getData();
    Flight::json($service->create_user($data));
});

/**
 * @OA\Put(
 *     path="/users/{id}",
 *     tags={"Users"},
 *     summary="Update user",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(ref="#/components/schemas/UserUpdate")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="User updated",
 *         @OA\JsonContent(ref="#/components/schemas/User")
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="User not found"
 *     )
 * )
 */

Flight::route('PUT /users/@id', function($id) {
    $service = Flight::users_service();
    $data = Flight::request()->data->getData();
    Flight::json($service->update_user($data, $id));
});


/**
 * @OA\Delete(
 *     path="/users/{id}",
 *     tags={"Users"},
 *     summary="Delete user",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="User deleted"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="User not found"
 *     )
 * )
 */

Flight::route('DELETE /users/@id', function($id) {
    $service = Flight::users_service();
    $service->delete($id);
    Flight::json(['message' => "User with ID $id deleted"]);
});