
<script src='https://fullcalendar.io/releases/core/4.1.0/main.min.js'></script>
<script src='https://fullcalendar.io/releases/interaction/4.1.0/main.min.js'></script>
<script src='https://fullcalendar.io/releases/daygrid/4.1.0/main.min.js'></script>
<script src='https://fullcalendar.io/releases/timegrid/4.1.0/main.min.js'></script>
  
<script>
  var Calendar = FullCalendar.Calendar;
  var Draggable = FullCalendarInteraction.Draggable;
  var calendarEl = document.getElementById('calendar');

  // initialize the calendar
  // -----------------------------------------------------------------
  var calendar = new Calendar(calendarEl, {
    plugins: ['interaction', 'dayGrid', 'timeGrid'],
    header: {
      left: 'prev,next today',
      center: 'title',
      right: 'dayGridMonth,timeGridWeek,timeGridDay' 
	},
    eventClick: function (info) {
      console.log(info.event.title);console.log(info.event.customAttribute);
    }, 
	events: [
        {
          title: 'All Day Event',
          start: '2020-06-02'
        },
	]
	
   });
  calendar.render();
</script>