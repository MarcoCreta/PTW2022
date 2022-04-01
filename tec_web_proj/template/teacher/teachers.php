<article class="content tab-container" id="teachers-container">
    <div class="d-flex">
    <a class="back-button hidden" href="asd"></a>
        <h3 class="mb-1 text-center">Membri di questo gruppo :</h3>
    </div>
    <hr>
    <div id="add-teacher">
        <button type="button" class="n-button m-1 w-100" data-bs-toggle="modal" data-bs-target="#addTeacher">
            <i class="bi bi-plus-circle"></i>
        </button>


        <!-- Modal -->
        <div class="modal fade" id="addTeacher" tabindex="-1" aria-labelledby="addTeacherLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="content modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addTeacherLabel">Specifica un utente</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST">
                            <label for="add-teacher-name">Inserisci il nome dell'utente checkdate si vuole aggiungere</label>
                            <input class ="w-100" type="text" name="add-teacher-name" id="add-teacher-name">
                            <span hidden class="" id="teacher-warning">
                                <i class="bi bi-exclamation-circle-fill text-danger"></i>
                            </span>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id="add-teacher-submit">Conferma</button>
                    </div>
                </div>
            </div>
        </div>


    </div>
    <div class="row g-1" id='teachers-list'>
        <?php require APP_ROOT . '/' . 'template/teacher/search-teacher.php' ?>
    </div>
</article>