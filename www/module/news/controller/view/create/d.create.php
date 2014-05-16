<div class="row">
    <div class="col-md-offset-4 col-md-4">

        <h3>Добавление новости</h3>
        
        <p class="p1">Введите новость!</p>

        <form role="form" method="post" action="/news/create">
            <?php
            /*
            <div class="form-group<?= (isset($this->model->orm_validate['date'])) ? " has-error" : ""; ?>">
                <label>Дата</label>
                <input type="text" class="form-control" placeholder="Введите дату" name="name[date]" value="<?= $this->model->orm_data['date']; ?>">
                <p class="text-danger"><?=$this->model->validate_message['date']; ?></p>
            </div>
            <div class="form-group<?= (isset($this->model->orm_validate['name'])) ? " has-error" : ""; ?>">
                <label>Сообщение</label>
                <input type="textarea" class="form-control" placeholder="Новость" name="name[name]" value="<?= $this->model->orm_data['name']; ?>">
                <p class="text-danger"><?=$this->model->validate_message['name']; ?></p>
            </div>
            
            <div class="form-group<?= (isset($this->model->orm_validate['keystring'])) ? " has-error" : ""; ?>">
                <img src="/api/captcha_image">
                <input type="text" class="form-control" placeholder="Фраза из картинки" name="name[keystring]" value="">
                <p class="text-danger"><?=$this->model->validate_message['keystring']; ?></p>
            </div>*/
            ?>
            
            <div class="form-group<?= (isset($this->model->orm_validate['date'])) ? " has-error" : ""; ?>">
                <label>Дата</label>
                <input type="text" class="form-control" placeholder="Введите дату" name="name[date]" value="<?= $this->model->get_data('date'); ?>">
                <p class="text-danger"><?=$this->model->get_mess('date'); ?></p>
            </div>
            <div class="form-group<?= (isset($this->model->orm_validate['name'])) ? " has-error" : ""; ?>">
                <label>Сообщение</label>
                <input type="textarea" class="form-control" placeholder="Новость" name="name[name]" value="<?= $this->model->get_data('name'); ?>">
                <p class="text-danger"><?=$this->model->get_mess('name'); ?></p>
            </div>
            
            <div class="form-group<?= (isset($this->model->orm_validate['keystring'])) ? " has-error" : ""; ?>">
                <img class="col-md-offset-3" src="/api/captcha_image">
                <input type="text" class="form-control" placeholder="Фраза из картинки" name="name[keystring]" value="">
                <p class="text-danger"><?=$this->model->get_mess('keystring'); ?></p>
            </div>
            <button type="submit" class="btn btn-default">Отправить</button>
        </form>
    </div>
</div>













