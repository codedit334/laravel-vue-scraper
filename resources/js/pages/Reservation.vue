<template>
    <vue-cal
        ref="vuecal2"
        class="vuecal--green-theme"    
        style="height: 500px;margin-top: 80px"
        :time-from="8 * 60"
        :time-step="30"
        :disable-views="['years', 'week']"
        :drag-to-create-event="false"
        show-time-in-cells
        :snap-to-time="15"
        editable-events
        :events="events"
        :split-days="splitDays"
        :sticky-split-labels="stickySplitLabels"
        :min-cell-width="minCellWidth"
        :min-split-width="minSplitWidth"
        @cell-click="createEventInSplit"
    >
    </vue-cal>
</template>

<script>
import VueCal from "vue-cal";
import "vue-cal/dist/vuecal.css";

export default {
    components: {
        VueCal,
    },
    data() {
        return {
            resources: [
                { id: "tennis", label: "Tennis" },
                { id: "padel", label: "Padel" },
                { id: "football", label: "Football" },
            ],
            events: [],
            stickySplitLabels: true,
            minCellWidth: 400,
            minSplitWidth: 300,
            splitDays: [
                // The id property is added automatically if none (starting from 1), but you can set a custom one.
                // If you need to toggle the splits, you must set the id explicitly.
                { id: 1, class: "Tennis", label: "Tennis" },
                { id: 2, class: "Padel", label: "Padel", hide: false },
                { id: 3, class: "Football", label: "Football" },
            ],
        };
    },
    methods: {
        createEventInSplit(event) {
            if (event.split) {
                // Find the split where the event is created
                const split = this.splitDays.find(
                    (split) => split.id === event.split
                );

                // Create the new event in the correct split
                this.$refs.vuecal2.createEvent(event.date, 120, {
                    title: `New Event`,
                    class: "blue-event",
                    split: event.split, // Assign event to the correct split
                });
                console.log(event);
            }
        },
        createBooking({ start, end, resource }) {
            console.log(end, start, resource);
        },
        handleCellClick(event) {},
        handleCelldblClick(event) {
            console.log(event);
        },
    },
};
</script>

<style>
.blue-event {
    background-color: lightgreen;
    color: white;
}
</style>
