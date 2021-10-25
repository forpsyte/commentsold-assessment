<template>
  <div>
    <h1 class="mb-8 font-bold text-3xl">
      <span>Inventory</span>
    </h1>
    <div class="mb-6 flex justify-between items-center">
      <search-filter v-model="form.search" class="w-full max-w-md mr-4" placeholder="Search by SKU or Product ID..." @reset="reset">
        <label class="block text-gray-700">Quantity:</label>
        <div class="flex">
          <select v-model="form.threshold" class="mt-1 w-1/2 form-select">
            <option :value="null" />
            <option value="lower">Less than</option>
            <option value="upper">More than</option>
          </select>
          <text-input v-model="form.quantity" class="mt-1 ml-2 w-1/4" />
        </div>
      </search-filter>
      <span>({{ count }} Items)</span>
    </div>
    <div class="bg-white rounded-md shadow overflow-x-auto">
      <table class="w-full whitespace-nowrap">
        <tr class="text-left font-bold">
          <th class="px-6 pt-6 pb-4">Name</th>
          <th class="px-6 pt-6 pb-4">Sku</th>
          <th class="px-6 pt-6 pb-4">Quantity</th>
          <th class="px-6 pt-6 pb-4">Color</th>
          <th class="px-6 pt-6 pb-4">Size</th>
          <th class="px-6 pt-6 pb-4">Price</th>
          <th class="px-6 pt-6 pb-4">Cost</th>
        </tr>
        <tr v-for="inventory in inventories.data" :key="inventory.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
          <td class="border-t">
            <div class="px-6 py-4 flex items-center focus:text-indigo-500">
              {{ inventory.name }}
            </div>
          </td>
          <td class="border-t">
            <div class="px-6 py-4 flex items-center focus:text-indigo-500">
              {{ inventory.sku }}
            </div>
          </td>
          <td class="border-t">
            <div class="px-6 py-4 flex items-center focus:text-indigo-500">
              {{ inventory.quantity }}
            </div>
          </td>
          <td class="border-t">
            <div class="px-6 py-4 flex items-center focus:text-indigo-500">
              {{ inventory.color }}
            </div>
          </td>
          <td class="border-t">
            <div class="px-6 py-4 flex items-center focus:text-indigo-500">
              {{ inventory.size }}
            </div>
          </td>
          <td class="border-t">
            <div class="px-6 py-4 flex items-center focus:text-indigo-500">
              ${{ inventory.price }}
            </div>
          </td>
          <td class="border-t">
            <div class="px-6 py-4 flex items-center focus:text-indigo-500">
              ${{ inventory.cost }}
            </div>
          </td>
        </tr>
        <tr v-if="inventories.data.length === 0">
          <td class="border-t px-6 py-4" colspan="4">No inventory found.</td>
        </tr>
      </table>
    </div>
    <pagination class="mt-6" :links="inventories.links" />
  </div>
</template>

<script>
import pickBy from 'lodash/pickBy'
import Layout from '@/Shared/Layout'
import throttle from 'lodash/throttle'
import mapValues from 'lodash/mapValues'
import TextInput from '@/Shared/TextInput'
import Pagination from '@/Shared/Pagination'
import SearchFilter from '@/Shared/SearchFilter'

export default {
  metaInfo: {title: 'Inventory'},
  components: {
    TextInput,
    Pagination,
    SearchFilter,
  },
  layout: Layout,
  props: {
    inventories: Object,
    count: Number,
    filters: Object,
  },
  data() {
    return {
      form: {
        search: this.filters.search,
        quantity: this.filters.quantity,
        threshold: this.filters.threshold,
      },
    }
  },
  watch: {
    form: {
      deep: true,
      handler: throttle(function() {
        this.$inertia.get(this.route('inventory'), pickBy(this.form), { preserveState: true })
      }, 150),
    },
  },
  methods: {
    reset() {
      this.form = mapValues(this.form, () => null)
    },
  },
}
</script>
