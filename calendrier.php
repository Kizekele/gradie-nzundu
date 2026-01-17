<?php
require 'config.php';
require __DIR__ . '/inc/auth.php';
require_login();

$page_title = 'Calendrier';

$extra_head = "\n<link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css' rel='stylesheet' />\n<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js'></script>\n";

// Events
$stmt = $conn->prepare(
  'SELECT e.*, c.nom_cours FROM calendrier e JOIN cours c ON e.id_cours = c.id'
);
$stmt->execute();
$evenements = $stmt->fetchAll(PDO::FETCH_ASSOC);

$events_json = json_encode(array_map(function($e){
  return [
    'title' => ($e['titre'] ?? '').' ('.($e['nom_cours'] ?? '').')',
    'start' => $e['date_debut'] ?? null,
    'end' => $e['date_fin'] ?? null,
    'description' => $e['description'] ?? '',
    'color' => '#7c3aed',
    'textColor' => '#ffffff'
  ];
}, $evenements));

include __DIR__ . '/inc/layout_start.php';
?>

<div class="d-flex flex-wrap align-items-end justify-content-between gap-2 mb-4">
  <div>
    <h1 class="h3 mb-1">Calendrier</h1>
    <div class="muted">Cours, deadlines, examens : tout en un seul calendrier.</div>
  </div>
  <div class="muted small">Astuce : cliquez sur un événement pour voir sa description.</div>
</div>

<div class="app-card p-3">
  <div id="calendar"></div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
  var calendarEl = document.getElementById('calendar');
  var calendar = new FullCalendar.Calendar(calendarEl, {
    initialView: 'dayGridMonth',
    locale: 'fr',
    height: 'auto',
    headerToolbar: {
      left: 'prev,next today',
      center: 'title',
      right: 'dayGridMonth,timeGridWeek,timeGridDay'
    },
    events: <?= $events_json ?>,
    eventClick: function(info){
      const desc = info.event.extendedProps.description;
      if(desc){
        alert(desc);
      }
    }
  });
  calendar.render();
});
</script>

<?php include __DIR__ . '/inc/layout_end.php'; ?>
