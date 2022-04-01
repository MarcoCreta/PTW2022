<article class="content">
    <div class="row">
        <div class="col-12">
            <h6 class="mb-1">Impostazioni teaching</h6>
        </div>
    </div>
    <hr>
    <form class="content" id="settings" name="settings" <?php if(isset($_GET['ID_group']))echo 'ID_group="'.$_GET['ID_group'].'"'?><?php if(isset($templateParams['teaching'])) echo 'ID_content="'.$templateParams['teaching']['ID_content'].'"action="update"'?> >
        <fieldset class="" form="settings">
            <div class="">

                <select class="btn btn-secondary dropdown-toggle col-12" id="type" required="required" <?php if(isset($templateParams['teaching']['type'])) echo 'disabled'?>>
                    <?php if(!isset($templateParams['teaching']['type'])):?>
                    <option value="" disabled selected>Tipologia</option>
                    <option value="course">Course</option>
                    <option value="masterclass">Masterclass</option>
                    <option value="webinair">Webinair</option>
                    <?php else :?>
                    <option value="<?php echo $templateParams['teaching']['type']?>"><?php echo $templateParams['teaching']['type']?></option>
                    <?php endif ?>
                </select>
            </div>
            <div class="">
                <select class="btn btn-secondary dropdown-toggle col-12" id="category" required="required">
                    <option value="" disabled selected>Categoria</option>
                    <?php foreach ($templateParams['categories'] as $category) : ?>
                        <option value="<?php echo $category['name'] ?>"<?php if($category['name'] == $templateParams['teaching']['category']) echo 'selected'?>><?php echo $category['name'] ?></option>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="input-group">
                <label class="form-label col-12" for="name">Nome teaching: *</label>
                <input type="text" class="col-12 form-control" id="name" name="name" placeholder="scegli un nome" required="required" value="<?php if(isset($templateParams['teaching']['name'])) echo $templateParams['teaching']['name']?>">
            </div>
            <div class="input-group">
                <label class="form-label col-12" for="price">Prezzo: *</label>
                <input type="number" step="0.01" class="col-11 form-control" id="price" name="price" placeholder="imposta un prezzo" required="required" value="<?php if(isset($templateParams['teaching']['name'])) echo $templateParams['teaching']['price']?>">
                <div class="input-group-text col-1">€</div>
            </div>
            <div class="form-check form-switch">
                <label class="form-check-label" for="active">Attivo</label>
                <input class="form-check-input" type="checkbox" id="active" <?php if(isset($templateParams['teaching']['active'])) if($templateParams['teaching']['active']) echo 'checked'?>>
            </div>
        </fieldset>

        <input form="settings" type="submit" value="save" class="btn btn-primary action-button col-12">
    </form>
</article>