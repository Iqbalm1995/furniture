
        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-4 text-gray-800">Data Produk</h1>
          <?php echo $this->session->userdata('message1') <> '' ? $this->session->userdata('message1') : ''; ?>
          <div class="col-md-12">
            <a class="btn btn-primary" href="<?php echo base_url('produk/tambah_data'); ?>">Tambah Data</a>
          </div>
          <!-- DataTales Example -->
          <div class="card shadow mb-4 mt-2">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Tabel Produk</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th width="5%">No.</th>
                      <th width="10%">ID Produk</th>
                      <th>Kategori</th>
                      <th>Nama File</th>
                      <th>Harga</th>
                      <th>Upload File</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>#</th>
                      <th>ID Produk</th>
                      <th>Kategori</th>
                      <th>Nama File</th>
                      <th>Harga</th>
                      <th>Upload File</th>
                      <th>Aksi</th>
                    </tr>
                  </tfoot>
                  <tbody>
                    <?php 
                      $no = 1;
                      foreach($produk as $r){ 

                        $kategori_val    = $this->produk->get_id_val($where = array('id_kategori' => $r->id_kategori),'t_kategori');
                    ?>
                      <tr>
                        <td><?php echo $no++ ?></td>
                        <td><?php echo $r->id_produk ?></td>
                        <td><strong><?php echo $kategori_val['nama_kategori'] ?></strong></td>
                        <td><?php echo $r->nama_produk ?></td>
                        <td>Rp. <?php echo number_format($r->harga, 0 , '' , '.' ) ?></td>
                        <td><a href="<?php echo base_url('upload_file/'.$r->upload_file) ?>" target="_blank"><?php echo $r->upload_file ?></a>
                          <small>(<a href="<?php echo base_url('produk/download_file/'.$r->upload_file) ?>" target="_blank">Download</a>)</small>
                        </td>
                        <td>
                          <a href="<?php echo base_url('produk/edit/'.$r->id_produk); ?>">Edit</a> | 
                          <a href="<?php echo base_url('produk/hapus/'.$r->id_produk); ?>">Hapus</a> | 
                          <a href="<?php echo base_url('produk/detail/'.$r->id_produk); ?>">Detail</a>
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

        <!-- Script Data Tabel -->
        <script type="text/javascript">
          // Call the dataTables jQuery plugin
          $(document).ready(function() {
            $('#dataTable').DataTable();
          });
        </script>
        <!-- End Script Data Tabel -->
