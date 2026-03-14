<x-layouts.admin>
    <x-slot:title>Detail Kategori</x-slot:title>
    <x-slot:subtitle>{{ $category->icon }} {{ $category->name }}</x-slot:subtitle>

    <div class="max-w-2xl">

        {{-- Info card --}}
        <div class="admin-card mb-6">
            <div class="flex items-start justify-between mb-4">
                <div class="flex items-center gap-3">
                    @if($category->icon)
                    <span class="text-3xl">{{ $category->icon }}</span>
                    @endif
                    <div>
                        <h2 class="text-lg font-bold text-gray-800">{{ $category->name }}</h2>
                        <p class="text-xs text-gray-400 font-mono">{{ $category->slug }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <a href="{{ route('admin.categories.edit', $category) }}" class="btn-secondary text-xs">Edit</a>
                </div>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 text-sm">
                <div>
                    <p class="text-gray-400 text-xs mb-1">Status</p>
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
                </div>
                <div>
                    <p class="text-gray-400 text-xs mb-1">Jumlah Produk</p>
                    <p class="font-semibold text-gray-700">{{ $category->products_count }}</p>
                </div>
                <div>
                    <p class="text-gray-400 text-xs mb-1">Urutan</p>
                    <p class="font-semibold text-gray-700">{{ $category->sort_order }}</p>
                </div>
                <div>
                    <p class="text-gray-400 text-xs mb-1">Dibuat</p>
                    <p class="font-semibold text-gray-700">{{ $category->created_at->isoFormat('D MMM Y') }}</p>
                </div>
            </div>

            @if($category->description)
            <div class="mt-4 pt-4 border-t border-gray-100">
                <p class="text-gray-400 text-xs mb-1">Deskripsi</p>
                <p class="text-sm text-gray-600">{{ $category->description }}</p>
            </div>
            @endif
        </div>

        <a href="{{ route('admin.categories.index') }}"
            class="text-sm text-gray-400 hover:text-gray-600 transition-colors">
            ← Kembali ke daftar kategori
        </a>

    </div>

</x-layouts.admin>