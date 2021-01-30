<template>

    <form @submit="submit">
        <button type="submit" value='submit' class="btn btn-danger btn-sm float-right m-2">Remove</button>
    </form>

</template>

<script>
export default {

    props: {
        itemId: String
    },

    data: function () {
        return {
            status: this.itemId,
        }
    },

    methods: {
        submit(){
            axios.delete('/item/' + this.itemId, {
                 method: 'DELETE',
            })
            .catch(error => {
                if(error.response.status == 401) {
                    window.location = '/login';
                }
            });
        }
    }

}
</script>