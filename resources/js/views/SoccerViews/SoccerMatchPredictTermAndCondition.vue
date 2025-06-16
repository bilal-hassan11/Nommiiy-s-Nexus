<template>
  <div class="row align-items-center form-header">
     <div class="col-lg-7 col-md-4 col-sm-6">
      <h2 class="form-title">Soccer Match List</h2>
      <p class="breadcrumb">Soccer Match List > <strong>Soccer Match Predict Term And Condition</strong></p>
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
      <component :is="currentComponent" />
    </div>
  </div>
</template>

<script setup>
import {computed, ref} from "vue";
import TermsAndConditions from "@/views/SoccerViews/SubComponentViews/TermsAndConditions.vue";
import FAQ from "@/views/SoccerViews/SubComponentViews/FAQ.vue";

const selectedTab = ref("termsandconditions");
const selectedRadio = ref(null);
const currentComponent = computed(() => {
  return selectedTab.value === "termsandconditions" ? TermsAndConditions : FAQ;
});

const tabs = ref([
  {label: "Terms & Conditions", value: "termsandconditions"},
  {label: "FAQ", value: "faq"},
]);
const form = ref({
  language: "EN-BD",
});


const changeTab = (tab) => {
  selectedTab.value = tab;
  selectedRadio.value = null;
  clearForm();
};

const clearForm = () => {
  form.value = {
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
