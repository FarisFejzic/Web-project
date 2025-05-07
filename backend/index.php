<?php
require 'vendor/autoload.php'; //run autoloader
require "rest/services/BookingsService.php";
require "rest/services/PackagesService.php";
require "rest/services/PaymentsService.php";
require "rest/services/ReviewsService.php";
require "rest/services/UsersService.php";


Flight::register('bookings_service',"BookingsService");
Flight::register('packages_service',"PackagesService");
Flight::register('payments_service',"PaymentsService");
Flight::register('reviews_service',"ReviewsService");
Flight::register('users_service',"UsersService");


require_once "rest/routes/BookingsRoutes.php";
require_once "rest/routes/PackagesRoutes.php";
require_once "rest/routes/PaymentsRoutes.php";
require_once "rest/routes/ReviewsRoutes.php";
require_once "rest/routes/UsersRoutes.php";

Flight::start();  //start FlightPHP



