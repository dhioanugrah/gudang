<x-filament::page>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #ccc;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }

        thead {
            background-color: #f3f3f3;
            color: #444;
            font-size: 14px;
        }

        tbody tr:hover {
            background-color: #f9f9f9;
        }

        .button {
            padding: 8px 16px;
            border: none;
            color: white;
            cursor: pointer;
            transition: 0.2s;
            border-radius: 5px;
        }

        .btn-green {
            background-color: #28a745;
        }

        .btn-green:hover {
            background-color: #218838;
        }

        .btn-blue {
            background-color: #007bff;
        }

        .btn-blue:hover {
            background-color: #0056b3;
        }

        .modal {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            width: 300px;
        }

        .flex {
            display: flex;
            justify-content: space-between;
        }
    </style>

    <div style="padding: 16px;">
        <table>
            <thead>
                <tr>
                    <th>Kode Barang</th>
                    <th>Nama Barang</th>
                    <th>Merk</th>
                    <th>Ukuran</th>
                    <th>Part Number</th>
                    <th>Jumlah Diajukan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($records as $record)
                    <tr>
                        <td>{{ $record->kode_barang }}</td>
                        <td>{{ $record->barang->nama_barang }}</td>
                        <td>{{ $record->barang->merk }}</td>
                        <td>{{ $record->barang->ukuran }}</td>
                        <td>{{ $record->barang->part_number }}</td>
                        <td>{{ $record->jumlah_diajukan }}</td>
                        <td class="flex">
                            <button onclick="openModal('modal-{{ $record->id }}')" class="button btn-green">Terima</button>
                            <button onclick="openModal('detail-modal-{{ $record->id }}')" class="button btn-blue">Detail</button>
                        </td>
                    </tr>

                    <!-- Modal Terima -->
                    <div id="modal-{{ $record->id }}" class="modal">
                        <div class="modal-content">
                            <h2>Terima Barang</h2>
                            <form method="POST" action="{{ route('terima-barang', $record->id) }}">
                                @csrf
                                <label>Jumlah Diterima</label>
                                <input type="number" name="jumlah_diterima" required>

                                <label>Keterangan Vendor</label>
                                <textarea name="keterangan_vendor" required></textarea>

                                <label>Keterangan Barang</label>
                                <textarea name="keterangan_barang" required></textarea>

                                <div class="flex">
                                    <button type="submit" class="button btn-green">Simpan</button>
                                    <button type="button" onclick="closeModal('modal-{{ $record->id }}')" class="button btn-blue">Batal</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Modal Detail -->
                    <div id="detail-modal-{{ $record->id }}" class="modal">
                        <div class="modal-content">
                            <h2>Detail Barang</h2>
                            <p><strong>Keterangan Vendor:</strong> {{ $record->keterangan_vendor }}</p>
                            <p><strong>Jumlah Diterima:</strong> {{ $record->jumlah_diterima }}</p>
                            <p><strong>Keterangan Barang:</strong> {{ $record->keterangan_barang }}</p>
                            <button type="button" onclick="closeModal('detail-modal-{{ $record->id }}')" class="button btn-blue">Tutup</button>
                        </div>
                    </div>
                @endforeach
            </tbody>
        </table>
    </div>

    <script>
        function openModal(id) {
            document.getElementById(id).style.display = 'flex';
        }

        function closeModal(id) {
            document.getElementById(id).style.display = 'none';
        }
    </script>
</x-filament::page>
