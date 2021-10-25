<template>
  <div>
    <h1 class="mb-8 font-bold text-3xl">
      <inertia-link class="text-indigo-400 hover:text-indigo-600" :href="route('products')">Products</inertia-link>
      <span class="text-indigo-400 font-medium">/</span> Create
    </h1>
    <div class="bg-white rounded-md shadow overflow-hidden max-w-3xl">
      <form @submit.prevent="save">
        <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
          <text-input v-model="form.product_name" :error="form.errors.product_name" class="pr-6 pb-8 w-full lg:w-full" label="Name" />
          <textarea-input v-model="form.description" :error="form.errors.description" class="pr-6 pb-8 w-full lg:w-full" label="Description" />
          <text-input v-model="form.style" :error="form.errors.style" class="pr-6 pb-8 w-full lg:w-full" label="Style" />
          <text-input v-model="form.brand" :error="form.errors.brand" class="pr-6 pb-8 w-full lg:w-full" label="Brand" />
          <text-input v-model="form.url" :error="form.errors.url" class="pr-6 pb-8 w-full lg:w-full" label="Url" />
          <text-input v-model="form.product_type" :error="form.errors.product_type" class="pr-6 pb-8 w-full lg:w-full" label="Product Type" />
          <text-input v-model="form.shipping_price" :error="form.errors.shipping_price" class="pr-6 pb-8 w-full lg:w-full" label="Shipping Price" />
          <text-input v-model="form.note" :error="form.errors.note" class="pr-6 pb-8 w-full lg:w-full" label="Note" />
        </div>
        <div class="px-8 py-4 bg-gray-50 border-t border-gray-100 flex items-center">
          <loading-button :loading="form.processing" class="btn-indigo ml-auto" type="submit">Create Product</loading-button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import Layout from '@/Shared/Layout'
import TextInput from '@/Shared/TextInput'
import TextareaInput from '@/Shared/TextareaInput'
import LoadingButton from '@/Shared/LoadingButton'

export default {
  metaInfo: {title: 'Create Product'},
  components: {
    TextInput,
    TextareaInput,
    LoadingButton,
  },
  layout: Layout,
  remember: 'form',
  data() {
    return {
      form: this.$inertia.form({
        product_name: null,
        description: null,
        style: null,
        brand: null,
        url: null,
        product_type: null,
        shipping_price: null,
        note: null,
      }),
    }
  },
  methods: {
    save() {
      this.form.post(this.route('products.save'))
    },
  },
}

</script>
