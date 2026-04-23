<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <h3 class="mb-0">My Profile</h3>
    </div>
    <div class="card-body">
        <?php if(session()->getFlashdata('message')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= session()->getFlashdata('message') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        <?php if(session()->getFlashdata('error')): ?>
            <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>
        <?php if(session()->getFlashdata('errors')): ?>
            <div class="alert alert-danger">
                <?php foreach(session()->getFlashdata('errors') as $error): ?>
                    <p class="mb-0"><?= $error ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form method="post" action="<?= base_url('admin/profile/update') ?>" enctype="multipart/form-data">
            <?= csrf_field() ?>

            <div class="row mb-3">
                <div class="col-md-3 text-center">
                    <?php 
                    $profileImage = !empty($admin['profile_image']) ? base_url('uploads/profile/' . $admin['profile_image']) : '';
                    $defaultMale = base_url('admin-assets/images/users/avatar-3.jpg');
                    $defaultFemale = base_url('admin-assets/images/users/avatar-2.jpg');
                    $gender = $admin['gender'] ?? 'male';
                    $defaultImg = ($gender === 'female') ? $defaultFemale : $defaultMale;
                    ?>
                    <img src="<?= $profileImage ?: $defaultImg ?>" class="rounded-circle mb-3" width="120" height="120" style="object-fit: cover;" alt="Profile Picture">
                    <div class="mb-2">
                        <input type="file" name="profile_image" class="form-control" accept="image/jpeg,image/png,image/gif">
                        <small class="text-muted">Max 2MB, JPG/PNG/GIF</small>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="mb-3">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="name" class="form-control" value="<?= old('name', $admin['name']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="<?= old('email', $admin['email']) ?>" required>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Gender</label>
                            <select name="gender" class="form-control">
                                <option value="male" <?= ($admin['gender'] ?? '') == 'male' ? 'selected' : '' ?>>Male</option>
                                <option value="female" <?= ($admin['gender'] ?? '') == 'female' ? 'selected' : '' ?>>Female</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">New Password (leave blank to keep current)</label>
                        <input type="password" name="password" class="form-control" placeholder="Enter new password">
                    </div>
                </div>
            </div>

            <div class="mt-3">
                <button type="submit" class="btn btn-primary">Update Profile</button>
                <a href="<?= base_url('admin/dashboard') ?>" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>