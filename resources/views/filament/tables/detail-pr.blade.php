<x-filament::page>
    <div class="p-4">
        <table class="w-full border-collapse border border-gray-300">
            <thead class="bg-gray-100 text-black">
                <tr>
                    <th class="border border-gray-300 px-4 py-2">Kode Barang</th>
                    <th class="border border-gray-300 px-4 py-2">Nama Barang</th>
                    <th class="border border-gray-300 px-4 py-2">Merk</th>
                    <th class="border border-gray-300 px-4 py-2">Ukuran</th>
                    <th class="border border-gray-300 px-4 py-2">Part Number</th>
                    <th class="border border-gray-300 px-4 py-2">Jumlah Diajukan</th>
                    <th class="border border-gray-300 px-4 py-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($records as $record)
                    <tr class="text-black">
                        <td class="border border-gray-300 px-4 py-2">{{ $record->kode_barang }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $record->barang->nama_barang }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $record->barang->merk }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $record->barang->ukuran }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $record->barang->part_number }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $record->jumlah_diajukan }}</td>
                        <td class="border border-gray-300 px-4 py-2 space-x-2">
                            <button
                                onclick="openModal('modal-{{ $record->id }}')"
                                class="bg-green-500 text-white px-3 py-1 rounded shadow-md hover:bg-green-600 transition"
                            >
                                Terima
                            </button>
                            <button
                                onclick="openModal('detail-modal-{{ $record->id }}')"
                                class="bg-blue-500 text-white px-3 py-1 rounded shadow-md hover:bg-blue-600 transition"
                            >
                                Detail
                            </button>
                        </td>
                    </tr>

                    <!-- Modal Terima -->
                    <div id="modal-{{ $record->id }}" class="hidden fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50">
                        <div class="bg-white p-6 rounded-lg shadow-lg w-1/3">
                            <h2 class="text-lg font-bold mb-3">Terima Barang</h2>
                            <form method="POST" action="{{ route('terima-barang', $record->id) }}">
                                @csrf
                                <div class="space-y-2">
                                    <label class="block">Jumlah Diterima</label>
                                    <input type="number" name="jumlah_diterima" class="w-full p-2 border rounded" required>

                                    <label class="block">Keterangan Vendor</label>
                                    <textarea name="keterangan_vendor" class="w-full p-2 border rounded" required></textarea>

                                    <label class="block">Keterangan Barang</label>
                                    <textarea name="keterangan_barang" class="w-full p-2 border rounded" required></textarea>
                                </div>

                                <div class="mt-4 flex justify-end space-x-2">
                                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded shadow-md hover:bg-green-600 transition">Simpan</button>
                                    <button type="button" onclick="closeModal('modal-{{ $record->id }}')" class="px-4 py-2 bg-gray-500 text-white rounded shadow-md hover:bg-gray-600 transition">Batal</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Modal Detail -->
                    <div id="detail-modal-{{ $record->id }}" class="hidden fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50">
                        <div class="bg-white p-6 rounded-lg shadow-lg w-1/2">
                            <h2 class="text-lg font-bold mb-3">Detail Barang</h2>
                            <div class="space-y-4">
                                <table class="w-full border-collapse border border-gray-300 text-black">
                                    <thead>
                                        <tr class="bg-gray-200 text-black">
                                            <th class="border border-gray-300 px-4 py-2">Kode Barang</th>
                                            <th class="border border-gray-300 px-4 py-2">Nama Barang</th>
                                            <th class="border border-gray-300 px-4 py-2">Merk</th>
                                            <th class="border border-gray-300 px-4 py-2">Ukuran</th>
                                            <th class="border border-gray-300 px-4 py-2">Part Number</th>
                                            <th class="border border-gray-300 px-4 py-2">Jumlah</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="text-black">
                                            <td class="border border-gray-300 px-4 py-2">{{ $record->kode_barang }}</td>
                                            <td class="border border-gray-300 px-4 py-2">{{ $record->barang->nama_barang }}</td>
                                            <td class="border border-gray-300 px-4 py-2">{{ $record->barang->merk }}</td>
                                            <td class="border border-gray-300 px-4 py-2">{{ $record->barang->ukuran }}</td>
                                            <td class="border border-gray-300 px-4 py-2">{{ $record->barang->part_number }}</td>
                                            <td class="border border-gray-300 px-4 py-2">{{ $record->jumlah_diajukan }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="mt-4 flex justify-end">
                                <button type="button" onclick="closeModal('detail-modal-{{ $record->id }}')" class="px-4 py-2 bg-gray-500 text-white rounded shadow-md hover:bg-gray-600 transition">Tutup</button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </tbody>
        </table>
    </div>

    <script>
        function openModal(id) {
            document.getElementById(id).classList.remove('hidden');
        }

        function closeModal(id) {
            document.getElementById(id).classList.add('hidden');
        }
    </script>
</x-filament::page>
