<?php


/**
 * @OA\Get(
 *     path="/bookings",
 *     tags={"Bookings"},
 *     summary="List all bookings",
 *     @OA\Response(
 *         response=200,
 *         description="Success",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(ref="#/components/schemas/Booking")
 *         )
 *     )
 * )
 */


Flight::route('GET /bookings', function() {
    $service = Flight::bookings_service();
    Flight::json($service->get_all());
});

/**
 * @OA\Get(
 *     path="/bookings/{id}",
 *     tags={"Bookings"},
 *     summary="Get booking by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID of booking to return",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Successful operation",
 *         @OA\JsonContent(ref="#/components/schemas/Booking")
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Booking not found"
 *     )
 * )
 */

Flight::route('GET /bookings/@id', function($id) {
    $service = Flight::bookings_service();
    Flight::json($service->get_by_id($id));
});


/**
 * @OA\Get(
 *     path="/bookings/user/{user_id}",
 *     tags={"Bookings"},
 *     summary="Get bookings by user ID",
 *     @OA\Parameter(
 *         name="user_id",
 *         in="path",
 *         required=true,
 *         description="ID of user",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Successful operation",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(ref="#/components/schemas/Booking")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="No bookings found"
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
 *     tags={"Bookings"},
 *     summary="Create a booking",
 *     @OA\RequestBody(
 *         description="Booking object that needs to be added",
 *         required=true,
 *         @OA\JsonContent(ref="#/components/schemas/BookingInput")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Booking created",
 *         @OA\JsonContent(ref="#/components/schemas/Booking")
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Invalid input"
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
 *     tags={"Bookings"},
 *     summary="Update a booking",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID of booking to update",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         description="Booking object that needs to be updated",
 *         required=true,
 *         @OA\JsonContent(ref="#/components/schemas/BookingInput")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Booking updated",
 *         @OA\JsonContent(ref="#/components/schemas/Booking")
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Booking not found"
 *     )
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
 *     tags={"Bookings"},
 *     summary="Delete a booking",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID of booking to delete",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Booking deleted"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Booking not found"
 *     )
 * )
 */
Flight::route('DELETE /bookings/@id', function($id) {
    $service = Flight::bookings_service();
    $service->delete($id);
    Flight::json(['message' => "Booking with ID $id deleted"]);
});