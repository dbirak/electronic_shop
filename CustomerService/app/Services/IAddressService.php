<?php

namespace App\Services;

use App\Http\Requests\StoreAddressRequest;
use App\Http\Requests\UpdateAddressRequest;

interface IAddressService
{
    public function getAddress(int $userId);

    public function storeAddress(int $userId, StoreAddressRequest $request);

    public function updateAddress(int $userId, UpdateAddressRequest $request, string $addressId);

    public function destroyAddress(int $userId, string $addressId);

    public function showAddress(int $userId, string $addressId);
}
