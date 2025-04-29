<?php

namespace App\Repositories;

use App\Http\Requests\StoreAddressRequest;
use App\Http\Requests\UpdateAddressRequest;
use App\Models\Address;

class AddressRepository implements IAddressRepository
{

    public function getAddress(int $userId)
    {
        return Address::where('user_id', $userId)->get();
    }

    public function storeAddress(int $userId, StoreAddressRequest $request)
    {
        $address = new Address();
        $address->name = $request["name"];
        $address->adreess = $request["adreess"];
        $address->post_code = $request["post_code"];
        $address->city = $request["city"];
        $address->user_id = $userId;
        $address->save();

        return $address;
    }

    public function findAddressById(string $addressId)
    {
        return Address::where("id", $addressId)->first();
    }

    public function updateAddress(int $userId, UpdateAddressRequest $request, Address $address)
    {
        $address->name = $request["name"];
        $address->adreess = $request["adreess"];
        $address->post_code = $request["post_code"];
        $address->city = $request["city"];
        $address->user_id = $userId;
        $address->save();

        return $address;
    }

    public function destroyAddress(int $userId, string $addressId)
    {
        Address::where('id', $addressId)->delete();
    }
}
