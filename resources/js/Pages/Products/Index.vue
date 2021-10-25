<template>
  <div>
    <h1 class="mb-8 font-bold text-3xl">Products</h1>
    <div class="mb-6 grid justify-items-end">
      <inertia-link class="btn-indigo" :href="route('products.create')">
        <span>Create</span>
        <span class="hidden md:inline">Product</span>
      </inertia-link>
    </div>
    <div class="bg-white rounded-md shadow overflow-x-auto">
      <table class="w-full whitespace-nowrap">
        <tr class="text-left font-bold">
          <th class="px-6 pt-6 pb-4">Name</th>
          <th class="px-6 pt-6 pb-4">Style</th>
          <th class="px-6 pt-6 pb-4">Brand</th>
          <th class="px-6 pt-6 pb-4">Available Skus</th>
        </tr>
        <tr v-for="product in products.data" :key="product.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
          <td class="border-t">
            <inertia-link class="px-6 py-4 flex items-center focus:text-indigo-500" :href="route('products.edit', product.id)">
              {{ product.name }}
            </inertia-link>
          </td>
          <td class="border-t">
            <inertia-link class="px-6 py-4 flex items-center" :href="route('products.edit', product.id)" tabindex="-1">
              {{ product.style }}
            </inertia-link>
          </td>
          <td class="border-t">
            <inertia-link class="px-6 py-4 flex items-center" :href="route('products.edit', product.id)" tabindex="-1">
              {{ product.brand }}
            </inertia-link>
          </td>
          <td class="border-t">
            <inertia-link class="px-6 py-4 flex items-center" :href="route('products.edit', product.id)" tabindex="-1">
              {{ product.skus }}
            </inertia-link>
          </td>
          <td class="border-t w-px">
            <inertia-link class="px-4 flex items-center" :href="route('products.edit', product.id)" tabindex="-1">
              <icon name="cheveron-right" class="block w-6 h-6 fill-gray-400" />
            </inertia-link>
          </td>
        </tr>
        <tr v-if="products.data.length === 0">
          <td class="border-t px-6 py-4" colspan="4">No products found.</td>
        </tr>
      </table>
    </div>
    <pagination class="mt-6" :links="products.links" />
  </div>
</template>
<script>
import Icon from '@/Shared/Icon'
import Layout from '@/Shared/Layout'
import Pagination from '@/Shared/Pagination'

export default {
  metaInfo: {title: 'Products'},
  components: {
    Icon,
    Pagination
  },
  layout: Layout,
  props: {
    products: Object,
  },
}
</script>
