<div id="main-content" class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">


            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive table-responsive-data2">
                        <table class="table table-data2">
                            <thead>
                                <tr>
                                    <th>Solicitante</th>
                                    <th>Título</th>
                                    <th>Horário Início</th>
                                    <th>Horário Fim</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php foreach ($solicitacoes as $solicitacao) { ?>
                                        <tr class="tr-shadow">
                                            <td><?= $solicitacao['nome_solicitante'] ?></td>
                                            <td><?= $solicitacao['titulo'] ?></td>
                                            <td><?= date('d/m/Y H:i:s', strtotime($solicitacao['datainicio'])) ?></td>
                                            <td><?= date('d/m/Y H:i:s', strtotime($solicitacao['datafim'])) ?></td>
                                            <td>
                                                <div class="table-data-feature">

                                                    <button class="item">
                                                        <i class="fa fa-check-circle-o"></i>
                                                    </button>

                                                    <button class="item">
                                                        <i class="fa fa-times"></i>
                                                    </button>
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

<script>
    $(document).ready(function() {

        $('.table').DataTable({
            paginate: false,
            info: false
        })
    })
</script>