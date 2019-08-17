<template>
    <div>
        <div class="dates" v-for="(day, index) in calendarDates" :key="index">
            <h1 v-if="day.isFirstDay">{{ day.date.format('MMM YYYY') }}</h1>
            <div class="row" :class="{ 'bg-success': day.event }">
                <div class="col-3">
                    {{ day.date.format('D ddd') }}
                </div>
                <div class="col-9">
                    {{ day.event ? day.event.name : '' }}
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['events'],
        data: () => ({
            startingDate: moment().startOf('month'),
            endingDate: moment().endOf('month'),
            calendarDates: [],
        }),
        watch: {
            events(data) {
                if (data.length === 0) return
                
                this.calendarDates = [];
                // As events from api are expected to be ordered oldest schedule first,
                // lets take the first event as basis of starting date for the calendar
                this.startingDate = moment(data[0].date).startOf('month')

                // And the last element for the ending date
                this.endingDate = moment(data[data.length -1].date).endOf('month')

                for (let current = moment(this.startingDate); current.isBefore(this.endingDate); current.add(1, 'days')) {
                    const eventForTheDay = data.find(ev => ev.date === current.format('YYYY-MM-DD'))
                    // have to clone a copy of `current`
                    this.calendarDates.push({
                        date: moment(current),
                        event: eventForTheDay,
                        isFirstDay: current.format('D') === '1'
                    })
                }
            }
        },
        mounted() {
            for (let current = moment(this.startingDate); current.isBefore(this.endingDate); current.add(1, 'days')) {
                // have to clone a copy of `current`
                this.calendarDates.push({
                    date: moment(current),
                    event: null,
                    isFirstDay: current.format('D') === '1'
                })
            }
        }
    }
</script>

<style lang="scss" scoped>
    .dates {
        border-bottom: 1px solid #cccccc;
        .row {
            min-height: 50px;
        }
    }
</style>