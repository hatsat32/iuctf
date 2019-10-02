<?=$this->extend("darky/templates/base")?>

<?=$this->section('content')?>

    <div class="my-4 text-center">
        <h1>Scoreboard</h1>
    </div>

    <div class="m-2">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">Takım Adı</th>
                    <th scope="col">Puan</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($scores as $score): ?>
                <tr class="table-active">
                    <td><?= esc($score['name']) ?></th>
                    <td><?= esc($score['point']) ?></td>
                </tr>
                <?php endforeach ?>
            </tbody>
        </table> 
    </div>

<?=$this->endSection()?>