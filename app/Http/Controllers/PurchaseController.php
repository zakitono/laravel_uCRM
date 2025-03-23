<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePurchaseRequest;
use App\Http\Requests\UpdatePurchaseRequest;
use App\Models\Item;
use App\Models\Order;
use App\Models\Purchase;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
//        dd(Order::paginate(10));

        $orders = Order::groupBy('id')
            ->selectRaw('id, sum(subtotal) as total,
            customer_name, status, created_at')
            ->paginate(50);

//        dd($orders);

        return Inertia::render('Purchases/Index', [
            'orders' => $orders
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
//        $customers = Customer::select('id', 'name', 'kana')->get();
        $items = Item::select('id', 'name', 'price')->
        where('is_selling', true)->get();

        return Inertia::render('Purchases/Create', [
//            'customers' => $customers,
            'items' => $items
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePurchaseRequest $request)
    {
        DB::beginTransaction();

        try{
              $purchase = Purchase::create([
                  'customer_id' => $request->customer_id,
                  'status' => $request->status,
              ]);

              foreach($request->items as $item){
                  $purchase->items()->attach($purchase->id,[
                      'item_id' => $item['id'],
                      'quantity' => $item['quantity'],
                  ]);
              }

              DB::commit();
              return to_route('dashboard');

        }catch (\Exception $e){
            DB::rollBack();
            }
    }

    /**
     * Display the specified resource.
     */
    public function show(Purchase $purchase)
    {

        $items = Order::where('id', $purchase->id)
            ->get();
        $order = Order::groupBy('id')
            ->where('id', $purchase->id)
            ->selectRaw('id, sum(subtotal) as total,
            customer_name, status, created_at')
            ->get();

        return Inertia::render('Purchases/Show', [
            'items' => $items,
            'order' => $order
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Purchase $purchase)
    {
//        すべての商品を取得
        $allItems = Item::select('id', 'name', 'price')->get();

        // 購入商品の数量、をIDをキーとした連想配列で取得
        $purchaseItemQuantities = $purchase->items->pluck('pivot.quantity', 'id')->toArray();

        // 商品リストを作成
        $items = $allItems->map(function($item) use ($purchaseItemQuantities){
            return [
                'id' => $item->id,
                'name' => $item->name,
                'price' => $item->price,
                'quantity' => $purchaseItemQuantities[$item->id] ?? 0
            ];
        })->toArray();

        $order = Order::groupBy('id')
        ->where('id', $purchase->id)
        ->selectRaw('id, customer_id, customer_name, status, created_at')
        ->get();

        return Inertia::render('Purchases/Edit', [
            'items' => $items,
            'order' => $order
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePurchaseRequest $request, Purchase $purchase)
    {
//        dd($request, $purchase);

        DB::beginTransaction();

        try{
            $purchase->status = $request->status;
            $purchase->save();

            $items = [];

            foreach($request->items as $item){
                $items = $items + [
                    $item['id'] => ['quantity' => $item['quantity']
                    ]
                ];
            }

    //        dd($items);
            $purchase->items()->sync($items);

            DB::commit();
            return to_route('dashboard');
        } catch(\Exception $e){
            DB::rollBack();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Purchase $purchase)
    {
        //
    }
}
