<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Order;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(){
        // Ambil semua produk
        $products = Menu::all();
    
        // Ambil ID-ID dari tabel Order
        $orderIds = Order::pluck('product_id');
    
        // Array kosong untuk menyimpan produk yang telah dijumlahkan berdasarkan ID
        $orderedProducts = [];

        // Variabel untuk menyimpan total harga
        $totalPrice = 0;

    
        // Loop melalui setiap ID produk dalam Order
        foreach ($orderIds as $orderId) {
            // Cari produk dengan ID yang sesuai
            $product = Menu::find($orderId);
    
            // Jika produk ditemukan, cek apakah sudah ada dalam orderedProducts
            if ($product) {
                $existingProduct = array_filter($orderedProducts, function ($item) use ($product) {
                    return $item['id'] == $product->id;
                });
    
                // Jika produk sudah ada, tambahkan harga ke produk yang ada
                if (!empty($existingProduct)) {
                    $key = key($existingProduct);
                    // $orderedProducts[$key]['price'] += $product->price;
                    $orderedProducts[$key]['quantity'] += 1;
                } else {
                    // Jika produk belum ada, tambahkan produk ke orderedProducts
                    $orderedProducts[] = [
                        'id' => $product->id,
                        'name' => $product->name,
                        'price' => $product->price,
                        'quantity' => 1, // Inisialisasi jumlah produk
                    ];
                }

                // Tambahkan harga produk ke total harga
                $totalPrice += $product->price;
            }
        }
    
        // Tampilkan data produk ke halaman web bersama dengan produk yang telah dipesan
        return view('home', compact('products', 'orderedProducts', 'totalPrice'));
    }
   
    
}
