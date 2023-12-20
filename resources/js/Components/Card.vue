<script setup>
const props = defineProps({
    item: Object
});
</script>

<template>
    <div class="flex flex-col items-center pb-10 bg-cyan-800 rounded-xl shadow-lg hover:shadow-2xl transition duration-300">
        <slot name="image" :item="item">
            <img :src="item.image" alt="Item Image" class="w-full h-48 object-cover rounded-t-xl"/>
        </slot>
        <div class="p-4 w-full">
            <slot name="title" :item="item">
                <h3 class="text-lg font-bold text-white">{{ item.name || item.game_title || 'Untitled' }}</h3>
            </slot>
            <slot name="content" :item="item">
            </slot>
            <slot name="details" :item="item">
            </slot>
            <slot name="status" :item="item">
            </slot>
            <slot name="type" :item="item">
            </slot>
        </div>
    </div>
</template>
