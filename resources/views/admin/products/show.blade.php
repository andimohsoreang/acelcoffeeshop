<x-layouts.admin>
    <x-slot:title>Detail Produk</x-slot:title>
    <x-slot:subtitle>Informasi lengkap menu dan pengaturan visibilitas</x-slot:subtitle>

    {{-- Breadcrumbs --}}
    <div class="mb-6 flex items-center justify-between">
        <a href="{{ route('admin.products.index') }}" class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-blue-600 font-medium transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke Daftar Produk
        </a>
        <a href="{{ route('admin.products.edit', $product) }}" class="btn-primary flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
            Edit Produk Ini
        </a>
    </div>

    @php
        // Persiapkan Array Gambar untuk Alpine Gallery
        $imageUrls = [];
        if($product->images->count() > 0) {
            foreach($product->images as $img) {
                $imageUrls[] = asset('storage/' . $img->image_path);
            }
        } elseif($product->image) {
            $imageUrls[] = asset('storage/' . $product->image);
        }
    @endphp

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        {{-- BAGIAN KIRI: Galeri Media (Sekitar 5/12 kolom) --}}
        <div class="lg:col-span-5 space-y-4" x-data="{ activeImage: 0, images: {{ json_encode($imageUrls) }} }">
            <div class="admin-card p-4">
                {{-- Main Image Showcase --}}
                <div class="w-full aspect-video sm:aspect-square max-h-[320px] rounded-2xl bg-gray-50 overflow-hidden border border-gray-100 relative mb-4 flex items-center justify-center">
                    <template x-if="images.length > 0">
                        <img :src="images[activeImage]" alt="{{ $product->name }}" class="w-full h-full object-contain absolute inset-0 transition-opacity duration-300">
                    </template>
                    <template x-if="images.length === 0">
                        <div class="text-gray-300 flex flex-col items-center">
                            <svg class="w-16 h-16 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                            <span class="text-sm font-medium">Tidak ada foto</span>
                        </div>
                    </template>

                    {{-- Badges Overlay --}}
                    <div class="absolute top-3 right-3 flex flex-col gap-2 items-end z-10">
                        @if($product->is_featured)
                            <span class="px-2.5 py-1 rounded-full bg-amber-500/90 backdrop-blur text-white text-[10px] font-bold shadow-sm uppercase tracking-wider flex items-center gap-1">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg> 
                                Unggulan
                            </span>
                        @endif
                        @if($product->is_newcomer)
                            <span class="px-2.5 py-1 rounded-full bg-blue-500/90 backdrop-blur text-white text-[10px] font-bold shadow-sm uppercase tracking-wider">
                                🔥 New Entry
                            </span>
                        @endif
                    </div>
                </div>

                {{-- Thumbnails --}}
                <template x-if="images.length > 1">
                    <div class="flex gap-3 overflow-x-auto py-1 px-1 no-scrollbar snap-x">
                        <template x-for="(img, index) in images" :key="index">
                            <button @click="activeImage = index" type="button" 
                                class="w-20 h-20 rounded-xl flex-shrink-0 overflow-hidden border-2 transition-all transform snap-center"
                                :class="activeImage === index ? 'border-purple-500 shadow-md scale-105' : 'border-transparent opacity-60 hover:opacity-100 hover:border-gray-200'">
                                <img :src="img" class="w-full h-full object-cover bg-gray-50">
                            </button>
                        </template>
                    </div>
                </template>
            </div>

            {{-- Metrik Singkat Bawah Gambar --}}
            <div class="grid grid-cols-2 gap-4">
                <div class="admin-card text-center p-4">
                    <p class="text-xs text-gray-400 font-medium mb-1">Terjual</p>
                    <p class="text-xl font-bold text-gray-800">{{ $product->orderItems ? $product->orderItems->sum('quantity') : 0 }}</p>
                </div>
                <div class="admin-card text-center p-4">
                    <p class="text-xs text-gray-400 font-medium mb-1">Total Review</p>
                    <div class="flex items-center justify-center gap-1">
                        <span class="text-amber-400">⭐</span>
                        <span class="text-xl font-bold text-gray-800">{{ number_format($product->rating_avg, 1) }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- BAGIAN KANAN: Detail, Spesifikasi, Deskripsi (Sekitar 7/12 kolom) --}}
        <div class="lg:col-span-7 space-y-6">
            {{-- Header Informasi --}}
            <div class="admin-card">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <div class="flex items-center gap-2 mb-2">
                            <span class="px-2.5 py-1 bg-gray-100 text-gray-600 rounded-lg text-xs font-semibold">{{ $product->category->icon ?? '' }} {{ $product->category->name ?? 'Tanpa Kategori' }}</span>
                            @if($product->is_available)
                                <span class="px-2.5 py-1 bg-green-50 text-green-600 rounded-lg text-xs font-semibold flex items-center gap-1.5 border border-green-100"><span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Online</span>
                            @else
                                <span class="px-2.5 py-1 bg-red-50 text-red-500 rounded-lg text-xs font-semibold flex items-center gap-1.5 border border-red-100"><span class="w-1.5 h-1.5 rounded-full bg-red-400"></span> Offline / Habis</span>
                            @endif
                        </div>
                        <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight mb-1">{{ $product->name }}</h1>
                        <p class="text-sm font-mono text-gray-400 bg-gray-50 px-2 py-0.5 rounded inline-block">ID: {{ $product->slug }}</p>
                    </div>
                </div>

                <div class="flex items-end justify-between py-6 border-y border-gray-100 my-6">
                    <div>
                        <p class="text-xs text-gray-500 font-medium mb-1 uppercase tracking-wider">Harga Satuan</p>
                        <p class="text-4xl font-extrabold text-primary">{{ $product->formatted_price }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-xs text-gray-500 font-medium mb-1 uppercase tracking-wider">Sisa Stok Fisik</p>
                        <p class="text-3xl font-black {{ $product->stock <= 5 ? ($product->stock == 0 ? 'text-red-500' : 'text-amber-500') : 'text-gray-800' }}">
                            {{ $product->stock }} <span class="text-base font-medium text-gray-400">Unit</span>
                        </p>
                    </div>
                </div>

                <div>
                    <h3 class="text-sm font-bold text-gray-800 mb-3 uppercase tracking-wider">Deskripsi Menu</h3>
                    <div class="prose prose-sm w-full max-w-none text-gray-600 leading-relax rounded-xl bg-gray-50/50 p-5 border border-gray-100">
                        @if($product->description)
                            {!! nl2br(e($product->description)) !!}
                        @else
                            <i class="text-gray-400">Belum ada deskripsi spesifik untuk produk ini.</i>
                        @endif
                    </div>
                </div>
            </div>

            {{-- List Reviewer (Opsional) --}}
            @if($product->reviews && $product->reviews->count() > 0)
            <div class="admin-card p-0 overflow-hidden border-t-4 border-t-amber-400">
                <div class="p-5 border-b border-gray-100 flex items-center justify-between">
                    <h3 class="font-bold text-gray-800 flex items-center gap-2">
                        <span class="w-8 h-8 rounded-full bg-amber-100 text-amber-600 flex items-center justify-center">⭐</span>
                        Umpan Balik Pelanggan
                    </h3>
                    <span class="text-xs font-semibold text-gray-500 bg-gray-100 py-1 px-3 rounded-full">{{ $product->reviews->count() }} Ulasan</span>
                </div>
                
                <div class="divide-y divide-gray-50 max-h-[300px] overflow-y-auto no-scrollbar">
                    @foreach($product->reviews as $review)
                    <div class="p-5 hover:bg-gray-50 transition-colors">
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-blue-500 to-indigo-500 flex items-center justify-center text-sm font-bold text-white flex-shrink-0 shadow-sm">
                                {{ strtoupper(substr($review->customer_name ?? 'A', 0, 1)) }}
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center justify-between">
                                    <p class="text-sm font-bold text-gray-800">{{ $review->customer_name ?? 'Anonim' }}</p>
                                    <span class="text-xs text-gray-400 font-medium">{{ $review->created_at->diffForHumans() }}</span>
                                </div>
                                <div class="flex text-amber-400 text-xs my-1">
                                    @for($i = 0; $i < 5; $i++)
                                        <svg class="w-3.5 h-3.5 {{ $i < $review->rating ? 'text-amber-400' : 'text-gray-200' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                    @endfor
                                </div>
                                @if($review->comment)
                                <p class="text-sm text-gray-600 mt-2 bg-white rounded-lg p-3 border border-gray-100 shadow-sm italic leading-relaxed">"{{ $review->comment }}"</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</x-layouts.admin>