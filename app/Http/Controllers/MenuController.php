<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Order;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Menu::all();
        return view('products.index', compact('products'));
    }
    public function cetakInvoice()
    {
        $products = Menu::get();
        return view('cetak.cetakBill', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $req)
    {
        // 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $req)
    {
        try {
            $datas = $req->all();

            $product = new Menu;
            $product->name = $datas['name'];
            $product->price = $datas['price'];

            if ($req->hasFile('image')) {
                $namaImage = time().rand(100,999).".".$datas['image']->getClientOriginalExtension();
                $datas['image']->move(public_path().'/img', $namaImage);
                $product->image = $namaImage;
            }
            $product->save();

            return redirect()->back()->with('success', __('Berhasil membuat data'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', __($th->getMessage()));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Menu $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Menu $product)
    {
        return view('products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Menu $product)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'price' => 'required|numeric',
            ]);

        
            $product->update($validatedData);

            return redirect()->route('products.index')->with('succes', __('Berhasil mengedit data'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', __($th->getMessage()));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Menu $product)
    {
        try {
            $product->delete();
            return redirect()->route('products.index')->with('success', 'Product deleted successfully');
        } catch (\Exception $e) {
            return redirect()->route('products.index')->with('error', 'Failed to delete product');
        }
    }

    public function order(Request $request) 
    {   
        try {
            $productId = $request->input('product_id');

            // Simpan data ke database
            $order = new Order();
            $order->product_id = $productId;
            $order->save();
            
            return redirect()->back()->with('success', 'Product deleted successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete product');
        }
    }
}
