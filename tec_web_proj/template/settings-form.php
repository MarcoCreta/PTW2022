
            <div class="row">
                <div class="col-sm-12 col-lg-12">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <ul id="top-tabbar-vertical" class="p-0">
                                    <li class="settings-selector" id="personal">
                                        <a class="settings-form">
                                            <i class="ri-user bi bi-person-lines-fill bg-soft-primary text-primary me-3"></i>Personal
                                        </a>
                                    </li>
                                    <li class="settings-selector" id="privacy">
                                        <a class="privacy-form">
                                            <i class="ri-user bi bi-shield-lock-fill bg-soft-primary text-primary me-3"></i>Privacy
                                        </a>
                                    </li>
                                    <li class="settings-selector" id="personal">
                                        <a class="payment-form">
                                            <i class="ri-user bi bi-credit-card-fill bg-soft-primary text-primary me-3"></i>Payment
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="formset-vertical col-md-9">
                            <form class="settings-form card active" id="teacher-form" name="teacher-form">
                                    <div class="form-card text-left">
                                        <div class="row">
                                            <div class="col-12">
                                                <h3 class="mb-1">Informazioni Personali :</h3>
                                                <hp class="mb-4">Compila queste informazioni per diventare un teacher:</h3>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="form-group">
                                                <label class="form-label" for="fname">Nome : *</label>
                                                <input type="text" class="form-control" id="fname" name="fname" placeholder="First Name" required="required">
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label" for="lname">Cognome : *</label>
                                                <input type="text" class="form-control" id="lname" name="lname" placeholder="Last Name" required="required">
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label" for="dob">Data di nascita : *</label>
                                                <input type="date" class="form-control" id="dob" name="dob" required="required">
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label" for="fname">Codice fiscale : *</label>
                                                <input type="text" class="form-control" id="CF" name="CF" placeholder="Fiscal Code" required="required">
                                            </div>
                                        </div>
                                    </div>
                                    <button form="teacher-form" class="btn btn-primary next action-button float-end">Salva</button>
                            </form>
                            <form class="privacy-form card" id="privacy-form" name="privacy-form">
                                    <div class="form-card text-left">
                                        <div class="row">
                                            <div class="col-12">
                                            <h3 class="mb-4">Impostazioni privacy :</h3>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                            <div class="form-group">

                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" id="profile-privacy">
                                                    <label class="form-check-label" for="profile-privacy">Profilo privato </label>
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                    <button form="privacy-form" class="btn btn-primary next action-button float-end">Salva</button>
                            </form>
                            <form class="payment-form card" id="payment-form" name="payment-form">
                                    <div class="form-card text-left">
                                        <div class="row">
                                            <div class="col-12">
                                            <h3 class="mb-4">Informazioni pagamento :</h3>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <p>questa pagina non è ancora disponibile<p>
                                        </div>
                                    </div>
                            </form>
                            </div>
                        </div>
                    </div>
                    </div>
            </div>

            
