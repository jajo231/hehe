<template>
    <div class="game-list">
      <div class="game-card" v-for="game in games.data" :key="game.id">
        <div class="game-image">
            <img :src="getImageUrl(game)" alt="Game Cover" class="fixed-image">
        </div>
        <div class="game-details">
          <h2 class="game-title">{{ game.name }}</h2>
          <div class="info-item">
            <span class="info-label">Primary Attribute: </span>
            <span class="info-value">{{ game.attribute.name }}</span>
          </div>
          <div class="info-item">
            <span class="info-label">Type: </span>
            <span class="info-value">{{ game.type }}</span>
          </div>
          <div class="info-item">
            <span class="info-label">Release Date: </span>
            <span class="info-value">{{ formatDate(game.release_date) }}</span>
          </div>
          <p class="game-description">{{ game.description }}</p>
        </div>
        <div class="button-container">
            <Link :href="`/games/edit/${game.id}`" class="text-green font-bold py-2 px-4 rounded-md mt-4 mb-4">
            <i class="fa-regular fa-pen-to-square"></i>
            </Link>
        <button class="delete-button" @click="deleteGame(game)"><i class="fa-solid fa-user-xmark"></i></button>
      </div>
      </div>
    </div>
    <div v-if="successMessage" class="flash-message">{{ successMessage }}</div>
  </template>

<script setup>
import { defineProps, ref, onMounted } from 'vue';
import axios from 'axios';
import { useRoute } from 'vue-router';
import { Inertia } from '@inertiajs/inertia-vue3';
import { Link } from '@inertiajs/vue3';


const props = defineProps({
  games: Object,
  game: Object,
});

const getImageUrl = (game) => {
  return game.image.startsWith('http') ? game.image : `/storage/${game.image}`;
};

const formatDate = (dateString) => {
  const options = { year: 'numeric', month: 'long', day: 'numeric' };
  return new Date(dateString).toLocaleDateString(undefined, options);
};

const successMessage = ref('');

const route = useRoute();

const deleteGame = (game) => {
  if (confirm(`Are you sure you want to delete ${game.name}?`)) {
    axios
      .delete(`/games/${game.id}`)
      .then((response) => {
        if (response.status === 200) {
          successMessage.value = `Successful removing hero - ${game.name}`;
          // Reload the page using Inertia.js's Inertia.reload()
          Inertia.reload();
        } else {
          console.error('Deletion failed.');
        }
      })
      .catch((error) => {
        console.error('Error deleting game:', error);
      });
  }
};

onMounted(() => {
});
</script>

  <style scoped>
.flash-message {
  background-color: #4CAF50;
  color: white;
  text-align: center;
  padding: 10px;
  position: fixed;
  bottom: 20px;
  right: 20px;
  border-radius: 5px;
  z-index: 9999;
}

  .game-list {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    justify-content: center;
    padding: 20px;
  }

  .game-card {
    background-color: #fff;
    border: 1px solid #ddd;
    border-radius: 5px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    cursor: pointer;
    overflow: hidden;
    transition: transform 0.2s;
    max-width: 300px;
    display: flex;
    flex-direction: column;
    position: relative;
  }

  .button-container {
  position: absolute;
  bottom: 0;
  right: 0;
  margin: 10px;
    }

    .edit-button {
    margin-right: 5px;
    }

    .delete-button {
    color: red;
    border: none;
    cursor: pointer;
    }
  .game-card:hover {
    transform: translateY(-5px);
  }

  .game-image {
    overflow: hidden;
    height: 200px; /* Set a fixed height for all images */
    text-align: center; /* Center the image vertically */
    display: flex;
    justify-content: center; /* Center the image horizontally */
  }

  .fixed-image {
    width: 100%; /* Make the image take up the entire space */
    height: 100%; /* Make the image take up the entire space */
    object-fit: cover;
  }

  .game-details {
    padding: 15px;
    text-align: left;
  }

  .game-title {
    font-size: 18px;
    font-weight: bold;
    margin-bottom: 10px;
  }

  .info-item {
    margin-bottom: 5px;
  }

  .info-label {
    font-weight: bold;
  }

  .info-value {
    color: #555;
  }

  .game-description {
    font-size: 14px;
    color: #777;
    margin-top: 10px;
  }

  .w-full {
    width: 100%;
  }

  </style>
