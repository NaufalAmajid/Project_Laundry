<!--breadcrumb-->
<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3">Daftar Jasa</div>
    <div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="?mydashboard"><i class="bx bx-home-alt"></i></a>
                </li>
                <li class="breadcrumb-item active" aria-current="page"><a href="?page=<?= $_GET['page'] ?>">List Jasa & Harga</a></li>
            </ol>
        </nav>
    </div>
    <div class="ms-auto">
        <div class="btn-group">
            <button type="button" class="btn btn-primary">Settings</button>
            <button type="button" class="btn btn-primary split-bg-primary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown"> <span class="visually-hidden">Toggle Dropdown</span>
            </button>
            <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-end"> <a class="dropdown-item" href="javascript:;">Action</a>
                <a class="dropdown-item" href="javascript:;">Another action</a>
                <a class="dropdown-item" href="javascript:;">Something else here</a>
                <div class="dropdown-divider"></div> <a class="dropdown-item" href="javascript:;">Separated link</a>
            </div>
        </div>
    </div>
</div>
<!--end breadcrumb-->
<?php
require_once 'classes/Jasa.php';
$jasa = new Jasa();
$data = $jasa->getAllJasa();
$no   = 1;
?>
<div class="card">
    <div class="card-header py-3">
        <h6 class="mb-0">Daftar Jasa</h6>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-12 col-lg-4">
                <div class="card border shadow-none w-100">
                    <div class="card-body">
                        <form class="row g-3" id="form-jasa">
                            <div class="col-12">
                                <label class="form-label">Nama Jasa</label>
                                <input type="text" class="form-control" placeholder="nama jasa ..." name="nama_jasa">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Harga Satuan</label>
                                <input type="text" class="form-control" placeholder="harga satuan ..." name="harga_satuan_display" onkeyup="justNumberWithCurrency(this)">
                                <input type="hidden" name="harga_satuan" id="harga_satuan">
                            </div>
                            <div class="col-12">
                                <div class="d-grid">
                                    <button class="btn btn-primary" type="button" onclick="addJasa()" id="btn-jasa">Tambah Jasa</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-8 d-flex">
                <div class="card border shadow-none w-100">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table align-middle" id="table-daftar-jasa">
                                <thead class="table-light">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Jasa</th>
                                        <th>Harga Satuan</th>
                                        <th>Order</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($data as $jas) : ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= $jas['nama_jasa'] ?></td>
                                            <td><?= $func->currency($jas['harga_satuan']) ?></td>
                                            <td>
                                                <?php if ($jas['is_active'] == 1) : ?>
                                                    <span class="badge bg-secondary">Pending <?= $jas['jumlah_orderan_pending'] ?></span><br>
                                                    <span class="badge bg-primary">Proses <?= $jas['jumlah_orderan_proses'] ?></span>
                                                    <span class="badge bg-success">Selesai <?= $jas['jumlah_orderan_selesai'] ?></span>
                                                <?php else : ?>
                                                    <span class="badge bg-danger">Jasa Tidak Aktif</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center gap-3 fs-6">
                                                    <?php if ($jas['is_active'] == 1) : ?>
                                                        <a href="javascript:;" onclick="getJasaById('<?= $jas['jasa_id'] ?>', 0)" class="text-warning" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="Edit Jasa" aria-label="Edit"><i class="bx bx-edit-alt fs-4"></i></a>
                                                        <a href="javascript:;" onclick="deleteJasa('<?= $jas['jasa_id'] ?>')" class="text-danger" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="Hapus Jasa" aria-label="Delete"><i class="bx bx-eraser fs-4"></i></a>
                                                    <?php else : ?>
                                                        <a href="javascript:;" onclick="deleteJasa('<?= $jas['jasa_id'] ?>', 1)" class="text-info" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="Aktifkan Jasa" aria-label="Aktifkan"><i class="bx bx-rotate-left fs-4"></i></a>
                                                    <?php endif; ?>
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
    $(document).ready(function() {
        $('#table-daftar-jasa').DataTable();
    });

    function justNumberWithCurrency(element) {
        element.value = element.value.replace(/[^0-9]/g, '');
        element.value = new Intl.NumberFormat('id', {
            maximumFractionDigits: 0
        }).format(element.value);
        let harga = element.value.replace(/\./g, '');
        $('#harga_satuan').val(parseInt(harga));
    }

    function addJasa() {
        let form = $('#form-jasa').serializeArray();
        let data = {};
        $.each(form, function(i, field) {
            data[field.name] = field.value;
        });
        data['action'] = 'add_jasa';

        if (data['nama_jasa'] == '' || data['harga_satuan'] == '') {
            Lobibox.notify("warning", {
                pauseDelayOnHover: true,
                size: "mini",
                rounded: true,
                delayIndicator: false,
                delay: 2000,
                icon: "bx bx-error",
                continueDelayOnInactiveTab: false,
                sound: false,
                position: "top right",
                msg: "Nama jasa dan harga satuan tidak boleh kosong",
            });
            return;
        } else {
            $.ajax({
                url: 'classes/Jasa.php',
                type: 'POST',
                data: data,
                success: function(response) {
                    let result = JSON.parse(response);
                    Lobibox.notify(`${result.status}`, {
                        pauseDelayOnHover: true,
                        size: "mini",
                        rounded: true,
                        delayIndicator: false,
                        delay: 2000,
                        icon: `bx bx-${result.icon}`,
                        continueDelayOnInactiveTab: false,
                        sound: false,
                        position: "top right",
                        msg: result.msg,
                    });
                    setTimeout(() => {
                        location.reload();
                    }, 2000);
                }
            });
        }
    }

    function getJasaById(jasa_id) {
        $.ajax({
            url: 'classes/Jasa.php',
            type: 'POST',
            data: {
                action: 'get_jasa_by_id',
                jasa_id: jasa_id
            },
            success: function(response) {
                let result = JSON.parse(response);
                let harga = new Intl.NumberFormat('id', {
                    maximumFractionDigits: 0
                }).format(result.harga_satuan);
                $('input[name="nama_jasa"]').val(result.nama_jasa);
                $('input[name="harga_satuan_display"]').val(harga);
                $('input[name="harga_satuan"]').val(result.harga_satuan);
                $('#btn-jasa').html('Update Jasa');
                $('#btn-jasa').attr('onclick', `updateJasa(${result.jasa_id})`);
                $('#btn-jasa').removeClass('btn-primary').addClass('btn-warning');
            }
        })
    }

    function updateJasa(jasa_id) {
        let form = $('#form-jasa').serializeArray();
        let data = {};
        $.each(form, function(i, field) {
            data[field.name] = field.value;
        });
        data['action'] = 'update_jasa';
        data['jasa_id'] = jasa_id;

        if (data['nama_jasa'] == '' || data['harga_satuan'] == '') {
            Lobibox.notify("warning", {
                pauseDelayOnHover: true,
                size: "mini",
                rounded: true,
                delayIndicator: false,
                delay: 2000,
                icon: "bx bx-error",
                continueDelayOnInactiveTab: false,
                sound: false,
                position: "top right",
                msg: "Nama jasa dan harga satuan tidak boleh kosong",
            });
            return;
        } else {
            $.ajax({
                url: 'classes/Jasa.php',
                type: 'POST',
                data: data,
                success: function(response) {
                    let result = JSON.parse(response);
                    Lobibox.notify(`${result.status}`, {
                        pauseDelayOnHover: true,
                        size: "mini",
                        rounded: true,
                        delayIndicator: false,
                        delay: 2000,
                        icon: `bx bx-${result.icon}`,
                        continueDelayOnInactiveTab: false,
                        sound: false,
                        position: "top right",
                        msg: result.msg,
                    });
                    setTimeout(() => {
                        location.reload();
                    }, 2000);
                }
            });
        }
    }

    function deleteJasa(jasa_id, is_active = 0) {
        if (is_active == 0) {
            Swal.fire({
                title: "Apakah anda yakin?",
                text: "Jasa akan dinonaktifkan!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya, Hapus!",
                cancelButtonText: "Batal"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'POST',
                        url: 'classes/Jasa.php',
                        data: {
                            action: 'delete_jasa',
                            jasa_id: jasa_id,
                            is_active: is_active
                        },
                        success: function(response) {
                            let res = JSON.parse(response);
                            Lobibox.notify(`${res.status}`, {
                                pauseDelayOnHover: true,
                                size: "mini",
                                rounded: true,
                                delayIndicator: false,
                                delay: 2000,
                                icon: `bx bx-${res.icon}`,
                                continueDelayOnInactiveTab: false,
                                sound: false,
                                position: "top right",
                                msg: res.msg,
                            });
                            setTimeout(() => {
                                location.reload();
                            }, 2000);
                        }
                    })
                }
            });
        } else {
            $.ajax({
                type: 'POST',
                url: 'classes/Jasa.php',
                data: {
                    action: 'delete_jasa',
                    jasa_id: jasa_id,
                    is_active: is_active
                },
                success: function(response) {
                    let res = JSON.parse(response);
                    Lobibox.notify(`${res.status}`, {
                        pauseDelayOnHover: true,
                        size: "mini",
                        rounded: true,
                        delayIndicator: false,
                        delay: 2000,
                        icon: `bx bx-${res.icon}`,
                        continueDelayOnInactiveTab: false,
                        sound: false,
                        position: "top right",
                        msg: res.msg,
                    });
                    setTimeout(() => {
                        location.reload();
                    }, 2000);
                }
            })
        }
    }
</script>