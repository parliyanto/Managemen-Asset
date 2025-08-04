<div>
    <h2 class="text-lg font-bold mb-4">Riwayat Mutasi Aset Terbaru</h2>

    <table class="w-full text-sm table-auto">
        <thead>
            <tr class="text-left bg-gray-100">
                <th class="px-2 py-1">Tanggal</th>
                <th class="px-2 py-1">Aset</th>
                <th class="px-2 py-1">Dari</th>
                <th class="px-2 py-1">Ke</th>
                <th class="px-2 py-1">Catatan</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($mutations as $mutation)
                <tr class="border-b">
                    <td class="px-2 py-1">{{ $mutation->created_at->format('d M Y') }}</td>
                    <td class="px-2 py-1">{{ $mutation->asset->name }}</td>
                    <td class="px-2 py-1">{{ $mutation->fromUser->name ?? '-' }}</td>
                    <td class="px-2 py-1">{{ $mutation->toUser->name }}</td>
                    <td class="px-2 py-1">{{ $mutation->notes ?? '-' }}</td>
                </tr>
            @empty
                <tr><td colspan="5" class="px-2 py-2 text-center text-gray-500">Belum ada mutasi</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
