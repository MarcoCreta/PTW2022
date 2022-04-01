<article class="content">
    <div class="row">
        <div class="col-12">
            <h6 class="mb-1">Info Teaching</h6>
        </div>
    </div>
    <hr>
    <fieldset class="" id="info" form="settings">

        <label class="form-label col-12" for="detail">Dettaglio categoria: *</label>
        <input type="text" class="col-12 form-control" id="detail" name="detail" placeholder="Argomento nel dettaglio" required="required" value="<?php if(isset($templateParams['teaching']['category_detail'])) echo $templateParams['teaching']['category_detail']?>">

        <label class="form-label col-12" for="description">Descrizione: *</label>
        <input type="text" class="col-12 form-control" id="description" name="description" placeholder="Breve descrizione degli argomenti trattati" required="required" value="<?php if(isset($templateParams['teaching']['description'])) echo $templateParams['teaching']['description']?>">

    </fieldset>
</article>