<template>

    <form>
        <button type="submit" @click="submit" class="btn btn-danger btn-sm float-right m-2">Remove</button>
    </form>

</template>

<script>
export default {

    props: {
        itemId: String
    },

    mounted() {
        console.log('Component mounted.')
    },

    data: function () {
        return {
            status: this.itemId,
        }
    },

    methods: {
        submit(){
            axios.delete('/wishlist/' + this.itemId, {
                method: 'DELETE',
            })
            .catch((error) => {
                if(error.response.status==401) {
                  window.location='/login';
                }
            });
        }
    }
}
</script>