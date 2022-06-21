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
                                    <tr class="tr-shadow" id="id_<?=$solicitacao['id']?>" data-id-Solicitacao="<?= $solicitacao['id'] ?>">
                                        <td class="nomeSolicitacao"><?= $solicitacao['nome_solicitante'] ?></td>
                                        <td class="tituloSolicitacao"><?= $solicitacao['titulo'] ?></td>
                                        <td class="dataInicioSolicitacao"><?= date('d/m/Y H:i:s', strtotime($solicitacao['datainicio'])) ?></td>
                                        <td class="dataFimSolicitacao"><?= date('d/m/Y H:i:s', strtotime($solicitacao['datafim'])) ?></td>
                                        <td>
                                            <div class="table-data-feature">
                                                <button class="btn btn-primary btnAcoes">
                                                    <span>
                                                        <i class="fa fa-bolt"></i>
                                                        Ações
                                                    </span>
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

<!-- Modal -->
<div class="modal fade" id="modalAcao" tabindex="-1" role="dialog" aria-labelledby="modalAcaoLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalAcaoLabel">Confirmar Agenda</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Informações do agendamento</p>
                <input type="hidden" name="" id="idSolicitacao" data-id-Solicitacao="">
                <div class="form-group">
                    <label for="titulo">Nome do Evento</label>
                    <input type="text" name="" id="titulo" class="form-control" readonly>
                </div>
                <div class="form-group">
                    <label for="nome">Nome do Solicitante</label>
                    <input type="text" name="" id="nome" class="form-control" readonly>
                </div>
                <div class="form-group">
                    <label for="descricao">Descrição do Evento</label>
                    <input type="text" name="" id="descricao" class="form-control" readonly>
                </div>
                <div class="form-group">
                    <label for="horarioInicio">Inicio do Evento</label>
                    <input type="text" name="" id="horarioInicio" readonly class="form-control" readonly>
                </div>
                <div class="form-group">
                    <label for="horarioFim">Final do Evento</label>
                    <input type="text" name="" id="horarioFim" readonly class="form-control" readonly>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btnRecusar">Recusar</button>
                <button type="button" class="btn btn-primary btnAceitar">Aceitar</button>
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



    $('.btnAcoes').click(function() {

        let modalAcao = $('#modalAcao').modal({
            keyboard: false,
        })

        let tableRow = $(this).closest('tr')

        $('#idSolicitacao').val(tableRow.data('id-solicitacao'))

        $('#nome').val(tableRow.find('.nomeSolicitacao').text())

        $('#titulo').val(tableRow.find('.tituloSolicitacao').text())

        $('#horarioInicio').val(tableRow.find('.dataInicioSolicitacao').text())

        $('#horarioFim').val(tableRow.find('.dataFimSolicitacao').text())

        modalAcao.modal('show')
    })


    $('.btnAceitar').click(function() {

        let idSolicitacao = $('#idSolicitacao').val()

        $.ajax({
            url: "<?= HOME_URI ?>/solicitacao/setStatus",
            type: 'POST',
            data: {
                idSoc: idSolicitacao,
                acao: 'aceitar'
            },
            success: function(response) {
                if (response == 'true') {
                    $('#modalAcao').modal('hide')
                    $('#modalAcao').find('form-control').val('')

                    $(`#id_${idSolicitacao}`).remove()
                    
                    showNotificatonModal('', 'Solicitação de agendamento aprovada com sucesso!', 'success')
                }
            }
        })
    })

    $('.btnRecusar').click(function() {

        let idSolicitacao = $('#idSolicitacao').val()

        $.ajax({
            url: "<?= HOME_URI ?>/solicitacao/setStatus",
            type: 'POST',
            data: {
                idSoc: idSolicitacao,
                acao: 'recusar'
            },
            success: function(response) {
                if (response == 'true') {
                    $('#modalAcao').modal('hide')
                    $('#modalAcao').find('.form-control').val('')

                    $(`#id_${idSolicitacao}`).remove()
                }
            }
        })
    })
</script>