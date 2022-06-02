<div id="main-content" class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            
            <div class="row">
                <div class="col-lg-12">
                    <h3 class="title-5 m-b-35">Editar usuário</h3>

                    <div class="card">
                        <div class="card-header">
                            <strong>Formulário de edição</strong> Preencha abaixo
                        </div>
                        <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                            <input type="hidden" name="editar_usuario" value="1">
                            <div class="card-body card-block">
                                <div class="row form-group">
                                    <div class="col col-md-3">
                                        <label for="text-input" class="form-control-label">Nome</label>
                                    </div>
                                    <div class="col-12 col-md-9">
                                        <input type="text" id="text-input" name="nome" class="form-control" value="<?= $this->usuario['nome'] ?>">
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col col-md-3">
                                        <label for="text-input" class="form-control-label">E-mail</label>
                                    </div>
                                    <div class="col-12 col-md-9">
                                        <input type="text" id="text-input" name="email"
                                        value="<?= $this->usuario['email'] ?>" class="form-control">
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col col-md-3">
                                        <label for="select" class=" form-control-label">Tipo Usuário</label>
                                    </div>
                                    <div class="col-12 col-md-9">
                                        <select name="tipo_usuario" id="unidade" class="form-control">
                                            <option value="1" <?= $this->usuario['tipo_usuario']=='1' ? 'selected': '' ?>>Admin</option>
                                            <option value="2" <?= $this->usuario['tipo_usuario']=='2' ? 'selected': '' ?>>Caixa</option>
                                        </select>
                                    </div>
                                </div>

                                <hr>

                                <div class="row form-group">
                                    <div class="col col-md-3">
                                        <label for="text-input" class="form-control-label">Senha</label>
                                    </div>
                                    <div class="col-12 col-md-9">
                                        <input type="text" id="text-input" name="senha" class="form-control">
                                        <small class="form-text text-muted">Preencha este campo apenas se quiser editar a senha atual do cliente</small>
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