<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\QrisSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class QrisController extends Controller
{
    public function index()
    {
        $activeQris = QrisSetting::getActive();
        $qrisHistory = QrisSetting::with('uploadedBy')
            ->latest()
            ->paginate(10);

        return view('admin.qris.index', compact('activeQris', 'qrisHistory'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'merchant_name' => 'nullable|string|max:255',
        ]);

        // Nonaktifkan semua QRIS lama
        QrisSetting::where('is_active', true)->update(['is_active' => false]);

        // Upload gambar baru
        $path = $request->file('image')->store('qris', 'public');

        QrisSetting::create([
            'image' => $path,
            'merchant_name' => $request->merchant_name,
            'is_active' => true,
            'uploaded_by' => auth()->id(),
        ]);

        return back()->with('success', 'QRIS baru berhasil diupload dan diaktifkan.');
    }

    public function update(Request $request, QrisSetting $qris)
    {
        $request->validate([
            'merchant_name' => 'nullable|string|max:255',
        ]);

        $qris->update([
            'merchant_name' => $request->merchant_name,
        ]);

        return back()->with('success', 'Informasi QRIS berhasil diperbarui.');
    }

    public function destroy(QrisSetting $qris)
    {
        if ($qris->is_active) {
            return back()->with('error', 'Tidak dapat menghapus QRIS yang sedang aktif.');
        }

        if (Storage::disk('public')->exists($qris->image)) {
            Storage::disk('public')->delete($qris->image);
        }

        $qris->delete();

        return back()->with('success', 'Riwayat QRIS berhasil dihapus.');
    }
}