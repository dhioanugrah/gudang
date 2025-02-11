<div class="space-y-4">
    <table class="w-full border-collapse border border-gray-300 text-black">
        <thead>
            <tr class="bg-gray-200 text-black">
                <th class="border border-gray-300 px-4 py-2">Kode Barang</th>
                <th class="border border-gray-300 px-4 py-2">Nama Barang</th>
                <th class="border border-gray-300 px-4 py-2">Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($prDetails as $detail)
                <tr class="text-black">
                    <td class="border border-gray-300 px-4 py-2">{{ $detail->kode_barang }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $detail->barang->nama_barang }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $detail->jumlah_diajukan }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
