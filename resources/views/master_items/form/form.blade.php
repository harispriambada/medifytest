<form method="POST" enctype="multipart/form-data">
    @csrf
    @if ($method == 'edit')
        <div class="form-group">
            <label>Kode Barang</label>
            <input type="text" class="form-control" name="kode_barang" required readonly value="{{ $item->kode ?? '' }}">
        </div>
    @endif

    <div class="form-group">
        <label>Nama</label>
        <input type="text" class="form-control" name="nama" required value="{{ $item->nama ?? '' }}">
    </div>

    <div class="form-group">
        <label>Harga Beli</label>
        <input type="number" class="form-control" name="harga_beli" required value="{{ $item->harga_beli ?? '' }}">
    </div>

    <div class="">
        <label>Foto</label>
        <input type="file" name="foto" id="foto" accept="image/*" onchange="previewImage(event)">
    </div>

    {{-- ini untuk input field category --}}

    {{-- <div class="form-group">
        <label>Kategori</label><br>

        @foreach ($categories as $cat)
            <label style="display:block;">
                <input type="checkbox" name="category_ids[]" value="{{ $cat->id }}"
                    {{ in_array($cat->id, $selectedCategories ?? []) ? 'checked' : '' }}>
                {{ $cat->kode }} - {{ $cat->nama }}
            </label>
        @endforeach
    </div> --}}

    <div class="form-group">
        <label>Kategori</label>
        <select name="category_id" class="form-control" required>
            <option value="">-- Pilih Kategori --</option>
            @foreach ($categories as $cat)
                <option value="{{ $cat->id }}"
                    {{ isset($selectedCategory) && $selectedCategory == $cat->id ? 'selected' : '' }}>
                    {{ $cat->kode }} - {{ $cat->nama }}
                </option>
            @endforeach
        </select>
    </div>




    <div style="margin-top: 10px;">
        <img id="preview" src="#" style="display:none; width:120px; border-radius:8px;">
    </div>


    <div class="form-group">
        <label>Laba (dalam persen)</label>
        <input type="number" class="form-control" name="laba" required value="{{ $item->laba ?? '' }}">
    </div>

    @php $selected = $item->supplier ?? ''; @endphp
    <div class="form-group">
        <label>Supplier</label>
        <select class="form-control" required name="supplier">
            <option @if ($selected == '') selected @endif value="">--Pilih--</option>
            <option @if ($selected == 'Tokopaedi') selected @endif>Tokopaedi</option>
            <option @if ($selected == 'Bukulapuk') selected @endif>Bukulapuk</option>
            <option @if ($selected == 'TokoBagas') selected @endif>TokoBagas</option>
            <option @if ($selected == 'E Commurz') selected @endif>E Commurz</option>
            <optio @if ($selected == 'Blublu') selected @endif>Blublu</option>
        </select>
    </div>

    @php $selected = $item->jenis ?? ''; @endphp
    <div class="form-group">
        <label>Jenis</label>
        <select class="form-control" required name="jenis">
            <option @if ($selected == '') selected @endif value="">--Pilih--</option>
            <option @if ($selected == 'Obat') selected @endif>Obat</option>
            <option @if ($selected == 'Alkes') selected @endif>Alkes</option>
            <option @if ($selected == 'Matkes') selected @endif>Matkes</option>
            <optio @if ($selected == 'Umum') selected @endif>Umum</option>
                <optio @if ($selected == 'ATK') selected @endif>ATK</option>
        </select>
    </div>

    <button class="btn btn-primary mt-3">Submit</button>

</form>
<script>
    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function() {
            const output = document.getElementById('preview');
            output.src = reader.result;
            output.style.display = 'block';
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
