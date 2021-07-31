<?php

if (!function_exists('add_user')) {

    function add_user($name, $gender, $age)
    {
        return (new \App\Features\Onboard())->addUser($name, $gender, $age);
    }
}

if (!function_exists('add_vehicle')) {

    function add_vehicle($user_name, $model, $vehicle_number)
    {
        return (new \App\Features\Onboard())->addVehicle($user_name, $model, $vehicle_number);
    }
}

if (!function_exists('offer_ride')) {

    function offer_ride($user_name, $origin, $available_seats, $vehicle, $destination)
    {
        $user = (new \App\Models\User())->getUserByName($user_name);
        $vehicle = (new \App\Models\Vehicle())->getVehicleByNumber($vehicle);

        return (new \App\Features\RideOffering())
            ->setRideCreator($user)
            ->setVehicle($vehicle)
            ->offerRide($origin, $destination, $available_seats);
    }
}
