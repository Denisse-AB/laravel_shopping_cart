<template>
<div class="w-100">
    <div class="col-md-12 mb-4">
        <h5>{{ user }}</h5>
        <textarea id="textarea" v-model="text" :class="{'form-control' : 'true', 'is-invalid' : errors.comment}" rows="3" type="text" maxlength="300"></textarea>
        <div v-if="errors && errors.comment" class="text-danger">{{ errors.comment[0] }}</div>
        <button @click="submit" class="btn btn-secondary btn-sm m-2 float-right" type="button">Send</button>
    </div>
    <!-- comments -->
    <div v-for="row in commentsData" :key="row.id" class="col-md-12 mt-1">
        <transition
        appear
        mode="out-in"
        enter-active-class="animate__animated animate__fadeIn">
        <!-- animate__slow for duration -->
        <div class="row p-2">
            <h5 class="m-3 font-weight-bold">{{ row.name }}</h5>
            <p class="m-3" @click="Delete">
                {{ row.comment }}
            </p>
            <p class="text-muted m-3">
                {{ row.updated_at }}
            </p>
        </div>
        </transition>
        <div v-if="userId == row.user_id" class="row ml-2">
            <button @click="replyArea(row.id)" class="btn btn-secondary btn-sm m-1 ml-3" type="button" v-text="buttonText"></button>
            <button @click="modal(row.id)" class="btn btn-secondary btn-sm m-1" type="button" data-toggle="modal" data-target="#exampleModal">Edit</button>
            <button @click="Delete(row.id)" class="btn btn-danger btn-sm m-1" type="button">Delete</button>
        </div>
        <div v-else class="row ml-2">
            <button @click="replyArea(row.id)" class="btn btn-secondary btn-sm m-1 ml-3" type="button" v-text="buttonText"></button>
        </div>
        <transition name="slide-fade">
            <div v-show="replyBox" v-if="row.id == rowId" class="row align-items-center mb-2">
                <textarea id="textarea" v-model="replyText" :class="{'form-control w-75 mt-2 ml-3' : 'true', 'is-invalid' : errors.reply}" rows="3" type="text" maxlength="300" placeholder="Reply..."></textarea>
                <button @click="reply(row.id)" class="btn btn-secondary btn-sm h-75 m-1" type="button">Send</button>
                <div v-if="errors && errors.reply" class="text-danger ml-3">{{ errors.reply[0] }}</div>
            </div>
        </transition>
        <!-- replies -->
        <div v-for="replies in repliesData" :key="replies.id" class="row m-1">
            <div v-if="replies.comments_id == row.id" id="reply" class="col-md-12 text-right">
                <h4>{{ replies.name }}</h4>
                <p>{{ replies.reply}}</p>
                <p class="text-muted m-3">
                    {{ replies.updated_at }}
                </p>
                <div v-if="userId == replies.user_id">
                    <button @click="DeleteReply(replies.id)" class="btn btn-danger btn-sm" type="button">Delete</button>
                </div>
            </div>
        </div>
    </div>
        <modal-component v-bind:commentId="commentId"></modal-component>
</div>
</template>

<script>
import ModalComponent from './ModalComponent.vue';

export default {

    props: {
        user: String,
        userId: String,
        itemId: String
    },

    components : {
        ModalComponent
    },

    mounted(){
        this.fetch();
    },

    data(){
        return{
            text: '',
            commentsData: [],
            repliesData: [],
            errors: {},
            commentId: '',
            replyBox: false,
            rowId: '',
            replyText: ''
        }
    },

    methods:{
        //fetch data
        fetch(){
            axios.get(`/comments/${this.itemId}` )
            .then(response => {

                this.commentsData = response.data.comments;

                this.commentsData = _.orderBy(response.data.comments, ['created_at'], ['desc']);

                this.repliesData = response.data.replies;
            })
            .catch(error => {
                alert('Server Error.');
            });
        },

        submit(){
            this.errors = {};
            axios.post(`/comment/${this.itemId}`, {
                comment: this.text,
            })
            .then(response => {

                this.text = '';

                this.fetch();
            })
            .catch(error => {
                if (error.response.status === 422) {
                    this.errors = error.response.data.errors;
                } else {
                    alert('There was an error sending you comment!');
                }
            });
        },

        Delete(row_id){
            axios.delete(`/deleteComment/${row_id}`,{
                method: 'DELETE',
            })
            .then(response => {
                if (response.data == 200) {
                   this.fetch();
                }
            })
            .catch(error => {
                alert('There was an error deleting you comment!');
            });
        },

        modal(row_id){

            this.commentId = row_id;

            this.ModalComponent = true;
        },

        replyArea(row_id){

            this.rowId = row_id;

            this.replyBox = !this.replyBox;
        },

        reply(row_id){
            this.errors = {};
            axios.post(`/reply/${row_id}`, {
                reply: this.replyText,
            })
            .then(response => {

                this.replyText = '';

                this.replyBox = false;

                this.fetch();

            })
            .catch(error => {
                if (error.response.status === 422) {
                    this.errors = error.response.data.errors;
                } else {
                    alert('There was an error sending you comment!');
                }
            });
        },

        DeleteReply(replies_id){
            axios.delete(`/deleteReply/${replies_id}`,{
                method: 'DELETE',
            })
            .then(response => {
                if (response.data == 200) {
                   this.fetch();
                }
            })
            .catch(error => {
                alert('There was an error deleting you comment!');
            });
        }
    },

    computed: {
        buttonText(){
            return (this.replyBox && this.rowId) ? 'Close' : 'Reply';
        }
    }
}
</script>

<style scope>
    .slide-fade-enter-active {
        transition: all .4s ease;
    }
    .slide-fade-leave-active {
        transition: all .3s ease;
    }
    .slide-fade-enter, .slide-fade-leave-to {
        transform: translateX(10px);
        opacity: 0;
}
</style>
