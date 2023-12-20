<script setup>
import NewLayout from '@/Layouts/NewLayout.vue'
import DevelopersView from '@/Components/DevelopersView.vue'
import Navbar from '@/Components/Navbar.vue'

const props = defineProps({
    attributes: Object
})
</script>

<template>
    <NewLayout>
        <Navbar />
        <div class="mx-3">
            <DevelopersView :attributes="attributes" />
        </div>
    </NewLayout>
</template>
