<template>
  <div class="row align-items-center form-header">
    <div class="col-lg-7 col-md-4 col-sm-6">
      <h2 class="form-title">System Settings</h2>
      <p class="breadcrumb">System Settings > <strong>Web Featured Game</strong></p>
    </div>
    <div class="col-lg-5 col-md-8 col-sm-6 d-flex align-items-center justify-content-end gap-2">
      <button class="tag-btn btn btn-primary text-dark" @click="handleClick">Update Sequence</button>
      <button class="btn btn-outline-success add-btn d-flex align-items-center me-2"
              @click="handleClick">Refresh Game List</button>
    </div>
  </div>

  <div class="form-container">
    <div class="row gx-3 gy-3">
      <div class="col-md-6 col-lg-3">
        <label>Merchant</label>
        <select v-model="form.merchant" class="form-select">
          <option value="All">All</option>
          <option>MJB</option>
          <option>MJB2</option>
          <option>MJB3</option>
        </select>
      </div>
      <div class="col-md-6 col-lg-3">
        <label>Currency</label>
        <Multiselect
            v-model="form.currency"
            :options="currencies"
            :multiple="true"
            :searchable="true"
            :close-on-select="false"
            :clear-on-select="false"
            :limit="2"
            placeholder="Pick currencies"
        />
      </div>
    </div>
    <div class="row gy-3 mt-4 mb-4">
      <div class="col-lg-4 col-md-6">
        <div class="d-flex align-items-center">
          <h6 class="mb-0 me-2 flex-shrink-0">Top / Hot Category (Home)</h6>
          <button class="search-btn btn btn-primary text-dark">Update</button>
        </div>
      </div>

      <div class="col-lg-4 col-md-6">
        <div class="d-flex align-items-center">
          <h6 class="mb-0 me-2 flex-shrink-0">Provider Hot Game</h6>
          <button class="search-btn btn btn-primary text-dark">Update</button>
        </div>
      </div>

      <div class="col-lg-4 col-md-6">
        <div class="d-flex align-items-center">
          <h6 class="mb-0 me-2 flex-shrink-0">Provider New Game</h6>
          <button class="search-btn btn btn-primary text-dark">Update</button>
        </div>
      </div>
    </div>
  </div>

  <div class="form-container mt-5">
    <div class="row align-items-center justify-content-between mb-3">
      <div class="col mt-3">
        <h5 class="form-title mb-0">Top Games</h5>
      </div>
    </div>

    <div class="table-responsive">
      <table class="table table-striped table-hover mb-0">
        <thead class="table-light">
        <tr>
          <th class="px-3 py-2">Provider</th>
          <th class="px-3 py-2 text-end">Game Name</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="(game, index) in topGames" :key="index">
          <td class="px-3 py-2">{{ game.provider }}</td>
          <td class="px-3 py-2 text-end">{{ game.name }}</td>
        </tr>
        </tbody>
      </table>
    </div>

    <div class="row align-items-center justify-content-between mb-3">
      <div class="col mt-3">
        <h5 class="form-title mb-0">Hot Games</h5>
      </div>
    </div>

    <div class="table-responsive">
      <table class="table table-striped table-hover mb-0">
        <thead class="table-light">
        <tr>
          <th class="px-3 py-2">Provider</th>
          <th class="px-3 py-2 text-end">Game Name</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="(game, index) in hotGames" :key="index">
          <td class="px-3 py-2">{{ game.provider }}</td>
          <td class="px-3 py-2 text-end">{{ game.name }}</td>
        </tr>
        </tbody>
      </table>
    </div>

    <div class="row align-items-center justify-content-between mb-3">
      <div class="col mt-3">
        <h5 class="form-title mb-0">New Games</h5>
      </div>
    </div>

    <div class="table-responsive">
      <table class="table table-striped table-hover mb-0">
        <thead class="table-light">
        <tr>
          <th class="px-3 py-2">Provider</th>
          <th class="px-3 py-2 text-end">Game Name</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="(game, index) in newGames" :key="index">
          <td class="px-3 py-2">{{ game.provider }}</td>
          <td class="px-3 py-2 text-end">{{ game.name }}</td>
        </tr>
        </tbody>
      </table>
    </div>
  </div>

</template>


<script setup>
import {ref} from "vue";
import Multiselect from "vue-multiselect";
import "vue-multiselect/dist/vue-multiselect.css";
import {useNotificationStore} from "@/stores/notification.js";

const notification = useNotificationStore();
const currencies = ref(["BDT", "NPR"]);

const form = ref({
  merchant: "MJB",
  currency: ["BDT", "NPR"]
});

function handleClick() {
  notification.triggerSuccess();
}

const topGames = ref([
  {provider: "JILI", name: "Super Ace"},
  {provider: "FACHAI-SLOT", name: "NIGHT MARKET"},
  {provider: "DREAMEXCH", name: "Dream Exchange Lobby"},
  {provider: "SABA", name: "SABA Sports"},
  {provider: "SPB-INST", name: "Aviator"},
  {provider: "PGsoft", name: "Wild Bounty Showdown"},
  {provider: "Evolution", name: "Crazy Time"},
  {provider: "Pragmatic Play-LIVE", name: "Mega Wheel"},
  {provider: "JDB-SLOT", name: "Pop Pop Candy"},
  {provider: "Relax Gaming", name: "Mega Heist"},
  {provider: "JILI", name: "Money Coming"},
]);

const hotGames = ref([
  {provider: "JILI", name: "Super Ace"},
  {provider: "JILI", name: "NIGHT MARKET"},
  {provider: "JILI", name: "Dream Exchange Lobby"},
  {provider: "JILI", name: "SABA Sports"},
  {provider: "JILI", name: "Aviator"},
  {provider: "JILI", name: "Wild Bounty Showdown"},
  {provider: "JILI", name: "Crazy Time"},
  {provider: "JILI", name: "Mega Wheel"},
  {provider: "JILI", name: "Pop Pop Candy"},
  {provider: "JILI", name: "Mega Heist"},
  {provider: "JILI", name: "Money Coming"},
]);

const newGames = ref([
  {provider: "FACHAI-SLOT", name: "Super Ace"},
  {provider: "FACHAI-SLOT", name: "NIGHT MARKET"},
  {provider: "FACHAI-SLOT", name: "Dream Exchange Lobby"},
  {provider: "FACHAI-SLOT", name: "SABA Sports"},
  {provider: "FACHAI-SLOT", name: "Aviator"},
  {provider: "FACHAI-SLOT", name: "Wild Bounty Showdown"},
  {provider: "FACHAI-SLOT", name: "Crazy Time"},
  {provider: "FACHAI-SLOT", name: "Mega Wheel"},
  {provider: "FACHAI-SLOT", name: "Pop Pop Candy"},
  {provider: "FACHAI-SLOT", name: "Mega Heist"},
  {provider: "FACHAI-SLOT", name: "Money Coming"},
]);

</script>


<style scoped>
.form-header {
  padding-right: 10px;
}

.form-container {
  width: 99%;
  background: #fff;
  padding: 10px 20px 10px 20px;
  border-radius: 5px;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

.form-title {
  font-size: 18px;
  font-weight: bold;
}

.breadcrumb {
  font-size: 12px;
  color: #3a3a3a;
}

label {
  font-size: 12px;
  font-weight: 600;
  margin-bottom: 5px;
}

input, select {
  font-size: 13px;
  padding: 6px;
  border: 1px solid #ccc;
  border-radius: 5px;
}

.search-btn {
  font-size: 12px;
  font-weight: 600;
  background: #d6b402;
  padding: 5px 20px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

.search-btn:hover {
  background: #a18923;
}

.add-btn {
  font-size: 12px;
  font-weight: 600;
  padding: 8px 25px;
  cursor: pointer;
  align-items: center;
}

.tag-btn {
  font-size: 12px;
  font-weight: 600;
  background: #e8c015;
  padding: 8px 26px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

.table {
  font-size: 12px;
  border-radius: 5px;
  overflow: hidden;
}

th {
  background-color: #faf1e8;
  font-weight: 500;
  font-size: 13px;
  color: #5a5858;
  cursor: pointer;
  user-select: none;
}

td {
  font-size: 12px;
  font-weight: 500;
  color: #2c2c2c;
}

tr:hover td {
  background: #fde2c1;
}
</style>