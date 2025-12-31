@extends('layouts.app')

@section('page-title', 'Input Purchase Order (PO)')

@section('content')
<div class="container-fluid">

    {{-- Tampilkan Error Validasi --}}
    @if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-triangle me-2"></i> Terdapat kesalahan input:
        <ul class="mb-0 mt-1">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="card border-top-primary">
        <div class="card-header bg-white">
            <h5 class="mb-0"><i class="fas fa-cart-plus me-2 text-primary"></i>Form Pesanan Masuk</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('sales.store') }}" method="POST">
                @csrf

                {{-- INFORMASI UMUM PO --}}
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Nomor PO Customer <span class="text-danger">*</span></label>
                        
                        {{-- PERUBAHAN: Ditambahkan ID, Class Error, dan Feedback Div --}}
                        <input type="text" name="po_number" id="po_number" 
                               class="form-control @error('po_number') is-invalid @enderror" 
                               placeholder="Contoh: PO-ASTRA-001" value="{{ old('po_number') }}" required>
                        
                        {{-- Error Bawaan Laravel --}}
                        @error('po_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                        {{-- Error Realtime AJAX --}}
                        <div id="po_feedback" class="invalid-feedback" style="display: none;">
                            Nomor PO ini sudah terdaftar di sistem.
                        </div>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Nama Customer <span class="text-danger">*</span></label>
                        <select name="customer_id" class="form-select" required>
                            <option value="">-- Pilih Customer --</option>
                            @foreach($customers as $customer)
                                <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                    {{ $customer->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Tanggal Order</label>
                        <input type="date" name="order_date" class="form-control" value="{{ old('order_date', date('Y-m-d')) }}" required>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Deadline Pengiriman <span class="text-danger">*</span></label>
                        <input type="date" name="delivery_date" class="form-control" value="{{ old('delivery_date') }}" required>
                        <small class="text-muted fst-italic"><i class="fas fa-info-circle me-1"></i>Tanggal ini menjadi target perhitungan MODM.</small>
                    </div>
                </div>

                <hr class="my-4">

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0">Daftar Barang Dipesan</h5>
                    <button type="button" class="btn btn-primary btn-sm" id="add-row">
                        <i class="fas fa-plus me-1"></i> Tambah Baris
                    </button>
                </div>
                
                {{-- CONTAINER BARIS PRODUK --}}
                <div id="product-container">
                    {{-- Baris Pertama --}}
                    <div class="row mb-2 product-row align-items-end p-2 border rounded bg-light">
                        <div class="col-md-5 mb-2 mb-md-0">
                            <label class="form-label small fw-bold">Nama Barang</label>
                            <select name="products[0][product_id]" class="form-select product-select" onchange="updateWeight(this)" required>
                                <option value="" data-weight="0">-- Pilih Produk --</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}" data-weight="{{ $product->weight }}">
                                        {{ $product->name }} ({{ $product->part_number ?? '-' }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        {{-- Kolom Berat Otomatis (Read Only) --}}
                        <div class="col-md-3 mb-2 mb-md-0">
                            <label class="form-label small fw-bold">Berat Satuan</label>
                            <div class="input-group">
                                <input type="text" class="form-control weight-display bg-white" placeholder="0" readonly>
                                <span class="input-group-text">Kg</span>
                            </div>
                        </div>

                        <div class="col-md-3 mb-2 mb-md-0">
                            <label class="form-label small fw-bold">Qty (Pcs) <span class="text-danger">*</span></label>
                            <input type="number" name="products[0][quantity]" class="form-control" min="1" placeholder="0" required>
                        </div>

                        <div class="col-md-1 text-end">
                            <label class="form-label small d-none d-md-block">&nbsp;</label>
                            <button type="button" class="btn btn-danger btn-sm remove-row" disabled title="Hapus Baris">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="mt-4 pt-3 border-top d-flex justify-content-end gap-2">
                    <a href="{{ route('sales.index') }}" class="btn btn-light border">Batal</a>
                    <button type="submit" class="btn btn-success px-4">
                        <i class="fas fa-save me-1"></i> Simpan PO
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // 1. FUNGSI UPDATE BERAT OTOMATIS
    function updateWeight(selectElement) {
        let selectedOption = selectElement.options[selectElement.selectedIndex];
        let weight = selectedOption.getAttribute('data-weight');
        let row = selectElement.closest('.product-row');
        let weightInput = row.querySelector('.weight-display');
        
        if(weight) {
            weightInput.value = weight;
        } else {
            weightInput.value = '';
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        
        // 2. LOGIKA TAMBAH BARIS PRODUK
        let productContainer = document.getElementById('product-container');
        let addRowBtn = document.getElementById('add-row');
        let productIndex = 0;

        addRowBtn.addEventListener('click', function() {
            productIndex++;
            let firstRow = productContainer.querySelector('.product-row');
            let newRow = firstRow.cloneNode(true);
            
            let inputs = newRow.querySelectorAll('input');
            inputs.forEach(input => {
                input.value = '';
                if(input.name) {
                    input.name = input.name.replace(/\[\d+\]/, `[${productIndex}]`);
                }
            });

            let select = newRow.querySelector('select');
            select.value = "";
            select.name = select.name.replace(/\[\d+\]/, `[${productIndex}]`);

            let removeBtn = newRow.querySelector('.remove-row');
            removeBtn.disabled = false;
            removeBtn.onclick = function() {
                newRow.remove();
            };

            productContainer.appendChild(newRow);
        });

        // 3. LOGIKA CEK PO REALTIME (AJAX)
        const poInput = document.getElementById('po_number');
        const poFeedback = document.getElementById('po_feedback');
        const submitBtn = document.querySelector('button[type="submit"]');

        if(poInput) {
            poInput.addEventListener('input', function() {
                let poNumber = this.value;

                // Jika kurang dari 3 huruf, reset
                if(poNumber.length < 3) {
                    poInput.classList.remove('is-invalid');
                    poInput.classList.remove('is-valid');
                    poFeedback.style.display = 'none';
                    submitBtn.disabled = false;
                    return;
                }

                // Panggil Route Check
                fetch("{{ route('sales.checkPo') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({ po_number: poNumber })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.exists) {
                        // SUDAH ADA: Merah & Disable Tombol
                        poInput.classList.add('is-invalid');
                        poInput.classList.remove('is-valid');
                        poFeedback.style.display = 'block';
                        submitBtn.disabled = true;
                    } else {
                        // AMAN: Hijau & Enable Tombol
                        poInput.classList.remove('is-invalid');
                        poInput.classList.add('is-valid');
                        poFeedback.style.display = 'none';
                        submitBtn.disabled = false;
                    }
                })
                .catch(error => console.error('Error:', error));
            });
        }
    });
</script>
@endpush