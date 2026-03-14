<x-layouts.admin>
    <x-slot:title>Kategori</x-slot:title>
    <x-slot:subtitle>Kelola kategori produk</x-slot:subtitle>

    <div x-data="{
        editModal: false,
        deleteModal: false,
        editId: null,
        editData: { name: '', icon: '', description: '', sort_order: 0, is_active: true },
        deleteName: '',
        deleteAction: '',
        openEdit(c) {
            this.editId = c.id;
            this.editData = {
                name: c.name,
                icon: c.icon || '',
                description: c.description || '',
                sort_order: c.sort_order,
                is_active: c.is_active
            };
            this.editModal = true;
        },
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
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari kategori..."
                        class="form-input pl-9 !w-48 text-sm">
                </div>

                {{-- Filter status --}}
                <select name="status" class="form-input !w-auto text-sm" onchange="this.form.submit()">
                    <option value="">Semua Status</option>
                    <option value="active" {{ request('status')==='active' ? 'selected' : '' }}>Aktif</option>
                    <option value="inactive" {{ request('status')==='inactive' ? 'selected' : '' }}>Nonaktif</option>
                </select>

                @if(request()->hasAny(['search', 'status', 'per_page']))
                <a href="{{ route('admin.categories.index') }}" class="text-xs text-gray-400 hover:text-gray-600">✕
                    Reset</a>
                @endif
            </form>

            <a href="{{ route('admin.categories.create') }}" class="btn-primary flex-shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Kategori
            </a>
        </div>

        {{-- Table --}}
        <div class="admin-card p-0 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th class="pl-6 w-16">Urutan</th>
                            <th>Kategori</th>
                            <th>Deskripsi</th>
                            <th class="text-center">Produk</th>
                            <th class="text-center">Status</th>
                            <th class="pr-6 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($categories as $category)
                        <tr>
                            <td class="pl-6">
                                <span
                                    class="inline-flex items-center justify-center w-7 h-7 rounded-md bg-gray-100 text-gray-500 text-xs font-semibold">
                                    {{ $category->sort_order }}
                                </span>
                            </td>
                            <td>
                                <div class="flex items-center gap-3">
                                    @if($category->icon)
                                    <span class="text-xl leading-none">{{ $category->icon }}</span>
                                    @endif
                                    <div>
                                        <p class="font-medium text-gray-800">{{ $category->name }}</p>
                                        <p class="text-xs text-gray-400">{{ $category->slug }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="max-w-xs truncate text-gray-500">
                                {{ $category->description ?? '—' }}
                            </td>
                            <td class="text-center">
                                <span class="px-2.5 py-0.5 rounded-full bg-blue-50 text-blue-600 text-xs font-medium">
                                    {{ $category->products_count }} produk
                                </span>
                            </td>
                            <td class="text-center">
                                @if($category->is_active)
                                <span
                                    class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-700 text-xs font-medium">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Aktif
                                </span>
                                @else
                                <span
                                    class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-gray-100 text-gray-500 text-xs font-medium">
                                    <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span> Nonaktif
                                </span>
                                @endif
                            </td>
                            <td class="pr-6">
                                <div class="flex items-center justify-end gap-1">
                                    <button
                                        @click="openEdit(@js($category->only(['id','name','icon','description','sort_order','is_active'])))"
                                        class="p-1.5 rounded-lg text-gray-400 hover:text-blue-600 hover:bg-blue-50 transition-colors"
                                        title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </button>
                                    <button
                                        @click="openDelete('{{ $category->name }}', '{{ route('admin.categories.destroy', $category) }}')"
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
                            <td colspan="6" class="text-center py-12 text-gray-400">
                                <svg class="w-10 h-10 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                </svg>
                                <p>Belum ada kategori</p>
                                <a href="{{ route('admin.categories.create') }}"
                                    class="text-blue-600 text-sm hover:underline mt-1 inline-block">+ Tambah
                                    Kategori</a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination footer --}}
            <div style="display:flex; flex-wrap:wrap; align-items:center; justify-content:space-between; gap:12px; padding:12px 16px; border-top:1px solid #e2e8f0; background:#f8fafc;">
                <p style="font-size:12px; color:#64748b; margin:0;">
                    Menampilkan {{ $categories->firstItem() ?? 0 }}–{{ $categories->lastItem() ?? 0 }} dari {{ $categories->total() }} kategori
                </p>
                @if($categories->hasPages())
                <div style="display:flex; align-items:center; gap:4px;">
                    @if($categories->onFirstPage())
                    <span style="display:inline-flex; align-items:center; justify-content:center; width:32px; height:32px; border-radius:6px; border:1px solid #e2e8f0; color:#cbd5e1;">‹</span>
                    @else
                    <a href="{{ $categories->previousPageUrl() }}" style="display:inline-flex; align-items:center; justify-content:center; width:32px; height:32px; border-radius:6px; border:1px solid #e2e8f0; color:#475569; text-decoration:none;">‹</a>
                    @endif

                    @foreach ($categories->getUrlRange(max(1, $categories->currentPage() - 2), min($categories->lastPage(), $categories->currentPage() + 2)) as $page => $url)
                    @if($page == $categories->currentPage())
                    <span style="display:inline-flex; align-items:center; justify-content:center; width:32px; height:32px; border-radius:6px; background:linear-gradient(135deg,#3ecf8e,#2bb578); color:#fff; font-size:13px; font-weight:600;">{{ $page }}</span>
                    @else
                    <a href="{{ $url }}" style="display:inline-flex; align-items:center; justify-content:center; width:32px; height:32px; border-radius:6px; border:1px solid #e2e8f0; color:#475569; font-size:13px; text-decoration:none;">{{ $page }}</a>
                    @endif
                    @endforeach

                    @if($categories->hasMorePages())
                    <a href="{{ $categories->nextPageUrl() }}" style="display:inline-flex; align-items:center; justify-content:center; width:32px; height:32px; border-radius:6px; border:1px solid #e2e8f0; color:#475569; text-decoration:none;">›</a>
                    @else
                    <span style="display:inline-flex; align-items:center; justify-content:center; width:32px; height:32px; border-radius:6px; border:1px solid #e2e8f0; color:#cbd5e1;">›</span>
                    @endif
                </div>
                @endif
            </div>
        </div>

        {{-- EDIT MODAL --}}
        <template x-teleport="body">
            <div x-show="editModal" x-cloak>
                <div x-show="editModal" x-transition.opacity.duration.200ms @click="editModal = false"
                    style="position:fixed; top:0; left:0; right:0; bottom:0; z-index:9998; background:rgba(15,23,42,0.5); backdrop-filter:blur(4px);">
                </div>
                <div x-show="editModal" x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 transform scale-95"
                    x-transition:enter-end="opacity-100 transform scale-100"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100 transform scale-100"
                    x-transition:leave-end="opacity-0 transform scale-95"
                    style="position:fixed; z-index:9999; top:50%; left:50%; transform:translate(-50%,-50%); background:#fff; border-radius:16px; box-shadow:0 25px 80px rgba(0,0,0,0.2); width:480px; max-width:calc(100vw - 32px); max-height:calc(100vh - 48px); overflow-y:auto;">
                    <div
                        style="padding:20px 24px; border-bottom:1px solid #e2e8f0; display:flex; align-items:center; justify-content:space-between;">
                        <div>
                            <h3 style="font-size:16px; font-weight:600; color:#1e293b; margin:0;">Edit Kategori</h3>
                            <p style="font-size:12px; color:#94a3b8; margin:4px 0 0;">Ubah detail kategori</p>
                        </div>
                        <button @click="editModal = false"
                            style="width:32px; height:32px; display:flex; align-items:center; justify-content:center; border:none; background:#f1f5f9; cursor:pointer; color:#64748b; border-radius:8px;">✕</button>
                    </div>
                    <form :action="'/admin/categories/' + editId" method="POST">
                        @csrf
                        @method('PUT')
                        <div style="padding:24px;">
                            <div style="margin-bottom:20px;">
                                <label
                                    style="display:block; font-size:13px; font-weight:500; color:#334155; margin-bottom:6px;">Nama
                                    Kategori <span style="color:#ef4444;">*</span></label>
                                <input type="text" name="name" x-model="editData.name" required
                                    placeholder="cth: Espresso"
                                    style="display:block; width:100%; padding:10px 14px; border:1px solid #e2e8f0; border-radius:8px; font-size:14px; color:#1e293b; background:#fff; outline:none; box-sizing:border-box; font-family:inherit;"
                                    onfocus="this.style.borderColor='#3ecf8e';this.style.boxShadow='0 0 0 3px rgba(62,207,142,0.12)'"
                                    onblur="this.style.borderColor='#e2e8f0';this.style.boxShadow='none'">
                            </div>
                            <div style="display:grid; grid-template-columns:100px 1fr; gap:16px; margin-bottom:20px;">
                                <div>
                                    <label
                                        style="display:block; font-size:13px; font-weight:500; color:#334155; margin-bottom:6px;">Icon</label>
                                    <input type="text" name="icon" x-model="editData.icon" maxlength="10"
                                        placeholder="☕"
                                        style="display:block; width:100%; padding:10px; border:1px solid #e2e8f0; border-radius:8px; font-size:22px; color:#1e293b; text-align:center; background:#fff; outline:none; box-sizing:border-box;"
                                        onfocus="this.style.borderColor='#3ecf8e'"
                                        onblur="this.style.borderColor='#e2e8f0'">
                                </div>
                                <div>
                                    <label
                                        style="display:block; font-size:13px; font-weight:500; color:#334155; margin-bottom:6px;">Urutan</label>
                                    <input type="number" name="sort_order" x-model="editData.sort_order" min="0"
                                        style="display:block; width:100%; padding:10px 14px; border:1px solid #e2e8f0; border-radius:8px; font-size:14px; color:#1e293b; background:#fff; outline:none; box-sizing:border-box; font-family:inherit;"
                                        onfocus="this.style.borderColor='#3ecf8e'"
                                        onblur="this.style.borderColor='#e2e8f0'">
                                </div>
                            </div>
                            <div style="margin-bottom:20px;">
                                <label
                                    style="display:block; font-size:13px; font-weight:500; color:#334155; margin-bottom:6px;">Deskripsi</label>
                                <textarea name="description" x-model="editData.description" rows="3"
                                    placeholder="Deskripsi singkat..."
                                    style="display:block; width:100%; padding:10px 14px; border:1px solid #e2e8f0; border-radius:8px; font-size:14px; color:#1e293b; resize:none; background:#fff; outline:none; box-sizing:border-box; font-family:inherit;"
                                    onfocus="this.style.borderColor='#3ecf8e'"
                                    onblur="this.style.borderColor='#e2e8f0'"></textarea>
                            </div>
                            <div
                                style="display:flex; align-items:center; justify-content:space-between; padding:14px 16px; background:#f8fafc; border-radius:10px; border:1px solid #e2e8f0;">
                                <div>
                                    <p style="font-size:13px; font-weight:500; color:#334155; margin:0;">Status</p>
                                    <p style="font-size:12px; color:#94a3b8; margin:2px 0 0;"
                                        x-text="editData.is_active ? 'Ditampilkan di menu' : 'Disembunyikan'"></p>
                                </div>
                                <input type="hidden" name="is_active" value="0">
                                <label
                                    style="position:relative; display:inline-block; width:44px; height:24px; cursor:pointer; flex-shrink:0;">
                                    <input type="checkbox" name="is_active" value="1" x-model="editData.is_active"
                                        style="position:absolute; opacity:0; width:0; height:0;">
                                    <span
                                        :style="editData.is_active ? 'position:absolute;inset:0;background:#3ecf8e;border-radius:99px;transition:background 0.2s' : 'position:absolute;inset:0;background:#cbd5e1;border-radius:99px;transition:background 0.2s'"></span>
                                    <span
                                        :style="editData.is_active ? 'position:absolute;left:22px;top:2px;width:20px;height:20px;background:#fff;border-radius:50%;transition:left 0.2s;box-shadow:0 1px 4px rgba(0,0,0,0.15)' : 'position:absolute;left:2px;top:2px;width:20px;height:20px;background:#fff;border-radius:50%;transition:left 0.2s;box-shadow:0 1px 4px rgba(0,0,0,0.15)'"></span>
                                </label>
                            </div>
                        </div>
                        <div
                            style="padding:16px 24px; border-top:1px solid #e2e8f0; display:flex; align-items:center; justify-content:flex-end; gap:10px; background:#f8fafc; border-radius:0 0 16px 16px;">
                            <button type="button" @click="editModal = false"
                                style="padding:9px 18px; border-radius:8px; font-size:13px; font-weight:500; color:#475569; background:#fff; border:1px solid #d1d5db; cursor:pointer;">Batal</button>
                            <button type="submit"
                                style="padding:9px 22px; border-radius:8px; font-size:13px; font-weight:600; color:#fff; background:linear-gradient(135deg,#3ecf8e,#2bb578); border:none; cursor:pointer;">Simpan
                                Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </template>

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
                        <h3 style="font-size:17px; font-weight:600; color:#1e293b; margin:0 0 8px;">Hapus Kategori?</h3>
                        <p style="font-size:14px; color:#64748b; margin:0; line-height:1.5;">Kategori <strong
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