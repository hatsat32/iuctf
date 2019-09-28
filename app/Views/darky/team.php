<?= $this->extend("darky/templates/base") ?>

<?= $this->section('content') ?>

    <?php if(isset($no_team) && $no_team): ?>

        <div class="alert alert-danger w-100 m-2" role="alert">
            Şu anda herhangi bir takıma dahil değilsiniz. Bir takıma katılın yada yeni bir tane oluşturun!
        </div>

        <div class="card w-100 m-2">
            <div class="card-header">
                <i class="fas fa-chart-area"></i>
                Takım Oluştur</div>
            <div class="card-body">
                <form action="/createteam" method="post">
                    <div class="form-group">
                        <label for="name">İsmi Giriniz</label>
                        <input type="name" name="name" class="form-control" id="name" placeholder="Takım İsmi">
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Takım Oluştur</button>
                </form>
            </div>
        </div>

        <div class="card w-100 m-2">
            <div class="card-header">
                <i class="fas fa-chart-area"></i>
                Takıma Katıl</div>
            <div class="card-body">
                <form action="/jointeam" method="post">
                    <div class="form-group">
                        <label for="auth_code">Takım Kodunu Giriniz</label>
                        <input type="text" name="auth_code" class="form-control" id="auth_code" placeholder="Takım Kodu">
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Takıma Katıl</button>
                </form>
            </div>
        </div>
    <?php else: ?>

    <div class="card m-2">
        <h3 class="card-header">Takım Üyeleri</h3>
        <ul class="list-group list-group-flush">
            <?php foreach($team_members as $member): ?>
                <li class="list-group-item"><?= esc($member['username']) ?></li>
            <?php endforeach ?>
        </ul>
    </div>

    <hr>

    <h3>Takım Bilgileri</h3>

    <hr>

    <table class="table table-hover">
        <tbody>
            <tr>
                <th>Takım Lideri</th>
                <td><?= esc($team['leader_id']) ?></td>
            </tr>
            <tr>
                <th>Takım İsmi</th>
                <td><?= esc($team['name']) ?></td>
            </tr>
            <tr>
                <th>Takım Kodu</th>
                <td><?= esc($team['auth_code']) ?></td>
            </tr>
        </tbody>
    </table> 

    <?php endif ?>

<?=$this->endSection()?>