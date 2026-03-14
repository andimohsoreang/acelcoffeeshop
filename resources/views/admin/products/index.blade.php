<x-layouts.admin>
    <x-slot:title>Produk</x-slot:title>
    <x-slot:subtitle>Kelola daftar produk</x-slot:subtitle>

    <div x-data="{
        deleteModal: false,
        deleteName: '',
        deleteAction: '',
        openDelete(n, a) {
            this.deleteName = n;
            this.deleteAction = a;
            this.deleteModal = true;
        }
    }">

        {{-- Header + Filter --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
            <form method="GET" class="flex flex-wrap items-center gap-2">
                {{-- Per Baris --}}
                <select name="per_page" class="form-input !w-auto text-sm" onchange="this.form.submit()">
                    <option value="5" {{ request('per_page') == 5 ? 'selected' : '' }}>5 Baris</option>
                    <option value="10" {{ request('per_page') == 10 || !request('per_page') ? 'selected' : '' }}>10 Baris</option>
                    <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25 Baris</option>
                    <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50 Baris</option>
                </select>

                {{-- Search --}}
                <div class="relative">
                    <svg class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari produk..."
                        class="form-input pl-9 !w-48 text-sm">
                </div>

                {{-- Filter kategori --}}
                <select name="category" class="form-input !w-auto text-sm" onchange="this.form.submit()">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ request('category')==$cat->id ? 'selected' : '' }}>
                        {{ $cat->icon }} {{ $cat->name }}
                    </option>
                    @endforeach
                </select>

                {{-- Filter status --}}
                <select name="status" class="form-input !w-auto text-sm" onchange="this.form.submit()">
                    <option value="">Semua Status</option>
                    <option value="available" {{ request('status')==='available' ? 'selected' : '' }}>Tersedia</option>
                    <option value="unavailable" {{ request('status')==='unavailable' ? 'selected' : '' }}>Tidak Tersedia
                    </option>
                </select>

                @if(request()->hasAny(['search', 'category', 'status', 'per_page']))
                <a href="{{ route('admin.products.index') }}" class="text-xs text-gray-400 hover:text-gray-600">✕
                    Reset</a>
                @endif
            </form>

            <a href="{{ route('admin.products.create') }}" class="btn-primary flex-shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Produk
            </a>
        </div>

        {{-- Table --}}
        <div class="admin-card p-0 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th class="pl-6">Produk</th>
                            <th>Kategori</th>
                            <th class="text-right">Harga</th>
                            <th class="text-center">Stok</th>
                            <th class="text-center">Rating</th>
                            <th class="text-center">Status</th>
                            <th class="pr-6 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                        <tr>
                            <td class="pl-6">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-lg bg-gray-100 overflow-hidden flex-shrink-0">
                                        @if($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                            class="w-full h-full object-cover">
                                        @else
                                        <div class="w-full h-full flex items-center justify-center text-gray-400">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-800">{{ $product->name }}</p>
                                        <p class="text-xs text-gray-400">
                                            {{ $product->slug }}
                                            @if($product->is_featured)
                                            <span
                                                class="ml-1 px-1.5 py-0.5 rounded bg-amber-50 text-amber-600 text-[10px] font-semibold">⭐
                                                Featured</span>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="text-sm text-gray-600">
                                    {{ $product->category->icon ?? '' }} {{ $product->category->name ?? '—' }}
                                </span>
                            </td>
                            <td class="text-right font-semibold text-gray-700">
                                {{ $product->formatted_price }}
                            </td>
                            <td class="text-center">
                                @if($product->stock <= 5 && $product->stock > 0)
                                    <span class="text-amber-600 font-semibold text-sm">{{ $product->stock }}</span>
                                    @elseif($product->stock === 0)
                                    <span class="text-red-500 font-semibold text-sm">0</span>
                                    @else
                                    <span class="text-gray-700 text-sm">{{ $product->stock }}</span>
                                    @endif
                            </td>
                            <td class="text-center">
                                @if($product->rating_count > 0)
                                <span class="text-sm text-gray-700">
                                    ⭐ {{ number_format($product->rating_avg, 1) }}
                                    <span class="text-gray-400 text-xs">({{ $product->rating_count }})</span>
                                </span>
                                @else
                                <span class="text-gray-300 text-xs">—</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <form method="POST" action="{{ route('admin.products.toggle', $product) }}"
                                    class="inline">
                                    @csrf @method('PATCH')
                                    <button type="submit" title="Toggle ketersediaan">
                                        @if($product->is_available)
                                        <span
                                            class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-700 text-xs font-medium hover:bg-emerald-100 transition-colors cursor-pointer">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Tersedia
                                        </span>
                                        @else
                                        <span
                                            class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-gray-100 text-gray-500 text-xs font-medium hover:bg-gray-200 transition-colors cursor-pointer">
                                            <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span> Nonaktif
                                        </span>
                                        @endif
                                    </button>
                                </form>
                            </td>
                            <td class="pr-6">
                                <div class="flex items-center justify-end gap-1">
                                    <a href="{{ route('admin.products.show', $product) }}"
                                        class="p-1.5 rounded-lg text-gray-400 hover:text-gray-600 hover:bg-gray-50 transition-colors"
                                        title="Detail">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </a>
                                    <a href="{{ route('admin.products.edit', $product) }}"
                                        class="p-1.5 rounded-lg text-gray-400 hover:text-blue-600 hover:bg-blue-50 transition-colors"
                                        title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>
                                    <button type="button"
                                        @click="openDelete('{{ addslashes($product->name) }}', '{{ route('admin.products.destroy', $product) }}')"
                                        class="p-1.5 rounded-lg text-gray-400 hover:text-red-600 hover:bg-red-50 transition-colors"
                                        title="Hapus">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-12 text-gray-400">
                                <svg class="w-10 h-10 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                </svg>
                                <p>Belum ada produk</p>
                                <a href="{{ route('admin.products.create') }}"
                                    class="text-blue-600 text-sm hover:underline mt-1 inline-block">+ Tambah Produk</a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination footer --}}
            <div style="display:flex; flex-wrap:wrap; align-items:center; justify-content:space-between; gap:12px; padding:12px 16px; border-top:1px solid #e2e8f0; background:#f8fafc;">
                <p style="font-size:12px; color:#64748b; margin:0;">
                    Menampilkan {{ $products->firstItem() ?? 0 }}–{{ $products->lastItem() ?? 0 }} dari {{ $products->total() }} produk
                </p>
                @if($products->hasPages())
                <div style="display:flex; align-items:center; gap:4px;">
                    @if($products->onFirstPage())
                    <span style="display:inline-flex; align-items:center; justify-content:center; width:32px; height:32px; border-radius:6px; border:1px solid #e2e8f0; color:#cbd5e1;">‹</span>
                    @else
                    <a href="{{ $products->previousPageUrl() }}" style="display:inline-flex; align-items:center; justify-content:center; width:32px; height:32px; border-radius:6px; border:1px solid #e2e8f0; color:#475569; text-decoration:none;">‹</a>
                    @endif

                    @foreach ($products->getUrlRange(max(1, $products->currentPage() - 2), min($products->lastPage(), $products->currentPage() + 2)) as $page => $url)
                    @if($page == $products->currentPage())
                    <span style="display:inline-flex; align-items:center; justify-content:center; width:32px; height:32px; border-radius:6px; background:linear-gradient(135deg,#3ecf8e,#2bb578); color:#fff; font-size:13px; font-weight:600;">{{ $page }}</span>
                    @else
                    <a href="{{ $url }}" style="display:inline-flex; align-items:center; justify-content:center; width:32px; height:32px; border-radius:6px; border:1px solid #e2e8f0; color:#475569; font-size:13px; text-decoration:none;">{{ $page }}</a>
                    @endif
                    @endforeach

                    @if($products->hasMorePages())
                    <a href="{{ $products->nextPageUrl() }}" style="display:inline-flex; align-items:center; justify-content:center; width:32px; height:32px; border-radius:6px; border:1px solid #e2e8f0; color:#475569; text-decoration:none;">›</a>
                    @else
                    <span style="display:inline-flex; align-items:center; justify-content:center; width:32px; height:32px; border-radius:6px; border:1px solid #e2e8f0; color:#cbd5e1;">›</span>
                    @endif
                </div>
                @endif
            </div>
        </div>

        {{-- DELETE MODAL --}}
        <template x-teleport="body">
            <div x-show="deleteModal" x-cloak>
                <div x-show="deleteModal" x-transition.opacity.duration.200ms @click="deleteModal = false"
                    style="position:fixed; top:0; left:0; right:0; bottom:0; z-index:9998; background:rgba(15,23,42,0.5); backdrop-filter:blur(4px);">
                </div>
                <div x-show="deleteModal" x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 transform scale-95"
                    x-transition:enter-end="opacity-100 transform scale-100"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100 transform scale-100"
                    x-transition:leave-end="opacity-0 transform scale-95"
                    style="position:fixed; z-index:9999; top:50%; left:50%; transform:translate(-50%,-50%); background:#fff; border-radius:16px; box-shadow:0 25px 80px rgba(0,0,0,0.2); width:400px; max-width:calc(100vw - 32px);">
                    <div style="padding:32px 24px 20px; text-align:center;">
                        <div
                            style="width:56px; height:56px; border-radius:50%; background:#fef2f2; display:flex; align-items:center; justify-content:center; margin:0 auto 20px;">
                            <svg style="width:28px; height:28px; color:#ef4444;" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </div>
                        <h3 style="font-size:17px; font-weight:600; color:#1e293b; margin:0 0 8px;">Hapus Produk?</h3>
                        <p style="font-size:14px; color:#64748b; margin:0; line-height:1.5;">Produk <strong
                                x-text="deleteName" style="color:#1e293b;"></strong> akan dihapus permanen.</p>
                    </div>
                    <div
                        style="padding:16px 24px; border-top:1px solid #e2e8f0; display:flex; align-items:center; gap:10px; background:#f8fafc; border-radius:0 0 16px 16px;">
                        <button type="button" @click="deleteModal = false"
                            style="padding:10px 20px; border-radius:8px; font-size:13px; font-weight:500; color:#475569; background:#fff; border:1px solid #d1d5db; cursor:pointer; flex:1;">Batal</button>
                        <form :action="deleteAction" method="POST" style="flex:1;">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                style="width:100%; padding:10px 20px; border-radius:8px; font-size:13px; font-weight:600; color:#fff; background:#ef4444; border:none; cursor:pointer;">Ya,
                                Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
        </template>
    </div>
</x-layouts.admin>