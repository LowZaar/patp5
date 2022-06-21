<style>
  .fc-event-title {
    color: #F8F8FF !important;
  }
</style>
<?php dump($_SESSION) ?>
<div class="container-fluid">
  <div class="main-content col-12 d-flex">
    <div id="calendar" class="align-items-stretch w-100 h-75 pt-5">
    </div>
  </div>
</div>

<!-- Modal Nova Solicitacao -->
<div class="modal fade" id="solicitacaoModal" tabindex="-1" role="dialog" aria-labelledby="solicitacaoModalTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="solicitacaoModalTitle">Nova Solicitação de Agenda</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label for="titulo">Nome do Evento</label>
          <input type="text" name="" id="titulo" class="form-control">
        </div>

        <div class="form-group">
          <label for="horarioInicio">Inicio do Evento</label>
          <input type="text" name="" id="horarioInicio" readonly class="form-control">
        </div>
        <div class="form-group">
          <label for="horarioFim">Final do Evento</label>
          <input type="text" name="" id="horarioFim" readonly class="form-control">
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" id="save">Salvar</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
      </div>
    </div>
  </div>
</div>


<!-- Modal Detalhes de Evento -->
<div class="modal fade" id="detalhesEvento" tabindex="-1" role="dialog" aria-labelledby="detalhesEventoTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="detalhesEventoTitle">Nova Solicitação de Agenda</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label for="titulo">Nome do Evento</label>
          <input type="text" name="" id="titulo" class="form-control">
        </div>

        <div class="form-group">
          <label for="horarioInicio">Inicio do Evento</label>
          <input type="text" name="" id="detalheInicio" class="form-control">
        </div>
        <div class="form-group">
          <label for="horarioFim">Final do Evento</label>
          <input type="text" name="" id="detalheFim" class="form-control">
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    let bizhrs = 1

    if (bizhrs == 0) {
      var bizHours = {
        daysOfWeek: [1, 2, 3, 4, 5],
        startTime: '07:00',
        endTime: '18:00',
      }

      var selConstraint = 'businessHours'
    }else{
      var businessHours = false
    }

    let calendarEl = document.getElementById('calendar');
    let calendar = new FullCalendar.Calendar(calendarEl, {
      locale: 'pt-br',
      initialView: 'timeGridWeek',
      initialDate: new Date(),
      allDaySlot: true,
      selectable: true,
      selectOverlap: false,
      eventOverlap: false,
      businessHours: bizHours,
      selectConstraint: selConstraint,
      weekends: <?= $_SESSION['user']['fimDeSemana'] ?>,
      themeSystem: 'bootStrap5',
      buttonIcons: {
        prev: 'chevron-left',
        next: 'chevron-right'
      },
      headerToolbar: {
        left: 'prev next today',
        center: 'title',
        right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
      },
      events: '<?= HOME_URI ?>/home/retornaCalendario',
      eventClick: function(info) {

        console.log('click');
        let modalDetails = $('#detalhesEvento').modal({
          keyboard: false
        })
        $('#eventoInicio').val(info.event.start.toLocaleString('pt-BR'))
        $('#eventoFim').val(info.event.end.toLocaleString('pt-BR'))
        modalDetails.modal('show')
      },

      select: function(info) {

        if (!info.event) {
          let modal = $('#solicitacaoModal').modal({
            keyboard: false
          })
          $('#horarioInicio').val(info.start.toLocaleString('pt-BR'))
          $('#horarioFim').val(info.end.toLocaleString('pt-BR'))
          modal.modal('show')

          $('#save').click(function() {
            let titulo = $('#titulo').val()

            if (titulo !== '') {
              $.ajax({
                url: '<?= HOME_URI ?>/solicitacao/criar',
                method: 'POST',
                data: {
                  titulo: titulo,
                  horarioInicio: info.startStr,
                  horarioFinal: info.endStr
                },
                success: function(result) {
                  result = JSON.parse(result)
                  showNotificatonModal(result.label, result.message, result.type)
                  $('#titulo').val('')
                  modal.modal('hide')
                }
              })
            } else {
              showNotificatonModal('Erro', 'O Título deve ser preenchido', 'error')
            }
          })

        }
      }
    })
    calendar.render();
  })
</script>

<script>
  $('.buttonLink').click(function() {
    let link = document.getElementById('link');
    link.type = "text"
    link.focus();
    link.select();
    document.execCommand("copy");
    link.type = "hidden"
    alert('O link do seu calendário foi copiado para sua área de transferencia!')
  })
</script>