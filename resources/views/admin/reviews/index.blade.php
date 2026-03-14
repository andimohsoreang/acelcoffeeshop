<x-layouts.admin>
    <x-slot:title>Reviews</x-slot:title>
    <x-slot:subtitle>Kelola ulasan dari pelanggan</x-slot:subtitle>

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
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari ulasan..."
                        class="form-input pl-9 !w-48 text-sm">
                </div>

                {{-- Filter rating --}}
                <select name="rating" class="form-input !w-auto text-sm" onchange="this.form.submit()">
                    <option value="">Semua Rating</option>
                    <option value="5" {{ request('rating') == '5' ? 'selected' : '' }}>⭐⭐⭐⭐⭐</option>
                    <option value="4" {{ request('rating') == '4' ? 'selected' : '' }}>⭐⭐⭐⭐</option>
                    <option value="3" {{ request('rating') == '3' ? 'selected' : '' }}>⭐⭐⭐</option>
                    <option value="2" {{ request('rating') == '2' ? 'selected' : '' }}>⭐⭐</option>
                    <option value="1" {{ request('rating') == '1' ? 'selected' : '' }}>⭐</option>
                </select>

                {{-- Filter status --}}
                <select name="status" class="form-input !w-auto text-sm" onchange="this.form.submit()">
                    <option value="">Semua Status</option>
                    <option value="approved" {{ request('status')==='approved' ? 'selected' : '' }}>Disetujui</option>
                    <option value="pending" {{ request('status')==='pending' ? 'selected' : '' }}>Menunggu Persetujuan</option>
                </select>

                @if(request()->hasAny(['search', 'rating', 'status', 'per_page']))
                <a href="{{ route('admin.reviews.index') }}" class="text-xs text-gray-400 hover:text-gray-600">✕ Reset</a>
                @endif
            </form>
        </div>

        {{-- Table --}}
        <div class="admin-card p-0 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th class="pl-6 w-16">No</th>
                            <th>Pelanggan</th>
                            <th>Produk</th>
                            <th>Komentar & Rating</th>
                            <th class="text-center">Status</th>
                            <th class="pr-6 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($reviews as $review)
                        <tr>
                            <td class="pl-6 text-gray-500 font-medium align-top py-4">
                                {{ $loop->iteration + ($reviews->currentPage() - 1) * $reviews->perPage() }}
                            </td>
                            <td class="align-top py-4">
                                <p class="font-medium text-gray-800">{{ $review->customer_name }}</p>
                                <p class="text-xs text-gray-400 hover:text-blue-500">
                                    <a href="{{ route('admin.orders.show', $review->order->order_code ?? '') }}">{{ $review->order->order_code ?? 'None' }}</a>
                                </p>
                            </td>
                            <td class="align-top py-4">
                                <span class="text-sm font-medium text-gray-700">{{ $review->product->name ?? '—' }}</span>
                                <p class="text-xs text-gray-400">{{ $review->product->category->name ?? '—' }}</p>
                            </td>
                            <td class="align-top py-4 max-w-md">
                                <div class="text-yellow-400 text-sm mb-1 tracking-widest">{{ $review->stars }}</div>
                                <p class="text-gray-600 text-sm italic break-words line-clamp-2">"{{ $review->comment ?? 'Tidak ada pesan tertulis.' }}"</p>
                                <p class="text-[10px] text-gray-400 mt-1" title="{{ $review->created_at }}">{{ $review->created_at->diffForHumans() }}</p>
                            </td>
                            <td class="text-center align-middle">
                                @if($review->is_approved)
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-700 text-xs font-medium">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Approved
                                </span>
                                @else
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-amber-50 text-amber-700 text-xs font-medium">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Pending
                                </span>
                                @endif
                            </td>
                            <td class="pr-6 align-middle">
                                <div class="flex items-center justify-end gap-1">
                                    {{-- Action Toggle Approve / Reject --}}
                                    @if($review->is_approved)
                                        <form method="POST" action="{{ route('admin.reviews.reject', $review) }}" class="inline">
                                            @csrf @method('PATCH')
                                            <button type="submit" class="p-1.5 border border-gray-200 rounded-lg text-amber-600 hover:text-white hover:bg-amber-500 hover:border-amber-500 transition-colors bg-white shadow-sm font-semibold" title="Tolak / Sembunyikan Review">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            </button>
                                        </form>
                                    @else
                                        <form method="POST" action="{{ route('admin.reviews.approve', $review) }}" class="inline">
                                            @csrf @method('PATCH')
                                            <button type="submit" class="p-1.5 border border-gray-200 rounded-lg text-emerald-600 hover:text-white hover:bg-emerald-500 hover:border-emerald-500 transition-colors bg-white shadow-sm font-semibold" title="Setujui Review">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            </button>
                                        </form>
                                    @endif

                                    <button type="button"
                                        @click="openDelete('{{ addslashes($review->customer_name) }}', '{{ route('admin.reviews.destroy', $review) }}')"
                                        class="p-1.5 rounded-lg text-gray-400 hover:text-red-600 hover:bg-red-50 transition-colors"
                                        title="Hapus Permanen">
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
                            <td colspan="6" class="text-center py-12 text-gray-400">
                                <svg class="w-10 h-10 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                </svg>
                                <p>Belum ada ulasan</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination footer --}}
            <div style="display:flex; flex-wrap:wrap; align-items:center; justify-content:space-between; gap:12px; padding:12px 16px; border-top:1px solid #e2e8f0; background:#f8fafc;">
                <p style="font-size:12px; color:#64748b; margin:0;">
                    Menampilkan {{ $reviews->firstItem() ?? 0 }}–{{ $reviews->lastItem() ?? 0 }} dari {{ $reviews->total() }} data
                </p>
                @if($reviews->hasPages())
                <div style="display:flex; align-items:center; gap:4px;">
                    @if($reviews->onFirstPage())
                    <span style="display:inline-flex; align-items:center; justify-content:center; width:32px; height:32px; border-radius:6px; border:1px solid #e2e8f0; color:#cbd5e1;">‹</span>
                    @else
                    <a href="{{ $reviews->previousPageUrl() }}" style="display:inline-flex; align-items:center; justify-content:center; width:32px; height:32px; border-radius:6px; border:1px solid #e2e8f0; color:#475569; text-decoration:none;">‹</a>
                    @endif

                    @foreach ($reviews->getUrlRange(max(1, $reviews->currentPage() - 2), min($reviews->lastPage(), $reviews->currentPage() + 2)) as $page => $url)
                    @if($page == $reviews->currentPage())
                    <span style="display:inline-flex; align-items:center; justify-content:center; width:32px; height:32px; border-radius:6px; background:linear-gradient(135deg,#3ecf8e,#2bb578); color:#fff; font-size:13px; font-weight:600;">{{ $page }}</span>
                    @else
                    <a href="{{ $url }}" style="display:inline-flex; align-items:center; justify-content:center; width:32px; height:32px; border-radius:6px; border:1px solid #e2e8f0; color:#475569; font-size:13px; text-decoration:none;">{{ $page }}</a>
                    @endif
                    @endforeach

                    @if($reviews->hasMorePages())
                    <a href="{{ $reviews->nextPageUrl() }}" style="display:inline-flex; align-items:center; justify-content:center; width:32px; height:32px; border-radius:6px; border:1px solid #e2e8f0; color:#475569; text-decoration:none;">›</a>
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
                        <h3 style="font-size:17px; font-weight:600; color:#1e293b; margin:0 0 8px;">Hapus Ulasan?</h3>
                        <p style="font-size:14px; color:#64748b; margin:0; line-height:1.5;">Ulasan dari <strong
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
