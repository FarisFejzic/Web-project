<?php

require_once __DIR__ . '/BaseDao.php';
require_once __DIR__ . '/ReviewsDao.php';
require_once __DIR__ . '/BookingsDao.php';
require_once __DIR__ . '/PackagesDao.php';
require_once __DIR__ . '/PaymentsDao.php';
require_once __DIR__ . '/UsersDao.php';

$user_dao= new UsersDao();
//$user_dao->add(["first_name"=>"Adnan","last_name"=>"Drugic","email"=>"adrugic@gmail.com","password_hash"=>"5436526","role"=>"user"]);
$packages_dao = new PackagesDao();
/*$packages_dao->add([
    "title" => "Paris Adventure",
    "destination" => "Paris, France",
    "duration_days" => 7,
    "price" => 1200.00,
    "description" => "Explore the City of Lights with our premium tour package",
    "image_url" => "",
    "status" => "active",
    "num_of_people" => 3
]);*/
print_r($user_dao->get_all());
print_r($packages_dao->get_all());
print_r($user_dao->get_by_id(1));

$user_dao->update(["first_name"=>"Hamdija"],1);

print_r($user_dao->get_by_id(1));

$bookings_dao = new BookingsDao();
/*
$bookings_dao->add([
    "user_id" => 1,
    "package_id" => 1,
    "booking_date" => "2023-06-15",
    "travel_date" => "2023-07-20",
    "status" => "confirmed"
]);*/

print_r($bookings_dao->get_by_user_id(1));

$payments_dao = new PaymentsDao();

$payments_dao->add([
    "booking_id" => 2,
    "amount" => 1200.00,
    "payment_method" => "credit_card",
    "status" => "completed",
    "payment_date" => "2023-06-16"
]);

print_r($payments_dao->get_by_status("completed"));


$reviews_dao = new ReviewsDao();
$reviews_dao->add([
    "user_id" => 1,
    "package_id" => 1,
    "rating" => 5,
    "comment" => "Amazing experience! Would definitely book again.",
    "created_at" => "2023-08-01 14:30:00"
]);

print_r($reviews_dao->get_reviews_by_package_id(1));