<template>
  <AddCountryRestrictionModal v-model="showCountryRestrictionModal" @submit="handleFormSubmit"/>
  <AddIPDeviceModal v-model="showIPDeviceRestrictionModal" @submit="handleFormSubmit"/>
  <AddMemberRestrictionModal v-model="showMemberRestrictionModal" @submit="handleFormSubmit"/>
  <AddRegisterNameModal v-model="showRegisterNameModal" @submit="handleFormSubmit"/>

  <div class="row align-items-center form-header">
    <div class="col-lg-7 col-md-9 col-sm-12">
      <h2 class="form-title">Compliance</h2>
      <p class="breadcrumb">Compliance > <strong>Roadblock</strong></p>
    </div>
    <div class="col-lg-5 col-md-8 col-sm-6 d-flex align-items-center justify-content-end">
      <button class="btn btn-outline-success add-btn d-flex align-items-center me-2" @click="handleAddButtonClick">
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
      <CountryRestriction v-if="selectedTab === 'countryRestriction'"/>
      <IPDeviceRestriction v-if="selectedTab === 'ipDeviceRestriction'"/>
      <MemberRestriction v-if="selectedTab === 'memberRestriction'"/>
      <RegisterNameBlacklist v-if="selectedTab === 'registerNameBlacklist'"/>
    </div>
  </div>
</template>

<script setup>
import {ref} from "vue";
import CountryRestriction from "@/views/ComplianceViews/SubComponents/CountryRestriction.vue";
import IPDeviceRestriction from "@/views/ComplianceViews/SubComponents/IPDeviceRestriction.vue";
import MemberRestriction from "@/views/ComplianceViews/SubComponents/MemberRestriction.vue";
import RegisterNameBlacklist from "@/views/ComplianceViews/SubComponents/RegisterNameBlacklist.vue";
import {CirclePlus} from "lucide-vue-next";
import AddCountryRestrictionModal from "@/views/ComplianceViews/modals/AddCountryRestrictionModal.vue";
import AddIPDeviceModal from "@/views/ComplianceViews/modals/AddIPDeviceModal.vue";
import AddMemberRestrictionModal from "@/views/ComplianceViews/modals/AddMemberRestrictionModal.vue";
import AddRegisterNameModal from "@/views/ComplianceViews/modals/AddRegisterNameModal.vue";

const selectedTab = ref("countryRestriction");
const selectedRadio = ref(null);
const showCountryRestrictionModal = ref(false);
const showIPDeviceRestrictionModal = ref(false);
const showMemberRestrictionModal = ref(false);
const showRegisterNameModal = ref(false);

const handleAddButtonClick = () => {
  switch (selectedTab.value) {
    case 'countryRestriction':
      showCountryRestrictionModal.value = true
      break
    case 'ipDeviceRestriction':
      showIPDeviceRestrictionModal.value = true
      break
    case 'memberRestriction':
      showMemberRestrictionModal.value = true
      break
    case 'registerNameBlacklist':
      showRegisterNameModal.value = true
      break
  }
}

const handleFormSubmit = (formData) => {
  console.log("Received Form Data:", formData)
  // Process submission (API call etc.)
}

const tabs = ref([
  {label: "Country Restriction", value: "countryRestriction"},
  {label: "IP/Device Restriction", value: "ipDeviceRestriction"},
  {label: "Member Restriction", value: "memberRestriction"},
  {label: "Register Name Blacklist", value: "registerNameBlacklist"},
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

.add-btn {
  font-size: 12px;
  font-weight: 600;
  padding: 8px 25px;
  cursor: pointer;
  align-items: center;
}
</style>
