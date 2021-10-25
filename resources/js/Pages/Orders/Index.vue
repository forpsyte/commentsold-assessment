<template>
  <div>
    <h1 class="mb-8 font-bold text-3xl">
      <span>Orders</span>
    </h1>
    <div class="mb-6 xl:flex justify-between items-end">
      <search-filter v-model="form.search" class="mb-6 xl:mb-0 w-full max-w-md mr-4" placeholder="Search by SKU or Product..." @reset="reset">
        <label class="block text-gray-700">Status:</label>
        <div class="flex">
          <select v-model="form.status" class="mt-1 w-full form-select">
            <option :value="null" />
            <option value="open">Open</option>
            <option value="pending">Pending</option>
            <option value="paid">Paid</option>
            <option value="shipped">Shipped</option>
            <option value="fulfilled">Fulfilled</option>
          </select>
        </div>
      </search-filter>
      <div class="px-6 py-4 bg-white w-full max-w-md rounded-md shadow">
        <div class="mb-3"><span class="font-bold">Orders: </span>{{ count }} </div>
        <div class="mb-3"><span class="font-bold">Average Sales: </span>${{ sales.average }}</div>
        <div class="mb-3"><span class="font-bold">Total Sales: </span>${{ sales.total }}</div>
      </div>
    </div>
    <div class="bg-white rounded-md shadow overflow-x-auto">
      <table class="w-full whitespace-nowrap">
        <tr class="text-left font-bold">
          <th class="px-6 pt-6 pb-4">Customer</th>
          <th class="px-6 pt-6 pb-4">Email</th>
          <th class="px-6 pt-6 pb-4">Product</th>
          <th class="px-6 pt-6 pb-4">Color</th>
          <th class="px-6 pt-6 pb-4">Size</th>
          <th class="px-6 pt-6 pb-4">Status</th>
          <th class="px-6 pt-6 pb-4">Total</th>
          <th class="px-6 pt-6 pb-4">Transaction ID</th>
          <th class="px-6 pt-6 pb-4">Carrier</th>
          <th class="px-6 pt-6 pb-4">Tracking Number</th>
        </tr>
        <tr v-for="order in orders.data" :key="order.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
          <td class="border-t">
            <div class="px-6 py-4 flex items-center focus:text-indigo-500">
              {{ order.customer_name }}
            </div>
          </td>
          <td class="border-t">
            <div class="px-6 py-4 flex items-center focus:text-indigo-500">
              {{ order.email }}
            </div>
          </td>
          <td class="border-t">
            <div class="px-6 py-4 flex items-center focus:text-indigo-500">
              {{ order.product_name }}
            </div>
          </td>
          <td class="border-t">
            <div class="px-6 py-4 flex items-center focus:text-indigo-500">
              {{ order.color }}
            </div>
          </td>
          <td class="border-t">
            <div class="px-6 py-4 flex items-center focus:text-indigo-500">
              {{ order.size }}
            </div>
          </td>
          <td class="border-t">
            <div class="px-6 py-4 flex items-center focus:text-indigo-500">
              {{ order.status }}
            </div>
          </td>
          <td class="border-t">
            <div class="px-6 py-4 flex items-center focus:text-indigo-500">
              ${{ order.total }}
            </div>
          </td>
          <td class="border-t">
            <div class="px-6 py-4 flex items-center focus:text-indigo-500">
              {{ order.transaction_id }}
            </div>
          </td>
          <td class="border-t">
            <div class="px-6 py-4 flex items-center focus:text-indigo-500">
              {{ order.carrier }}
            </div>
          </td>
          <td class="border-t">
            <div class="px-6 py-4 flex items-center focus:text-indigo-500">
              {{ order.tracking_number }}
            </div>
          </td>
        </tr>
        <tr v-if="orders.data.length === 0">
          <td class="border-t px-6 py-4" colspan="4">No orders found.</td>
        </tr>
      </table>
    </div>
    <pagination class="mt-6" :links="orders.links" />
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
  metaInfo: {title: 'Orders'},
  components: {
    TextInput,
    Pagination,
    SearchFilter,
  },
  layout: Layout,
  props: {
    orders: Object,
    count: Number,
    sales: Object,
    filters: Object,
  },
  data() {
    return {
      form: {
        search: this.filters.search,
        status: this.filters.status,
      },
    }
  },
  watch: {
    form: {
      deep: true,
      handler: throttle(function() {
        this.$inertia.get(this.route('orders'), pickBy(this.form), { preserveState: true })
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
