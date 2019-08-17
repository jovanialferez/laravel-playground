<template>
    <div>
        <form @submit.prevent="submitForm">
            <div class="form-group">
                <label for="name">Event</label>
                <input v-model="event.name" id="name" name="name" type="text" class="form-control">
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="start-date">From</label>
                    <input v-model="event.startDate" id="start-date" name="start-date" type="date" class="form-control">
                </div>
                <div class="form-group col-md-6">
                    <label for="end-date">To</label>
                    <input v-model="event.endDate" id="end-date" name="end-date" type="date" class="form-control">
                </div>
            </div>
            <div class="form-check form-check-inline" v-for="day of days" :key="day">
                <input v-model="event.daysOfTheWeek" :name="day" :value="day" type="checkbox" class="form-check-input">
                <label :for="day" class="form-check-label">{{ day }}</label>
            </div>
            <button type="submit">Save</button>
        </form>
    </div>
</template>

<script>
    export default {
        props: [],
        data: () => ({
            days: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'], // to match date format `ddd`
            event: {
                name: '',
                startDate: null,
                endDate: null,
                daysOfTheWeek: [],
            }
        }),
        methods: {
            // @TODO validations; for now, we will leave validation and assume minimum fields required are filled up
            submitForm() {
                let dates = []
                // Loop thru dates and capture those with day-of-the-week ticked
                for (let current = moment(this.event.startDate); current.isBefore(this.event.endDate); current.add(1, 'days')) {
                    // Did we ticked it?
                    if (this.event.daysOfTheWeek.includes(current.format('ddd')) === false) continue

                    // have to clone a copy of `current`
                    dates.push(moment(current))
                }
                this.$emit('submit-form', { name: this.event.name, dates })
            }
        }
    }
</script>

<style lang="scss" scoped>
</style>