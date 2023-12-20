<script setup>
import NewLayout from '@/Layouts/NewLayout.vue';
import Navbar from '@/Components/Navbar.vue';
import { Head, usePage } from '@inertiajs/vue3';
import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import timeGridPlugin from '@fullcalendar/timegrid';

import { ref, onMounted } from 'vue';

const { events } = usePage().props;

const calendarOptions = ref({
  plugins: [dayGridPlugin, timeGridPlugin],
  initialView: 'dayGridMonth',
  events: events,
  dayRender: function (info) {
    const date = info.date.toISOString().split('T')[0];
    const event = events.find(event => event.start === date);

    if (event) {
      const cell = info.el;
      const tooltip = document.createElement('div');
      tooltip.className = 'tooltip';
      tooltip.textContent = `Release date of ${event.title}`; // Updated tooltip text
      tooltip.style.display = 'block';

      cell.appendChild(tooltip);

      cell.addEventListener('mouseenter', () => {
        tooltip.style.display = 'block';
      });

      cell.addEventListener('mouseleave', () => {
        tooltip.style.display = 'none';
      });
    }
  },
});

onMounted(() => {
  const calendarEl = document.getElementById('calendar');

  if (calendarEl) {
    const calendar = new Calendar(calendarEl, calendarOptions.value);
    calendar.render();
  }
});
</script>

<style scoped>
#calendar {
  background-color: rgb(46, 129, 147);
  font-size: 15px;
  width: 65%;
  margin: 0 auto;
  margin-top: 15px;

}
.tooltip {
  position: absolute;
  top: -20px; /* Adjust this value based on your design */
  left: 20px; /* Adjust this value based on your design */
  background-color: white;
  border: 1px solid #ccc;
  padding: 5px;
  border-radius: 5px;
  box-shadow: 0 0 5px rgb(46, 129, 147);
}
</style>

<template>
  <Head title="Dashboard" />

  <NewLayout>
    <Navbar />
    <div class="fade-in">
      <div class="max-w-7xl">
        <div class="bg-cyan-200">
          <div class="text-white p-10" id="calendar"></div>
        </div>
      </div>
    </div>
  </NewLayout>
</template>
