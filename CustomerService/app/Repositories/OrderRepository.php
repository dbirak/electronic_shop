<?php

namespace App\Repositories;

use App\Http\Requests\StoreOrderRequest;
use App\Models\Address;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\Product;

class OrderRepository implements IOrderRepository
{
    public function getOrder(int $userId)
    {
        return Order::where('user_id', $userId)->get();
    }

    public function storeOrder(int $userId, StoreOrderRequest $request, $products)
    {
        $address = Address::where('id', $request["address_id"])->first();

        $totalAmount = collect($products)->sum('price');

        $invoice = new Invoice();
        $invoice->name = $request["name"];
        $invoice->adreess = $request["adreess"];
        $invoice->post_code = $request["post_code"];
        $invoice->city = $request["city"];
        $invoice->nip = $request["nip"] ?? null;

        $currentMonth = date('m');
        $invoiceCount = Invoice::whereMonth('created_at', $currentMonth)->count() + 1;
        $invoice->invoice_number = sprintf('FAV/%s/%05d', $currentMonth, $invoiceCount);

        $invoice->amount = $totalAmount;
        $invoice->save();

        $order = new Order();
        $order->product_ids = json_encode($request["product_ids"]);
        $order->status = $request["status"];
        $order->amount = $totalAmount;
        $order->user_id = $userId;
        $order->address_id = $request["address_id"];
        $order->invoices_id = $invoice->id;
        $order->save();

        return $order;
    }

    public function findOrderById(string $orderId)
    {
        return Order::where("id", $orderId)->first();
    }


    public function destroyOrder(int $userId, string $orderId)
    {
        $order = Order::where('id', $orderId)->first();

        if ($order->status == 'pending') {
            $order->status = 'cancelled';
            $order->save();
        }
    }
}
