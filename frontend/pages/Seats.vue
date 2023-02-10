<script setup>
import { ref } from 'vue'
import fetch from '../utils/fetch'

const seats = ref([])

const fetchGuests = async () => {
  const response = await fetch('/random-matrix', {
    lazy: true,
    server: true,
    immediate: true,
  })

  seats.value = response.data.value
}

const clearGuests = async () => {
  await fetch('/guest-clear', {
    method: 'post',
  })

  fetchGuests()
}

const generateGuests = async () => {
  await fetch('/guest-generate', {
    method: 'post',
  })

  fetchGuests()
}

onMounted(async () => {
  await nextTick(async () => {
    await fetchGuests()
  })
})
const rowLetters = ref(['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J'])
</script>

<template>
  <div class="flex flex-col items-center my-12">
    <div class="flex items-center my-8 place-items-center">
      <button
        class="mx-2 px-4 py-3 text-center text-white bg-blue-400 rounded-md hover:opacity-50"
        @click="generateGuests()"
      >
        Generate Guests
      </button>
      <button
        class="mx-2 px-4 py-3 text-center text-white bg-red-400 rounded-md hover:opacity-50"
        @click="clearGuests()"
      >
        Clear Guests
      </button>
    </div>
    <div class="flex flex-col">
      <div
        v-for="(row, index) in seats"
        :key="index"
        class="flex items-center mt-4"
      >
        <span class="w-6">{{ index + 1 }}</span>
        <div
          v-for="(column, colIndex) in row"
          :key="colIndex"
        >
          <div
            v-if="index === 0"
            class="w-6 mb-3 flex w-full justify-center"
          >
            {{ rowLetters[colIndex] }}
          </div>
          <div class="flex flex-col pl-2 ml-4 w-24 h-16 bg-white border border-gray-300 rounded text-gray-500 shadow-sm">
            <div class="text-sm">
              {{ column.id }}
            </div>
            <div class="truncate bottom-0 text-xs mt-6 tooltip cursor-default">
              {{ column.name }}
              <div class="tooltiptext">
                {{ column.name }}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
/* Tooltip text */
.tooltip .tooltiptext {
  visibility: hidden;
  background-color: black;
  color: #fff;
  text-align: center;
  padding: 5px 3px;
  border-radius: 6px;
  position: absolute;
  z-index: 1;
}

.tooltip:hover .tooltiptext {
  visibility: visible;
}
</style>
