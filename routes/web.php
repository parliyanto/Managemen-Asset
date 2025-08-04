<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use App\Models\Asset;

// Halaman utama (bisa dikosongkan atau redirect ke dashboard)
Route::get('/', function () {
    return view('welcome');
});

// Route detail untuk setiap aset (untuk QR code)
Route::get('/assets/{id}', function ($id) {
    $asset = Asset::findOrFail($id);
    return view('asset-detail', compact('asset'));
})->name('assets.show');

// Route untuk mengunduh QR code
Route::get('/download-qr/{asset}', function (Asset $asset) {
    if (!$asset->qr_code_path || !Storage::disk('public')->exists($asset->qr_code_path)) {
        abort(404, 'QR code not found');
    }

    return response()->download(
        storage_path('app/public/' . $asset->qr_code_path),
        'qr-code-' . $asset->id . '.png'
    );
})->name('assets.downloadQr');


Route::get('/test-widget', function () {
    return view('filament.widgets.user-list-widget', [
        'users' => \App\Models\User::latest()->take(5)->get(),
    ]);
});




