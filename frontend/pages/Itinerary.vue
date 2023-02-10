<script setup>
import { ref } from 'vue'
import { Dialog, DialogPanel, DialogTitle, Menu, MenuButton, MenuItem, MenuItems, TransitionChild, TransitionRoot } from '@headlessui/vue'
import { ChevronDownIcon } from '@heroicons/vue/20/solid'
import { CheckIcon } from '@heroicons/vue/24/outline'
import fetch from '../utils/fetch'

const pass = ref(false)
const open = ref(false)
const items = ref([])
const packageItem = ref('package_1')
const guestId = ref(0)
const guestName = ref('')
const companions = ref(0)
const concertPass = ref({})

const fetchItems = async () => {
  const response = await fetch('/guest-packages')

  items.value = response.data.value
}

const handlePackageItem = (item) => {
  packageItem.value = item
}

const viewPass = () => {
  open.value = false
  pass.value = true

  concertPass.value = {
    guest_id: guestId,
    name: guestName.value,
    companions: companions.value,
    package_name: packageItem.value,
  }
}

const book = async () => {
  const response = await fetch('/guest', {
    method: 'post',
    params: {
      name: guestName.value,
      companions: companions.value,
      package_id: `${packageItem.value.replace(/^\D+/g, '')}`,
    },
  })

  guestId.value = response.data.value.id
  open.value = true
}

onMounted(async () => {
  await nextTick(async () => {
    await fetchItems()
  })
})
</script>

<template>
  <div>
    <TransitionRoot
      as="template"
      :show="open"
    >
      <Dialog
        v-show="open"
        as="div"
        class="relative z-10"
        @close="open = false"
      >
        <TransitionChild
          as="template"
          enter="ease-out duration-300"
          enter-from="opacity-0"
          enter-to="opacity-100"
          leave="ease-in duration-200"
          leave-from="opacity-100"
          leave-to="opacity-0"
        >
          <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" />
        </TransitionChild>

        <div class="fixed inset-0 z-10 overflow-y-auto">
          <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <TransitionChild
              as="template"
              enter="ease-out duration-300"
              enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
              enter-to="opacity-100 translate-y-0 sm:scale-100"
              leave="ease-in duration-200"
              leave-from="opacity-100 translate-y-0 sm:scale-100"
              leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            >
              <DialogPanel class="relative transform overflow-hidden rounded-lg bg-white px-4 pt-5 pb-4 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-sm sm:p-6">
                <div>
                  <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-green-100">
                    <CheckIcon
                      class="h-6 w-6 text-green-600"
                      aria-hidden="true"
                    />
                  </div>
                  <div class="mt-3 text-center sm:mt-5">
                    <DialogTitle
                      as="h3"
                      class="text-lg font-medium leading-6 text-gray-900"
                    >
                      Yey!
                    </DialogTitle>
                    <div class="mt-2">
                      <p class="text-sm text-gray-500">
                        Your seat reservation for the concert was successful.
                      </p>
                    </div>
                  </div>
                </div>
                <div class="mt-5 sm:mt-6">
                  <button
                    type="button"
                    class="inline-flex w-full justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:text-sm"
                    @click="viewPass()"
                  >
                    View Pass
                  </button>
                </div>
              </DialogPanel>
            </TransitionChild>
          </div>
        </div>
      </Dialog>
    </TransitionRoot>
    <div
      v-if="pass"
      class="max-w-3xl bg-gray-50 text-gray-700 border border-gray-300 px-10 py-8 mx-auto mt-20 rounded z-0"
    >
      <div class="flex flex-col">
        <div class="flex w-full justify-center text-2xl">
          Concert Pass
        </div>
        <div>
          <div class="mt-8 flex flex-col">
            <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
              <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                  <table class="min-w-full divide-y divide-gray-300">
                    <thead class="bg-gray-50">
                      <tr>
                        <th
                          scope="col"
                          class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6"
                        >
                          Guest ID
                        </th>
                        <th
                          scope="col"
                          class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"
                        >
                          Guest Name
                        </th>
                        <th
                          scope="col"
                          class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"
                        >
                          Companions
                        </th>
                        <th
                          scope="col"
                          class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"
                        >
                          Package Name
                        </th>
                      </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                      <tr>
                        <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                          {{ concertPass.guest_id }}
                        </td>
                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-900">
                          {{ concertPass.name }}
                        </td>
                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-900">
                          {{ concertPass.companions }}
                        </td>
                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-900">
                          {{ concertPass.package_name }}
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div
      v-else
      class="max-w-3xl bg-gray-50 text-gray-700 border border-gray-300 px-10 py-8 mx-auto mt-20 rounded z-0"
    >
      <div class="flex">
        <div class="w-1/3 flex flex-col">
          <span class="text-xl">Book a seat</span>
          <span class="text-sm text-gray-500">Fill the form to book a seat/s</span>
        </div>
        <div class="ml-10 w-2/3">
          <div class="flex flex-col">
            <label
              class="text-sm text-gray-600"
              for="guest_name"
            >Guest Name*</label>
            <input
              id="guest_name"
              v-model="guestName"
              type="text"
              class="px-2 py-2.5 border border-gray-200 rounded mt-2"
            >
          </div>
          <div class="flex flex-col mt-4">
            <label
              class="text-sm text-gray-600"
              for="number_of_companions"
            >Number of Companions*</label>
            <input
              id="number_of_companions"
              v-model="companions"
              type="text"
              class="px-2 py-2.5 border border-gray-200 rounded mt-2"
            >
          </div>
          <div class="flex flex-col mt-4 w-1/2">
            <span
              class="text-sm text-gray-600"
              for="number_of_companions"
            >Packages*</span>
            <Menu
              as="div"
              class="relative inline-block text-left"
            >
              <div>
                <MenuButton class="flex justify-between items-center px-2 py-2.5 border border-gray-200 rounded mt-2 w-full">
                  <span class="text-sm">{{ packageItem }}</span>
                  <ChevronDownIcon
                    class="-mr-1 ml-2 h-5 w-5"
                    aria-hidden="true"
                  />
                </MenuButton>
              </div>

              <transition
                enter-active-class="transition ease-out duration-100"
                enter-from-class="transform opacity-0 scale-95"
                enter-to-class="transform opacity-100 scale-100"
                leave-active-class="transition ease-in duration-75"
                leave-from-class="transform opacity-100 scale-100"
                leave-to-class="transform opacity-0 scale-95"
              >
                <MenuItems class="absolute left-0 z-20 mt-2 w-56 origin-top-right rounded-md shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
                  <div
                    v-for="(item, index) in items"
                    :key="index"
                  >
                    <MenuItem
                      v-slot="{ active }"
                      @click="handlePackageItem(item.name)"
                    >
                      <a
                        href="#"
                        class="block px-4 py-2 text-sm"
                        :class="[active ? 'bg-gray-100 text-gray-900' : 'bg-gray-50 text-gray-700']"
                      >{{ item.name }}</a>
                    </MenuItem>
                  </div>
                </MenuItems>
              </transition>
            </Menu>
          </div>
        </div>
      </div>
      <div class="border border-t-0 border-gray-200 mt-8" />
      <div>
        <div class="flex justify-end mt-8">
          <button
            class="px-4 py-2 bg-indigo-500 text-white rounded hover:opacity-60"
            @click="book()"
          >
            Book
          </button>
        </div>
      </div>
    </div>
  </div>
</template>
