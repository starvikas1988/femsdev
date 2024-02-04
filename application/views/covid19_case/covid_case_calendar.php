
  
<link rel='stylesheet' href='https://fullcalendar.io/releases/core/4.1.0/main.min.css'>
<link rel='stylesheet' href='https://fullcalendar.io/releases/daygrid/4.1.0/main.min.css'>
<link rel='stylesheet' href='https://fullcalendar.io/releases/timegrid/4.1.0/main.min.css'>
  
<style>
html, body {
  margin: 0;
  padding: 0;
  font-family: Arial, Helvetica Neue, Helvetica, sans-serif;
  font-size: 14px;
}

#external-events {
  position: fixed;
  z-index: 2;
  top: 20px;
  left: 20px;
  width: 150px;
  padding: 0 10px;
  border: 1px solid #ccc;
  background: #eee;
}

#external-events .fc-event {
  margin: 1em 0;
  cursor: move;
}

#calendar-container {
  position: relative;
  z-index: 1;
  margin-left: 200px;
}

#calendar {
  max-width: 900px;
  margin: 20px auto;
}
</style>

<div class="wrap">
<section class="app-content">
<div class="widget">
<div class="widget-body">


<h6>Calendar</h6>

<div id='calendar-container'>
  <div id='calendar'></div>
</div>


</div>
</div>
</section>
</div>