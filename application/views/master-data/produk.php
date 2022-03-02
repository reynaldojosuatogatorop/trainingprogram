<div class="breadcrumb-area">
    <h1>Dashboard</h1>
    <ol class="breadcrumb">
        <li class="item"><a href="dashboard-analytics.html"><i class='bx bx-home-alt'></i></a></li>
        <li class="item">Dashboard</li>
        <li class="item">Analytics</li>
    </ol>
</div>

<div class="card">
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-12" align="right">
                <button class="btn btn-success btn-sm" onclick="tambahData()">Tambah Data</button>
            </div>
        </div>
        <table class="table table-bordered" id="datatable" width="100%">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nama Produk</th>
                    <th scope="col">Jenis Produk</th>
                    <th scope="col">Harga</th>
                    <th scope="col">Satuan</th>
                    <th scope="col">Sisa Stok</th>
                    <th scope="col">Deskripsi</th>
                    <th scope="col">Gambar</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
<div class="modal fade" id="modalProses" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                      <div class="form-group">
                        <label class="control-label" for="gambar">Gambar</label><br/>
                        <img  for="file_2" id="img_file_2" src="https://png.pngtree.com/png-vector/20191129/ourmid/pngtree-image-upload-icon-photo-upload-icon-png-image_2047545.jpg" style="max-height:40px;border-radius: 5px;"/>
                        <br/>
                        <label class="text-info" style="cursor:pointer;margin-top:5px" for="file_2"><i class="fe-image"></i>&nbsp;Cari foto</label>
                        <input type="file" class="form-control" id="file_2" onchange="ResizeFile(this.id)" accept=".jpg, .png, .jpeg" style="display:none" >
                        <input type="text" class="form-control" id="text_file_2" style="display:none">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <label>Nama Produk</label>
                        <input type="text" id="nama_produk" class="form-control" placeholder="Masukkan nama produk">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label>Jenis Produk</label>
                        <select class="form-control" id="jenis_produk" class="form-control">
                            <option value hidden>Pilih Data</option>
                            <option value="Peralatan Rumah Tanggal">Peralatan Rumah Tanggal</option>
                            <option value="Sembako">Sembako</option>
                            <option value="Makanan Ringan">Makanan Ringan</option>
                            <option value="Peralatan Masak">Peralatan Masak</option>
                        </select>
                    </div>
                </div>

                <div class="col-6">
                    <div class="form-group">
                        <label>Satuan</label>
                        <select class="form-control" id="satuan_produk" class="form-control">
                            <option value hidden>Pilih Data</option>
                            <option value="Kg">Kg</option>
                            <option value="Lusin">Lusin</option>
                            <option value="Item">Item</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <label>Harga</label>
                        <input type="text" id="harga" class="form-control" placeholder="Masukkan harga produk">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <label>Deskripsi Produk</label>
                        <textarea class="form-control" id="deskripsi" placeholder="Deskripsi Produk"></textarea>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <label>Stok Awal</label>
                        <input type="text" class="form-control" id="stok_awal" placeholder="Masukkan stok awal produk">
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-success" id="simpanData" onclick="simpanData()">Simpan</button>
            <button type="button" class="btn btn-primary" id="ubahData" onclick="ubahData()">Ubah</button>
        </div>
    </div>
</div>
</div>
<script type="text/javascript">
    var id;
    function clearData()
    {
        $('#text_file_2').val("");
        $('#nama_produk').val("");
        $('#jenis_produk').val("");
        $('#satuan_produk').val("");
        $('#harga').val("");
        $('#deskripsi').val("");
        $('#stok_awal').val("");
    }
    function tambahData()
    {
        clearData();
        $('#modalTitle').html("Tambah Data Produk");
        $('#ubahData').hide();
        $('#simpanData').show();
        $('#modalProses').modal('show');
    }

    function simpanData()
    {
        const data = {
            'gambar' : $('#text_file_2').val(),
            'nama_produk' : $('#nama_produk').val(),
            'jenis_produk' : $('#jenis_produk').val(),
            'satuan_produk' : $('#satuan_produk').val(),
            'harga' : $('#harga').val(),
            'deskripsi' : $('#deskripsi').val(),
            'stok_awal' : $('#stok_awal').val(),
        }

        $.ajax({
            url: '<?= base_url("Backend/ProsesProduk/Tambah") ?>',
            data: { 'data': data },
            type: "POST",
            success: function(dataResponse) {
                var dataJson = dataResponse;

                if(dataJson.status == true)
                {
                    notif('success', dataJson.notifikasi);
                }else{
                        ('error', dataJson.notifikasi);
                }

            },
            error: function(e){
                alert("Sorry, looks like there are some errors detected, please try again !");       
            }
        })
    }

    function tampilUbahData(args,gambar)
    {
        clearData();
        $('#ubahData').show();
        $('#simpanData').hide();
        var decodeData = JSON.parse(window.atob(args));
        id = decodeData.id;
        $('#modalTitle').html("Ubah Data Produk");
        $('#nama_produk').val(decodeData.produk);
        $('#jenis_produk').val(decodeData.jenis_produk);
        $('#harga').val(decodeData.harga);
        $('#stok_awal').val(decodeData.jumlah_stok);
        $('#satuan_produk').val(decodeData.satuan);
        $('#deskripsi').val(decodeData.deskripsi_produk);
        $('#img_file_2').attr("src", gambar);
        $('#text_file_2').val(decodeData.gambar_produk);
        $('#modalProses').modal('show');
    }

    function ubahData()
    {
        const data = {
            'tokenID'       : id,
            'gambar'        : $('#text_file_2').val(),
            'nama_produk'   : $('#nama_produk').val(),
            'jenis_produk'  : $('#jenis_produk').val(),
            'satuan_produk' : $('#satuan_produk').val(),
            'harga'         : $('#harga').val(),
            'deskripsi'     : $('#deskripsi').val(),
            'stok_awal'     : $('#stok_awal').val(),
        }

        $.ajax({
            url: '<?= base_url("Backend/ProsesProduk/Ubah") ?>',
            data: { 'data': data },
            type: "POST",
            success: function(dataResponse) {
                var dataJson = dataResponse;

                if(dataJson.status == true)
                {
                    notif('success', dataJson.notifikasi);
                }else{
                        ('error', dataJson.notifikasi);
                }

            },
            error: function(e){
                alert("Sorry, looks like there are some errors detected, please try again !");       
            }
        })
    }

    function hapusData(args)
    {
        const data ={
            'tokenID' : args,
        }
        $.ajax({
            url: '<?= base_url("Backend/HapusProduk") ?>',
            data: { 'data': data },
            type: "POST",
            success: function(dataResponse) {
                var dataJson = dataResponse;

                if(dataJson.status == true)
                {
                    notif('success', dataJson.notifikasi);
                }else{
                        ('error', dataJson.notifikasi);
                }

            },
            error: function(e){
                alert("Sorry, looks like there are some errors detected, please try again !");       
            }
        })
    }
</script>