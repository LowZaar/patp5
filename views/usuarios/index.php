<div id="main-content" class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-12">
                    <div class="overview-wrap">
                        <h3 class="title-3">Usuários</h3>
                        <a href="<?= HOME_URI.'/usuarios/inserir' ?>" class="au-btn au-btn--small au-btn-icon au-btn--green">
                            <i class="zmdi zmdi-plus"></i>Inserir
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive table-responsive-data2">
                        <table class="table table-data2">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nome</th>
                                    <th>E-mail</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($this->lista as $key => $usuario) { ?>
                                    <tr class="tr-shadow">
                                        <td><?= $usuario['id'] ?></td>
                                        <td><?= $usuario['nome'] ?></td>
                                        <td><?= $usuario['email'] ?></td>
                                        <td>
                                            <div class="table-data-feature">
                                                <a href="<?= HOME_URI.'/usuarios/editar/'.$usuario['id'] ?>" class="item" data-toggle="tooltip" data-placement="top" title="Editar">
                                                    <i class="fa fa-pencil"></i>
												</a>
                                                <a href="<?= HOME_URI.'/usuarios/excluir/'.$usuario['id'] ?>" class="item" data-toggle="tooltip" data-placement="top" title="Excluir">
                                                    <i class="fa fa-times"></i>
												</a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- END DATA TABLE -->
                </div>
            </div>
            
        </div>
    </div>
</div>