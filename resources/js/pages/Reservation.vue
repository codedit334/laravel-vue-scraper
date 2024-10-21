<template>
  <div style="margin-top: 100px">
    <!-- Dropdown to select between Sportma and Manager -->
    <div class="user-selection">
      <label for="user">Select User:</label>
      <select v-model="selectedUser">
        <option value="sportma">Sportma</option>
        <option value="manager">Manager</option>
      </select>
    </div>

    <!-- Radio buttons for selecting sport -->
    <div class="sport-selection">
      <label>
        <input
          type="radio"
          v-model="selectedSport"
          value="football"
          @change="updateSplitDays"
        />
        Football
      </label>
      <label>
        <input
          type="radio"
          v-model="selectedSport"
          value="padel"
          @change="updateSplitDays"
        />
        Padel
      </label>
      <label>
        <input
          type="radio"
          v-model="selectedSport"
          value="tennis"
          @change="updateSplitDays"
        />
        Tennis
      </label>
    </div>

    <!-- VueCal Calendar -->
    <vue-cal
      ref="vuecal2"
      locale="fr"
      class="vuecal--green-theme"    
      style="height: 500px; margin-bottom: 80px"
      :time-step="30"
      :disable-views="['years', 'year', 'week']"
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
    />
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
      selectedUser: "sportma", // Default selected user
      selectedSport: "football", // Default selected sport
      events: [],
      stickySplitLabels: true,
      minCellWidth: 400,
      minSplitWidth: 300,
      splitDays: [], // To be updated based on selected sport
    };
  },
  mounted() {
    this.updateSplitDays(); // Initialize splitDays on mount
  },
  methods: {
    updateSplitDays() {
      if (this.selectedSport === "football") {
        this.splitDays = [
          { id: "football 1", class: "Football", label: "Terrain Football 1" },
          { id: "football 2", class: "Football", label: "Terrain Football 2" },
          { id: "football 3", class: "Football", label: "Terrain Football 3" },
        ];
      } else if (this.selectedSport === "padel") {
        this.splitDays = [
          { id: 'padel 1', class: "Padel", label: "Terrain Padel 1" },
          { id: 'padel 2', class: "Padel", label: "Terrain Padel 2" },
          { id: 'padel 3', class: "Padel", label: "Terrain Padel 3" },
          { id: 'padel 4', class: "Padel", label: "Terrain Padel 4" },
        ];
      } else if (this.selectedSport === "tennis") {
        this.splitDays = [
          { id: "tennis 1", class: "Tennis", label: "Terrain Tennis 1" },
          { id: "tennis 2", class: "Tennis", label: "Terrain Tennis 2" },
          { id: "tennis 3", class: "Tennis", label: "Terrain Tennis 3" },
          { id: "tennis 4", class: "Tennis", label: "Terrain Tennis 4" },
          { id: "tennis 5", class: "Tennis", label: "Terrain Tennis 5" },
        ];
      }
    },
    createEventInSplit(event) {
      if (event.split) {
        let eventClass =
          this.selectedUser === "sportma" ? "blue-event" : "green-event";
        this.$refs.vuecal2.createEvent(event.date, 120, {
          title: `Nouvelle Reservation`,
          class: eventClass,
          split: event.split,
        });
      }
    },
  },
};
</script>

<style>
/* Styles for the user dropdown */
.user-selection {
  margin-bottom: 15px;
}

.user-selection select {
  padding: 5px;
  border: 2px solid #007bff;
  border-radius: 4px;
  outline: none;
  font-size: 14px;
}

/* Styles for the radio buttons */
.sport-selection {
  margin-bottom: 20px;
}

.sport-selection label {
  margin-right: 15px;
  font-size: 16px;
  cursor: pointer;
}

.sport-selection input[type="radio"] {
  margin-right: 5px;
}

/* Event styles */
.blue-event {
  background-color: lightblue;
  color: white;
}

.green-event {
  background-color: lightgreen;
  color: white;
}
</style>
