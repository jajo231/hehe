<script setup>
import { defineProps } from 'vue';
import { Link } from '@inertiajs/vue3';
import { inject } from 'vue';

const { hidden } = defineProps(['hidden']);
const darkTheme = inject('darkTheme')

const logout = () => {
    page.post(route('logout'), {
        _token: csrfToken.value,
    });
};


</script>

<template>
    <div :class="[darkTheme ? 'dark-main-nav' : 'light-main-nav']">
      <Link :href="route('dashboard')" :active="route().current('dashboard')">
        <i class="fa-solid fa-house"></i>
        <span :hidden="hidden" class="text-label" :class="[darkTheme ? 'dark-text' : 'light-text']"> Home</span>
      </Link>
      <Link :href="route('games.index')" :active="route().current('games.index')">
        <i class="fa-solid fa-mask"></i>
        <span :hidden="hidden" class="text-label" :class="[darkTheme ? 'dark-text' : 'light-text']"> Heroes</span>
      </Link>
      <Link :href="route('attributes.index')" :active="route().current('attributes.index')">
        <i class="fa-solid fa-hand-fist"></i>
        <span :hidden="hidden" class="text-label" :class="[darkTheme ? 'dark-text' : 'light-text']"> Primary Attributes</span>
      </Link>
      <Link :href="route('dateIndex')" :active="route().current('dateIndex')">
        <i class="fa-regular fa-calendar-days"></i>
        <span v-if="!hidden" class="text-label" :class="[darkTheme ? 'dark-text' : 'light-text']"> Release Dates</span>
        </Link>
      <Link :href="route('logout')" method="post" title="Logout">
        <i class="fa-solid fa-right-from-bracket"></i>
        <span :hidden="hidden" class="text-label" :class="[darkTheme ? 'dark-text' : 'light-text']"> Logout</span>
      </Link>
    </div>
  </template>

  <style scoped>
  .light-main-nav {
    background-color: #2bb5dc;
    color: #415c5e;
  }

  .dark-main-nav {
    background-color: #517695;
    color: #46adf2;
  }

  .light-text {
    color: #000;
  }

  .dark-text {
    color: #fff;
  }
  </style>
