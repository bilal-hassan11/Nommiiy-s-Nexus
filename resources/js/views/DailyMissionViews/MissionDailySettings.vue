<template>
  <div class="row align-items-center form-header">
    <div class="col-lg-10 col-md-9 col-sm-12">
      <h2 class="form-title">Mission Daily Setting</h2>
      <p class="breadcrumb">Mission Daily Setting > <strong>Mission Daily Settings</strong></p>
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
      <MissionSetting v-if="selectedTab === 'missionSetting'"/>
      <DiaryMissionTC v-if="selectedTab === 'diaryMissionTC'"/>
    </div>
  </div>
</template>

<script setup>
import {ref} from "vue";
import GeneralSettings from "@/views/DailyMissionViews/SubComponents/GeneralSettings.vue";
import MissionSetting from "@/views/DailyMissionViews/SubComponents/MissionSetting.vue";
import DiaryMissionTC from "@/views/DailyMissionViews/SubComponents/DiaryMissionTC.vue";

const selectedTab = ref("generalSettings");
const selectedRadio = ref(null);

const tabs = ref([
  {label: "General Settings", value: "generalSettings"},
  {label: "Mission Setting", value: "missionSetting"},
  {label: "Diary Mission T&C", value: "diaryMissionTC"},
]);

const form = ref({
  currency: [],
  merchant: "MJB",
  language: "EN-BD",
});

const changeTab = (tab) => {
  selectedTab.value = tab;
  selectedRadio.value = null;
  clearForm();
};

const clearForm = () => {
  form.value = {
    currency: [],
    merchant: "MJB",
    language: "EN-BD",
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
</style>
