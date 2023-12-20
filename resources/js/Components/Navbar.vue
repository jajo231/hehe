<script setup>
import { inject } from 'vue';
import ResponsiveNavLink from './ResponsiveNavLink.vue';

const darkTheme = inject('darkTheme');
const toggleDarkTheme = () => {
  darkTheme.value = !darkTheme.value; // Toggle dark theme
};
</script>

<template>
    <nav :class="['flex items-center justify-between', darkTheme ? 'dark-mode' : 'light-mode']">
      <button @click="toggleDarkTheme" class="relative px-4 py-2 rounded-md overflow-hidden transition-all duration-300">
        <div class="toggle-label">{{ darkTheme ? 'Light Mode' : 'Dark Mode' }}</div>
        <div :class="[darkTheme ? 'bg-yellow-600' : 'bg-cyan-400']" class="w-full h-full absolute left-0 top-0 transition-transform duration-300 transform translate-x-[100%]"></div>
      </button>
    </nav>
  </template>
<style>
.dark-mode .toggle-label {
  color: #fff;
}

.light-mode .toggle-label {
  color: #000;
}
</style>
