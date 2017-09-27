<template>
<div>
    <div v-if="signedIn">
        <div class="form-group">
            <label for="body">
                Leave a reply
            </label>
            <textarea
                name="body"
                id="body"
                cols="30"
                rows="5"
                class="form-control"
                placeholder="Add your thought"
                v-model="body">
            </textarea>
        </div>
        <div class="form-group">
            <button
                type="submit"
                class="btn btn-default"
                @click="addReply">Post</button>
        </div>
    </div>
    <p class="text-center" v-else>Please <a href="/login">Log in</a> to participate in the forum</p>
</div>
</template>

<script>
    export default {
        data() {
            return {
                body: '',
            };
        },
        methods: {
            addReply() {
                axios.post(location.pathname + '/replies', { body: this.body})
                    .then(response => {
                        this.body = '';
                        flash('Your reply has been posted');
                        this.$emit('created', response.data)
                    });
            }
        },
        computed: {
            signedIn(){
                return window.App.signedIn;
            }
        }
    }
</script>
