<?php

namespace App\Repositories;

use App\Http\Requests\ChangeOrderStatusRequest;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Resources\OrderResource;
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
        $address = Address::where('id', $request["address_id"])->firstOrFail();

        $totalAmount = collect($products)->sum(function ($product) {
            return $product['promotion'] != null ? $product['promotion']['new_price'] : $product['price'];
        });

        $invoice = new Invoice();
        $invoice->name = $request["name"];
        $invoice->adreess = $request["address"];
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
        $order->address_id = $address->id;
        $order->invoice_id = $invoice->id;
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

    public function getActiveOrders()
    {
        return Order::where('status', '!=', 'cancelled')->where('status', '!=', 'completed')->orderBy('created_at', 'desc')->paginate(20);
    }

    public function changeOrderStatus(ChangeOrderStatusRequest $request, string $orderId)
    {
        $order = Order::where('id', $orderId)->first();
        $order->status = $request->status;
        $order->save();

        return new OrderResource($order);
    }
}
