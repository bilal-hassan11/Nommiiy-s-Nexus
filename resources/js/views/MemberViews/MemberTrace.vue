<template>
  <div class="d-flex justify-content-between form-header">
    <div class="col-lg-8">
      <h2 class="form-title">Member</h2>
      <p class="breadcrumb">Member > <strong>Member Trace</strong></p>
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
      <template v-for="(field, index) in activeFields" :key="index">
        <div class="col-md-6 col-lg-4">
          <label>{{ field.label }}</label>

          <!-- If Radio is Required and the Field Matches -->
          <div v-if="isRadioRequired && shouldShowRadio(field.model)" class="d-flex align-items-center">
            <input
                type="radio"
                v-model="selectedRadio"
                :value="field.model"
                class="me-2"
            />
            <input
                v-if="field.type === 'input'"
                v-model="form[field.model]"
                class="form-control"
                type="text"
                :disabled="isRadioRequired && selectedRadio !== field.model"
            />
          </div>

          <!-- Input without Radio -->
          <input
              v-else-if="field.type === 'input'"
              v-model="form[field.model]"
              class="form-control"
              type="text"
          />

          <!-- Select Dropdown -->
          <select
              v-else-if="field.type === 'select'"
              v-model="form[field.model]"
              class="form-select"
          >
            <option v-for="option in field.props.options" :key="option" :value="option">
              {{ option }}
            </option>
          </select>

          <!-- Multiselect -->
          <Multiselect
              v-else-if="field.type === 'Multiselect'"
              v-model="form[field.model]"
              :options="field.props.options"
              :multiple="field.props.multiple"
              :searchable="field.props.searchable"
              :close-on-select="false"
              :clear-on-select="false"
              :limit="2"
              placeholder="Pick currencies"
          />
        </div>
      </template>
    </div>

    <div class="button-group">
      <button @click="clearForm" class="btn btn-outline-dark clear-btn">Clear</button>
      <button class="btn search-btn">Search</button>
    </div>
  </div>
</template>

<script setup>
import {ref, computed} from "vue";
import Multiselect from "vue-multiselect";

const selectedTab = ref("sameInfoQuery");
const selectedRadio = ref(null);

const tabs = ref([
  {label: "Same Info Query", value: "sameInfoQuery"},
  {label: "Same IP Query", value: "sameIpQuery"},
  {label: "Same Fingerprint Query", value: "sameFingerprintQuery"},
  {label: "Same Password Trace", value: "samePasswordTrace"},
]);

const form = ref({
  dynamicField: "",
  ipAddress: "",
  fingerprint: "",
  startDate: "",
  endDate: "",
  currency: [],
  source: "All",
  merchant: "MJB",
  timeZone: "GMT+0500",
});

const fieldsMap = {
  sameInfoQuery: [
    {label: "Username", model: "dynamicField", type: "input"},
    {label: "Time Zone", model: "timeZone", type: "select", props: {options: ["GMT+0700", "GMT+0500"]}},
    {
      label: "Currency",
      model: "currency",
      type: "Multiselect",
      props: {options: ["BDT", "NPR"], multiple: true, searchable: true}
    }
  ],
  sameIpQuery: [
    {label: "Username", model: "dynamicField", type: "input"},
    {label: "IP Address", model: "ipAddress", type: "input"},
    {label: "Time Zone", model: "timeZone", type: "select", props: {options: ["GMT+0700", "GMT+0500"]}},
    {
      label: "Currency",
      model: "currency",
      type: "Multiselect",
      props: {options: ["BDT", "NPR"], multiple: true, searchable: true}
    }
  ],
  sameFingerprintQuery: [
    {label: "Username", model: "dynamicField", type: "input"},
    {label: "Fingerprint", model: "fingerprint", type: "input"},
    {label: "Time Zone", model: "timeZone", type: "select", props: {options: ["GMT+0700", "GMT+0500"]}},
    {
      label: "Currency",
      model: "currency",
      type: "Multiselect",
      props: {options: ["BDT", "NPR"], multiple: true, searchable: true}
    }
  ],
  samePasswordTrace: [
    {label: "Username", model: "dynamicField", type: "input"},
    {label: "Time Zone", model: "timeZone", type: "select", props: {options: ["GMT+0700", "GMT+0500"]}},
    {label: "Password", model: "password", type: "input"},
    {
      label: "Currency",
      model: "currency",
      type: "Multiselect",
      props: {options: ["BDT", "NPR"], multiple: true, searchable: true}
    }
  ],
};

const activeFields = computed(() => fieldsMap[selectedTab.value]);
const isRadioRequired = computed(() => ["sameIpQuery", "sameFingerprintQuery"].includes(selectedTab.value));

const shouldShowRadio = (model) => {
  return model === "dynamicField" || model === "ipAddress" || model === "fingerprint";
};

const changeTab = (tab) => {
  selectedTab.value = tab;
  selectedRadio.value = null;
  clearForm();
};

const clearForm = () => {
  form.value = {
    dynamicField: "",
    ipAddress: "",
    fingerprint: "",
    startDate: "",
    endDate: "",
    currency: [],
    source: "All",
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

input, select {
  font-size: 13px;
  padding: 3px;
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

.button-group {
  display: flex;
  justify-content: flex-end;
  gap: 15px;
  margin-top: 20px;
}

.clear-btn {
  font-size: 12px;
  font-weight: 600;
  padding: 5px 20px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

.search-btn {
  font-size: 12px;
  font-weight: 600;
  background: #e8c015;
  padding: 5px 20px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

.search-btn:hover {
  background: #d6b402;
}

input[type="radio"] {
  appearance: none;
  width: 12px;
  height: 12px;
  border: 2px solid #ffcc00;
  border-radius: 50%;
  position: relative;
  cursor: pointer;
}

input[type="radio"]:checked {
  background-color: #ffcc00;
}

input[type="radio"]:checked::after {
  content: "";
  width: 6px;
  height: 6px;
  background: white;
  border-radius: 50%;
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
}
</style>
