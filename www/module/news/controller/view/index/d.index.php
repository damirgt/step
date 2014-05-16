<div class="row">

    <h3 class="text-center">Новости</h3>

    <div class="text-center">
        <?php
        if (isset($this->sph->pageable_array)) {
            foreach ($this->sph->pageable_array as $key => $item) {
                ?>
                <a class="btn btn-info" <?php if ($key == $this->i) echo "disabled" ?> href="/news/page/<?= $key; ?>"><?= $item; ?></a>
                <?php
            }
        }
        ?>
    </div>

    <div class="col-md-offset-2">

        <ul class="media-list">
            <?php foreach ($this->recordset as $item) { ?>
            <li class="media">
                <a class="pull-left" href="/news/details/<?= $item['id']; ?>">
                    <img class="media-object" src="<?= $this->src('images/4page-img4.jpg') ?>" alt="">
                </a>
                <div class="media-body">
                    <h4 class="media-heading"><?= $item['date']; ?></h4>
                    <p><?= $item['name']; ?></p>
                </div>
            </li>           
            <?php } ?>
        </ul>

        
    </div>
    <div class="text-center">
        <?php
        if (isset($this->sph->pageable_array)) {
            foreach ($this->sph->pageable_array as $key => $item) {
                ?>
                <a class="btn btn-info" <?php if ($key == $this->i) echo "disabled" ?> href="/news/page/<?= $key; ?>"><?= $item; ?></a>
                <?php
            }
        }
        ?>	
    </div>

</div>  																																