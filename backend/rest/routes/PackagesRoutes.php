<?php

/**
 * @OA\Get(
 *     path="/packages",
 *     tags={"Packages"},
 *     summary="List all packages",
 *     @OA\Response(
 *         response=200,
 *         description="Success",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(ref="#/components/schemas/Package")
 *         )
 *     )
 * )
 */
Flight::route('GET /packages', function() {
    $service = Flight::packages_service();
    Flight::json($service->get_all());
});


/**
 * @OA\Get(
 *     path="/packages/{id}",
 *     tags={"Packages"},
 *     summary="Get package by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Success",
 *         @OA\JsonContent(ref="#/components/schemas/Package")
 *     ),
 *     @OA\Response(response=404, description="Not Found")
 * )
 */
Flight::route('GET /packages/@id', function($id) {
    $service = Flight::packages_service();
    Flight::json($service->get_by_id($id));
});


/**
 * @OA\Get(
 *     path="/packages/destination/{destination}",
 *     tags={"Packages"},
 *     summary="Find packages by destination",
 *     @OA\Parameter(
 *         name="destination",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="string")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Success",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(ref="#/components/schemas/Package")
 *         )
 *     )
 * )
 */
Flight::route('GET /packages/destination/@destination', function($destination) {
    $service = Flight::packages_service();
    Flight::json($service->get_by_destination($destination));
});



/**
 * @OA\Get(
 *     path="/packages/available",
 *     tags={"Packages"},
 *     summary="Get available packages",
 *     @OA\Response(
 *         response=200,
 *         description="Success",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(ref="#/components/schemas/Package")
 *         )
 *     )
 * )
 */
Flight::route('GET /packages/available', function() {
    Flight::json(Flight::packages_service()->get_available_packages());
});


/**
 * @OA\Post(
 *     path="/packages",
 *     tags={"Packages"},
 *     summary="Create new package",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(ref="#/components/schemas/PackageInput")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Created",
 *         @OA\JsonContent(ref="#/components/schemas/Package")
 *     ),
 *     @OA\Response(response=400, description="Bad Request")
 * )
 */
Flight::route('POST /packages', function() {
    $service = Flight::packages_service();
    $data = Flight::request()->data->getData();
    Flight::json($service->add($data));
});


/**
 * @OA\Put(
 *     path="/packages/{id}",
 *     tags={"Packages"},
 *     summary="Update package",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(ref="#/components/schemas/PackageInput")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Success",
 *         @OA\JsonContent(ref="#/components/schemas/Package")
 *     ),
 *     @OA\Response(response=404, description="Not Found")
 * )
 */
Flight::route('PUT /packages/@id', function($id) {
    $service = Flight::packages_service();
    $data = Flight::request()->data->getData();
    Flight::json($service->update($data, $id));
});


/**
 * @OA\Delete(
 *     path="/packages/{id}",
 *     tags={"Packages"},
 *     summary="Delete package",
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
Flight::route('DELETE /packages/@id', function($id) {
    $service = Flight::packages_service();
    $service->delete($id);
    Flight::json(['message' => "Package with ID $id deleted"]);
});