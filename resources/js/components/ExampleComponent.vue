<template>
  <div>
    <button type='button' name="plus" @click="increment()" class='btn bg-light border rounded-circle'><i class='fas fa-plus'></i></button>
    <input type='text' name="quantity" id="qty" class='form-control d-inline' v-bind:value="quantity" style="width:50px;" disabled>
    <button type='button' name="minus" @click="decrement()" class='btn bg-light border rounded-circle'><i class='fas fa-minus'></i></button>
  </div>
</template>

<script>
export default {
  data () {
    return {
      quantity: 1
    }
  },
  methods: {
    increment () {
      if (this.quantity >= 10) {
        alert('Only 10 items per purchase.')
      } else {
        this.quantity++
      }
    },
    decrement () {
      if(this.quantity === 1) {
        alert('Negative quantity not allowed')
      } else {
        this.quantity--
      }
    }
  }
}

</script>

