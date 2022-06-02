<div id="main-content" class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            
            <div class="row">
                <div class="col-lg-12">
                    <h3 class="title-5 m-b-35">Inserir novo usuário</h3>

                    <div class="card">
                        <div class="card-header">
                            <strong>Formulário de cadastro</strong> Preencha abaixo
                        </div>
                        <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                            <input type="hidden" name="insere_usuario" value="1">
                            <div class="card-body card-block">
                                <div class="row form-group">
                                    <div class="col col-md-3">
                                        <label for="text-input" class="form-control-label">Nome</label>
                                    </div>
                                    <div class="col-12 col-md-9">
                                        <input type="text" id="text-input" name="nome" placeholder="" class="form-control">
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col col-md-3">
                                        <label for="text-input" class="form-control-label">E-mail</label>
                                    </div>
                                    <div class="col-12 col-md-9">
                                        <input type="text" id="text-input" name="email"
                                        placeholder="" class="form-control">
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col col-md-3">
                                        <label for="text-input" class="form-control-label">Senha</label>
                                    </div>
                                    <div class="col-12 col-md-9">
                                        <input type="text" id="text-input" name="senha"
                                        placeholder="" class="form-control">
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col col-md-3">
                                        <label for="select" class=" form-control-label">Tipo Usuário</label>
                                    </div>
                                    <div class="col-12 col-md-9">
                                        <select name="tipo_usuario" id="unidade" class="form-control">
                                            <option value="1">Admin</option>
                                            <option value="2">Caixa</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary btn-sm">
                                    <i class="fa fa-check"></i> Salvar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>