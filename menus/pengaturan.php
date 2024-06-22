<!--breadcrumb-->
<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3">Pengaturan</div>
    <div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="?mydashboard"><i class="bx bx-home-alt"></i></a>
                </li>
                <li class="breadcrumb-item active" aria-current="page"><a href="?page=<?= $_GET['page'] ?>">Pengaturan</a></li>
            </ol>
        </nav>
    </div>
</div>
<!--end breadcrumb-->
<div class="col-xl-6 mx-auto">
    <h6 class="mb-0 text-uppercase">Pengaturan Profile Usaha</h6>
    <hr />
    <div class="card">
        <div class="card-body">
            <form class="row g-3" id="form-setting">
                <div class="col-12">
                    <label class="form-label">Nama Usaha</label>
                    <input type="text" class="form-control form-control-lg" name="nama_usaha" value="<?= ucwords($set['nama_usaha']) ?>">
                </div>
                <div class="col-12">
                    <label class="form-label">Alamat</label>
                    <input type="text" class="form-control form-control-lg" name="alamat" value="<?= ucwords($set['alamat']) ?>">
                </div>
                <div class="col-12">
                    <label class="form-label">Email</label>
                    <input type="text" class="form-control form-control-lg" name="email" value="<?= $set['email'] ?>">
                </div>
                <div class="col-12">
                    <label class="form-label">No Telepon</label>
                    <input type="text" class="form-control form-control-lg" name="no_telepon" value="<?= $set['no_telepon'] ?>">
                </div>
                <div class="col-12">
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#form-setting').submit(function(e) {
            e.preventDefault();
            let data = $(this).serialize();
            $.ajax({
                url: 'classes/Pengaturan.php',
                type: 'POST',
                data: {
                    data: data,
                    page: 'update-setting'
                },
                success: function(data) {
                    let result = JSON.parse(data);
                    Lobibox.notify(`${result.status}`, {
                        pauseDelayOnHover: true,
                        size: "mini",
                        rounded: true,
                        delayIndicator: false,
                        delay: 2000,
                        icon: `bx bx-${result.icon}`,
                        continueDelayOnInactiveTab: false,
                        sound: false,
                        position: "center top",
                        msg: result.msg,
                    });
                    setTimeout(() => {
                        location.reload();
                    }, 2000);
                }
            });
        });
    });
</script>