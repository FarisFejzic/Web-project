<?php


/**
 * @OA\Get(
 *     path="/reviews",
 *     tags={"Reviews"},
 *     summary="List all reviews",
 *     @OA\Response(
 *         response=200,
 *         description="Success",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(ref="#/components/schemas/Review")
 *         )
 *     )
 * )
 */
Flight::route('GET /reviews', function() {
    $service = Flight::reviews_service();
    Flight::json($service->get_all());
});


/**
 * @OA\Get(
 *     path="/reviews/{id}",
 *     tags={"Reviews"},
 *     summary="Get review by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Success",
 *         @OA\JsonContent(ref="#/components/schemas/Review")
 *     ),
 *     @OA\Response(response=404, description="Not Found")
 * )
 */
Flight::route('GET /reviews/@id', function($id) {
    $service = Flight::reviews_service();
    Flight::json($service->get_by_id($id));
});


/**
 * @OA\Get(
 *     path="/reviews/package/{package_id}",
 *     tags={"Reviews"},
 *     summary="Get reviews for package",
 *     @OA\Parameter(
 *         name="package_id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Success",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(ref="#/components/schemas/Review")
 *         )
 *     )
 * )
 */
Flight::route('GET /reviews/package/@package_id', function($package_id) {
    $service = Flight::reviews_service();
    Flight::json($service->get_reviews_by_package_id($package_id));
});


/**
 * @OA\Get(
 *     path="/reviews/user/{user_id}",
 *     tags={"Reviews"},
 *     summary="Get reviews by user",
 *     @OA\Parameter(
 *         name="user_id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Success",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(ref="#/components/schemas/Review")
 *         )
 *     )
 * )
 */
Flight::route('GET /reviews/user/@user_id', function($user_id) {
    Flight::json(Flight::reviews_service()->get_reviews_by_user_id($user_id));
});



/**
 * @OA\Post(
 *     path="/reviews",
 *     tags={"Reviews"},
 *     summary="Create new review",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(ref="#/components/schemas/ReviewInput")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Created",
 *         @OA\JsonContent(ref="#/components/schemas/Review")
 *     ),
 *     @OA\Response(response=400, description="Bad Request")
 * )
 */
Flight::route('POST /reviews', function() {
    $service = Flight::reviews_service();
    $data = Flight::request()->data->getData();
    Flight::json($service->add($data));
});


/**
 * @OA\Put(
 *     path="/reviews/{id}",
 *     tags={"Reviews"},
 *     summary="Update review",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(ref="#/components/schemas/ReviewInput")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Success",
 *         @OA\JsonContent(ref="#/components/schemas/Review")
 *     ),
 *     @OA\Response(response=404, description="Not Found")
 * )
 */
Flight::route('PUT /reviews/@id', function($id) {
    $service = Flight::reviews_service();
    $data = Flight::request()->data->getData();
    Flight::json($service->update($data, $id));
});



/**
 * @OA\Delete(
 *     path="/reviews/{id}",
 *     tags={"Reviews"},
 *     summary="Delete review",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(response=200, description="Deleted"),
 *     @OA\Response(response=404, description="Not Found")
 * )
 */
Flight::route('DELETE /reviews/@id', function($id) {
    $service = Flight::reviews_service();
    $service->delete($id);
    Flight::json(['message' => "Review with ID $id deleted"]);
});