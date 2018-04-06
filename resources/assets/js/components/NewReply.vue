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
    import "jquery.caret";
    import "at.js";
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
                    })
                    .catch(error => flash(error.response.data, 'danger'));
            }
        },
        mounted() {
            $('#body').atwho({
                at: "@",
                delay: 750,
                callbacks: {
                    remoteFilter: function(query, callback) {
                        $.getJSON("/api/users", {name: query}, function(usernames) {
                            callback(usernames)
                        });
                    }
                }
            });
        },
        computed: {
            signedIn(){
                return window.App.signedIn;
            }
        }
    }
</script>
