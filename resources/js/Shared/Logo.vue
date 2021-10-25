<template>
  <img :src="image" alt="Logo" />
</template>

<script>
import image from './../../img/cs-logo.png'

export default {
  data: function () {
    return {
      image: image,
    }
  },
}
</script>
