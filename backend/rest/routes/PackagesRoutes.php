<?php

/**
 * @OA\Get(
 *     path="/packages",
 *     tags={"packages"},
 *     summary="Return all packages from the API.",
 *     security={
 *         {"ApiKey": {}}
 *     },
 *     @OA\Response(
 *         response=200,
 *         description="List of packages."
 *     )
 * )
 */

Flight::route('GET /packages', function() {
    Flight::auth_middleware()->authorizeRoles([Roles::USER, Roles::ADMIN]);
    $service = Flight::packages_service();
    Flight::json($service->get_all());
});

/**
* @OA\Get(
*     path="/packages/{id}",
*     tags={"packages"},
*     summary="Get package details by ID",
*     security={
 *         {"ApiKey": {}}
 *     }, 
*     @OA\Parameter(
*         name="id",
*         in="path",
*         required=true,
*         description="Package ID",
*         @OA\Schema(type="integer", example=5)
*     ),
*     @OA\Response(
*         response=200,
*         description="Package details"
*     ),
*     @OA\Response(
*         response=404,
*         description="Package not found"
*     )
* )
*/

Flight::route('GET /packages/@id', function($id) {
    Flight::auth_middleware()->authorizeRoles([Roles::USER, Roles::ADMIN]);
    $service = Flight::packages_service();
    Flight::json($service->get_by_id($id));
});

/**
* @OA\Get(
*     path="/packages/{destination}",
*     tags={"packages"},
*     summary="Get packages details by destination",
*     security={
 *         {"ApiKey": {}}
 *     }, 
*     @OA\Parameter(
*         name="destination",
*         in="path",
*         required=true,
*         description="Packages destination",
*         @OA\Schema(type="string", example="France")
*     ),
*     @OA\Response(
*         response=200,
*         description="Package details"
*     ),
*     @OA\Response(
*         response=404,
*         description="Package not found"
*     )
* )
*/

Flight::route('GET /packages/destination/@destination', function($destination) {
    Flight::auth_middleware()->authorizeRoles([Roles::USER, Roles::ADMIN]);
    $service = Flight::packages_service();
    Flight::json($service->get_by_destination($destination));
});

/**
 * @OA\Get(
 *     path="/packages/{status}",
 *     tags={"packages"},
 *     summary="Get packages by status",
 *     description="Retrieve packages filtered by their active status",
 *     security={
 *         {"ApiKey": {}}
 *     },
 *     @OA\Parameter(
 *         name="status",
 *         in="path",
 *         required=true,
 *         description="Item status",
 *         @OA\Schema(
 *             type="string",
 *             enum={"active", "inactive"},
 *             example="active"
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="List of packages with specified status",
 *         
 *     ),
 *     
 *     @OA\Response(
 *         response=404,
 *         description="No packages found",
 *         
 *     )
 * )
 */

Flight::route('GET /packages/available', function() {
    Flight::auth_middleware()->authorizeRoles([Roles::USER, Roles::ADMIN]);
    Flight::json(Flight::packages_service()->get_available_packages());
});

/**
 * @OA\Post(
 *     path="/packages",
 *     tags={"packages"},
 *     summary="Add a new package",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"title","destination","duration_days", "price", "num_of_people", "status"},
 *             @OA\Property(property="title", type="string", example="Luxury Paris Tour"),
 *             @OA\Property(property="destination", type="string", example="France"),
 *             @OA\Property(property="duration_days", type="integer", example=7),
 *             @OA\Property(property="price", type="number", format="float", example=1999.99),
 *             @OA\Property(property="num_of_people", type="integer", example=2),
 *             @OA\Property(property="status", type="string", enum={"active", "inactive"}, example="active"),
 *             
 *             
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="package added successfully"
 *     )
 * )
 */

Flight::route('POST /packages', function() {
    Flight::auth_middleware()->authorizeRole(Roles::ADMIN);
    $service = Flight::packages_service();
    $data = Flight::request()->data->getData();
    Flight::json($service->add($data));
});

/**
 * @OA\Put(
 *     path="/packages/{id}",
 *     summary="Update a package",
 *     tags={"packages"},
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
 *          description="Package updated"),
 *     @OA\Response(
 *         response="404",
 *         description="Package not found")
 * )
 */

Flight::route('PUT /packages/@id', function($id) {
    Flight::auth_middleware()->authorizeRole(Roles::ADMIN);
    $service = Flight::packages_service();
    $data = Flight::request()->data->getData();
    Flight::json($service->update($data, $id));
});

/**
 * @OA\Delete(
 *     path="/packages/{id}",
 *     summary="Delete a package by ID.",
 *     description="Delete a package from the database using their ID.",
 *     tags={"packages"},
 *     security={
 *         {"ApiKey": {}}
 *     },
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="package ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Package deleted successfully."
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Package not found."
 *     )
 * )
 */

Flight::route('DELETE /packages/@id', function($id) {
    Flight::auth_middleware()->authorizeRole(Roles::ADMIN);
    $service = Flight::packages_service();
    $service->delete($id);
    Flight::json(['message' => "Package with ID $id deleted"]);
});