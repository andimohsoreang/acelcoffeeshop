<x-layouts.admin>
    <x-slot:title>Edit Produk</x-slot:title>
    <x-slot:subtitle>{{ $product->name }}</x-slot:subtitle>

    <form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data">
        @csrf @method('PUT')
        
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
            {{-- Kolom Kiri: Informasi Utama --}}
            <div class="xl:col-span-2 space-y-6">
                {{-- Card Informasi Dasar --}}
                <div class="admin-card p-6 border-t-4 border-t-blue-500 shadow-sm relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-4 opacity-[0.03] pointer-events-none">
                        <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 24 24"><path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    </div>
                    <h2 class="text-lg font-bold text-gray-800 mb-5 flex items-center gap-2 relative z-10">
                        <div class="p-1.5 rounded-lg bg-blue-50 text-blue-500 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        Informasi Dasar
                    </h2>
                    
                    <div class="space-y-5 relative z-10">
                        {{-- Nama --}}
                        <div>
                            <label for="name" class="form-label font-bold text-gray-700">Nama Produk <span class="text-red-500">*</span></label>
                            <input type="text" id="name" name="name" value="{{ old('name', $product->name) }}" required maxlength="255"
                                class="form-input transition-colors focus:ring-2 focus:ring-blue-100 focus:border-blue-500 text-sm">
                            @error('name') <p class="form-error mt-1.5 text-xs font-medium text-red-500 flex items-center gap-1"><svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>{{ $message }}</p> @enderror
                        </div>

                        {{-- Kategori --}}
                        <div>
                            <label for="category_id" class="form-label font-bold text-gray-700">Kategori <span class="text-red-500">*</span></label>
                            <select id="category_id" name="category_id" required class="form-input transition-colors focus:ring-2 focus:ring-blue-100 focus:border-blue-500 text-sm">
                                <option value="" disabled>Pilih kategori produk...</option>
                                @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->icon }} {{ $cat->name }}
                                </option>
                                @endforeach
                            </select>
                            @error('category_id') <p class="form-error mt-1.5 text-xs font-medium text-red-500 flex items-center gap-1"><svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>{{ $message }}</p> @enderror
                        </div>

                        {{-- Deskripsi --}}
                        <div>
                            <label for="description" class="form-label font-bold text-gray-700">Deskripsi Detail</label>
                            <textarea id="description" name="description" rows="4"
                                class="form-input transition-colors focus:ring-2 focus:ring-blue-100 focus:border-blue-500 text-sm leading-relaxed">{{ old('description', $product->description) }}</textarea>
                            @error('description') <p class="form-error mt-1.5 text-xs font-medium text-red-500 flex items-center gap-1"><svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                {{-- Card Harga & Inventaris --}}
                <div class="admin-card p-6 border-t-4 border-t-emerald-500 shadow-sm relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-4 opacity-[0.03] pointer-events-none">
                        <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 24 24"><path d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <h2 class="text-lg font-bold text-gray-800 mb-5 flex items-center gap-2 relative z-10">
                        <div class="p-1.5 rounded-lg bg-emerald-50 text-emerald-500 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        Harga & Inventaris
                    </h2>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 relative z-10">
                        {{-- Harga --}}
                        <div>
                            <label for="price" class="form-label font-bold text-gray-700">Harga Jual (Rp) <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 font-semibold text-sm">Rp</span>
                                <input type="number" id="price" name="price" value="{{ old('price', $product->price) }}" required min="0" max="999999999" step="100" 
                                    class="form-input pl-11 h-11 transition-colors focus:ring-2 focus:ring-emerald-100 focus:border-emerald-500 font-bold text-gray-800">
                            </div>
                            @error('price') <p class="form-error mt-1.5 text-xs font-medium text-red-500 flex items-center gap-1"><svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>{{ $message }}</p> @enderror
                        </div>
                        
                        {{-- Stok --}}
                        <div>
                            <label for="stock" class="form-label font-bold text-gray-700">Jumlah Stok <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                                </span>
                                <input type="number" id="stock" name="stock" value="{{ old('stock', $product->stock) }}" required min="0" max="999999" 
                                    class="form-input pl-10 h-11 transition-colors focus:ring-2 focus:ring-emerald-100 focus:border-emerald-500 font-bold text-gray-800">
                            </div>
                            @error('stock') <p class="form-error mt-1.5 text-xs font-medium text-red-500 flex items-center gap-1"><svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>
            </div>

            {{-- Kolom Kanan: Media, Visibility, Action --}}
            <div class="space-y-6">
                
                {{-- Card Upload Media --}}
                <div class="admin-card p-6 border-t-4 border-t-purple-500 shadow-sm relative overflow-hidden">
                    <h2 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                        <div class="p-1.5 rounded-lg bg-purple-50 text-purple-500 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                        Media Visual
                    </h2>
                    
                    <div>
                        {{-- Container Gambar Saat Ini (Bawaan DB) --}}
                        @if($product->image || $product->images->count() > 0)
                        <div id="current-image-container" class="mb-4 bg-purple-50/50 rounded-xl p-3 border border-purple-100 flex flex-col gap-2 relative overflow-hidden">
                            <div class="z-10">
                                <p class="text-sm font-bold text-purple-900 leading-tight">Gambar Saat Ini ({{ $product->images->count() ?: 1 }})</p>
                                <p class="text-[10px] text-purple-600 mt-0.5">Abaikan input di bawah jika Anda tidak ingin mengganti file gambar.</p>
                            </div>
                            
                            <div class="relative w-full overflow-hidden rounded-lg bg-white border border-purple-200 aspect-video group">
                                <style>
                                    .snap-x-mandatory { scroll-snap-type: x mandatory; }
                                    .snap-center { scroll-snap-align: center; }
                                    .no-scrollbar::-webkit-scrollbar { display: none; }
                                    .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
                                </style>
                                <div class="flex overflow-x-auto snap-x-mandatory no-scrollbar h-full w-full">
                                    @if($product->images->count() > 0)
                                        @foreach($product->images as $img)
                                        <div class="w-full h-full flex-shrink-0 snap-center relative group/img">
                                            <img src="{{ asset('storage/' . $img->image_path) }}" alt="{{ $product->name }}" class="w-full h-full object-contain bg-gray-50">
                                            @if($img->is_primary)
                                            <div class="absolute top-2 left-2 bg-amber-500 text-white text-[10px] font-bold px-2 py-1 rounded shadow">UTAMA</div>
                                            @endif
                                            
                                            {{-- Tombol Hapus Satuan --}}
                                            <button type="button" onclick="if(confirm('Hapus gambar ini secara permanen dari server?')) document.getElementById('delete-image-form-{{ $img->id }}').submit();"
                                                class="absolute top-2 right-2 w-7 h-7 bg-red-500 text-white rounded-full flex items-center justify-center opacity-0 group-hover/img:opacity-100 transition-opacity hover:bg-red-600 shadow" title="Hapus Gambar">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                            </button>
                                        </div>
                                        @endforeach
                                    @else
                                        <div class="w-full h-full flex-shrink-0 snap-center relative group/img">
                                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-contain bg-gray-50">
                                            <div class="absolute top-2 left-2 bg-amber-500 text-white text-[10px] font-bold px-2 py-1 rounded shadow">UTAMA</div>
                                        </div>
                                    @endif
                                </div>
                                <div class="absolute bottom-2 left-0 right-0 text-center text-[10px] text-gray-500 bg-white/70 backdrop-blur-sm py-1 font-medium hidden group-hover:block transition-all pointer-events-none">Geser horizontal untuk melihat lebih banyak</div>
                            </div>
                        </div>
                        @else
                        <div id="current-image-container" class="mb-4 bg-gray-50/50 rounded-xl p-3 border border-gray-100 text-center hidden flex flex-col items-center justify-center aspect-video">
                            <p class="text-sm font-semibold text-gray-400">Belum ada media</p>
                        </div>
                        @endif

                        {{-- Preview Gambar Baru (Disembunyikan secara default) --}}
                        <div id="new-image-preview-container" class="mb-4 bg-blue-50/50 rounded-xl p-3 border border-blue-100 relative overflow-hidden hidden">
                            <div class="flex items-center justify-between mb-2 z-10">
                                <div>
                                    <p class="text-sm font-bold text-blue-900 leading-tight">Preview Gambar Baru</p>
                                    <p id="new-file-count-display" class="text-[10px] text-blue-600 mt-0.5 font-medium"></p>
                                </div>
                                <button type="button" onclick="cancelImageSelection(event)" class="w-8 h-8 flex items-center justify-center rounded-full bg-red-50 text-red-500 hover:bg-red-100 transition-colors z-20" title="Batal ubah gambar">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </button>
                            </div>
                            
                            <!-- Carousel -->
                            <div class="relative w-full overflow-hidden rounded-lg bg-white border border-blue-200">
                                <div id="new-carousel-track" class="flex transition-transform duration-300 ease-in-out">
                                    <!-- Images will be injected here -->
                                </div>
                                <!-- Prev Button -->
                                <button type="button" onclick="moveCarousel(-1)" class="absolute left-2 top-1/2 -translate-y-1/2 w-8 h-8 flex items-center justify-center rounded-full bg-black/50 text-white hover:bg-black/70 z-20 hidden shadow-md focus:outline-none focus:ring-2 focus:ring-white" id="new-carousel-prev">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                                </button>
                                <!-- Next Button -->
                                <button type="button" onclick="moveCarousel(1)" class="absolute right-2 top-1/2 -translate-y-1/2 w-8 h-8 flex items-center justify-center rounded-full bg-black/50 text-white hover:bg-black/70 z-20 hidden shadow-md focus:outline-none focus:ring-2 focus:ring-white" id="new-carousel-next">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                </button>
                            </div>
                            <!-- Thumbnails/Dots -->
                            <div id="new-carousel-indicators" class="flex justify-center flex-wrap gap-1.5 mt-3 px-2">
                            </div>
                        </div>

                        <div id="upload-dropzone" class="mt-2 flex justify-center rounded-xl border-2 border-dashed border-gray-300 px-6 py-6 bg-gray-50/50 hover:bg-purple-50 hover:border-purple-300 transition-all duration-200 relative group cursor-pointer" onclick="document.getElementById('images').click()">
                            <div class="text-center">
                                <div class="bg-white w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-3 shadow-sm border border-gray-100 group-hover:scale-110 transition-transform">
                                    <svg class="h-5 w-5 text-purple-500" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M1.5 6a2.25 2.25 0 012.25-2.25h16.5A2.25 2.25 0 0122.5 6v12a2.25 2.25 0 01-2.25 2.25H3.75A2.25 2.25 0 011.5 18V6zM3 16.06V18c0 .414.336.75.75.75h16.5A.75.75 0 0021 18v-1.94l-2.69-2.689a1.5 1.5 0 00-2.12 0l-.88.879.97.97a.75.75 0 11-1.06 1.06l-5.16-5.159a1.5 1.5 0 00-2.12 0L3 16.061zm10.125-7.81a1.125 1.125 0 112.25 0 1.125 1.125 0 01-2.25 0z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="mt-2 text-sm text-gray-600">
                                    <span class="font-bold text-purple-600">Tekan Untuk Memilih File Baru <br>(Bisa Pilih Banyak Foto)</span>
                                    <input id="images" name="images[]" type="file" multiple class="sr-only" accept="image/jpeg,image/png,image/webp" onchange="previewImages(event)">
                                </div>
                                <p class="text-[11px] text-gray-400 mt-2">Hanya PNG, JPG, WEBP (Maks: 5 File, @2MB)</p>
                            </div>
                        </div>
                        @error('image') <p class="form-error mt-1.5 text-xs font-medium text-red-500 flex items-center gap-1"><svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>{{ $message }}</p> @enderror
                    </div>
                </div>

                {{-- Card Visibilitas & Etalase --}}
                <div class="admin-card p-6 border-t-4 border-t-amber-500 shadow-sm relative overflow-hidden">
                    <h2 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                        <div class="p-1.5 rounded-lg bg-amber-50 text-amber-500 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        </div>
                        Visibilitas Katalog
                    </h2>
                    
                    <div class="space-y-4">
                        <label class="flex items-start gap-3 p-3.5 rounded-xl border border-gray-100 hover:bg-green-50/30 hover:border-green-200 cursor-pointer transition-all group">
                            <input type="hidden" name="is_available" value="0">
                            <div class="flex items-center h-5 mt-0.5">
                                <input type="checkbox" name="is_available" value="1" {{ old('is_available', $product->is_available) ? 'checked' : '' }} class="w-4 h-4 rounded border-gray-300 text-green-500 focus:ring-green-500 transition-colors">
                            </div>
                            <div class="flex flex-col">
                                <span class="text-sm font-bold text-gray-800 group-hover:text-green-700 transition-colors">Tersedia Dijual</span>
                                <span class="text-[11px] text-gray-500 leading-tight mt-0.5">Produk akan tampil bebas dan dapat dibeli di halaman menu user.</span>
                            </div>
                        </label>
                        
                        <label class="flex items-start gap-3 p-3.5 rounded-xl border border-amber-100 bg-amber-50/40 hover:bg-amber-50 hover:border-amber-200 cursor-pointer transition-all group">
                            <input type="hidden" name="is_featured" value="0">
                            <div class="flex items-center h-5 mt-0.5">
                                <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $product->is_featured) ? 'checked' : '' }} class="w-4 h-4 rounded border-amber-300 text-amber-500 focus:ring-amber-500 transition-colors">
                            </div>
                            <div class="flex flex-col">
                                <span class="text-sm font-bold text-amber-800 flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                    Produk Unggulan
                                </span>
                                <span class="text-[11px] text-amber-700/80 leading-tight mt-0.5">Produk akan disorot secara paksa di Beranda Utama sistem pengguna.</span>
                            </div>
                        </label>
                        
                        <label class="flex items-start gap-3 p-3.5 rounded-xl border border-blue-100 bg-blue-50/40 hover:bg-blue-50 hover:border-blue-200 cursor-pointer transition-all group">
                            <input type="hidden" name="is_newcomer" value="0">
                            <div class="flex items-center h-5 mt-0.5">
                                <input type="checkbox" name="is_newcomer" value="1" {{ old('is_newcomer', $product->is_newcomer) ? 'checked' : '' }} class="w-4 h-4 rounded border-blue-300 text-blue-500 focus:ring-blue-500 transition-colors">
                            </div>
                            <div class="flex flex-col">
                                <span class="text-sm font-bold text-blue-800 flex items-center gap-1 text-[13px]">
                                    <span class="bg-blue-500 text-white text-[9px] px-1 py-0.5 rounded leading-none">NEW</span>
                                    Newcomer Show
                                </span>
                                <span class="text-[11px] text-blue-700/80 leading-tight mt-0.5">Menyamatkan produk di List Etalase eksklusif Pendatang Baru Dasbor.</span>
                            </div>
                        </label>
                    </div>
                </div>

                {{-- Card Simpan --}}
                <div class="admin-card p-6 border-t-4 border-t-gray-800 shadow-sm relative overflow-hidden">
                    <h2 class="text-lg font-bold text-gray-800 mb-2">Simpan Modifikasi</h2>
                    <p class="text-xs text-gray-500 mb-5 leading-relaxed">Periksa kembali data Master Produk sebelum menyetujui pembaruan Data.</p>
                    <div class="flex flex-col gap-3">
                        <button type="submit" class="btn-primary w-full justify-center py-2.5 shadow-md hover:shadow-lg transition-all text-sm font-bold bg-gray-800 hover:bg-gray-900 border-gray-800 text-white">
                            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Terapkan Pembaruan
                        </button>
                        <a href="{{ route('admin.products.index') }}" class="btn-secondary w-full justify-center py-2.5 text-sm font-bold bg-white text-gray-700 hover:bg-gray-100 border border-gray-200">Batal Edit</a>
                    </div>
                </div>
            </div>
        </div>
    </form>

    {{-- Form Rahasia Untuk Hapus Image Satuan --}}
    @if($product->images->count() > 0)
        @foreach($product->images as $img)
        <form id="delete-image-form-{{ $img->id }}" action="{{ route('admin.products.images.destroy', ['product' => $product->id, 'image' => $img->id]) }}" method="POST" class="hidden">
            @csrf @method('DELETE')
        </form>
        @endforeach
    @endif

    <script>
        let currentSlide = 0;
        let totalSlides = 0;
        const MAX_TOTAL_SIZE = 8 * 1024 * 1024; // 8MB

        function previewImages(event) {
            const input = event.target;
            const newPreviewContainer = document.getElementById('new-image-preview-container');
            const dropzone = document.getElementById('upload-dropzone');
            const currentImageContainer = document.getElementById('current-image-container');
            const carouselTrack = document.getElementById('new-carousel-track');
            const carouselIndicators = document.getElementById('new-carousel-indicators');
            const countDisplay = document.getElementById('new-file-count-display');
            const prevBtn = document.getElementById('new-carousel-prev');
            const nextBtn = document.getElementById('new-carousel-next');

            currentSlide = 0;
            carouselTrack.innerHTML = '';
            carouselIndicators.innerHTML = '';

            if (input.files && input.files.length > 0) {
                if (input.files.length > 5) {
                    alert('JUMLAH FILE MELEBIHI BATAS:\\nMaksimal hanya 5 gambar yang diperbolehkan per produk.');
                    input.value = '';
                    return;
                }

                let totalSize = 0;
                let validTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'];
                let hasInvalidType = false;

                Array.from(input.files).forEach(file => {
                    totalSize += file.size;
                    if (!validTypes.includes(file.type)) {
                        hasInvalidType = true;
                    }
                });
                
                if (hasInvalidType) {
                    alert('FORMAT FILE DITOLAK:\\nHanya file gambar (JPG, PNG, WEBP) yang diperbolehkan.');
                    input.value = '';
                    return;
                }
                
                if (totalSize > MAX_TOTAL_SIZE) {
                    alert('UKURAN TERLALU BESAR:\\nTotal ukuran gabungan file melebihi batas 8MB.\\nSilakan pilih kombinasi gambar dengan ukuran yang lebih kecil.');
                    input.value = '';
                    return;
                }

                totalSlides = input.files.length;
                countDisplay.textContent = `${totalSlides} file telah ditambahkan`;
                
                Array.from(input.files).forEach((file, index) => {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const slide = document.createElement('div');
                        slide.className = 'w-full flex-shrink-0 aspect-video relative';
                        slide.innerHTML = `<img src="${e.target.result}" class="w-full h-full object-contain bg-gray-50"><div class="absolute top-2 right-2 bg-black/60 text-white text-[10px] font-bold px-2 py-1 rounded shadow backdrop-blur-sm">${index + 1}/${totalSlides}</div>`;
                        carouselTrack.appendChild(slide);

                        const dot = document.createElement('button');
                        dot.type = 'button';
                        dot.className = `h-2 rounded-full transition-all focus:outline-none focus:ring-2 focus:ring-blue-300 ${index === 0 ? 'bg-blue-600 w-4' : 'bg-blue-300 w-2'}`;
                        dot.onclick = () => goToSlide(index);
                        carouselIndicators.appendChild(dot);
                    }
                    reader.readAsDataURL(file);
                });

                if (totalSlides > 1) {
                    prevBtn.classList.remove('hidden');
                    nextBtn.classList.remove('hidden');
                } else {
                    prevBtn.classList.add('hidden');
                    nextBtn.classList.add('hidden');
                }

                newPreviewContainer.classList.remove('hidden');
                dropzone.classList.add('hidden');
                if (currentImageContainer) {
                    currentImageContainer.classList.add('hidden');
                }
            }
        }

        function updateCarousel() {
            const track = document.getElementById('new-carousel-track');
            track.style.transform = `translateX(-${currentSlide * 100}%)`;
            
            const dots = document.getElementById('new-carousel-indicators').children;
            for(let i=0; i<dots.length; i++) {
                if(i === currentSlide) {
                    dots[i].classList.replace('bg-blue-300', 'bg-blue-600');
                    dots[i].classList.replace('w-2', 'w-4');
                } else {
                    dots[i].classList.replace('bg-blue-600', 'bg-blue-300');
                    dots[i].classList.replace('w-4', 'w-2');
                }
            }
        }

        function moveCarousel(direction) {
            currentSlide = (currentSlide + direction + totalSlides) % totalSlides;
            updateCarousel();
        }

        function goToSlide(index) {
            currentSlide = index;
            updateCarousel();
        }

        function cancelImageSelection(event) {
            event.stopPropagation();
            const input = document.getElementById('images');
            const newPreviewContainer = document.getElementById('new-image-preview-container');
            const currentImageContainer = document.getElementById('current-image-container');
            const dropzone = document.getElementById('upload-dropzone');
            
            input.value = '';
            newPreviewContainer.classList.add('hidden');
            dropzone.classList.remove('hidden');
            if (currentImageContainer) {
                currentImageContainer.classList.remove('hidden');
            }
            document.getElementById('new-carousel-track').innerHTML = '';
        }
    </script>
</x-layouts.admin>