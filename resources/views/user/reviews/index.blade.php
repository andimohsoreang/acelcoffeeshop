<x-layouts.app>
    <x-slot:title>Ulasan & Penilaian Pelanggan</x-slot:title>

    <div class="bg-slate-50 min-h-screen pb-24 md:pb-16 flex flex-col">
        
        {{-- Hero Header --}}
        <div class="relative overflow-hidden bg-slate-900 pt-16 pb-20 md:pt-24 md:pb-28">
            <!-- Decorative Background Patterns -->
            <div class="absolute inset-0 z-0 opacity-20 bg-[url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'1\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')]"></div>
            <div class="absolute -top-40 -right-40 w-[500px] h-[500px] bg-brand-primary rounded-full blur-[100px] opacity-20"></div>
            <div class="absolute -bottom-40 -left-40 w-[400px] h-[400px] bg-brand-secondary rounded-full blur-[100px] opacity-20"></div>
            
            <div class="relative z-10 max-w-5xl lg:max-w-7xl mx-auto px-6 lg:px-10 text-center">
                <h1 class="text-3xl md:text-5xl lg:text-6xl font-black text-white tracking-tight leading-tight mb-4">
                    Apa <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-secondary to-brand-secondary/80">Kata Mereka?</span>
                </h1>
                <p class="text-sm md:text-base lg:text-lg text-slate-300 font-medium max-w-2xl mx-auto leading-relaxed">
                    Lebih dari sekadar secangkir kopi. Baca pengalaman jujur dari pelanggan kami tentang rasa, kualitas, dan kehangatan yang kami sajikan di setiap tegukan.
                </p>
                
                {{-- Quick Stats (Optional Visuals) --}}
                <div class="mt-8 flex flex-wrap justify-center items-center gap-4 md:gap-8">
                    <div class="flex items-center gap-2 text-white bg-white/10 backdrop-blur-md px-4 py-2 rounded-2xl border border-white/20">
                        <div class="flex gap-0.5">
                            @for($i=0; $i<5; $i++)
                                <svg class="w-4 h-4 text-brand-secondary" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            @endfor
                        </div>
                        <span class="text-sm font-bold ml-1">Kualitas Premium</span>
                    </div>
                    <div class="flex items-center gap-2 text-white bg-white/10 backdrop-blur-md px-4 py-2 rounded-2xl border border-white/20">
                        <svg class="w-5 h-5 text-brand-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span class="text-sm font-bold">Harga Terbaik</span>
                    </div>
                </div>
            </div>
            
            {{-- Curved Bottom Divider --}}
            <div class="absolute bottom-0 inset-x-0">
                <svg viewBox="0 0 1440 48" class="w-full h-auto text-slate-50 fill-current" preserveAspectRatio="none"><path d="M0,48 L1440,48 L1440,0 C1080,48 360,48 0,0 L0,48 Z"></path></svg>
            </div>
        </div>

        {{-- Reviews Content --}}
        <div class="relative z-20 flex-1 max-w-5xl lg:max-w-7xl mx-auto px-4 md:px-6 lg:px-10 -mt-6">
            
            @if($reviews->isEmpty())
                <div class="bg-white rounded-[2rem] p-12 text-center shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-100 flex flex-col items-center justify-center min-h-[400px] transform transition-all duration-500 hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)]">
                    <div class="w-24 h-24 bg-gradient-to-tr from-slate-50 to-slate-100 rounded-3xl flex items-center justify-center mb-6 shadow-inner border border-white">
                        <svg class="w-12 h-12 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl md:text-2xl font-extrabold text-slate-800 tracking-tight">Belum Ada Ulasan</h3>
                    <p class="text-sm md:text-base text-slate-500 mt-2 max-w-md mx-auto leading-relaxed">Jadilah yang pertama memberikan ulasan yang berharga setelah Anda menikmati hidangan dari kami!</p>
                </div>
            @else
                {{-- Masonry Grid Layout via CSS Columns --}}
                <div class="columns-1 md:columns-2 lg:columns-3 gap-6 space-y-6">
                    @foreach($reviews as $review)
                        <div class="break-inside-avoid bg-white rounded-3xl p-6 md:p-8 shadow-[0_4px_20px_rgb(0,0,0,0.03)] border border-slate-100 hover:shadow-[0_10px_40px_rgb(0,0,0,0.06)] hover:-translate-y-1 transition-all duration-300 group">
                            
                            {{-- Reviewer Info --}}
                            <div class="flex items-center gap-4 mb-5">
                                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-brand-primary to-brand-dark flex items-center justify-center text-white font-black text-lg shadow-md flex-shrink-0 group-hover:scale-110 transition-transform duration-300">
                                    {{ strtoupper(substr($review->customer_name, 0, 1)) }}
                                </div>
                                <div class="min-w-0 flex-1">
                                    <h4 class="text-base font-bold text-slate-800 line-clamp-1 tracking-tight" title="{{ $review->customer_name }}">{{ $review->customer_name }}</h4>
                                    <p class="text-[11px] font-medium text-slate-400 mt-0.5">{{ $review->approved_at->translatedFormat('d F Y') }}</p>
                                </div>
                                {{-- Stars Badge --}}
                                <div class="bg-slate-50 border border-slate-100 px-2 py-1.5 rounded-xl flex gap-0.5" title="{{ $review->rating }} out of 5">
                                    @for($i = 1; $i <= 5; $i++)
                                        <svg class="w-3.5 h-3.5 {{ $i <= $review->rating ? 'text-brand-primary' : 'text-slate-200' }}" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                    @endfor
                                </div>
                            </div>

                            {{-- Comment Content --}}
                            <div class="relative">
                                <svg class="absolute -top-3 -left-3 w-8 h-8 text-slate-100 -z-10 rotate-180" fill="currentColor" viewBox="0 0 24 24"><path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z" /></svg>
                                @if($review->comment)
                                    <p class="text-[13px] md:text-sm text-slate-600 leading-relaxed italic z-10 relative">"{{ $review->comment }}"</p>
                                @else
                                    <p class="text-[13px] md:text-sm text-slate-400 italic z-10 relative">Pesanan ini diberikan rating tanpa ulasan tertulis.</p>
                                @endif
                            </div>

                            {{-- Interstitial Divider --}}
                            <div class="my-5 w-full h-[1px] bg-gradient-to-r from-transparent via-slate-100 to-transparent"></div>

                            {{-- Product Info Snippet --}}
                            <div class="flex items-center gap-3 bg-slate-50/50 p-2.5 rounded-2xl border border-slate-50 hover:bg-slate-50 transition-colors">
                                @if($review->product)
                                    @if($review->product->image)
                                        <img src="{{ asset('storage/' . $review->product->image) }}" loading="lazy" width="40" height="40" class="w-10 h-10 rounded-[10px] object-cover bg-white shadow-sm border border-slate-100" alt="{{ $review->product->name }}">
                                    @else
                                        <div class="w-10 h-10 rounded-[10px] bg-white border border-slate-100 shadow-sm flex items-center justify-center">
                                            <svg class="w-5 h-5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        </div>
                                    @endif
                                    <div class="min-w-0 flex-1">
                                        <p class="text-[9px] text-slate-400 uppercase tracking-widest font-black mb-0.5">Produk Diulas</p>
                                        <p class="text-[13px] font-bold text-slate-800 truncate" title="{{ $review->product->name }}">{{ $review->product->name }}</p>
                                    </div>
                                @else
                                    <div class="w-10 h-10 rounded-[10px] bg-slate-100 border border-slate-200 flex items-center justify-center text-slate-400">
                                        ?
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <p class="text-[13px] font-bold text-slate-800 italic">Produk terhapus</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Custom Tailwind Pagination Container --}}
                <div class="mt-12 flex justify-center pb-8 border-t border-slate-100 pt-8">
                    {{ $reviews->links('pagination::tailwind') }}
                </div>
            @endif

        </div>
    </div>
</x-layouts.app>
