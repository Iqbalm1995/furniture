
	    <div class="container-fluid">

	    	<!-- Page Heading -->
	        <h1 class="h3 mb-4 text-gray-800">Tambah Produk</h1>
	        <div class="col-md-12">
	            <a class="btn btn-secondary" href="<?php echo base_url('produk/'); ?>">Kembali</a>
	        </div>
	        
	        <div class="card shadow mb-4 mt-2">
	        	<div class="card-header py-3">
	            	<h6 class="m-0 font-weight-bold text-primary">Form Produk</h6>
	            </div>
	            <div class="offset-md-2 col-md-8 offset-md-2 card-body">
	            	<form action="<?php echo base_url('produk/proses_tambah'); ?>"  method="post" enctype="multipart/form-data">
	            	  <div class="form-group">
	            	  	<label>Kategori</label>
	            	  	<select name="id_kategori" id="id_kategori" class="form-control">
                          <?php foreach ($kategori as $rd){ ?>
                              <option value="<?php echo $rd->id_kategori; ?>"><?php echo $rd->nama_kategori; ?></option>
                          <?php }; ?>
                        </select>
	            	  </div>
					  <div class="form-group">
					    <label>Nama Produk</label>
					    <input type="text" name="nama_produk" class="form-control" placeholder="Isi Nama Produk" required>
					  </div>
					  <div class="form-group">
					    <label>Upload File</label>
					    <input name="upload_file" type="file" class="form-control" required>
					  </div>
					  <div class="form-group">
					    <label>Bahan</label>
					    <input type="text" name="bahan" class="form-control" placeholder="Isi Bahan Produk" required>
					  </div>
					  <div class="form-group">
					    <label>Harga Rp.</label>
					    <input type="number" name="harga" class="form-control" placeholder="Isi Harga Produk" required>
					  </div>
					  <div class="form-group">
					    <label>Merk</label>
					    <input type="text" name="merk" class="form-control" placeholder="Isi Merek Produk" required>
					  </div>
					  <strong>Ukuran Produk</strong>
					  <div class="row">
					  	<div class="col-md-4">
					  		<div class="form-group">
							    <label>Panjang(m)</label>
							    <input type="text" name="panjang" class="form-control" placeholder="(Dalam Ukuran Centi Meter)" maxlength="3" required>
							</div>
					  	</div>
					  	<div class="col-md-4">
					  		<div class="form-group">
							    <label>Lebar(m)</label>
							    <input type="text" name="lebar" class="form-control" placeholder="(Dalam Ukuran Centi Meter)" maxlength="3" required>
							</div>
					  	</div>
					  	<div class="col-md-4">
					  		<div class="form-group">
							    <label>Tinggi(m)</label>
							    <input type="text" name="tinggi" class="form-control" placeholder="(Dalam Ukuran Centi Meter)" maxlength="3" required>
							</div>
					  	</div>
					  </div>
					  <div class="form-group">
					    <label>Keterangan</label>
					    <textarea class="form-control" name="keterangan" placeholder="Keterangan (Opsional)"></textarea>
					  </div>
					  <button type="submit" class="btn btn-primary">Simpan</button>
					</form>
	            </div>
	        </div>

	    </div>
