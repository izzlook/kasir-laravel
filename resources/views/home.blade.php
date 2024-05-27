@extends('layouts.app')

@section('content')
<style>
    .card-clickable:hover {
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.2); /* Bayangan saat hover */
    }
</style>

<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="row">
                @foreach ($products as $product)
                    <div class="col-md-3 mb-4">
                        <div class="card card-clickable" onclick="submitForm(this);" style="cursor: pointer;">
                            <img src="{{ asset('img/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}">
                            <div class="card-body">
                                <p class="card-title text-center" style="max-height: 1.5em; overflow: hidden; white-space: nowrap; text-overflow: ellipsis;">{{ $product->name }}</p>
                            </div>
                            <form action="{{ route('products.save-order') }}" method="POST" style="display: none;">
                            @csrf
                            <input type="hidden" id="product_id" name="product_id" value="{{ $product->id }}">
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <!-- content bill -->
        <div class="col-md-4">
            <div class="row" style="background-color: #c0c8e3;">
                <div class="col-md-2 text-center">
                    <i class="bi bi-person-circle " style="color: #586daf; font-size: 30px;"></i> 
                </div>
                <div class="col-md-8 text-center pt-2" style="background-color: #e3e6f3;">
                    <h3>New Customer</h3>
                </div>
                <div class="col-md-2 text-center">
                    <i class="bi bi-list-task" style="color: #586daf; font-size: 30px;"></i> 
                </div>
            </div>
            <div class="row" style="background-color: #ffffff;">
                <div class="col-md-12 text-center pt-2 border">
                    <h6>Dine In</h6>
                </div>
            </div>
            <p></p>
            <div class="row" style="background-color: #ffffff;">
                <div class="col-md-6 text-start pt-2">
                    <p style="color: #586daf;">1</p>
                </div>
                <div class="col-md-6 text-end pt-2">
                    <p style="color: #586daf;">View Table</p>
                </div>
            </div>
            <!-- Content bill yang diprint -->
            <div id="contentToPrint">
                <div class="row" style="background-color: #ffffff;">
                @foreach ($orderedProducts as $order)
                    <div class="col-md-7 text-start pt-2">
                        <p>{{ $order['name'] }}</p>
                    </div>
                    <div class="col-md-1 text-end pt-2">
                        @if ($order['quantity'] > 1)
                            <p>x{{ $order['quantity'] }}</p>
                        @endif
                    </div>
                    <div class="col-md-4 text-end pt-2">
                        <p>Rp. {{ $order['price'] }}</p>
                    </div>
                @endforeach
                </div>
                <div class="row" style="background-color: #ffffff;">
                    <div class="col-md-8 text-start pt-2">
                        <p>Sub Total :</p>
                    </div>
                    <div class="col-md-4 text-end pt-2">
                        <p>Rp. {{ $totalPrice }}</p>
                    </div>
                </div>
                <div class="row" style="background-color: #ffffff;">
                    <div class="col-md-8 text-start pt-2">
                        <p>Total :</p>
                    </div>
                    <div class="col-md-4 text-end pt-2">
                        <p>Rp. {{ $totalPrice }}</p>
                    </div>
                </div>
            </div>
            <!-- End Content bill yang diprint -->
            <p></p>
            <div class="row" style="background-color: #ffffff;">
                <div class="col-md-12 text-center pt-2 border">
                    <a href="{{ route('orders.destroyAll') }}" style="text-decoration: none;"><h6 style="color: black;">Clear Sale</h6></a>
                </div>
            </div>
            <p></p>
            <div class="row" style="background-color: #ffffff;">
                <a href="" style="text-decoration: none;"></a><div><p></p></div>
            </div>
            <div class="row" style="background-color: #ffffff;">
                <div class="col-md-6 text-center pt-2" style="background-color: #e3e6f3; border-right: 1px solid #ffffff;">
                    <a href="" style="text-decoration: none;" data-bs-toggle="modal" data-bs-target="#saveModal"><h5 style="color: black;">Save Bill</h5></a>
                </div>
                <div class="col-md-6 text-center pt-2" style="background-color: #e3e6f3; border-left: 1px solid #ffffff;">
                    <a href="{{ route('cetakBill')}}" id="printButton" style="text-decoration: none;"><h5 style="color: black;">Print Bill</h5></a>
                </div>
            </div>
            <div class="row" style="background-color: #ffffff;">
                <div class="col-md-2 text-center pt-2" style="background-color: #495da7; border-right: 1px solid #ffffff;">
                    <i class="bi bi-view-stacked" style="color: #ffffff; font-size: 24px;"></i>
                </div>
                <div class="col-md-10 text-center pt-2" style="background-color: #495da7; border-left: 1px solid #ffffff;">
                    <a href="" style="text-decoration: none;" data-bs-toggle="modal" data-bs-target="#kembalianModal"><h2 style="color: #ffffff;">Charge Rp. {{ $totalPrice }}</h2></a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Save bill-->
<div>
    <div class="modal fade" id="saveModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Save Bill</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h6>Apakah anda yakin ingin menyimpan bill?</h6>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Yakin</button>
            </div>
        </div>
    </div>
</div>


<!-- Modal Hitung Kembalian-->
<div>
    <div class="modal fade" id="kembalianModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Kembalian</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h6>Total Belanja : Rp. {{ $totalPrice }}</h6>
                <h6>Total Bayar : 
                    <input type="number" id="uangDiberikan" placeholder="total bayar" required></h6>  
                    <button type="button" id="hitungButton" class="btn btn-secondary">Hitung Kembalian</button>

              
                <h6><br><div id="result"></div></h6>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Selesai</button>
            </div>
        </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
function submitForm(element) {
    console.log("Form submitted");
    var form = $(element).find('form');
    form.submit();
}
</script>
<!-- Script JavaScript untuk hitung kembalian -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const totalBelanja = <?php echo $totalPrice; ?>;
        const uangDiberikanInput = document.getElementById('uangDiberikan');
        const hitungButton = document.getElementById('hitungButton');
        const resultDiv = document.getElementById('result');

        hitungButton.addEventListener('click', function() {
            const uangDiberikan = parseFloat(uangDiberikanInput.value);

            if (isNaN(uangDiberikan)) {
                resultDiv.textContent = 'Masukkan angka yang valid.';
            } else if (uangDiberikan < totalBelanja) {
                resultDiv.textContent = 'Uang yang diberikan tidak cukup.';
            } else {
                const kembalian = uangDiberikan - totalBelanja;
                resultDiv.textContent = `Kembalian: Rp. ${kembalian.toFixed(2)}`;
            }
        });
    });
</script>

@endsection
