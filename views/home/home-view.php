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
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="save">Save changes</button>
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
    let calendarEl = document.getElementById('calendar');

    let calendar = new FullCalendar.Calendar(calendarEl, {
      locale: 'pt-br',
      initialView: 'timeGridWeek',
      initialDate: new Date(),
      allDaySlot: true,
      selectable: true,
      selectOverlap: false,
      eventOverlap: false,
      buttonIcons: {
        prev: 'chevron-left',
        next: 'chevron-right'
      },
      headerToolbar: {
        left: 'prev next today',
        center: 'title',
        right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
      },
      events: [{
          id: 'a',
          title: 'my event',
          start: '2022-06-07',
          end: '2022-06-08',
          display: 'background'
        }],
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
          
          $('#save').click(function(){
            $.ajax({
              url: '<?= HOME_URI ?>/solicitacao/criar',
              method: 'POST',
              data: {
                  descricao: $('#titulo').val(),
                  horarioInicio : info.start,
                  horarioFinal : info.end
              },
              success: function(result){
                console.log(data)
                showNotificatonModal('success', 'inserido')
              }
            })
          })
        
        }
      }
    })
    calendar.render();
  })
</script>