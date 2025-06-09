<?php

/**
 * @OA\Get(
 *     path="/payments",
 *     tags={"payments"},
 *     summary="Return all payments from the API.",
 *     security={
 *         {"ApiKey": {}}
 *     },
 *     @OA\Response(
 *         response=200,
 *         description="List of payments."
 *     )
 * )
 */

Flight::route('GET /payments', function() {
    Flight::auth_middleware()->authorizeRole(Roles::ADMIN);
    $service = Flight::payments_service();
    Flight::json($service->get_all());
});

/**
* @OA\Get(
*     path="/payments/{id}",
*     tags={"payments"},
*     summary="Get payment details by ID",
*     security={
 *         {"ApiKey": {}}
 *     }, 
*     @OA\Parameter(
*         name="id",
*         in="path",
*         required=true,
*         description="Payment ID",
*         @OA\Schema(type="integer", example=5)
*     ),
*     @OA\Response(
*         response=200,
*         description="Payment details"
*     ),
*     @OA\Response(
*         response=404,
*         description="Payment not found"
*     )
* )
*/

Flight::route('GET /payments/@id', function($id) {
    Flight::auth_middleware()->authorizeRole(Roles::ADMIN);
    $service = Flight::payments_service();
    Flight::json($service->get_by_id($id));
});

/**
 * @OA\Get(
 *     path="/payments/{status}",
 *     summary="Get payments by status",
 *     tags={"payments"},
 *     @OA\Parameter(
 *         name="status",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="String")
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
 *          description="List of payments by status"),
 *     @OA\Response(
 *         response="404",
 *         description="Payment not found")
 * )
 */

Flight::route('GET /payments/status/@status', function($status) {
    Flight::auth_middleware()->authorizeRole(Roles::ADMIN);
    $service = Flight::payments_service();
    Flight::json($service->get_by_status($status));
});


/**
 * @OA\Post(
 *     path="/payments",
 *     tags={"payments"},
 *     summary="Add a new payment",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"booking_id","amount", "payment_method"},
 *             @OA\Property(property="booking_id", type="integer", example="3"),
 *             @OA\Property(property="amount", type="number", format="float", example="150.00"),  
 *             @OA\Property(property="payment_method", type="string", enum={"credit_card", "paypal", "bank_transfer"}, example="credit_card"),
 *             @OA\Property(property="status", type="string", enum={"pending", "completed", "failed"}, example="pending"),
 *             @OA\Property(property="payment_date", type="string", format="date-time", example="2025-06-10 14:30:00")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Payment added successfully"
 *     )
 * )
 */

Flight::route('POST /payments', function() {
    Flight::auth_middleware()->authorizeRole(Roles::ADMIN);
    $service = Flight::payments_service();
    $data = Flight::request()->data->getData();
    Flight::json($service->add($data));
});

/**
 * @OA\Put(
 *     path="/payments/{id}",
 *     summary="Update a payment",
 *     tags={"payments"},
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
 *             @OA\Property(property="status", type="string", enum={"active", "inactive"})
 *         )
 *     ),
 *     @OA\Response(
 *         response="200",
 *          description="Payment updated"),
 *     @OA\Response(
 *         response="404",
 *         description="Payment not found")
 * )
 */

Flight::route('PUT /payments/@id', function($id) {
    Flight::auth_middleware()->authorizeRole(Roles::ADMIN);
    $service = Flight::payments_service();
    $data = Flight::request()->data->getData();
    Flight::json($service->update($data, $id));
});

/**
 * @OA\Delete(
 *     path="/payments/{id}",
 *     summary="Delete a payment by ID.",
 *     description="Delete a payment from the database using their ID.",
 *     tags={"payments"},
 *     security={
 *         {"ApiKey": {}}
 *     },
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="payment ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Payment deleted successfully."
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Payment not found."
 *     )
 * )
 */

Flight::route('DELETE /payments/@id', function($id) {
    Flight::auth_middleware()->authorizeRole(Roles::ADMIN);
    $service = Flight::payments_service();
    $service->delete($id);
    Flight::json(['message' => "Payment with ID $id deleted"]);
});