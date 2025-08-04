<h1>Detail Aset</h1>

<p><strong>Nama:</strong> {{ $asset->name }}</p>
<p><strong>Kategori:</strong> {{ $asset->kategori }}</p>
<p><strong>Serial Number:</strong> {{ $asset->serial_number }}</p>

@if ($asset->image)
    <p><strong>Gambar:</strong><br>
        <img src="{{ asset('storage/' . $asset->image) }}" width="200">
    </p>
@endif
