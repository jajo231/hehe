<script setup>
import { ref, provide } from 'vue';
import SidebarNavigation from '@/Components/SidebarNavigation.vue';
import { watch } from 'vue';

let width = ref('w-[250px]')
let hide = ref(false)

function toggleWidth() {
    if(width.value == 'w-[250px]') {
        width.value = 'w-[90px]'
        hide.value = true
    }else {
        width.value = ['w-[250px]']
        hide.value = false
    }
}

const storedTheme = localStorage.getItem('darkTheme')
const darkTheme = ref(storedTheme !== null ? JSON.parse(storedTheme) : false)
watch(darkTheme, (newValue) => {
    localStorage.setItem('darkTheme', newValue)
})
provide('darkTheme', darkTheme)

</script>

<template>
    <div>
        <div class="flex min-h-screen">
            <div id="sidebar" :class="[darkTheme ? 'dark-sidebar' : 'light-sidebar', width]" style="position: relative;">
                <button class="text-xl text-cyan-600" @click="toggleWidth" style="position: absolute; right: 10px; top:10px">
                    <i :class="[darkTheme ? 'fa-solid fa-bars text-cyan-500' : 'fa-solid fa-bars text-cyan-600']"></i>
                </button>
                <div id="branding" :hidden="hide" class="my-6">
                    <img src="data:image/png;base64,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" alt="Logo"
                        class="w-[170px] h-[170px] mx-auto rounded-full object-cover">
                </div>
                <hr class="border-cyan-600" :hidden="hide">
                <SidebarNavigation :hidden="hide" />
            </div>

            <div id="container" :class="[darkTheme ? 'flex-1 bg-cyan-700' : 'flex-1 bg-cyan-200']">
                <slot />
            </div>
        </div>
    </div>
</template>
<style scoped>
.light-sidebar {
  background-color: #2bb5dc;
  color: #415c5e;
}

.dark-sidebar {
  background-color: #517695;
  color: #46adf2;
}
</style>
