<template>
    <vue-cal
        ref="vuecal"
        hide-title-bar
        :time-from="0 * 60"
        :time-to="23 * 60"
        :snap-to-time="15"
        :disable-views="['years', 'year', 'month', 'week']"
        :editable-events="{
            title: true,
            drag: true,
            resize: true,
            delete: true,
            create: true,
        }"
        :drag-to-create-threshold="15"
        :cell-click-hold="false"
        :drag-to-create-event="false"
        editable-events
        :split-days="splitDays"
        :sticky-split-labels="stickySplitLabels"
        :min-cell-width="minCellWidth"
        :min-split-width="minSplitWidth"
        @cell-click="createEventInSplit"
        @cell-dblclick="handleCelldblClick"
    >
    </vue-cal>
    <br />
    <br />
    <br />
    <br />
    <br />
    <br />
    <br />
    <vue-cal
        ref="vuecal2"

        selected-date="2018-11-19"
        :time-from="8 * 60"
        :time-step="30"
        :disable-views="['years', 'year', 'month']"
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
                { id: 1, class: "mom", label: "Mom" },
                { id: 2, class: "dad", label: "Dad", hide: false },
                { id: 3, class: "kid1", label: "Kid 1" },
                { id: 4, class: "kid2", label: "Kid 2" },
                { id: 5, class: "kid3", label: "Kid 3" },
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
    background-color: #007bff;
    color: white;
}
</style>
