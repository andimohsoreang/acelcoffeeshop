<x-layouts.admin>
    <x-slot:title>Tambah Kategori</x-slot:title>
    <x-slot:subtitle>Buat kategori produk baru</x-slot:subtitle>

    <a href="{{ route('admin.categories.index') }}"
        class="inline-flex items-center gap-1.5 text-sm text-gray-400 hover:text-gray-600 transition-colors mb-5"
        style="display: inline-flex;">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        Kembali
    </a>

    <form method="POST" action="{{ route('admin.categories.store') }}">
        @csrf

        {{-- Section: Informasi Umum --}}
        <div
            style="background: #fff; border-radius: 12px; border: 1px solid #e2e8f0; overflow: hidden; margin-bottom: 24px;">
            <div style="padding: 16px 24px; border-bottom: 1px solid #f1f5f9; background: #f8fafc;">
                <h3 style="font-size: 13px; font-weight: 600; color: #1e293b; margin: 0;">Informasi Umum</h3>
            </div>

            {{-- Nama --}}
            <div style="padding: 16px 24px; border-bottom: 1px solid #f1f5f9;">
                <div style="display: flex; gap: 0;">
                    <div style="width: 176px; flex-shrink: 0; padding-top: 8px;">
                        <label for="name" style="font-size: 13px; color: #475569; font-weight: 400;">Nama
                            Kategori</label>
                    </div>
                    <div style="flex: 1;">
                        <input type="text" id="name" name="name" value="{{ old('name') }}" required
                            placeholder="cth: Espresso Based"
                            style="display: block; width: 100%; border-radius: 6px; border: 1px solid #d1d5db; background: #fff; padding: 8px 12px; font-size: 13px; color: #1e293b; outline: none; transition: border-color 0.15s, box-shadow 0.15s;"
                            onfocus="this.style.borderColor='#3ecf8e'; this.style.boxShadow='0 0 0 3px rgba(62,207,142,0.15)'"
                            onblur="this.style.borderColor='#d1d5db'; this.style.boxShadow='none'">
                        @error('name') <p style="font-size: 12px; color: #ef4444; margin-top: 6px;">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Icon --}}
            <div style="padding: 16px 24px; border-bottom: 1px solid #f1f5f9;">
                <div style="display: flex; gap: 0;">
                    <div style="width: 176px; flex-shrink: 0; padding-top: 8px;">
                        <label for="icon" style="font-size: 13px; color: #475569; font-weight: 400;">Icon
                            (Emoji)</label>
                        <p style="font-size: 11px; color: #94a3b8; margin-top: 2px;">Paste emoji untuk ikon</p>
                    </div>
                    <div style="flex: 1;">
                        <input type="text" id="icon" name="icon" value="{{ old('icon') }}" placeholder="☕"
                            maxlength="10"
                            style="display: block; width: 64px; border-radius: 6px; border: 1px solid #d1d5db; background: #fff; padding: 8px 12px; font-size: 20px; color: #1e293b; text-align: center; outline: none; transition: border-color 0.15s, box-shadow 0.15s;"
                            onfocus="this.style.borderColor='#3ecf8e'; this.style.boxShadow='0 0 0 3px rgba(62,207,142,0.15)'"
                            onblur="this.style.borderColor='#d1d5db'; this.style.boxShadow='none'">
                        @error('icon') <p style="font-size: 12px; color: #ef4444; margin-top: 6px;">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Deskripsi --}}
            <div style="padding: 16px 24px;">
                <div style="display: flex; gap: 0;">
                    <div style="width: 176px; flex-shrink: 0; padding-top: 8px;">
                        <label for="description"
                            style="font-size: 13px; color: #475569; font-weight: 400;">Deskripsi</label>
                        <p style="font-size: 11px; color: #94a3b8; margin-top: 2px;">Opsional</p>
                    </div>
                    <div style="flex: 1;">
                        <textarea id="description" name="description" rows="3"
                            placeholder="Deskripsi singkat kategori..."
                            style="display: block; width: 100%; border-radius: 6px; border: 1px solid #d1d5db; background: #fff; padding: 8px 12px; font-size: 13px; color: #1e293b; resize: none; outline: none; transition: border-color 0.15s, box-shadow 0.15s;"
                            onfocus="this.style.borderColor='#3ecf8e'; this.style.boxShadow='0 0 0 3px rgba(62,207,142,0.15)'"
                            onblur="this.style.borderColor='#d1d5db'; this.style.boxShadow='none'">{{ old('description') }}</textarea>
                        @error('description') <p style="font-size: 12px; color: #ef4444; margin-top: 6px;">{{ $message
                            }}</p> @enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- Section: Pengaturan --}}
        <div
            style="background: #fff; border-radius: 12px; border: 1px solid #e2e8f0; overflow: hidden; margin-bottom: 24px;">
            <div style="padding: 16px 24px; border-bottom: 1px solid #f1f5f9; background: #f8fafc;">
                <h3 style="font-size: 13px; font-weight: 600; color: #1e293b; margin: 0;">Pengaturan</h3>
            </div>

            {{-- Sort Order --}}
            <div style="padding: 16px 24px;">
                <div style="display: flex; gap: 0;">
                    <div style="width: 176px; flex-shrink: 0; padding-top: 8px;">
                        <label for="sort_order" style="font-size: 13px; color: #475569; font-weight: 400;">Urutan
                            Tampil</label>
                        <p style="font-size: 11px; color: #94a3b8; margin-top: 2px;">Angka kecil = lebih atas</p>
                    </div>
                    <div style="flex: 1;">
                        <input type="number" id="sort_order" name="sort_order" value="{{ old('sort_order', 0) }}"
                            min="0"
                            style="display: block; width: 80px; border-radius: 6px; border: 1px solid #d1d5db; background: #fff; padding: 8px 12px; font-size: 13px; color: #1e293b; outline: none; transition: border-color 0.15s, box-shadow 0.15s;"
                            onfocus="this.style.borderColor='#3ecf8e'; this.style.boxShadow='0 0 0 3px rgba(62,207,142,0.15)'"
                            onblur="this.style.borderColor='#d1d5db'; this.style.boxShadow='none'">
                        @error('sort_order') <p style="font-size: 12px; color: #ef4444; margin-top: 6px;">{{ $message }}
                        </p> @enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- Actions --}}
        <div style="display: flex; align-items: center; justify-content: flex-end; gap: 12px; padding-bottom: 24px;">
            <a href="{{ route('admin.categories.index') }}"
                style="padding: 8px 16px; border-radius: 6px; font-size: 13px; font-weight: 500; color: #475569; background: #fff; border: 1px solid #d1d5db; text-decoration: none; transition: background 0.15s;"
                onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='#fff'">
                Batal
            </a>
            <button type="submit"
                style="padding: 8px 20px; border-radius: 6px; font-size: 13px; font-weight: 600; color: #fff; background: linear-gradient(135deg, #3ecf8e, #2bb578); border: none; cursor: pointer; transition: opacity 0.15s;"
                onmouseover="this.style.opacity='0.9'" onmouseout="this.style.opacity='1'">
                Simpan Kategori
            </button>
        </div>
    </form>

</x-layouts.admin>