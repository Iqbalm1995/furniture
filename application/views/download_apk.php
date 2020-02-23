
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Download/Upload APK Furniture</h1>
    <?php echo $this->session->userdata('message1') <> '' ? $this->session->userdata('message1') : ''; ?>

    <div class="card shadow mb-4 mt-2 offset-md-2 col-md-8 offset-md-2">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Download APK Furniture</h6>
        </div>
        <div class="col-md-12 card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                    <th width="5%">No.</th>
                    <th>Nama File</th>
                    <th>Deskripsi</th>
                    <th>Versi</th>
                    <th>Tanggal</th>
                    <th width="25%">Aksi</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                    <th>#</th>
                    <th>Nama File</th>
                    <th>Deskripsi</th>
                    <th>Versi</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php 
                    $no = 1;
                    foreach ($data_apk as $r){ 
                    ?>
                    <tr>
                        <td><?php echo $no++ ?></td>
                        <td><?php echo $r->nama_file; ?></td>
                        <td><?php echo $r->deskripsi; ?></td>
                        <td><?php echo $r->versi; ?></td>
                        <td><?php echo $r->tgl_upload; ?></td>
                        <td>
                        <a href="<?php echo base_url('upload_file/apk/'.$r->nama_file) ?>" class="btn btn-primary btn-sm" target="_blank">
                            <i class="fas fa-download"></i> Download APK
                        </a>
                        <a href="<?php echo base_url('download_apk/hapus/'.$r->id); ?>" class="btn btn-danger btn-sm">
                            <i class="fas fa-trash"></i>
                        </a>
                        </td>
                    </tr>
                    <?php } ?>

                </tbody>
                </table>
            </div>

            <!-- <a href="<?php echo base_url('download_apk/download_file/apk/') ?>" class="btn btn-primary btn-lg" target="_blank">
                <i class="fas fa-download"></i><br>Download APK
            </a> -->
        </div>
    </div>

    <div class="card shadow mb-4 mt-2 offset-md-2 col-md-8 offset-md-2">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Upload APK Furniture</h6>
        </div>
        <div class="col-md-12 card-body">

            <form action="<?php echo base_url('download_apk/proses_upload'); ?>" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label>Upload APK</label>
                <input name="upload_file" type="file" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Versi APK</label>
                <input type="text" name="versi" class="form-control" placeholder="Isi Versi APK" required>
            </div>
            <div class="form-group">
                <label>Deskripsi</label>
                <textarea class="form-control" name="deskripsi" placeholder="Deskripsi"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
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
