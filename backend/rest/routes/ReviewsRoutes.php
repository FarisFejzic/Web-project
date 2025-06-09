<?php

/**
 * @OA\Get(
 *     path="/reviews",
 *     tags={"reviews"},
 *     summary="Return all reviews from the API.",
 *     security={
 *         {"ApiKey": {}}
 *     },
 *     @OA\Response(
 *         response=200,
 *         description="List of reviews."
 *     )
 * )
 */

Flight::route('GET /reviews', function() {
    Flight::auth_middleware()->authorizeRoles([Roles::USER, Roles::ADMIN]);
    $service = Flight::reviews_service();
    Flight::json($service->get_all());
});

/**
* @OA\Get(
*     path="/reviews/{id}",
*     tags={"reviews"},
*     summary="Get review details by ID",
*     security={
 *         {"ApiKey": {}}
 *     }, 
*     @OA\Parameter(
*         name="id",
*         in="path",
*         required=true,
*         description="review ID",
*         @OA\Schema(type="integer", example=5)
*     ),
*     @OA\Response(
*         response=200,
*         description="Review details"
*     ),
*     @OA\Response(
*         response=404,
*         description="Review not found"
*     )
* )
*/

Flight::route('GET /reviews/@id', function($id) {
    Flight::auth_middleware()->authorizeRoles([Roles::USER, Roles::ADMIN]);
    $service = Flight::reviews_service();
    Flight::json($service->get_by_id($id));
});

/**
* @OA\Get(
*     path="/reviews/review/{id}",
*     tags={"reviews"},
*     summary="Get review details by ID",
*     security={
 *         {"ApiKey": {}}
 *     }, 
*     @OA\Parameter(
*         name="id",
*         in="path",
*         required=true,
*         description="review ID",
*         @OA\Schema(type="integer", example=4)
*     ),
*     @OA\Response(
*         response=200,
*         description="review details"
*     ),
*     @OA\Response(
*         response=404,
*         description="review not found"
*     )
* )
*/

Flight::route('GET /reviews/review/@review_id', function($review_id) {
    Flight::auth_middleware()->authorizeRoles([Roles::USER, Roles::ADMIN]);
    $service = Flight::reviews_service();
    Flight::json($service->get_reviews_by_review_id($review_id));
});

/**
 * @OA\Get(
 *     path="/review_by_user_id",
 *     tags={"reviews"},
 *     summary="Fetch individual reviews by User ID.",
 *     security={
 *         {"ApiKey": {}}
 *     },
 *     @OA\Parameter(
 *         name="id",
 *         in="query",
 *         required=true,
 *         description="User ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Fetch  review by user."
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Bad request - missing or invalid ID."
 *     )
 * )
 */

Flight::route('GET /reviews/user/@user_id', function($user_id) {
    Flight::auth_middleware()->authorizeRoles([Roles::USER, Roles::ADMIN]);
    Flight::json(Flight::reviews_service()->get_reviews_by_user_id($user_id));
});

/**
 * @OA\Post(
 *     path="/reviews",
 *     tags={"reviews"},
 *     summary="Add a new review",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"user_id","package_id", "rating"},
 *             @OA\Property(property="user_id", type="integer", example="2"),
 *             @OA\Property(property="package_id", type="integer", example="3"),
 *             @OA\Property(property="rating", type="integer", format="int32", minimum=1, maximum=5, example=4),
 *             @OA\Property(property="comment", type="string", example="Great experience!"),
 *             @OA\Property(property="created_at", type="string", format="date-time", example="2025-06-15 10:30:00")                              
 * 
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Review added successfully"
 *     )
 * )
 */


Flight::route('POST /reviews', function() {
    Flight::auth_middleware()->authorizeRoles([Roles::USER, Roles::ADMIN]);
    $service = Flight::reviews_service();
    $data = Flight::request()->data->getData();
    Flight::json($service->add($data));
});

/**
 * @OA\Put(
 *     path="/reviews/{id}",
 *     summary="Update a review",
 *     tags={"reviews"},
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
 *             @OA\Property(property="rating", type="integer", example=5),
 *         )
 *     ),
 *     @OA\Response(
 *         response="200",
 *          description="review updated"),
 *     @OA\Response(
 *         response="404",
 *         description="review not found")
 * )
 */

Flight::route('PUT /reviews/@id', function($id) {
    Flight::auth_middleware()->authorizeRoles([Roles::USER, Roles::ADMIN]);
    $service = Flight::reviews_service();
    $data = Flight::request()->data->getData();
    Flight::json($service->update($data, $id));
});


/**
 * @OA\Delete(
 *     path="/reviews/{id}",
 *     summary="Delete a review by ID.",
 *     description="Delete a review from the database using their ID.",
 *     tags={"reviews"},
 *     security={
 *         {"ApiKey": {}}
 *     },
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Review ID",
 *         @OA\Schema(type="integer", example=7)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Review deleted successfully."
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Review not found."
 *     )
 * )
 */

Flight::route('DELETE /reviews/@id', function($id) {
    Flight::auth_middleware()->authorizeRoles([Roles::USER, Roles::ADMIN]);
    $service = Flight::reviews_service();
    $service->delete($id);
    Flight::json(['message' => "Review with ID $id deleted"]);
});