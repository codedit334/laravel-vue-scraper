<template>
    <div>
        <!-- Dropdown to select between Sportma and Manager -->
        <div class="user-selection">
            <label for="user">Select User:</label>
            <select v-model="selectedUser">
                <option value="sportma">Sportma</option>
                <option value="manager">Manager</option>
            </select>
        </div>

        <vue-cal
            ref="vuecal2"
            class="vuecal--green-theme"    
            style="height: 500px; margin-top: 80px"
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
    </div>
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
            selectedUser: 'sportma', // Default selected user
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
                { id: 1, class: "Tennis", label: "Tennis court 1" },
                { id: 2, class: "Tennis", label: "Tennis court 2", hide: false },
                { id: 3, class: "Tennis", label: "Tennis court 3" },
            ],
        };
    },
    methods: {
        createEventInSplit(event) {
            if (event.split) {
                const split = this.splitDays.find(
                    (split) => split.id === event.split
                );

                // Determine the class based on selected user
                let eventClass = this.selectedUser === 'sportma' ? 'blue-event' : 'green-event';

                // Create the new event in the correct split with the selected class
                this.$refs.vuecal2.createEvent(event.date, 120, {
                    title: `New Reservation`,
                    class: eventClass, // Dynamic class
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
/* Styles for the two different user types */
.blue-event {
    background-color: lightblue;
    color: white;
}

.green-event {
    background-color: lightgreen;
    color: white;
}

/* Dropdown styling */
.user-selection {
    margin-bottom: 10px;
}
</style>
