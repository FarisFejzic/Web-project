<?php

/**
 * @OA\Get(
 *     path="/bookings",
 *     tags={"bookings"},
 *     summary="Return all bookings from the API.",
 *     security={
 *         {"ApiKey": {}}
 *     },
 *     @OA\Response(
 *         response=200,
 *         description="List of bookings."
 *     )
 * )
 */



Flight::route('GET /bookings', function() {
    $service = Flight::bookings_service();
    Flight::json($service->get_all());
});

/**
 * @OA\Get(
 *     path="/booking_by_id",
 *     tags={"bookings"},
 *     summary="Fetch individual booking by ID.",
 *     security={
 *         {"ApiKey": {}}
 *     },
 *     @OA\Parameter(
 *         name="id",
 *         in="query",
 *         required=true,
 *         description="Booking ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Fetch individual booking."
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Bad request - missing or invalid ID."
 *     )
 * )
 */

Flight::route('GET /bookings/@id', function($id) {
    $service = Flight::bookings_service();
    Flight::json($service->get_by_id($id));
});

/**
 * @OA\Get(
 *     path="/booking_by_user_id",
 *     tags={"bookings"},
 *     summary="Fetch individual bookings by User ID.",
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
 *         description="Fetch  booking by user."
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Bad request - missing or invalid ID."
 *     )
 * )
 */

Flight::route('GET /bookings/user/@user_id', function($user_id) {
    $service = Flight::bookings_service();
    Flight::json($service->get_by_user_id($user_id));
});

/**
 * @OA\Post(
 *     path="/bookings",
 *     tags={"bookings"},
 *     summary="Add a new booking",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"user_id", "package_id"},
 *             @OA\Property(property="user_id", type="integer", example="3"),
 *             @OA\Property(property="package_id", type="imteger", example="1"),
 *             
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Booking added successfully"
 *     )
 * )
 */

Flight::route('POST /bookings', function() {
    $service = Flight::bookings_service();
    $data = Flight::request()->data->getData();
    Flight::json($service->add($data));
});

/**
 * @OA\Put(
 *     path="/bookings/{id}",
 *     summary="Update a booking",
 *     tags={"bookings"},
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
 *             @OA\Property(property="status", type="string", enum={"pending", "confirmed", "cancelled"})
 *         )
 *     ),
 *     @OA\Response(
 *         response="200",
 *          description="Booking updated"),
 *     @OA\Response(
 *         response="404",
 *         description="Booking not found")
 * )
 */


Flight::route('PUT /bookings/@id', function($id) {
    $service = Flight::bookings_service();
    $data = Flight::request()->data->getData();
    Flight::json($service->update($data, $id));
});

/**
 * @OA\Delete(
 *     path="/bookings/{id}",
 *     summary="Delete a booking by ID.",
 *     description="Delete a booking from the database using their ID.",
 *     tags={"bookings"},
 *     security={
 *         {"ApiKey": {}}
 *     },
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Booking ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Booking deleted successfully."
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Booking not found."
 *     )
 * )
 */

Flight::route('DELETE /bookings/@id', function($id) {
    $service = Flight::bookings_service();
    $service->delete($id);
    Flight::json(['message' => "Booking with ID $id deleted"]);
});