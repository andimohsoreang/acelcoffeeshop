<x-layouts.admin>
    <x-slot:title>Pengaturan QRIS</x-slot:title>
    <x-slot:subtitle>Kelola kode QRIS untuk pembayaran pelanggan</x-slot:subtitle>

    <style>
        .qris-layout { display:grid; grid-template-columns:1fr; gap:20px; }
        @media(min-width:1024px){ .qris-layout { grid-template-columns:360px 1fr; } }
        .qris-card { background:#fff; border-radius:14px; border:1px solid #e8edf2; box-shadow:0 1px 3px rgba(0,0,0,0.05); overflow:hidden; }
        .qris-input { display:block;width:100%;padding:8px 11px;border-radius:8px;border:1.5px solid #e2e8f0;font-size:13px;color:#1e293b;outline:none;box-sizing:border-box;font-family:inherit;background:#fff;transition:border-color .15s; }
        .qris-input:focus { border-color:#3b82f6; }
        .qris-label { display:block;font-size:10px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:.06em;margin-bottom:5px; }
        .qris-btn-primary { display:flex;align-items:center;justify-content:center;gap:7px;width:100%;padding:10px;border-radius:9px;background:linear-gradient(135deg,#3b82f6,#2563eb);color:#fff;font-size:13px;font-weight:600;border:none;cursor:pointer;box-shadow:0 2px 8px rgba(59,130,246,.25);transition:opacity .15s; }
        .qris-btn-primary:hover { opacity:.9; }
    </style>

    <div x-data="{
        deleteModal:false, deleteName:'', deleteAction:'',
        openDeleteQris(n,a){ this.deleteName=n; this.deleteAction=a; this.deleteModal=true; },
        editModal:false, editName:'', editAction:'',
        openEditQris(n,a){ this.editName=n; this.editAction=a; this.editModal=true; },
        previewModal:false, previewSrc:''
    }">
        <div class="qris-layout">

            {{-- ============ KOLOM KIRI ============ --}}
            <div style="display:flex;flex-direction:column;gap:16px;">

                {{-- Kartu Status QRIS Aktif --}}
                <div class="qris-card">
                    {{-- Banner tipis dekoratif --}}
                    <div style="height:8px;background:linear-gradient(90deg,#6366f1,#3b82f6,#06b6d4);"></div>

                    <div style="padding:20px;display:flex;align-items:center;gap:16px;">
                        {{-- QR Thumbnail + tombol preview --}}
                        <div style="position:relative;flex-shrink:0;">
                            <div style="width:80px;height:80px;background:#f8fafc;border-radius:12px;border:1px solid #e2e8f0;display:flex;align-items:center;justify-content:center;overflow:hidden;">
                                @if($activeQris)
                                    <img src="{{ asset('storage/'.$activeQris->image) }}" alt="QRIS" style="width:72px;height:72px;object-fit:contain;">
                                @else
                                    <svg style="width:28px;height:28px;color:#d1d5db;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/></svg>
                                @endif
                            </div>
                            @if($activeQris)
                            <button type="button"
                                @click="previewSrc='{{ asset('storage/'.$activeQris->image) }}'; previewModal=true"
                                style="position:absolute;bottom:-6px;right:-6px;width:22px;height:22px;border-radius:50%;background:#3b82f6;border:2px solid #fff;cursor:pointer;display:flex;align-items:center;justify-content:center;box-shadow:0 2px 6px rgba(59,130,246,.4);"
                                title="Lihat fullsize">
                                <svg style="width:10px;height:10px;color:#fff;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/></svg>
                            </button>
                            @endif
                        </div>

                        {{-- Info --}}
                        <div style="flex:1;min-width:0;">
                            <p style="font-size:13px;font-weight:700;color:#1e293b;margin:0 0 2px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ $activeQris->merchant_name ?? 'Belum Ada Merchant' }}</p>
                            <p style="font-size:11px;color:#94a3b8;margin:0 0 8px;">
                                @if($activeQris) Aktif sejak {{ $activeQris->created_at->isoFormat('D MMM Y') }}
                                @else Belum ada QRIS diunggah @endif
                            </p>
                            @if($activeQris)
                            <span style="display:inline-flex;align-items:center;gap:4px;padding:3px 9px;border-radius:99px;background:#ecfdf5;color:#059669;font-size:10px;font-weight:600;border:1px solid #bbf7d0;">
                                <span style="position:relative;width:5px;height:5px;display:inline-flex;">
                                    <span style="animation:ping 1s cubic-bezier(0,0,.2,1) infinite;position:absolute;inset:0;border-radius:50%;background:#34d399;opacity:.75;"></span>
                                    <span style="position:relative;width:5px;height:5px;border-radius:50%;background:#10b981;display:inline-flex;"></span>
                                </span>
                                Live — Aktif
                            </span>
                            @else
                            <span style="display:inline-flex;align-items:center;gap:4px;padding:3px 9px;border-radius:99px;background:#fef2f2;color:#dc2626;font-size:10px;font-weight:600;border:1px solid #fecaca;">
                                <span style="width:5px;height:5px;border-radius:50%;background:#ef4444;display:inline-block;"></span>
                                Belum Aktif
                            </span>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Form Upload --}}
                <div class="qris-card" style="padding:18px;">
                    {{-- Header form --}}
                    <div style="display:flex;align-items:center;gap:10px;margin-bottom:14px;padding-bottom:12px;border-bottom:1px solid #f1f5f9;">
                        <div style="width:30px;height:30px;border-radius:8px;background:#eff6ff;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                            <svg style="width:14px;height:14px;color:#3b82f6;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                        </div>
                        <div>
                            <p style="font-size:13px;font-weight:700;color:#1e293b;margin:0;">Upload QRIS Baru</p>
                            <p style="font-size:11px;color:#94a3b8;margin:0;">Otomatis menggantikan QRIS aktif</p>
                        </div>
                    </div>

                    <form action="{{ route('admin.qris.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        {{-- Upload Drop Area --}}
                        <div x-data="{ url:null }" style="margin-bottom:12px;">
                            <span class="qris-label">Gambar QRIS <span style="color:#ef4444;">*</span></span>
                            <input type="file" name="image" id="qrisFile" accept="image/jpeg,image/png,image/jpg"
                                style="display:none;" :required="!url" x-ref="f"
                                @change="url=$refs.f.files[0]?URL.createObjectURL($refs.f.files[0]):null">

                            {{-- Single container, style changes via Alpine --}}
                            <label for="qrisFile"
                                :style="url
                                    ? 'display:flex;flex-direction:column;align-items:center;justify-content:center;width:100%;border-radius:10px;box-sizing:border-box;cursor:pointer;border:2px dashed #3b82f6;background:#eff6ff;min-height:120px;position:relative;overflow:hidden;'
                                    : 'display:flex;flex-direction:column;align-items:center;justify-content:center;width:100%;border-radius:10px;box-sizing:border-box;cursor:pointer;border:2px dashed #e2e8f0;background:#f8fafc;min-height:100px;'">

                                {{-- Empty state --}}
                                <div x-show="!url" style="display:flex;flex-direction:column;align-items:center;padding:16px 12px;">
                                    <div style="width:32px;height:32px;border-radius:8px;background:#dbeafe;display:flex;align-items:center;justify-content:center;margin-bottom:6px;">
                                        <svg style="width:15px;height:15px;color:#3b82f6;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                                    </div>
                                    <p style="font-size:12px;font-weight:500;color:#475569;margin:0;">Klik untuk pilih gambar</p>
                                    <p style="font-size:10px;color:#94a3b8;margin:2px 0 0;">PNG, JPG • Maks. 2MB</p>
                                </div>

                                {{-- Preview state --}}
                                <div x-show="url" style="width:100%;display:flex;align-items:center;justify-content:center;padding:10px;box-sizing:border-box;min-height:120px;position:relative;">
                                    <img :src="url" style="max-width:100%;max-height:100px;object-fit:contain;border-radius:8px;">
                                    <span style="position:absolute;bottom:6px;left:50%;transform:translateX(-50%);background:#fff;color:#3b82f6;font-size:10px;font-weight:600;padding:2px 9px;border-radius:5px;box-shadow:0 1px 4px rgba(0,0,0,.1);white-space:nowrap;">Klik untuk ganti</span>
                                </div>
                            </label>

                            {{-- Tombol hapus (di luar label agar tidak trigger file dialog) --}}
                            <button x-show="url" type="button" @click.prevent="url=null;$refs.f.value=''"
                                style="display:flex;align-items:center;gap:5px;margin-top:5px;padding:4px 10px;border-radius:6px;background:#fef2f2;border:1px solid #fecaca;color:#ef4444;font-size:11px;font-weight:500;cursor:pointer;">
                                <svg style="width:11px;height:11px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                                Hapus gambar
                            </button>

                            @error('image')<p style="color:#ef4444;font-size:11px;margin-top:4px;">{{ $message }}</p>@enderror
                        </div>

                        {{-- Merchant Name --}}
                        <div style="margin-bottom:14px;">
                            <label class="qris-label" for="merchant_name">Nama Merchant <span style="text-transform:none;font-weight:400;letter-spacing:0;color:#94a3b8;">(opsional)</span></label>
                            <input id="merchant_name" type="text" name="merchant_name" class="qris-input"
                                value="{{ old('merchant_name', $activeQris->merchant_name ?? '') }}"
                                placeholder="cth: Kopi Senja Pusat"
                                onfocus="this.style.borderColor='#3b82f6'" onblur="this.style.borderColor='#e2e8f0'">
                            @error('merchant_name')<p style="color:#ef4444;font-size:11px;margin-top:4px;">{{ $message }}</p>@enderror
                        </div>

                        <button type="submit" class="qris-btn-primary">
                            <svg style="width:13px;height:13px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                            Upload & Aktifkan QRIS
                        </button>
                    </form>
                </div>

            </div>{{-- end kolom kiri --}}

            {{-- ============ KOLOM KANAN ============ --}}
            <div class="qris-card" style="display:flex;flex-direction:column;">

                {{-- Header --}}
                <div style="padding:14px 18px;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;justify-content:space-between;background:#fafafa;">
                    <div>
                        <p style="font-size:13px;font-weight:700;color:#1e293b;margin:0;">Riwayat QRIS</p>
                        <p style="font-size:11px;color:#94a3b8;margin:2px 0 0;">Semua versi QRIS yang pernah diunggah</p>
                    </div>
                    <span style="padding:3px 10px;background:#f1f5f9;color:#64748b;border-radius:99px;font-size:11px;font-weight:600;">{{ $qrisHistory->total() }} data</span>
                </div>

                {{-- Table --}}
                <div style="flex:1;overflow-x:auto;">
                    <table style="width:100%;min-width:460px;border-collapse:collapse;">
                        <thead>
                            <tr style="border-bottom:1px solid #f1f5f9;">
                                <th style="padding:9px 16px;text-align:left;font-size:10px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.06em;width:56px;">QR</th>
                                <th style="padding:9px 12px;text-align:left;font-size:10px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.06em;">Merchant & Info</th>
                                <th style="padding:9px 12px;text-align:center;font-size:10px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.06em;">Status</th>
                                <th style="padding:9px 16px;text-align:right;font-size:10px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.06em;width:72px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($qrisHistory as $history)
                            <tr style="border-bottom:1px solid #f8fafc;" onmouseover="this.style.background='#fafafa'" onmouseout="this.style.background='transparent'">
                                <td style="padding:12px 16px;">
                                    <div style="position:relative;width:42px;height:42px;">
                                        <div style="width:42px;height:42px;border-radius:9px;border:1px solid #e2e8f0;background:#fff;padding:3px;box-sizing:border-box;overflow:hidden;box-shadow:0 1px 3px rgba(0,0,0,.05);">
                                            <img src="{{ asset('storage/'.$history->image) }}" style="width:100%;height:100%;object-fit:contain;border-radius:6px;">
                                        </div>
                                        <button type="button"
                                            @click="previewSrc='{{ asset('storage/'.$history->image) }}'; previewModal=true"
                                            style="position:absolute;bottom:-5px;right:-5px;width:18px;height:18px;border-radius:50%;background:#6366f1;border:2px solid #fff;cursor:pointer;display:flex;align-items:center;justify-content:center;box-shadow:0 1px 4px rgba(99,102,241,.4);"
                                            title="Preview">
                                            <svg style="width:8px;height:8px;color:#fff;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        </button>
                                    </div>
                                </td>
                                <td style="padding:12px;">
                                    <p style="font-size:13px;font-weight:600;color:#1e293b;margin:0;">{{ $history->merchant_name ?? 'Tanpa Nama' }}</p>
                                    <p style="font-size:11px;color:#94a3b8;margin:3px 0 0;">
                                        Oleh <span style="color:#475569;font-weight:500;">{{ $history->uploadedBy->name ?? 'Admin' }}</span>
                                        · {{ $history->created_at->isoFormat('D MMM Y, HH:mm') }}
                                    </p>
                                    <p style="font-size:10px;color:#cbd5e1;margin:2px 0 0;">{{ $history->created_at->diffForHumans() }}</p>
                                </td>
                                <td style="padding:12px;text-align:center;">
                                    @if($history->is_active)
                                    <span style="display:inline-flex;align-items:center;gap:4px;padding:3px 9px;border-radius:99px;background:#ecfdf5;color:#059669;font-size:11px;font-weight:600;border:1px solid #bbf7d0;">
                                        <span style="width:5px;height:5px;border-radius:50%;background:#10b981;display:inline-block;"></span>Aktif
                                    </span>
                                    @else
                                    <span style="display:inline-flex;align-items:center;padding:3px 9px;border-radius:99px;background:#f8fafc;color:#94a3b8;font-size:11px;font-weight:500;border:1px solid #e2e8f0;">Arsip</span>
                                    @endif
                                </td>
                                <td style="padding:12px 16px;">
                                    <div style="display:flex;align-items:center;justify-content:flex-end;gap:3px;">
                                        <button type="button"
                                            x-on:click="openEditQris('{{ addslashes($history->merchant_name ?? '') }}','{{ route('admin.qris.update',$history) }}')"
                                            style="width:28px;height:28px;border-radius:7px;border:none;background:transparent;cursor:pointer;display:flex;align-items:center;justify-content:center;color:#94a3b8;transition:all .15s;"
                                            onmouseover="this.style.background='#eff6ff';this.style.color='#3b82f6'"
                                            onmouseout="this.style.background='transparent';this.style.color='#94a3b8'"
                                            title="Edit">
                                            <svg style="width:13px;height:13px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                        </button>
                                        @if(!$history->is_active)
                                        <button type="button"
                                            x-on:click="openDeleteQris('{{ addslashes($history->merchant_name ?? 'Tanpa Nama') }}','{{ route('admin.qris.destroy',$history) }}')"
                                            style="width:28px;height:28px;border-radius:7px;border:none;background:transparent;cursor:pointer;display:flex;align-items:center;justify-content:center;color:#94a3b8;transition:all .15s;"
                                            onmouseover="this.style.background='#fef2f2';this.style.color='#ef4444'"
                                            onmouseout="this.style.background='transparent';this.style.color='#94a3b8'"
                                            title="Hapus">
                                            <svg style="width:13px;height:13px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" style="padding:44px 20px;text-align:center;">
                                    <svg style="width:32px;height:32px;color:#e2e8f0;margin:0 auto 8px;display:block;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/></svg>
                                    <p style="font-size:12px;color:#94a3b8;margin:0;">Belum ada QRIS yang diunggah</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if($qrisHistory->hasPages())
                <div style="padding:10px 16px;border-top:1px solid #f1f5f9;background:#fafafa;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:8px;">
                    <p style="font-size:11px;color:#94a3b8;margin:0;">Hal. {{ $qrisHistory->currentPage() }} dari {{ $qrisHistory->lastPage() }}</p>
                    <div style="display:flex;align-items:center;gap:3px;">
                        @if($qrisHistory->onFirstPage())
                            <span style="width:28px;height:28px;border-radius:6px;border:1px solid #e2e8f0;color:#cbd5e1;display:inline-flex;align-items:center;justify-content:center;font-size:13px;">‹</span>
                        @else
                            <a href="{{ $qrisHistory->previousPageUrl() }}" style="width:28px;height:28px;border-radius:6px;border:1px solid #e2e8f0;color:#475569;display:inline-flex;align-items:center;justify-content:center;font-size:13px;text-decoration:none;">‹</a>
                        @endif
                        @foreach($qrisHistory->getUrlRange(max(1,$qrisHistory->currentPage()-1),min($qrisHistory->lastPage(),$qrisHistory->currentPage()+1)) as $page => $url)
                            @if($page==$qrisHistory->currentPage())
                                <span style="width:28px;height:28px;border-radius:6px;background:#3b82f6;color:#fff;display:inline-flex;align-items:center;justify-content:center;font-size:12px;font-weight:600;">{{ $page }}</span>
                            @else
                                <a href="{{ $url }}" style="width:28px;height:28px;border-radius:6px;border:1px solid #e2e8f0;color:#475569;display:inline-flex;align-items:center;justify-content:center;font-size:12px;text-decoration:none;">{{ $page }}</a>
                            @endif
                        @endforeach
                        @if($qrisHistory->hasMorePages())
                            <a href="{{ $qrisHistory->nextPageUrl() }}" style="width:28px;height:28px;border-radius:6px;border:1px solid #e2e8f0;color:#475569;display:inline-flex;align-items:center;justify-content:center;font-size:13px;text-decoration:none;">›</a>
                        @else
                            <span style="width:28px;height:28px;border-radius:6px;border:1px solid #e2e8f0;color:#cbd5e1;display:inline-flex;align-items:center;justify-content:center;font-size:13px;">›</span>
                        @endif
                    </div>
                </div>
                @endif

            </div>{{-- end kolom kanan --}}
        </div>

        {{-- ===== MODAL HAPUS ===== --}}
        <div x-show="deleteModal" x-cloak
            x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            @click="deleteModal=false"
            style="position:fixed;top:0;left:0;right:0;bottom:0;z-index:9990;background:rgba(15,23,42,.55);backdrop-filter:blur(4px);">
            <div @click.stop x-show="deleteModal"
                x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);background:#fff;border-radius:16px;box-shadow:0 20px 60px rgba(0,0,0,.25);width:calc(100% - 40px);max-width:360px;">
                <div style="padding:28px 22px 18px;text-align:center;">
                    <div style="width:46px;height:46px;border-radius:50%;background:#fef2f2;display:flex;align-items:center;justify-content:center;margin:0 auto 12px;">
                        <svg style="width:20px;height:20px;color:#ef4444;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    </div>
                    <p style="font-size:14px;font-weight:700;color:#1e293b;margin:0 0 6px;">Hapus Riwayat QRIS?</p>
                    <p style="font-size:12px;color:#64748b;margin:0;line-height:1.6;"><strong x-text="deleteName" style="color:#1e293b;"></strong> akan dihapus permanen.</p>
                </div>
                <div style="padding:12px 22px;border-top:1px solid #f1f5f9;display:flex;gap:8px;background:#fafafa;border-radius:0 0 16px 16px;">
                    <button type="button" @click="deleteModal=false" style="flex:1;padding:8px;border-radius:8px;font-size:12px;font-weight:500;color:#475569;background:#fff;border:1px solid #e2e8f0;cursor:pointer;">Batal</button>
                    <form :action="deleteAction" method="POST" style="flex:1;">
                        @csrf @method('DELETE')
                        <button type="submit" style="width:100%;padding:8px;border-radius:8px;font-size:12px;font-weight:600;color:#fff;background:#ef4444;border:none;cursor:pointer;">Ya, Hapus</button>
                    </form>
                </div>
            </div>
        </div>

        {{-- ===== MODAL EDIT ===== --}}
        <div x-show="editModal" x-cloak
            x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            @click="editModal=false"
            style="position:fixed;top:0;left:0;right:0;bottom:0;z-index:9990;background:rgba(15,23,42,.55);backdrop-filter:blur(4px);">
            <div @click.stop x-show="editModal"
                x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);background:#fff;border-radius:16px;box-shadow:0 20px 60px rgba(0,0,0,.25);width:calc(100% - 40px);max-width:380px;">
                <form :action="editAction" method="POST">
                    @csrf @method('PATCH')
                    <div style="padding:18px 22px;">
                        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px;">
                            <div>
                                <p style="font-size:14px;font-weight:700;color:#1e293b;margin:0;">Edit QRIS</p>
                                <p style="font-size:11px;color:#94a3b8;margin:2px 0 0;">Ubah nama merchant</p>
                            </div>
                            <button type="button" @click="editModal=false" style="width:26px;height:26px;border-radius:7px;background:#f1f5f9;border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;color:#64748b;font-size:13px;">✕</button>
                        </div>
                        <label class="qris-label">Nama Merchant</label>
                        <input type="text" name="merchant_name" x-model="editName" class="qris-input"
                            placeholder="cth: Kopi Senja Pusat"
                            onfocus="this.style.borderColor='#3b82f6'" onblur="this.style.borderColor='#e2e8f0'">
                    </div>
                    <div style="padding:12px 22px;border-top:1px solid #f1f5f9;display:flex;justify-content:flex-end;gap:8px;background:#fafafa;border-radius:0 0 16px 16px;">
                        <button type="button" @click="editModal=false" style="padding:7px 16px;border-radius:8px;font-size:12px;font-weight:500;color:#475569;background:#fff;border:1px solid #e2e8f0;cursor:pointer;">Batal</button>
                        <button type="submit" style="padding:7px 16px;border-radius:8px;font-size:12px;font-weight:600;color:#fff;background:#3b82f6;border:none;cursor:pointer;">Simpan</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- ===== MODAL PREVIEW QRIS ===== --}}
        <div x-show="previewModal" x-cloak
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            @click="previewModal=false"
            style="position:fixed;top:0;left:0;right:0;bottom:0;z-index:99999;background:rgba(0,0,0,.82);backdrop-filter:blur(8px);">

            {{-- Centered wrapper --}}
            <div style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);width:100%;max-width:420px;padding:20px;box-sizing:border-box;"
                @click.stop
                x-show="previewModal"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-90"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95">

                {{-- Close --}}
                <button type="button" @click="previewModal=false"
                    style="position:absolute;top:4px;right:4px;width:30px;height:30px;border-radius:50%;background:#fff;border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;color:#374151;font-size:13px;font-weight:700;box-shadow:0 2px 8px rgba(0,0,0,.3);z-index:1;">✕</button>

                {{-- Image --}}
                <div style="background:#fff;border-radius:14px;padding:12px;box-shadow:0 24px 80px rgba(0,0,0,.5);">
                    <img :src="previewSrc" alt="QRIS Preview"
                        style="width:100%;height:auto;max-height:80vh;object-fit:contain;border-radius:8px;display:block;">
                </div>
                <p style="text-align:center;color:rgba(255,255,255,.4);font-size:11px;margin:10px 0 0;">Klik di luar untuk menutup</p>
            </div>
        </div>

    </div>
</x-layouts.admin>