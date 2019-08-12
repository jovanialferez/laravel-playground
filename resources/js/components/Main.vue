<template>
    <div class="row">
        <div class="col-3"></div>
        <div class="col-9">
            <events :events="events"></events>
        </div>
    </div>
</template>

<script>
    import Events from './Events';

    export default {
        components: {
            'events': Events
        },
        props: [],
        data() {
            return {
                events: []
            }
        },
        mounted() {
            this.fetchEvents()
        },
        methods: {
            async fetchEvents() {
                try {
                    let response = await axios.get('/api/events')
                    this.events = response.data.data
                } catch (error) {
                    console.log(error)
                }
            }
        }
    }
</script>

<style scoped>
</style>