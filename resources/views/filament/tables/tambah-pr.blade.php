<form wire:submit.prevent="submit">
    @csrf
    <div class="space-y-4 text-black">
        <input type="hidden" name="pr_id" value="{{ $pr->id }}">

        <div>
            <label class="block text-sm font-medium text-black">Nomor PR</label>
            <input type="text" class="w-full p-2 border rounded-md bg-gray-100 text-black placeholder-black" value="{{ $pr->no_pr }}" disabled>
        </div>

        <div>
            <label class="block text-sm font-medium text-black">Nama Barang</label>
            <select name="kode_barang" class="w-full p-2 border rounded-md text-black placeholder-black bg-white" wire:model="kode_barang">
                <option value="" class="text-black">Pilih Kode Barang</option>
                @foreach (\App\Models\Barang::all() as $barang)
                    <option value="{{ $barang->kode_barang }}" class="text-black">{{ $barang->kode_barang }} - {{ $barang->nama_barang }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-black">Jumlah Diajukan</label>
            <input type="number" name="jumlah_diajukan" class="w-full p-2 border rounded-md text-black placeholder-black bg-white" required>
        </div>
    </div>

    <div class="mt-4 flex justify-end space-x-2">
        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Simpan</button>
        <button type="button" class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700">Cancel</button>
    </div>
</form>

<script>
    document.querySelector('[name="kode_barang"]').addEventListener('change', function() {
        fetch('/get-barang/' + this.value)
            .then(response => response.json())
            .then(data => {
                document.querySelector('[wire\\:model="nama_barang"]').value = data.nama_barang;
            });
    });
</script>
