<div class="row">
    <div class="col-md-offset-4 col-md-4">

        <h3>Изменение новости</h3>
        
        <p class="p1">Введите новость!</p>

        <form role="form" method="post" action="news/edit/<?=$this->model->orm_data['id']; ?>">
            <input type="hidden" name="name[id]" value="<?= $this->model->orm_data['id']; ?>">           
            <div class="form-group<?= (isset($this->model->orm_validate['date'])) ? " has-error" : ""; ?>">
                <label>Дата</label>
                <input type="text" class="form-control" placeholder="Введите дату" name="name[date]" value="<?= $this->model->orm_data['date']; ?>">
                <p class="text-danger"><?=$this->model->orm_validate['date']; ?></p>
            </div>
            <div class="form-group<?= (isset($this->model->orm_validate['name'])) ? " has-error" : ""; ?>">
                <label>Сообщение</label>
                <input type="textarea" class="form-control" placeholder="Новость" name="name[name]" value="<?= $this->model->orm_data['name']; ?>">
                <p class="text-danger"><?=$this->model->orm_validate['name']; ?></p>
            </div>
            <button type="submit" class="btn btn-info">Отправить</button>
        </form>
    </div>
</div>