<div class="container-fluid">
  <div class="main-content">
      <div id="calendar" class="w-100 h-100"></div>
  </div>
</div>


<script>
  var $calEl = $('#calendar').tuiCalendar({
    defaultView: 'week',
    taskView: false,
    template: {
      monthDayname: function(dayname) {
        return '<span class="calendar-week-dayname-name">' + dayname.label + '</span>';
      }
    },
    month: {
        daynames: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb'],
        startDayOfWeek: 1,
        narrowWeekend: false
    },
    week: {
        daynames: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb'],
        startDayOfWeek: 1,
        narrowWeekend: false
    }
  });

  var calendar = $calEl.data('tuiCalendar');

  calendar.createSchedules([{
      id: '1',
      calendarId: '1',
      title: 'my schedule',
      category: 'time',
      dueDateClass: '',
      start: '2022-06-01T22:30:00+09:00',
      end: '2022-06-02T02:30:00+09:00'
    },
    {
      id: '2',
      calendarId: '1',
      title: 'second schedule',
      category: 'time',
      dueDateClass: '',
      start: '2022-06-01T19:00:00+09:00',
      end: '2022-06-01T21:30:00+09:00',
      isReadOnly: true // schedule is read-only
    }
  ]);

  calendar.on('clickDayname', function(event) {
    console.log(event)
    if (calendar.getViewName() === 'week') {
        calendar.setDate(new Date(event.date));
        calendar.changeView('day', true);
    }
  });

  calendar.on('beforeUpdateSchedule', function(event) {
    var schedule = event.schedule;
    var changes = event.changes;
    console.log(schedule);
    console.log(changes);
    calendar.updateSchedule(schedule.id, schedule.calendarId, changes);
  });
</script>