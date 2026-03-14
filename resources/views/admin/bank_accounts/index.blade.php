<x-layouts.admin>
    <x-slot:title>Rekening Bank</x-slot:title>
    <x-slot:subtitle>Kelola rekening bank untuk pembayaran transfer pelanggan</x-slot:subtitle>

    <div x-data="{
        editModal: false,
        deleteModal: false,
        editId: null,
        editData: { bank_name: '', account_number: '', account_name: '', is_active: true },
        deleteName: '',
        deleteAction: '',
        openEdit(b) {
            this.editId = b.id;
            this.editData = {
                bank_name: b.bank_name,
                account_number: b.account_number,
                account_name: b.account_name,
                is_active: b.is_active || b.is_active == 1
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
            <div class="flex flex-wrap items-center gap-2">
                {{-- Reserved for future filters if needed --}}
            </div>

            <button @click="$dispatch('open-create-bank-modal')" class="btn-primary flex-shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Rekening
            </button>
        </div>

        {{-- Table --}}
        <div class="admin-card p-0 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th class="pl-6">Bank</th>
                            <th>No. Rekening</th>
                            <th>Atas Nama</th>
                            <th class="text-center">Status</th>
                            <th class="pr-6 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($bankAccounts as $bank)
                        <tr>
                            <td class="pl-6">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg flex items-center justify-center text-white font-bold text-xs" style="background: linear-gradient(135deg, #3ecf8e, #2bb578);">
                                        {{ substr(strtoupper($bank->bank_name), 0, 1) }}
                                    </div>
                                    <p class="font-medium text-gray-800">{{ strtoupper($bank->bank_name) }}</p>
                                </div>
                            </td>
                            <td>
                                <p class="font-mono text-sm text-gray-600">{{ $bank->account_number }}</p>
                            </td>
                            <td class="text-gray-500">
                                {{ ucwords(strtolower($bank->account_name)) }}
                            </td>
                            <td class="text-center">
                                @if($bank->is_active)
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-700 text-xs font-medium">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Aktif
                                </span>
                                @else
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-gray-100 text-gray-500 text-xs font-medium">
                                    <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span> Nonaktif
                                </span>
                                @endif
                            </td>
                            <td class="pr-6">
                                <div class="flex items-center justify-end gap-1">
                                    <button
                                        @click="openEdit(@js($bank->only(['id','bank_name','account_number','account_name','is_active'])))"
                                        class="p-1.5 rounded-lg text-gray-400 hover:text-blue-600 hover:bg-blue-50 transition-colors"
                                        title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </button>
                                    <button
                                        @click="openDelete('{{ $bank->bank_name }} - {{ $bank->account_number }}', '{{ route('admin.bank-accounts.destroy', $bank) }}')"
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
                            <td colspan="5" class="text-center py-12 text-gray-400">
                                <svg class="w-10 h-10 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                </svg>
                                <p>Belum ada rekening bank</p>
                                <button @click="$dispatch('open-create-bank-modal')" class="text-blue-600 text-sm hover:underline mt-1 inline-block">
                                    + Tambah Rekening
                                </button>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($bankAccounts->count() > 0)
            <div style="padding:12px 16px; border-top:1px solid #e2e8f0; background:#f8fafc;">
                <p style="font-size:12px; color:#64748b; margin:0;">
                    Menampilkan total {{ $bankAccounts->count() }} rekening terdaftar.
                </p>
            </div>
            @endif
        </div>

        {{-- CREATE MODAL (Using Global Alpine Listener) --}}
        <div x-data="{ open: false }" 
             x-show="open" 
             @open-create-bank-modal.window="open = true" 
             @keydown.escape.window="open = false" 
             class="relative z-50" x-cloak>
            
            <div x-show="open" x-transition.opacity class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm transition-opacity"></div>

            <div class="fixed inset-0 z-10 overflow-y-auto">
                <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
                    <div x-show="open" 
                         @click.away="open = false"
                         x-transition:enter="ease-out duration-300" 
                         x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                         x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" 
                         x-transition:leave="ease-in duration-200" 
                         x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" 
                         x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                         class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                        
                        <div style="padding:20px 24px; border-bottom:1px solid #e2e8f0; display:flex; align-items:center; justify-content:space-between;">
                            <div>
                                <h3 style="font-size:16px; font-weight:600; color:#1e293b; margin:0;">Tambah Rekening Baru</h3>
                                <p style="font-size:12px; color:#94a3b8; margin:4px 0 0;">Tambahkan opsi transfer bank untuk pelanggan</p>
                            </div>
                            <button @click="open = false" style="width:32px; height:32px; display:flex; align-items:center; justify-content:center; border:none; background:#f1f5f9; cursor:pointer; color:#64748b; border-radius:8px; transition:all 0.2s;" onmouseover="this.style.background='#e2e8f0'; this.style.color='#0f172a'" onmouseout="this.style.background='#f1f5f9'; this.style.color='#64748b'">✕</button>
                        </div>
                        
                        <form action="{{ route('admin.bank-accounts.store') }}" method="POST">
                            @csrf
                            <div style="padding:24px;">
                                <div style="margin-bottom:20px;">
                                    <label style="display:block; font-size:13px; font-weight:500; color:#334155; margin-bottom:6px;">Nama Bank <span style="color:#ef4444;">*</span></label>
                                    <input type="text" name="bank_name" required placeholder="Contoh: BCA, Mandiri, BNI"
                                        style="display:block; width:100%; padding:10px 14px; border:1px solid #e2e8f0; border-radius:8px; font-size:14px; color:#1e293b; background:#fff; outline:none; box-sizing:border-box; font-family:inherit; transition:all 0.2s;"
                                        onfocus="this.style.borderColor='#3ecf8e';this.style.boxShadow='0 0 0 3px rgba(62,207,142,0.12)'"
                                        onblur="this.style.borderColor='#e2e8f0';this.style.boxShadow='none'">
                                </div>
                                <div style="margin-bottom:20px;">
                                    <label style="display:block; font-size:13px; font-weight:500; color:#334155; margin-bottom:6px;">Nomor Rekening <span style="color:#ef4444;">*</span></label>
                                    <input type="text" name="account_number" required placeholder="Contoh: 1234567890" inputmode="numeric"
                                        style="display:block; width:100%; padding:10px 14px; border:1px solid #e2e8f0; border-radius:8px; font-family:'DM Mono', monospace; font-size:14px; color:#1e293b; background:#fff; outline:none; box-sizing:border-box; transition:all 0.2s;"
                                        onfocus="this.style.borderColor='#3ecf8e';this.style.boxShadow='0 0 0 3px rgba(62,207,142,0.12)'"
                                        onblur="this.style.borderColor='#e2e8f0';this.style.boxShadow='none'">
                                </div>
                                <div style="margin-bottom:20px;">
                                    <label style="display:block; font-size:13px; font-weight:500; color:#334155; margin-bottom:6px;">Atas Nama Pemilik <span style="color:#ef4444;">*</span></label>
                                    <input type="text" name="account_name" required placeholder="Sesuai buku tabungan"
                                        style="display:block; width:100%; padding:10px 14px; border:1px solid #e2e8f0; border-radius:8px; font-size:14px; color:#1e293b; background:#fff; outline:none; box-sizing:border-box; font-family:inherit; transition:all 0.2s;"
                                        onfocus="this.style.borderColor='#3ecf8e';this.style.boxShadow='0 0 0 3px rgba(62,207,142,0.12)'"
                                        onblur="this.style.borderColor='#e2e8f0';this.style.boxShadow='none'">
                                </div>
                                <div x-data="{ checkActive: true }" style="display:flex; align-items:center; justify-content:space-between; padding:14px 16px; background:#f8fafc; border-radius:10px; border:1px solid #e2e8f0;">
                                    <div>
                                        <p style="font-size:13px; font-weight:500; color:#334155; margin:0;">Status Aktif</p>
                                        <p style="font-size:12px; color:#94a3b8; margin:2px 0 0;" x-text="checkActive ? 'Ditampilkan ke pelanggan' : 'Disembunyikan sementara'"></p>
                                    </div>
                                    <label style="position:relative; display:inline-block; width:44px; height:24px; cursor:pointer; flex-shrink:0;">
                                        <input type="checkbox" name="is_active" value="1" x-model="checkActive" style="position:absolute; opacity:0; width:0; height:0;">
                                        <span :style="checkActive ? 'position:absolute;inset:0;background:#3ecf8e;border-radius:99px;transition:background 0.2s' : 'position:absolute;inset:0;background:#cbd5e1;border-radius:99px;transition:background 0.2s'"></span>
                                        <span :style="checkActive ? 'position:absolute;left:22px;top:2px;width:20px;height:20px;background:#fff;border-radius:50%;transition:left 0.2s;box-shadow:0 1px 4px rgba(0,0,0,0.15)' : 'position:absolute;left:2px;top:2px;width:20px;height:20px;background:#fff;border-radius:50%;transition:left 0.2s;box-shadow:0 1px 4px rgba(0,0,0,0.15)'"></span>
                                    </label>
                                </div>
                            </div>
                            <div style="padding:16px 24px; border-top:1px solid #e2e8f0; display:flex; align-items:center; justify-content:flex-end; gap:10px; background:#f8fafc; border-radius:0 0 16px 16px;">
                                <button type="button" @click="open = false" style="padding:9px 18px; border-radius:8px; font-size:13px; font-weight:500; color:#475569; background:#fff; border:1px solid #d1d5db; cursor:pointer; transition:all 0.2s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='#fff'">Batal</button>
                                <button type="submit" style="padding:9px 22px; border-radius:8px; font-size:13px; font-weight:600; color:#fff; background:linear-gradient(135deg,#3ecf8e,#2bb578); border:none; cursor:pointer; transition:all 0.2s;" onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='0 4px 12px rgba(62,207,142,0.3)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">Simpan Rekening</button>
                            </div>
                        </form>
                    </div>
                </div>
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
                            <h3 style="font-size:16px; font-weight:600; color:#1e293b; margin:0;">Edit Rekening Bank</h3>
                            <p style="font-size:12px; color:#94a3b8; margin:4px 0 0;">Perbarui informasi akun bank</p>
                        </div>
                        <button @click="editModal = false"
                            style="width:32px; height:32px; display:flex; align-items:center; justify-content:center; border:none; background:#f1f5f9; cursor:pointer; color:#64748b; border-radius:8px; transition:all 0.2s;" onmouseover="this.style.background='#e2e8f0'; this.style.color='#0f172a'" onmouseout="this.style.background='#f1f5f9'; this.style.color='#64748b'">✕</button>
                    </div>
                    <form :action="'/admin/bank-accounts/' + editId" method="POST">
                        @csrf
                        @method('PUT')
                        <div style="padding:24px;">
                            <div style="margin-bottom:20px;">
                                <label style="display:block; font-size:13px; font-weight:500; color:#334155; margin-bottom:6px;">Nama Bank <span style="color:#ef4444;">*</span></label>
                                <input type="text" name="bank_name" x-model="editData.bank_name" required
                                    style="display:block; width:100%; padding:10px 14px; border:1px solid #e2e8f0; border-radius:8px; font-size:14px; color:#1e293b; background:#fff; outline:none; box-sizing:border-box; font-family:inherit; transition:all 0.2s;"
                                    onfocus="this.style.borderColor='#3ecf8e';this.style.boxShadow='0 0 0 3px rgba(62,207,142,0.12)'"
                                    onblur="this.style.borderColor='#e2e8f0';this.style.boxShadow='none'">
                            </div>
                            <div style="margin-bottom:20px;">
                                <label style="display:block; font-size:13px; font-weight:500; color:#334155; margin-bottom:6px;">Nomor Rekening <span style="color:#ef4444;">*</span></label>
                                <input type="text" name="account_number" x-model="editData.account_number" required inputmode="numeric"
                                    style="display:block; width:100%; padding:10px 14px; border:1px solid #e2e8f0; border-radius:8px; font-family:'DM Mono', monospace; font-size:14px; color:#1e293b; background:#fff; outline:none; box-sizing:border-box; transition:all 0.2s;"
                                    onfocus="this.style.borderColor='#3ecf8e';this.style.boxShadow='0 0 0 3px rgba(62,207,142,0.12)'"
                                    onblur="this.style.borderColor='#e2e8f0';this.style.boxShadow='none'">
                            </div>
                            <div style="margin-bottom:20px;">
                                <label style="display:block; font-size:13px; font-weight:500; color:#334155; margin-bottom:6px;">Atas Nama Pemilik <span style="color:#ef4444;">*</span></label>
                                <input type="text" name="account_name" x-model="editData.account_name" required
                                    style="display:block; width:100%; padding:10px 14px; border:1px solid #e2e8f0; border-radius:8px; font-size:14px; color:#1e293b; background:#fff; outline:none; box-sizing:border-box; font-family:inherit; transition:all 0.2s;"
                                    onfocus="this.style.borderColor='#3ecf8e';this.style.boxShadow='0 0 0 3px rgba(62,207,142,0.12)'"
                                    onblur="this.style.borderColor='#e2e8f0';this.style.boxShadow='none'">
                            </div>
                            <div
                                style="display:flex; align-items:center; justify-content:space-between; padding:14px 16px; background:#f8fafc; border-radius:10px; border:1px solid #e2e8f0;">
                                <div>
                                    <p style="font-size:13px; font-weight:500; color:#334155; margin:0;">Status</p>
                                    <p style="font-size:12px; color:#94a3b8; margin:2px 0 0;"
                                        x-text="editData.is_active ? 'Ditampilkan ke pelanggan' : 'Disembunyikan sementara'"></p>
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
                                style="padding:9px 18px; border-radius:8px; font-size:13px; font-weight:500; color:#475569; background:#fff; border:1px solid #d1d5db; cursor:pointer; transition:all 0.2s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='#fff'">Batal</button>
                            <button type="submit"
                                style="padding:9px 22px; border-radius:8px; font-size:13px; font-weight:600; color:#fff; background:linear-gradient(135deg,#3ecf8e,#2bb578); border:none; cursor:pointer; transition:all 0.2s;" onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='0 4px 12px rgba(62,207,142,0.3)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">Simpan
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
                        <h3 style="font-size:17px; font-weight:600; color:#1e293b; margin:0 0 8px;">Hapus Rekening?</h3>
                        <p style="font-size:14px; color:#64748b; margin:0; line-height:1.5;">Rekening <strong
                                x-text="deleteName" style="color:#1e293b;"></strong> akan dihapus permanen.</p>
                    </div>
                    <div
                        style="padding:16px 24px; border-top:1px solid #e2e8f0; display:flex; align-items:center; gap:10px; background:#f8fafc; border-radius:0 0 16px 16px;">
                        <button type="button" @click="deleteModal = false"
                            style="padding:10px 20px; border-radius:8px; font-size:13px; font-weight:500; color:#475569; background:#fff; border:1px solid #d1d5db; cursor:pointer; flex:1; transition:all 0.2s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='#fff'">Batal</button>
                        <form :action="deleteAction" method="POST" style="flex:1;">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                style="width:100%; padding:10px 20px; border-radius:8px; font-size:13px; font-weight:600; color:#fff; background:#ef4444; border:none; cursor:pointer; transition:all 0.2s;" onmouseover="this.style.backgroundColor='#dc2626'" onmouseout="this.style.backgroundColor='#ef4444'">Ya, Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
        </template>

    </div>
</x-layouts.admin>
