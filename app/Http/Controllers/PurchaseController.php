<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePurchaseRequest;
use App\Http\Requests\UpdatePurchaseRequest;
use App\Models\Purchase;

use Illuminate\Support\Facades\DB;
use App\Models\Customer;
use App\Models\Item;
use App\Models\Order;
use Inertia\Inertia;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::groupBy('id')
            ->selectRaw('
                id, customer_name, sum(subtotal) AS total, status, created_at
            ')
            ->paginate(50);

            return Inertia::render('Purchases/Index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $items = Item::select('id', 'name', 'price')
            ->where('is_selling', true)->orderBy('id', 'asc')->get();
        return Inertia::render('Purchases/Create', compact('items'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePurchaseRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePurchaseRequest $request)
    {
        DB::beginTransaction();
        try {
            $purchase = Purchase::create([
                'customer_id' => $request->customer_id,
                'status' => $request->status,
            ]);
            foreach ($request->items as $item) {
                $purchase->items()->attach($purchase->id, [
                    'item_id' => $item['id'],
                    'quantity' => $item['quantity'],
                ]);
            }
            DB::commit();
            session()->flash('status', 'success');
            session()->flash('message', '購入追加を完了しました。');
            return to_route('purchases.index');
        } catch(\Exception) {
            DB::rollBack();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function show(Purchase $purchase)
    {
        $items = Order::where('id', $purchase->id)->get();

        $order = Order::groupBy('id')
            ->where('id', $purchase->id)
            ->selectRaw('id, customer_name, sum(subtotal) AS total, status, created_at, updated_at')
            ->first();

            return Inertia::render('Purchases/Show', [
            'items' => $items,
            'order' => $order,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function edit(Purchase $purchase)
    {
        if (!$purchase->status) {
            abort(404);
        }
        $items = $purchase->items;
        $allItems = Item::selectRaw('id, name, price, 0 AS quantity')->get();

        foreach ($allItems as $allItem) {
            foreach ($items as $item) {
                if ($allItem->id === $item->id) {
                    $allItem->quantity = $item->pivot->quantity;
                }
            }
        }

        $order = Order::where('id', $purchase->id)
            ->selectRaw('id, customer_id, customer_name, status, created_at')->first();

            return Inertia::render('Purchases/Edit',[
            'items' => $allItems,
            'order' => $order,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePurchaseRequest  $request
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePurchaseRequest $request, Purchase $purchase)
    {
        DB::beginTransaction();
        try {
            $purchase->status = $request->status;
            $purchase->save();

            $items = [];
            foreach ($request->items as $item) {
                $items[ $item['id'] ] = [
                        'quantity' => $item['quantity']
                    ];
            }

            $purchase->items()->sync($items);
            DB::commit();
            return to_route('dashboard');

        } catch( \Exception $e) {
            DB::rollback();
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function destroy(Purchase $purchase)
    {
        //
    }
}
