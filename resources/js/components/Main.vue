<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col"><h1>Calendar</h1></div>
        </div>
        <div class="row">
            <div class="col-3">
                <event-form @submit-form="handleOnEventFormSubmit"></event-form>
            </div>
            <div class="col-9">
                <events :events="events"></events>
            </div>
        </div>
    </div>
</template>

<script>
    import Events from './Events'
    import EventForm from './EventForm'

    export default {
        components: {
            'events': Events,
            'event-form': EventForm,
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
            },
            async handleOnEventFormSubmit(data) {
                let postData = []
                for (let date of data.dates) {
                    postData.push({ name: data.name, date: date.format('YYYY-MM-DD')})
                }
                try {
                    await axios.post('/api/events', postData)
                    this.fetchEvents() // or we could just update our data.events for the child component

                    alert('events saved!') // -- very old school! :D
                } catch (error) {
                    console.log(error)
                }
            }
        }
    }
</script>

<style scoped>
</style>