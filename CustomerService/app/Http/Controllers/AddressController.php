<?php

namespace App\Http\Controllers;

use App\Exceptions\ConflictException;
use App\Exceptions\NotFoundException;
use App\Http\Requests\StoreAddressRequest;
use App\Http\Requests\UpdateAddressRequest;
use App\Services\IAddressService;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    protected $addressService;

    public function __construct(IAddressService $addressService)
    {
        $this->addressService = $addressService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $res = $this->addressService->getAddress($request->user()->id, $request);
        return response($res, 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAddressRequest $request)
    {
        $res = $this->addressService->storeAddress($request->user()->id, $request);
        return response($res, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $addressId)
    {
        try {
            $res = $this->addressService->showAddress($request->user()->id, $addressId);
            return response($res, 200);
        } catch (Exception $e) {
            if ($e instanceof AuthorizationException)
                throw $e;
            if ($e instanceof NotFoundException)
                throw $e;
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAddressRequest $request, string $id)
    {
        try {
            $res = $this->addressService->updateAddress($request->user()->id, $request,  $id);
            return response($res, 200);
        } catch (Exception $e) {
            if ($e instanceof AuthorizationException)
                throw $e;
            if ($e instanceof NotFoundException)
                throw $e;
            if ($e instanceof ConflictException)
                throw $e;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        try {
            $res = $this->addressService->destroyAddress($request->user()->id, $id);
            return response($res, 204);
        } catch (Exception $e) {
            if ($e instanceof AuthorizationException)
                throw $e;
            if ($e instanceof NotFoundException)
                throw $e;
            if ($e instanceof ConflictException)
                throw $e;
        }
    }
}
