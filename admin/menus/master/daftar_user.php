<!--breadcrumb-->
<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3">Daftar User</div>
    <div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="?mydashboard"><i class="bx bx-home-alt"></i></a>
                </li>
                <li class="breadcrumb-item active" aria-current="page"><a href="?page=<?= $_GET['page'] ?>&sub=<?= $_GET['sub'] ?>">Daftar User</a></li>
            </ol>
        </nav>
    </div>
</div>
<!--end breadcrumb-->
<?php
require_once 'classes/Pelanggan.php';
require_once 'classes/Pemilik.php';
?>
<div class="row mb-3">
    <div class="col col-lg-12 mx-auto">
        <div class="card">
            <div class="card-body">
                <ul class="nav nav-tabs nav-primary" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" data-bs-toggle="tab" href="#daftar_pelanggan" role="tab" aria-selected="true">
                            <div class="d-flex align-items-center">
                                <div class="tab-icon"><i class='bx bx-user-check font-18 me-1'></i>
                                </div>
                                <div class="tab-title">Pelanggan</div>
                            </div>
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" data-bs-toggle="tab" href="#daftar_pemilik" role="tab" aria-selected="false">
                            <div class="d-flex align-items-center">
                                <div class="tab-icon"><i class='bx bx-user-circle font-18 me-1'></i>
                                </div>
                                <div class="tab-title">Pemilik</div>
                            </div>
                        </a>
                    </li>
                </ul>
                <div class="tab-content py-3">
                    <div class="tab-pane fade show active" id="daftar_pelanggan" role="tabpanel">
                        <div class="table-responsive">
                            <table class="table table-striped align-middle" id="table-user-pelanggan">
                                <thead class="table-light">
                                    <tr>
                                        <th>No</th>
                                        <th>Username</th>
                                        <th>Nama Pelanggan</th>
                                        <th>Alamat</th>
                                        <th>Jenis Kelamin</th>
                                        <th>No Telepon</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $pelanggan = new Pelanggan();
                                    $no_pelanggan = 1;
                                    ?>
                                    <?php foreach ($pelanggan->getAllPelanggan() as $pel) : ?>
                                        <tr>
                                            <td><?= $no_pelanggan++ ?></td>
                                            <td><?= $pel['username'] ?></td>
                                            <td><?= ucwords($pel['nama_pelanggan']) ?></td>
                                            <td><?= $pel['alamat'] ?></td>
                                            <td><?= $pel['jenis_kelamin'] ?></td>
                                            <td><?= $pel['no_hp'] ?></td>
                                            <td>
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-outline-primary" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Detail User" onclick="detailPelanggan('<?= $pel['pelanggan_id'] ?>')"><i class="bx bx-info-circle fs-4"></i></button>
                                                    <button type="button" class="btn btn-outline-danger" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Non-aktif User" onclick="deletePelanggan('<?= $pel['pelanggan_id'] ?>', '<?= $pel['user_id'] ?>')"><i class="bx bx-x fs-4"></i></button>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="daftar_pemilik" role="tabpanel">
                        <div class="mb-4">
                            <button type="button" class="btn btn-primary" onclick="showFormAddPemilik()"><i class='bx bx-plus'></i> Tambah Pemilik</button>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hovered table-borderless align-middle" id="table-user-pemilik">
                                <thead class="table-light">
                                    <tr>
                                        <th>No</th>
                                        <th>Username</th>
                                        <th>Nama Pelanggan</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $pemilik = new Pemilik();
                                    $no_pemilik = 1;
                                    ?>
                                    <?php foreach ($pemilik->getAllPemilik() as $pem) : ?>
                                        <tr>
                                            <td><?= $no_pemilik++ ?></td>
                                            <td><?= $pem['username'] ?></td>
                                            <td><?= ucwords($pem['nama_pemilik']) ?></td>
                                            <td>
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-outline-primary" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Detail User" onclick="detailPemilik('<?= $pem['pemilik_id'] ?>')"><i class="bx bx-info-circle fs-4"></i></button>
                                                    <button type="button" class="btn btn-outline-danger" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Non-aktif User" onclick="deletePemilik('<?= $pem['pemilik_id'] ?>', '<?= $pem['user_id'] ?>')"><i class="bx bx-x fs-4"></i></button>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(function() {
        $('#table-user-pelanggan').DataTable({
                lengthChange: false,
                buttons: ['copy', 'excel', 'pdf', 'print']
            }).buttons().container()
            .appendTo('#table-user-pelanggan_wrapper .col-md-6:eq(0)');

        $('#table-user-pemilik').DataTable({
                lengthChange: false,
                buttons: ['copy', 'excel', 'pdf', 'print']
            }).buttons().container()
            .appendTo('#table-user-pemilik_wrapper .col-md-6:eq(0)');
    })

    function detailPelanggan(pelanggan_id) {
        $.ajax({
            url: 'content/modal-add-pelanggan.php',
            type: 'POST',
            data: {
                pelanggan_id: pelanggan_id,
                action: 'detail'
            },
            success: function(response) {
                $('#my-modal-centered').html(response);
                $('#my-modal-centered').modal('show');
                $('[data-bs-toggle="tooltip"]').tooltip('hide');
            }
        })
    }

    function deletePelanggan(pelanggan_id, user_id) {
        Swal.fire({
            title: "Apakah anda yakin?",
            text: "User atau pelanggan yang dihapus tidak bisa dikembalikan!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya, Hapus!",
            cancelButtonText: "Batal"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: 'classes/Pelanggan.php',
                    type: 'POST',
                    data: {
                        action: 'delete_pelanggan',
                        pelanggan_id: pelanggan_id,
                        user_id: user_id
                    },
                    success: function(response) {
                        let res = JSON.parse(response);
                        Swal.fire({
                            title: res.status == 'success' ? 'Berhasil' : 'Gagal',
                            html: res.message,
                            icon: res.status,
                            showConfirmButton: false,
                            timer: res.time,
                            showCancelButton: false,
                            showConfirmButton: false,
                            allowOutsideClick: false,
                        }).then((e) => {
                            if (e.dismiss === Swal.DismissReason.timer) {
                                if (res.status == 'success') {
                                    location.reload();
                                }
                            }
                        })
                    }
                })
            }
        })
    }

    function showFormAddPemilik() {
        $.ajax({
            url: 'content/modal-pemilik.php',
            success: function(response) {
                $('#my-modal-centered').html(response);
                $('#my-modal-centered').modal('show');
                $('[data-bs-toggle="tooltip"]').tooltip('hide');
            }
        })
    }

    function detailPemilik(pemilik_id) {
        $.ajax({
            url: 'content/modal-pemilik.php',
            type: 'POST',
            data: {
                pemilik_id: pemilik_id,
                action: 'detail'
            },
            success: function(response) {
                $('#my-modal-centered').html(response);
                $('#my-modal-centered').modal('show');
                $('[data-bs-toggle="tooltip"]').tooltip('hide');
            }
        })
    }

    function deletePemilik(pemilik_id, user_id) {
        Swal.fire({
            title: "Apakah anda yakin?",
            text: "User atau pemilik yang dihapus tidak bisa dikembalikan!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya, Hapus!",
            cancelButtonText: "Batal"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: 'classes/Pemilik.php',
                    type: 'POST',
                    data: {
                        action: 'delete_pemilik',
                        pemilik_id: pemilik_id,
                        user_id: user_id
                    },
                    success: function(response) {
                        let res = JSON.parse(response);
                        Swal.fire({
                            title: res.status == 'success' ? 'Berhasil' : 'Gagal',
                            html: res.message,
                            icon: res.status,
                            showConfirmButton: false,
                            timer: res.time,
                            showCancelButton: false,
                            showConfirmButton: false,
                            allowOutsideClick: false,
                        }).then((e) => {
                            if (e.dismiss === Swal.DismissReason.timer) {
                                if (res.status == 'success') {
                                    location.reload();
                                }
                            }
                        })
                    }
                })
            }
        })
    }
</script>