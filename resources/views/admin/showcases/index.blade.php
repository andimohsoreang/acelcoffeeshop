<x-layouts.admin>
    <x-slot:title>Etalase Unggulan</x-slot:title>
    <x-slot:subtitle>Kelola produk Pendatang Baru & Peringkat Teratas</x-slot:subtitle>

    <div class="mb-8">
        <h2 class="text-xl font-bold tracking-tight text-gray-900 sm:text-2xl mb-2">Showcase Produk</h2>
        <p class="text-gray-500 text-sm">Review produk favorit pelanggan dan atur katalog produk rilisan baru Anda.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        
        {{-- PANEL: NEW COMERS (Manual Toggle) --}}
        <div class="admin-card !p-5 relative overflow-hidden flex flex-col h-full" style="border-top: 4px solid #3b82f6;">
            <div class="absolute top-0 right-0 p-4 opacity-5">
                <svg class="w-24 h-24 text-blue-500" fill="currentColor" viewBox="0 0 24 24"><path d="M11 2v4.085c-3.141.442-5.69 2.871-6.222 5.915H0v2h4.778c.532 3.044 3.081 5.473 6.222 5.915V24h2v-4.085c3.141-.442 5.69-2.871 6.222-5.915H24v-2h-4.778c-.532-3.044-3.081-5.473-6.222-5.915V2h-2zm1 6.012c2.757 0 5 2.226 5 4.988s-2.243 4.988-5 4.988c-2.756 0-5-2.226-5-4.988s2.244-4.988 5-4.988zm-2.5 1.488l-1.5 1.5 4 4 4-4-1.5-1.5-2.5 2.5-2.5-2.5z"/></svg>
            </div>
            
            <div class="flex items-center justify-between mb-6 relative z-10">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shadow-sm">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-800 text-base uppercase tracking-wider">New Comers</h3>
                        <p class="text-[13px] text-blue-600/80 font-medium">Ditentukan Manual via Edit Produk</p>
                    </div>
                </div>
                <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded-full">{{ $newComers->count() }} Produk</span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 relative z-10 flex-grow">
                @forelse($newComers as $new)
                <a href="{{ route('admin.products.show', $new) }}" class="flex flex-col p-4 rounded-xl border border-blue-100 bg-gradient-to-br from-white to-blue-50/40 hover:shadow-md hover:border-blue-300 transition-all group">
                    <div class="flex items-start justify-between mb-3">
                        <span class="text-[10px] font-bold tracking-widest uppercase px-2 py-1 rounded bg-blue-500 text-white shadow-sm">Baru Rilis</span>
                        <span class="text-[11px] text-gray-500 font-medium bg-white px-2 py-1 rounded-md border border-gray-100">{{ $new->updated_at->diffForHumans(['short' => true]) }}</span>
                    </div>
                    
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-12 h-12 rounded-lg bg-gray-100 border border-gray-200 overflow-hidden flex-shrink-0">
                            @if($new->image)
                                <img src="{{ asset('storage/' . $new->image) }}" alt="{{ $new->name }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-400">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                </div>
                            @endif
                        </div>
                        <div>
                            <p class="font-bold text-gray-800 text-sm line-clamp-2 group-hover:text-blue-600 transition-colors leading-tight">{{ $new->name }}</p>
                            <p class="text-xs text-gray-500 mt-1">{{ $new->category->name ?? 'Uncategorized' }}</p>
                        </div>
                    </div>
                    
                    <div class="mt-auto flex items-center justify-between pt-2 border-t border-blue-50">
                        <span class="text-sm font-bold text-gray-800">{{ $new->formatted_price }}</span>
                        @if($new->stock > 0)
                            <span class="text-[11px] font-medium px-2 py-1 rounded bg-emerald-50 text-emerald-600">Sisa {{ $new->stock }}</span>
                        @else
                            <span class="text-[11px] font-medium px-2 py-1 rounded bg-red-50 text-red-600">Habis</span>
                        @endif
                    </div>
                </a>
                @empty
                <div class="col-span-full flex flex-col items-center justify-center py-10 text-center border-2 border-dashed border-blue-100 rounded-xl bg-blue-50/30">
                    <svg class="w-12 h-12 text-blue-200 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    <p class="text-sm text-gray-500 font-medium">Belum ada produk "Newcomer".</p>
                    <p class="text-xs text-gray-400 mt-1">Berikan centang pada kotak 'Newcomer' di form Produk.</p>
                </div>
                @endforelse
            </div>
            
            <div class="mt-6 text-center z-10">
                 <a href="{{ route('admin.products.index') }}" class="inline-flex items-center justify-center w-full px-4 py-2 text-sm font-medium text-blue-600 bg-blue-50 border border-transparent rounded-lg hover:bg-blue-100 focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-blue-500 transition-colors">
                    Kelola Semua Produk
                 </a>
            </div>
        </div>

        {{-- PANEL: TOP RATED (Otomatis) --}}
        <div class="admin-card !p-5 relative overflow-hidden flex flex-col h-full" style="border-top: 4px solid #f59e0b;">
            <div class="absolute top-0 right-0 p-4 opacity-10">
                <svg class="w-24 h-24 text-amber-500" fill="currentColor" viewBox="0 0 24 24"><path d="M12 .587l3.668 7.568 8.332 1.151-6.064 5.828 1.48 8.279-7.416-3.967-7.417 3.967 1.481-8.279-6.064-5.828 8.332-1.151z"/></svg>
            </div>
            
            <div class="flex items-center justify-between mb-6 relative z-10">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-500 flex items-center justify-center font-bold text-2xl shadow-sm">
                        ⭐
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-800 text-base uppercase tracking-wider">Top Rated Products</h3>
                        <p class="text-[13px] text-amber-600/80 font-medium">Diurutkan Otomatis by Rating</p>
                    </div>
                </div>
            </div>

            <div class="space-y-3 relative z-10 flex-grow">
                @forelse($topRatedProducts as $index => $top)
                <div class="flex items-center justify-between p-3 rounded-xl border border-amber-100 hover:border-amber-300 hover:shadow-md transition-all bg-gradient-to-r from-white to-amber-50/20 group">
                    <div class="flex items-center gap-4">
                        <div class="relative">
                            <div class="w-12 h-12 rounded-lg bg-gray-100 border border-gray-200 overflow-hidden flex-shrink-0">
                                @if($top->image)
                                    <img src="{{ asset('storage/' . $top->image) }}" alt="{{ $top->name }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-400">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    </div>
                                @endif
                            </div>
                            <div class="absolute -top-2 -left-2 w-6 h-6 rounded-full {{ $index === 0 ? 'bg-amber-500' : ($index === 1 ? 'bg-gray-400' : ($index === 2 ? 'bg-amber-700' : 'bg-gray-800')) }} text-white flex items-center justify-center text-[10px] font-bold border-2 border-white shadow-sm">
                                #{{ $index + 1 }}
                            </div>
                        </div>
                        
                        <div>
                            <a href="{{ route('admin.products.show', $top) }}" class="font-bold text-sm text-gray-800 hover:text-amber-600 transition-colors">{{ $top->name }}</a>
                            <div class="flex items-center gap-3 mt-1 text-xs font-medium text-gray-500">
                                <span class="flex items-center gap-1 text-amber-600 font-bold bg-amber-50 px-2 py-0.5 rounded-md border border-amber-100">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                    {{ number_format($top->rating_avg, 1) }} 
                                    <span class="text-amber-600/60 ml-0.5">({{ $top->rating_count }})</span>
                                </span>
                                
                                <span class="flex items-center gap-1 text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-md border border-emerald-100">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                                    {{ $top->orderItems()->count() }} Terjual
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="flex flex-col items-center justify-center py-10 text-center border-2 border-dashed border-amber-100 rounded-xl bg-amber-50/30 h-full w-full">
                    <svg class="w-12 h-12 text-amber-200 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                    <p class="text-sm text-gray-500 font-medium">Belum ada rating produk.</p>
                </div>
                @endforelse
            </div>
        </div>

    </div>
</x-layouts.admin>
