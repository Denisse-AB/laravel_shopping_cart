<template>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="false">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Your Comment</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <textarea id="textarea" v-model="text" :class="{'form-control' : 'true', 'is-invalid' : errors.text}" rows="3" type="text" maxlength="300"></textarea>
            <div v-if="errors && errors.text" class="text-danger">{{ errors.text[0] }}</div>
      </div>
      <div class="modal-footer">
        <button @click="edit" type="button" class="btn btn-secondary btn-sm">Edit</button>
      </div>
    </div>
  </div>
</div>
</template>

<script>
export default {

    props: {
      commentId: Number
    },

    data(){
        return {
          text: '',
          errors:{}
        }
    },

    methods:{
        edit(){
          this.errors = {};
            axios.patch('/update/' + this.commentId,{
                method: 'PATCH',
                text: this.text,

            }).then(response => {
                if (response.data == 200) {
                   this.text = '';
                   window.location.reload();
                }
            }).catch(error => {
                if (error.response.status === 422) {
                    this.errors = error.response.data.errors;
                } else {
                    alert('There was an error editing your comment!');
                }
            });

        }
    }

}
</script>

<style scoped>
 .modal-body{
   background-color: #f2f2f2;
 }
</style>