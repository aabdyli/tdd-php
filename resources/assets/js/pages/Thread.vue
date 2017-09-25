<script>
    import Replies from '../components/Replies.vue';
    export default {
        props: [ 'initialReplyCount' ],
        components: { Replies },
        data() {
            return {
                repliesCount: this.initialReplyCount,
            }
        }
    }
</script>
