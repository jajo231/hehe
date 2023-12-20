<template>
    <NewLayout>
      <Navbar />
      <div class="mx-3">
        <div class="filter-controls-lg flex flex-wrap items-center">
        <div class="flex flex-col md:flex-row items-center md:space-x-2">
            <label class="text-dark font-bold">From:</label>
            <input
                type="date"
                v-model="filter.from_date"
                class="bg-cyan-400 text-dark border-0 rounded-md p-2 focus:ring-2 focus:ring-blue-500"
            />
            </div>
            <div class="flex flex-col md:flex-row items-center md:space-x-2">
                <label class="text-dark font-bold ml-5">To:</label>
                <input
                    type="date"
                    v-model="filter.to_date"
                    class="bg-cyan-400 text-dark border-0 rounded-md p-2 focus:ring-2 focus:ring-blue-500"
                />
            </div>
            <button
                @click="resetFilters"
                class="bg-blue-600 hover:bg-blue-700 ml-5 text-dark font-bold py-1 px-4 rounded-md transition duration-300 ease-in-out transform hover:-translate-y-1"
            >
                Reset
            </button>

        <Link :href="route('games.create')" :active="route().current('ganes.create')" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-md ml-auto mt-4 mr-5 mb-4">
            <i class="fa-solid fa-user-plus"></i>
                <span :hidden="hidden"> Create</span>
        </Link>
        </div>
    </div>



        <GamesView :games="games" />


        <div class="mt-6 flex justify-center" v-if="games.links">
          <nav aria-label="Pagination">
            <ul class="pagination">
              <li class="page-item" v-if="games.links.prev">
              </li>
              <li class="page-item" v-for="page in games.meta.last_page" :key="page" :class="{ active: games.meta.current_page === page }">
                <button class="page-link" @click="paginate(page)">{{ page }}</button>
              </li>
              <li class="page-item" v-if="games.links.next">
              </li>
            </ul>
          </nav>
        </div>
    </NewLayout>
    <div v-if="flash.success" class="flash-message">{{ flash.success }}</div>
  </template>

<script setup>
import NewLayout from '@/Layouts/NewLayout.vue';
import GamesView from '@/Components/GamesView.vue';
import Navbar from '@/Components/Navbar.vue';
import { ref, reactive, onMounted, watchEffect, computed } from 'vue';
import { router, usePage } from '@inertiajs/vue3';
import { Link } from '@inertiajs/vue3';
import { Calendar } from 'v-calendar';


const props = defineProps({
  games: Object,
  filter: Object,
  flash: Object,
});

const filter = reactive({ ...props.filter });
const isMounted = ref(false);

const attributes = computed(() => {
  return props.games.data.map((game) => ({
    key: `game-${game.id}`,
    dates: game.release_date,
    title: game.game_title,
    highlight: 'red',
    popover: {
      label: game.game_title,
      hideIndicator: true,
    },
    order: 0,
  }));
});

const resetFilters = () => {
  filter.from_date = '';
  filter.to_date = '';
  fetchGames();
};

const fetchGames = () => {
  if (isMounted.value) {
    router.visit(route('games.index', { from_date: filter.from_date, to_date: filter.to_date }), {
      preserveState: true,
    });
  }
};

const paginate = (page) => {
  if (isMounted.value) {
    router.visit(route('games.index', { from_date: filter.from_date, to_date: filter.to_date, page }), {
      preserveState: true,
    });
  }
};

onMounted(() => {
  isMounted.value = true;
  fetchGames();
});

watchEffect(() => {
  if (isMounted.value) {
    fetchGames();
  }
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
  animation: flash-message 3s linear;
}

@keyframes flash-message {
  0% {
    opacity: 1;
  }
  90% {
    opacity: 1;
  }
  100% {
    opacity: 0;
    display: none;
  }
}

.pagination {
  display: flex;
  justify-content: center;
  margin-top: 20px;
}

.page-item {
  list-style: none;
  margin: 0 5px;
}

.page-link {
  display: inline-block;
  padding: 8px 12px;
  background-color: #007bff;
  color: #fff;
  border: 1px solid #007bff;
  border-radius: 4px;
  cursor: pointer;
  transition: background-color 0.3s, border-color 0.3s;
}

.page-link:hover {
  background-color: #0056b3;
  border-color: #0056b3;
}

.page-link.active {
  background-color: #0056b3;
  border-color: #0056b3;
}

.page-link.disabled {
  cursor: not-allowed;
  background-color: #ddd;
  color: #777;
  border-color: #ddd;
}
</style>
