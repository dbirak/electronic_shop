<?php

namespace App\Repositories;

use App\Http\Requests\StoreAddressRequest;
use App\Http\Requests\UpdateAddressRequest;
use App\Models\Address;

interface IAddressRepository
{
    public function getAddress(int $userId);

    public function storeAddress(int $userId, StoreAddressRequest $request);

    public function findAddressById(string $addressId);

    public function updateAddress(int $userId, UpdateAddressRequest $request, Address $address);

    public function destroyAddress(int $userId, string $addressId);
}
