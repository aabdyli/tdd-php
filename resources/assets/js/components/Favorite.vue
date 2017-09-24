<template>
    <button type="submit" :class="classes" @click="toggle">
        <span class="glyphicon glyphicon-heart"></span>
        <span v-text="favoritesCount"></span>
    </button>
</template>

<script>
    export default {
        props: ['reply'],

        data() {
            return {
                favoritesCount: this.reply.favoritesCount,
                active: this.reply.isFavorited
            };
        },

        methods: {
            toggle() {
                return this.active ? this.destroy() : this.create();
            },
            create() {
                axios.post(this.endpoint);
                this.active = true;
                this.favoritesCount++;
            },
            destroy() {
                axios.delete(this.endpoint);
                this.active = false;
                this.favoritesCount--;
            }
        },

        computed: {
            classes() {
                return [
                    'btn',
                    this.active ? 'btn-primary' : 'btn-default'
                ];
            },
            endpoint() {
                return '/replies/' + this.reply.id + '/favorites';
            }
        },
    }
</script>
