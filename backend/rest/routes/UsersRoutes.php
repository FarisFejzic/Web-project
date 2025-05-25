<?php


/**
 * @OA\Get(
 *     path="/users",
 *     tags={"users"},
 *     summary="Return all user from the API.",
 *     security={
 *         {"ApiKey": {}}
 *     },
 *     @OA\Response(
 *         response=200,
 *         description="List of users."
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
*     tags={"users"},
*     summary="Get user details by ID",
*     security={
 *         {"ApiKey": {}}
 *     }, 
*     @OA\Parameter(
*         name="id",
*         in="path",
*         required=true,
*         description="user ID",
*         @OA\Schema(type="integer", example=5)
*     ),
*     @OA\Response(
*         response=200,
*         description="User details"
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
*     tags={"users"},
*     summary="Get user details by email",
*     security={
 *         {"ApiKey": {}}
 *     }, 
*     @OA\Parameter(
*         name="email",
*         in="path",
*         required=true,
*         description="user email",
*         @OA\Schema(type="email", example="exammple@gmail.com")
*     ),
*     @OA\Response(
*         response=200,
*         description="User details"
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
 *     tags={"users"},
 *     summary="Add a new userw",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"email"},
 *             @OA\Property(property="email", type="email", example="example@gmail.com"),
 *             
 *             
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="User added successfully"
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
 *     summary="Update a user",
 *     tags={"users"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="role", type="string", enum={"user", "admin"})
 *         )
 *     ),
 *     @OA\Response(
 *         response="200",
 *          description="User updated"),
 *     @OA\Response(
 *         response="404",
 *         description="User not found")
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
 *     summary="Delete a user by ID.",
 *     description="Delete a user from the database using their ID.",
 *     tags={"users"},
 *     security={
 *         {"ApiKey": {}}
 *     },
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="user ID",
 *         @OA\Schema(type="integer", example=7)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="User deleted successfully."
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="User not found."
 *     )
 * )
 */

Flight::route('DELETE /users/@id', function($id) {
    $service = Flight::users_service();
    $service->delete($id);
    Flight::json(['message' => "User with ID $id deleted"]);
});