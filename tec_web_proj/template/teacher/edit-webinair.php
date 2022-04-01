<article class="content">
    <div class="">
        <div class="row">
            <div class="col-12">
                <h6 class="mb-1">Contenuto teaching</h6>
            </div>
        </div>
        <hr>
        <fieldset class="" id="masterclass-content" form="settings">
            <label class="form-label" for="date">Data di svolgimento: *</label>
            <input type="date" class="form-control" id="date" name="date" required="required" value="<?php if (isset($templateParams['teaching']['content']['date'])) echo $templateParams['teaching']['content']['date'] ?>">

            <label class="form-label" for="time">ora di svolgimento: *</label>
            <input type="time" class="form-control" id="time" name="time" required="required" value="<?php if (isset($templateParams['teaching']['content']['time'])) echo $templateParams['teaching']['content']['time'] ?>">

            <label class="form-label col-12" for="presences">Numero di partecipanti:</label>
            <input type="number" step="1" class="col-11 form-control" id="presences" name="presences" placeholder="imposta il numero di partecipanti" value="<?php if (isset($templateParams['teaching']['content']['n_presences'])) echo $templateParams['teaching']['content']['n_presences'] ?>">
        </fieldset>
    </div>
</article>