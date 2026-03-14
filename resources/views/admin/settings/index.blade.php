<x-layouts.admin>
    <x-slot:title>Pengaturan Toko</x-slot:title>

    <div class="max-w-4xl mx-auto">
        {{-- Flash Message --}}
        @if(session('success'))
        <div class="mb-6 bg-emerald-50 text-emerald-600 p-4 rounded-2xl border border-emerald-100 flex items-center gap-3 shadow-sm" x-data="{ show: true }" x-show="show">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span class="font-medium text-sm">{{ session('success') }}</span>
            <button @click="show = false" class="ml-auto opacity-50 hover:opacity-100"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
        </div>
        @endif

        {{-- Form Pengaturan --}}
        <form action="{{ route('admin.settings.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="bg-white rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] overflow-hidden border border-slate-100 mb-8">
                <div class="border-b border-slate-100 px-8 py-6 bg-slate-50/50">
                    <h2 class="text-xl font-black text-slate-800 flex items-center gap-3">
                        <div class="p-2 bg-blue-100 text-blue-600 rounded-xl">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        </div>
                        Informasi Utama Toko
                    </h2>
                    <p class="mt-2 text-sm text-slate-500 font-medium ml-12">Konfigurasi nama kedai dan informasi dasar yang akan tampil di seluruh aplikasi dan struk.</p>
                </div>

                <div class="p-8 space-y-6">
                    {{-- Nama Toko --}}
                    <div>
                        <label for="shop_name" class="block text-sm font-bold text-slate-700 mb-2">Nama Toko / Kedai</label>
                        <input type="text" id="shop_name" name="shop_name" 
                            value="{{ old('shop_name', $settings['shop_name'] ?? 'Kopi Nusantara') }}" 
                            class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block p-3 transition-colors"
                            placeholder="Contoh: Koji Coffee Shop" required>
                    </div>

                    {{-- Deskripsi/Slogan --}}
                    <div>
                        <label for="shop_tagline" class="block text-sm font-bold text-slate-700 mb-2">Tagline / Slogan</label>
                        <input type="text" id="shop_tagline" name="shop_tagline" 
                            value="{{ old('shop_tagline', $settings['shop_tagline'] ?? 'Menyajikan kopi terbaik dari biji pilihan Nusantara.') }}" 
                            class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block p-3 transition-colors"
                            placeholder="Contoh: Sensasi Kopi Asli Indonesia">
                    </div>

                    {{-- Alamat --}}
                    <div>
                        <label for="shop_address" class="block text-sm font-bold text-slate-700 mb-2">Alamat Lengkap (Muncul di Struk/PDF)</label>
                        <textarea id="shop_address" name="shop_address" rows="3"
                            class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block p-3 transition-colors"
                            placeholder="Contoh: Jl. Sudirman No 45, Jakarta Selatan. 12190.">{{ old('shop_address', $settings['shop_address'] ?? '') }}</textarea>
                    </div>

                    {{-- No Telepon/WA --}}
                    <div>
                        <label for="shop_phone" class="block text-sm font-bold text-slate-700 mb-2">Nomor Telepon / WhatsApp</label>
                        <input type="text" id="shop_phone" name="shop_phone" 
                            value="{{ old('shop_phone', $settings['shop_phone'] ?? '') }}" 
                            class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block p-3 transition-colors"
                            placeholder="Contoh: 081234567890">
                    </div>

                    {{-- Biaya Layanan Tambahan (opsional) --}}
                    <div>
                        <label for="service_fee" class="block text-sm font-bold text-slate-700 mb-2">Biaya Tambahan / Pajak (Opsional, Rp)</label>
                        <input type="number" id="service_fee" name="service_fee" 
                            value="{{ old('service_fee', $settings['service_fee'] ?? '0') }}" 
                            class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block p-3 transition-colors"
                            placeholder="Contoh: 2000">
                    </div>
                </div>

                <div class="px-8 py-5 bg-slate-50 border-t border-slate-100 flex justify-end">
                    <button type="submit" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 shadow-lg shadow-blue-500/30 text-white font-bold text-sm rounded-xl transition-all flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Simpan Perubahan
                    </button>
                </div>
            </div>
        </form>
    </div>
</x-layouts.admin>
