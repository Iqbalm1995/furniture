
        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-4 text-gray-800">Data Produk</h1>
          <?php echo $this->session->userdata('message1') <> '' ? $this->session->userdata('message1') : ''; ?>
          <div class="col-md-12">
            <a class="btn btn-secondary" href="<?php echo base_url('produk/'); ?>">Kembali</a>
          </div>
          <!-- DataTales Example -->
          <div class="card shadow mb-4 mt-2">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Data Produk</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-sm" width="100%">
                  <tr>
                    <td colspan="2"><h4>Informasi Produk</h4></td>
                  </tr>
                  <tr>
                    <td><strong>Kategori</strong></td>
                    <td><?=$produk['nama_kategori']?></td>
                  </tr>
                  <tr>
                    <td><strong>Nama Produk</strong></td>
                    <td><?=$produk['nama_file']?></td>
                  </tr>
                  <tr>
                    <td><strong>Nama File</strong></td>
                    <td><?=$produk['upload_file']?></td>
                  </tr>
                  <tr>
                    <td><strong>Tanggal Buat</strong></td>
                    <td><?=$produk['tanggal']?></td>
                  </tr>
                  <tr>
                    <td><strong>Bahan</strong></td>
                    <td><?=$produk['bahan']?></td>
                  </tr>
                  <tr>
                    <td><strong>Kategori</strong></td>
                    <td><?=$produk['berat']?> Kg</td>
                  </tr>
                  <tr>
                    <td><strong>Kategori</strong></td>
                    <td><?=$produk['merk']?></td>
                  </tr>
                  <tr>
                    <td colspan="2"><h4>Ukuran</h4></td>
                  </tr>
                  <tr>
                    <td><strong>Panjang</strong></td>
                    <td><?=$produk['u_panjang']?> cm</td>
                  </tr>
                  <tr>
                    <td><strong>Lebar</strong></td>
                    <td><?=$produk['u_lebar']?> cm</td>
                  </tr>
                  <tr>
                    <td><strong>Tinggi</strong></td>
                    <td><?=$produk['u_tinggi']?> cm</td>
                  </tr>
                </table>
                <hr>
                <br>
                <h3>Data Stok & Warna <?=$produk['nama_file']?></h3>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tambahModal">Tambah Stok</button>
                <hr>
                <table class="table" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th width="5%">No.</th>
                      <th>Warna(HEX COLOR)</th>
                      <th>Stok</th>
                      <th width="12%">Aksi</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>#</th>
                      <th>Warna</th>
                      <th>Stok</th>
                      <th>Aksi</th>
                    </tr>
                  </tfoot>
                  <tbody>
                    <?php 
                      $no = 1;
                      foreach($stok as $r){ ?>
                      <tr>
                        <td><?php echo $no++ ?></td>
                        <td><strong style="color: <?php echo $r->warna ?>; text-shadow: 2px 2px 5px #919191;"><?php echo $r->warna ?></strong></td>
                        <td><?php echo $r->stok ?></td>
                        <td>
                          <a href="<?php echo base_url('produk/hapus_stok/'.$r->id_produk.'/'.$r->id); ?>">Hapus</a>
                        </td>
                      </tr>
                    <?php } ?>

                  </tbody>
                </table>
              </div>
            </div>
          </div>

        </div>
        <!-- /.container-fluid -->

        <!-- Modal -->
        <div class="modal fade" id="tambahModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <form action="<?php echo base_url(); ?>produk/tambah_stok" method="post" enctype="multipart/form-data">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Tambah Stok Produk</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <input type="hidden" name="id_produk" value="<?php echo $id_produk; ?>">
                  <div class="form-group">
                    <label>Warna Produk</label>
                    <input type="text" name="warna" maxlength="7" class="form-control" value="#" required>
                  </div>
                  <div class="form-group">
                    <label>Stok</label>
                    <input type="number" name="stok" maxlength="3" class="form-control" placeholder="Isi Stok" required>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
                  <input type="submit" name="submit" class="btn btn-primary" value="Simpan">
                </div>
              </div>
            </form>
          </div>
        </div>

        <!-- Script Data Tabel -->
        <script type="text/javascript">
          // Call the dataTables jQuery plugin
          $(document).ready(function() {
            $('#dataTable').DataTable();
          });
        </script>
        <!-- End Script Data Tabel -->
