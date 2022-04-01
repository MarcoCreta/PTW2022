<article class="content tab-container" id="groups-container">
    <div class="d-flex">
        <a class="back-button hidden" href="teacher-area.php"></a>
        <h3 class="mb-1 text-center">Gruppi di cuoi fai parte :</h3>
    </div>
    <hr>
    <div id="new-group">
        <button type="button" class="n-button m-1 w-100" data-bs-toggle="modal" data-bs-target="#newGroup">
            <i class="bi bi-plus-circle"></i>
        </button>


        <!-- Modal -->
        <div class="modal fade" id="newGroup" tabindex="-1" aria-labelledby="newGroupLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="content modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="newGroupLabel">Creazione Gruppo</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST">
                            <label for="new-group-name">Scegli un nome per il gruppo</label>
                            <input class ="w-100" type="text" name="new-group-name" id="new-group-name">
                            <span hidden class="" id="group-warning">
                                <i class="bi bi-exclamation-circle-fill text-danger"></i>
                            </span>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id="new-group-submit">Conferma</button>
                    </div>
                </div>
            </div>
        </div>


    </div>
    <div class="row g-1" id='groups-list'>
        <?php require APP_ROOT . '/' . 'template/search-group.php' ?>
    </div>
</article>