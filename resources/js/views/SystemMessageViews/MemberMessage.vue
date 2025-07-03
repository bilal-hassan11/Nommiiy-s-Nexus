<template>
  <SentToMemberModal v-model="showMemberModal" @submit="handleFormSubmit"/>
  <SentToGroupModal v-model="showGroupModal" @submit="handleFormSubmit"/>

  <div class="row align-items-center form-header">
    <div class="col-lg-9 col-md-6 col-sm-12">
      <h2 class="form-title">System Message</h2>
      <p class="breadcrumb">System Message > <strong>Mission Daily Settings</strong></p>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-12 d-flex align-items-center justify-content-end">
      <button class="btn tag-btn me-2" @click="showGroupModal = true">Sent To Group</button>
      <button
          v-if="selectedTab === 'memberMessage'"
          class="btn btn-outline-dark custom-btn me-2"
          @click="showMemberModal = true"
      >
        Sent To Member
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
      <MemberMessage v-if="selectedTab === 'memberMessage'"/>
      <GroupMessage v-if="selectedTab === 'groupMessage'"/>
    </div>
  </div>
</template>

<script setup>
import {ref} from "vue";
import MemberMessage from "@/views/SystemMessageViews/SubComponents/MemberMessage.vue";
import GroupMessage from "@/views/SystemMessageViews/SubComponents/GroupMessage.vue";
import SentToMemberModal from "@/views/SystemMessageViews/modals/SentToMemberModal.vue";
import SentToGroupModal from "@/views/SystemMessageViews/modals/SentToGroupModal.vue";

const selectedTab = ref("memberMessage");
const selectedRadio = ref(null);
const showMemberModal = ref(false);
const showGroupModal = ref(false);

const handleFormSubmit = (formData) => {
  console.log("Received Form Data:", formData)
  // Process submission (API call etc.)
}

const tabs = ref([
  {label: "Member Message", value: "memberMessage"},
  {label: "Group Message", value: "groupMessage"},
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

.tag-btn {
  font-size: 12px;
  font-weight: 600;
  background: #e8c015;
  padding: 8px 26px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

.tag-btn:hover {
  background: #d6b402;
}

.custom-btn {
  font-size: 12px;
  font-weight: 600;
  padding: 8px 25px;
  cursor: pointer;
  align-items: center;
}
</style>
