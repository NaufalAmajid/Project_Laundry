<!--breadcrumb-->
<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3">Profile</div>
    <div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="?mydashboard"><i class="bx bx-home-alt"></i></a>
                </li>
                <li class="breadcrumb-item active" aria-current="page"><a href="?page=<?= $_GET['page'] ?>">Profile</a></li>
            </ol>
        </nav>
    </div>
</div>
<!--end breadcrumb-->
<?php
require_once 'classes/User.php';

$detailUser = new user();
$detailUser = $detailUser->getDetailUser($_SESSION['user_id'], $_SESSION['role_id']);
?>
<div class="col-xl-6 mx-auto">
    <h6 class="mb-0 text-uppercase">Profile User</h6>
    <hr />
    <div class="card">
        <div class="card-body">
            <form class="row g-3" id="form-user">
                <div class="col-12">
                    <label class="form-label">Username</label>
                    <input type="text" class="form-control form-control-lg" name="username" value="<?= $detailUser['username'] ?>">
                </div>
                <div class="col-12">
                    <label class="form-label">Password</label>
                    <input type="password" class="form-control form-control-lg" name="password" onchange="checkPasswordUser('<?= $detailUser['user_id'] ?>')">
                    <small id="notif-check-password"></small>
                </div>
                <div class="col-6">
                    <label class="form-label">Ganti Password</label>
                    <input type="password" class="form-control form-control-lg" name="change_password1" disabled>
                </div>
                <div class="col-6">
                    <label class="form-label">Konfirm Password</label>
                    <input type="password" class="form-control form-control-lg" name="change_password2" disabled onkeyup="checkConfirmPassword()">
                    <small id="notif-konfirm-password"></small>
                </div>
                <div class="col-12">
                    <label class="form-label">Nama User</label>
                    <input type="text" class="form-control form-control-lg" name="nama_user" value="<?= ucwords($detailUser['nama_user']) ?>">
                </div>
                <?php if ($_SESSION['role_id'] == 2) : ?>
                    <div class="col-12">
                        <label class="form-label">Alamat</label>
                        <input type="text" class="form-control form-control-lg" name="alamat" value="<?= ucwords($detailUser['alamat']) ?>">
                    </div>
                    <div class="col-6">
                        <label class="form-label">Jenis Kelamin</label>
                        <select class="form-control" id="jenis_kelamin" name="jenis_kelamin" required>
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="Laki-laki" <?= $detailUser['jenis_kelamin'] == 'Laki-laki' ? 'selected' : '' ?>>Laki-laki</option>
                            <option value="Perempuan" <?= $detailUser['jenis_kelamin'] == 'Perempuan' ? 'selected' : '' ?>>Perempuan</option>
                        </select>
                    </div>
                    <div class="col-6">
                        <label class="form-label">No Telepon / Hp</label>
                        <input type="text" class="form-control form-control-lg" name="no_hp" value="<?= $detailUser['no_hp'] ?>">
                    </div>
                <?php endif; ?>
                <div class="col-12">
                    <div class="d-grid">
                        <button type="button" class="btn btn-primary" id="btn-update-user" onclick="updateUser('<?= $detailUser['user_id'] ?>', '<?= $_SESSION['the_id'] ?>', '<?= $_SESSION['role_id'] ?>')">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    function checkPasswordUser(user_id) {
        let password = $('input[name="password"]').val();
        $.ajax({
            url: 'classes/User.php',
            type: 'POST',
            data: {
                action: 'check-password',
                user_id: user_id,
                password: password
            },
            success: function(data) {
                let result = JSON.parse(data);
                if (result.status == 'success') {
                    $('input[name="change_password1"]').prop('disabled', false);
                    $('input[name="change_password2"]').prop('disabled', false);
                    $('input[name="change_password1"]').focus();
                    $('#notif-check-password').html('Password benar');
                    $('#notif-check-password').addClass('text-success');
                    $('#notif-check-password').removeClass('text-danger');
                    $('#btn-update-user').prop('disabled', true);
                } else {
                    $('input[name="change_password1"]').prop('disabled', true);
                    $('input[name="change_password2"]').prop('disabled', true);
                    $('#notif-check-password').html('Password salah');
                    $('#notif-check-password').addClass('text-danger');
                    $('#notif-check-password').removeClass('text-success');
                    $('#btn-update-user').prop('disabled', false);
                }
            }
        })
    }

    function checkConfirmPassword() {
        let password1 = $('input[name="change_password1"]').val();
        let password2 = $('input[name="change_password2"]').val();
        if (password1 != password2) {
            $('#notif-konfirm-password').html('Password tidak sama');
            $('#notif-konfirm-password').addClass('text-danger');
            $('#notif-konfirm-password').removeClass('text-success');
            $('#btn-update-user').prop('disabled', true);
        } else {
            $('#notif-konfirm-password').html('Password sama');
            $('#notif-konfirm-password').addClass('text-success');
            $('#notif-konfirm-password').removeClass('text-danger');
            $('#btn-update-user').prop('disabled', false);
        }
    }

    function updateUser(user_id, the_id, role_id) {
        let data = $('#form-user').serializeArray();
        let send = {};
        data.map(item => {
            send[item.name] = item.value;
        })
        send['user_id'] = user_id;
        send['the_id'] = the_id;
        send['role_id'] = role_id;
        $.ajax({
            url: 'classes/User.php',
            type: 'POST',
            data: {
                action: 'edit_user',
                data: send
            },
            success: function(response) {
                let res = JSON.parse(response);

                Lobibox.notify(`${res.status}`, {
                    pauseDelayOnHover: true,
                    size: "mini",
                    rounded: true,
                    delayIndicator: false,
                    delay: 2500,
                    icon: `${res.icon}`,
                    continueDelayOnInactiveTab: false,
                    sound: false,
                    position: "center top",
                    msg: `${res.message}`
                });

                if (res.status == 'success') {
                    setTimeout(() => {
                        location.reload();
                    }, 2500);
                }
            }
        })
    }
</script>