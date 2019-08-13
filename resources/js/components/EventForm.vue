<template>
    <div>
        <form>
            <div class="form-group">
                <label for="name">Event</label>
                <input id="name" name="name" type="text" class="form-control">
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="start-date">From</label>
                    <input id="start-date" name="start-date" type="date" class="form-control">
                </div>
                <div class="form-group col-md-6">
                    <label for="end-date">To</label>
                    <input id="end-date" name="end-date" type="date" class="form-control">
                </div>
            </div>
            <div class="form-check form-check-inline" v-for="day of days" :key="day">
                <input :name="day" type="checkbox" class="form-check-input">
                <label :for="day" class="form-check-label">{{ day }}</label>
            </div>
        </form>
    </div>
</template>

<script>
    export default {
        props: [],
        data: () => ({
            days: ['mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun']
        }),
        mounted() {
        }
    }
</script>

<style lang="scss" scoped>
    .form-check-label {
        text-transform: capitalize;
    }
</style>