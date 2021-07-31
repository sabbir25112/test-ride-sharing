<?php namespace App\Features;


use App\Exceptions\UserNotFoundException;
use App\Models\User;
use App\Models\Vehicle;
use Facade\FlareClient\Http\Exceptions\NotFound;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class Onboard
{
    public function addUser($name, $gender, $age)
    {
        $user_data = [
            'name'      => $name,
            'gender'    => $gender,
            'age'       => $age,
        ];

        $validator = Validator::make($user_data, [
            'name'      => 'required',
            'gender'    => 'required',
            'age'       => 'required|integer',
        ], [
            'age.required' => 'You must provide age'
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        return User::create($user_data);
    }

    public function addVehicle($user_name, $model, $vehicle_number)
    {
        $vehicle_data = [
            'user_name'     => $user_name,
            'model'         => $model,
            'vehicle_number'=> $vehicle_number,
        ];

        $validator = Validator::make($vehicle_data, [
            'user_name'     => 'required',
            'model'         => 'required',
            'vehicle_number'=> 'required',
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $user = (new User)->getUserByName($user_name);

        if (!$user) throw new UserNotFoundException("User Not Found");;

        $vehicle_data['user_id'] = $user->id;

        return Vehicle::create($vehicle_data);
    }
}
