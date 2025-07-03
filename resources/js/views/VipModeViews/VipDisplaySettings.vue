<template>
  <DisplayDataSettingsModal v-model="showModal" @submit="handleFormSubmit"/>

  <div class="row align-items-center form-header">
    <div class="col-lg-3 col-md-12 col-sm-12">
      <h2 class="form-title">VIP Mode</h2>
      <p class="breadcrumb">VIP Mode > <strong>VIP Display Settings</strong></p>
    </div>
    <!-- Right Side: All buttons in one line -->
    <div v-if="selectedTab === 'displayDataSettings'" class="col-lg-9 col-md-12 col-sm-12 d-flex align-items-center justify-content-end flex-wrap">
      <button class="btn btn-outline-success add-btn d-flex align-items-center justify-content-center"
        @click="showModal = true">
        <CirclePlus class="me-2" size="16" stroke-width="2"/>
        Add
      </button>
    </div>
  </div>

  <div class="form-container">
    <!-- Tabs -->
    <div class="tabs-container">
      <a
          v-for="tab in tabs"
          :key="tab.value"
          @click="changeTab(tab.value)"
          :class="['tab-button', { active: selectedTab === tab.value }]"
      >
        {{ tab.label }}
      </a>
    </div>

    <div class="row gx-3 gy-3">
      <GeneralSettings v-if="selectedTab === 'generalSettings'"/>
      <VipInfo v-if="selectedTab === 'vipInfo'"/>
      <GamingCredits v-if="selectedTab === 'gamingCredits'"/>
      <DisplayDataSettings v-if="selectedTab === 'displayDataSettings'"/>
  </div>
  </div>
</template>

<script setup>
import {ref} from "vue";
import GeneralSettings from "@/views/VipModeViews/SubComponents/GeneralSettings.vue";
import VipInfo from "@/views/VipModeViews/SubComponents/VipInfo.vue";
import GamingCredits from "@/views/VipModeViews/SubComponents/GamingCredits.vue";
import DisplayDataSettings from "@/views/VipModeViews/SubComponents/DisplayDataSettings.vue";
import {CirclePlus} from "lucide-vue-next";
import DisplayDataSettingsModal from "@/views/VipModeViews/modals/DisplayDataSettingsModal.vue";

const showModal = ref(false);

const handleFormSubmit = (formData) => {
  console.log("Received Form Data:", formData)
  // Process submission (API call etc.)
}

const selectedTab = ref("generalSettings");
const selectedRadio = ref(null);

const tabs = ref([
  {label: "General Settings", value: "generalSettings"},
  {label: "VIP Info", value: "vipInfo"},
  {label: "Gaming Credits", value: "gamingCredits"},
  {label: "Display Data Settings", value: "displayDataSettings"},
]);

const form = ref({
  username: "",
  playerID: "",
  startDate: "",
  endDate: "",
  currency: [],
  merchant: "MJB",
  timeZone: "GMT+0500",
  providerID: "All",
  status: "All"
});

const changeTab = (tab) => {
  selectedTab.value = tab;
  selectedRadio.value = null;
  clearForm();
};

const clearForm = () => {
  form.value = {
    playerID: "",
    username: "",
    status: "All",
    startDate: "",
    endDate: "",
    currency: [],
    providerID: "All",
    merchant: "MJB",
    timeZone: "GMT+0500",
  };
};
</script>


<style scoped>
.tabs-container {
  display: flex;
  gap: 10px;
  margin-bottom: 15px;
}

.tab-button {
  text-decoration: none;
  color: #6c757d;
  padding: 7px 7px;
  cursor: pointer;
  border-bottom: 2px solid transparent;
  font-size: 13px;
  font-weight: 600;
}

.tab-button.active {
  color: black;
  border-bottom: 2px solid #f4c938;
}

label {
  font-size: 12px;
  font-weight: 600;
  margin-bottom: 5px;
}

::v-deep(.multiselect) {
  border: 1px solid #ccc;
  border-radius: 5px;
  font-size: 13px;
}

input {
  font-size: 13px;
  border: 1px solid #ccc;
  border-radius: 5px;
}

select {
  padding: 10px;
  font-size: 13px;
  border: 1px solid #ccc;
  border-radius: 5px;
}

.form-title {
  font-size: 18px;
  font-weight: bold;
}

.breadcrumb {
  font-size: 12px;
  color: #3a3a3a;
}

.form-header {
  padding-right: 10px;
}

.form-container {
  width: 99%;
  background: #fff;
  padding: 10px 20px;
  border-radius: 5px;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

.add-btn {
  font-size: 12px;
  font-weight: 600;
  padding: 8px 25px;
  cursor: pointer;
  align-items: center;
}
</style>
