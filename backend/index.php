<?php
require 'vendor/autoload.php'; //run autoloader
require "rest/services/BookingsService.php";
require "rest/services/PackagesService.php";
require "rest/services/PaymentsService.php";
require "rest/services/ReviewsService.php";
require "rest/services/UsersService.php";
require "rest/services/AuthService.php";
require "middleware/AuthMiddleware.php";

use Firebase\JWT\JWT;
use Firebase\JWT\Key;


Flight::register('bookings_service',"BookingsService");
Flight::register('packages_service',"PackagesService");
Flight::register('payments_service',"PaymentsService");
Flight::register('reviews_service',"ReviewsService");
Flight::register('users_service',"UsersService");
Flight::register('auth_service',"AuthService");
Flight::register('auth_middleware', "AuthMiddleware");

Flight::route('/*', function() {
    if(
        strpos(Flight::request()->url, '/auth/login') === 0 ||
        strpos(Flight::request()->url, '/auth/register') === 0
    ) {
        return TRUE;
    } else {
        try {
            $token = Flight::request()->getHeader("Authentication");
            if(Flight::auth_middleware()->verifyToken($token))
                return TRUE;
        } catch (\Exception $e) {
            Flight::halt(401, $e->getMessage());
        }
    }
});


require_once "rest/routes/BookingsRoutes.php";
require_once "rest/routes/PackagesRoutes.php";
require_once "rest/routes/PaymentsRoutes.php";
require_once "rest/routes/ReviewsRoutes.php";
require_once "rest/routes/UsersRoutes.php";
require_once "rest/routes/AuthRoutes.php";

Flight::start();  //start FlightPHP



