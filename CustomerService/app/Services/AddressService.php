<?php

namespace App\Services;

use App\Exceptions\NotFoundException;
use App\Http\Requests\StoreAddressRequest;
use App\Http\Requests\UpdateAddressRequest;
use App\Http\Resources\AddressResource;
use App\Repositories\IAddressRepository;
use Illuminate\Auth\Access\AuthorizationException;

class AddressService implements IAddressService
{
    protected $addressRepository;

    public function __construct(IAddressRepository $addressRepository)
    {
        $this->addressRepository = $addressRepository;
    }

    public function getAddress(int $userId)
    {
        $address = $this->addressRepository->getAddress($userId);

        return AddressResource::collection($address);
    }

    public function storeAddress(int $userId, StoreAddressRequest $request)
    {
        $address = $this->addressRepository->storeAddress($userId, $request);

        return new AddressResource($address);
    }

    public function updateAddress(int $userId, UpdateAddressRequest $request, string $addressId)
    {
        $address = $this->addressRepository->findAddressById($addressId);

        if (!isset($address)) throw new NotFoundException();
        if ($address['user_id'] !== $userId) throw new AuthorizationException();

        $updatedAddress = $this->addressRepository->updateAddress($userId, $request, $address);

        return new AddressResource($updatedAddress);
    }

    public function destroyAddress(int $userId, string $addressId)
    {
        $address = $this->addressRepository->findAddressById($addressId);

        if (!isset($address)) throw new NotFoundException();
        if ($address['user_id'] !== $userId) throw new AuthorizationException();

        $this->addressRepository->destroyAddress($userId, $addressId);
    }

    public function showAddress(int $userId, string $addressId)
    {
        $address = $this->addressRepository->findAddressById($userId, $addressId);

        if (!isset($address)) throw new NotFoundException();
        if ($address['user_id'] !== $userId) throw new AuthorizationException();

        return new AddressResource($address);
    }
}
