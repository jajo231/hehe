<template>
    <NewLayout>
      <Navbar />
      <div class="container mx-auto mt-6">
        <div class="back-button-container">
            <Link :href="route('games.index')" :active="route().current('games.index')">
                <i class="fa-solid fa-circle-chevron-left"></i>
                <span :hidden="hidden"> Back</span>
            </Link>
        </div>
        <div class="max-w-md mx-auto">
          <div class="bg-white p-4 rounded-lg shadow-md">
            <h1 class="text-2xl font-semibold mb-4">Create New Game</h1>
            <form @submit.prevent="submit">
            <div class="mb-4">
              <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
              <input type="text" id="name" v-model="form.name" required class="mt-1 p-2 w-full border rounded-md">
            </div>
            <div class="mb-4">
              <label for="attribute_id" class="block text-sm font-medium text-gray-700">Attribute</label>
              <select id="attribute_id" v-model="form.attribute_id" required class="mt-1 p-2 w-full border rounded-md">
                <option value="" disabled>Select an attribute</option>
                <option v-for="attribute in props.attributes.data" :key="attribute.id" :value="attribute.id">{{ attribute.name }}</option>
              </select>
            </div>
            <div class="mb-4">
              <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
              <textarea id="description" v-model="form.description" required rows="2" class="mt-1 p-2 w-full border rounded-md"></textarea>
            </div>
            <div class="mb-4">
              <label for="image" class="block text-sm font-medium text-gray-700">Image</label>
              <input type="file" id="image" @change="handleImageChange" class="mt-1 p-2 w-full border rounded-md">
            </div>
            <div class="mb-4">
              <label for="type" class="block text-sm font-medium text-gray-700">Type</label>
              <select id="type" v-model="form.type" required class="mt-1 p-2 w-full border rounded-md">
                <option value="" disabled>Select a type</option>
                <option value="melee">Melee Hero</option>
                <option value="range">Range Hero</option>
              </select>
            </div>
            <div class="mb-4">
              <label for="release_date" class="block text-sm font-medium text-gray-700">Release Date</label>
              <input type="date" id="release_date" v-model="form.release_date" required class="mt-1 p-2 w-full border rounded-md">
            </div>
            <div class="mt-6">
              <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md">Create Game</button>
            </div>
          </form>
        </div>
      </div>
      </div>
    </NewLayout>
  </template>

<script setup>
import NewLayout from '@/Layouts/NewLayout.vue';
import Navbar from '@/Components/Navbar.vue';
import { useForm } from '@inertiajs/vue3';
import { usePage, useRoute } from '@inertiajs/inertia-vue3';
import { Link } from '@inertiajs/vue3';


const props = defineProps({
  attributes: Object
});

const form = useForm({
    name: '',
    attribute_id: '',
    description: '',
    image: null,
    type: '',
    release_date: '',
});

function submit() {
    form.post(route('games.store'), {
        onSuccess: () => {
            useRoute().push({ name: 'games.index' });
            usePage().props.flash.success = 'Game created successfully.';
        },
        onError: error => {
        }
    });
}

function handleImageChange(event) {
    form.image = event.target.files[0];
}

console.log(props.attributes.data);
</script>

<style scoped>
.back-button-container {
  position: absolute;
  top: 10px;
  right: 10px;
  z-index: 999;
}

.back-button-container Link {
  background-color: #007bff;
  color: #fff;
  padding: 8px 12px;
  border-radius: 4px;
  cursor: pointer;
  display: flex;
  align-items: center;
}

.back-button-container Link:hover {
  background-color: #0056b3;
}

.back-button-container Link i {
  margin-right: 5px;
}
</style>
