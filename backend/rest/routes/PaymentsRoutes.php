<?php


/**
 * @OA\Get(
 *     path="/payments",
 *     tags={"Payments"},
 *     summary="List all payments",
 *     @OA\Response(
 *         response=200,
 *         description="Success",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(ref="#/components/schemas/Payment")
 *         )
 *     )
 * )
 */
Flight::route('GET /payments', function() {
    $service = Flight::payments_service();
    Flight::json($service->get_all());
});


/**
 * @OA\Get(
 *     path="/payments/{id}",
 *     tags={"Payments"},
 *     summary="Get payment by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Success",
 *         @OA\JsonContent(ref="#/components/schemas/Payment")
 *     ),
 *     @OA\Response(response=404, description="Not Found")
 * )
 */
Flight::route('GET /payments/@id', function($id) {
    $service = Flight::payments_service();
    Flight::json($service->get_by_id($id));
});


/**
 * @OA\Get(
 *     path="/payments/status/{status}",
 *     tags={"Payments"},
 *     summary="Find payments by status",
 *     @OA\Parameter(
 *         name="status",
 *         in="path",
 *         required=true,
 *         @OA\Schema(
 *             type="string",
 *             enum={"pending", "completed", "failed"}
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Success",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(ref="#/components/schemas/Payment")
 *         )
 *     )
 * )
 */
Flight::route('GET /payments/status/@status', function($status) {
    $service = Flight::payments_service();
    Flight::json($service->get_by_status($status));
});



/**
 * @OA\Post(
 *     path="/payments",
 *     tags={"Payments"},
 *     summary="Create payment record",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(ref="#/components/schemas/PaymentInput")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Created",
 *         @OA\JsonContent(ref="#/components/schemas/Payment")
 *     ),
 *     @OA\Response(response=400, description="Bad Request")
 * )
 */
Flight::route('POST /payments', function() {
    $service = Flight::payments_service();
    $data = Flight::request()->data->getData();
    Flight::json($service->add($data));
});


/**
 * @OA\Put(
 *     path="/payments/{id}",
 *     tags={"Payments"},
 *     summary="Update payment status",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"status"},
 *             @OA\Property(
 *                 property="status",
 *                 type="string",
 *                 enum={"pending", "completed", "failed"}
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Success",
 *         @OA\JsonContent(ref="#/components/schemas/Payment")
 *     ),
 *     @OA\Response(response=404, description="Not Found")
 * )
 */
Flight::route('PUT /payments/@id', function($id) {
    $service = Flight::payments_service();
    $data = Flight::request()->data->getData();
    Flight::json($service->update($data, $id));
});


/**
 * @OA\Delete(
 *     path="/payments/{id}",
 *     tags={"Payments"},
 *     summary="Delete payment record",
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
Flight::route('DELETE /payments/@id', function($id) {
    $service = Flight::payments_service();
    $service->delete($id);
    Flight::json(['message' => "Payment with ID $id deleted"]);
});