<?= $this->extend("admin/templates/base") ?>

<?= $this->section('content') ?>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="#">Dashboard</a>
        </li>
        <li class="breadcrumb-item active"><?= lang('General.users') ?></li>
    </ol>

    <div class="my-4">
        <a class="btn btn-primary btn-block" href="/admin/users/new"><?= lang('General.add') ?></a>
    </div>

    <div class="card mb-3">
        <div class="card-header">
            <i class="fas fa-user"></i>
            <?= lang('General.users') ?></div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="users-table" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th><?= lang('General.id') ?></th>
                            <th><?= lang('General.team') ?></th>
                            <th><?= lang('General.username') ?></th>
                            <th><?= lang('General.name') ?></th>
                            <th><?= lang('General.email') ?></th>
                            <th><?= lang('General.createdAt') ?></th>
                            <th><?= lang('General.updatedAt') ?></th>
                            <th><?= lang('General.detail') ?></th>
                        </tr>
                    </thead>
                    <tbody>
					<?php foreach($users as $user): ?>
                        <tr>
                            <td><?= esc($user["id"]) ?></td>
                            <td><?= esc($user["team_id"]) ?></td>
                            <td><?= esc($user["username"]) ?></td>
                            <td><?= esc($user["name"]) ?></td>
                            <td><?= esc($user["email"]) ?></td>
                            <td><?= esc($user["created_at"]) ?></td>
                            <td><?= esc($user["updated_at"]) ?></td>
							<td><a href="/admin/users/<?= esc($user["id"]) ?>" class="btn btn-info btn-block"><?= lang('General.detail') ?></a></td>
                        </tr>
					<?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $("#users-table").DataTable();
        });
    </script>
<?= $this->endSection() ?>