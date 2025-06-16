<template>
  <div class="col-md-6 col-lg-3">
    <label>Currency</label>
    <select v-model="form.currency" class="form-select">
      <option>BDT</option>
      <option>NPR</option>
    </select>
  </div>

  <div class="row" style="font-size: 18px; font-weight: 600; margin: 10px 1px 10px 4px;">
    Player Bonus Claiming Qualification
  </div>
  <div class="container mt-3">
    <!-- Line 1 with Checkbox-dependent Inputs and Member Group -->
    <div class="row align-items-center mb-2">
      <!-- Minimum Deposit -->
      <div class="col-md-6 col-lg-3">
        <label>
          <input type="checkbox" v-model="checkboxes.deposit" class="me-2 custom-checkbox"/>
          Minimum Deposit
        </label>
        <input
            v-model="form.minimumDeposit"
            type="text"
            class="form-control custom-input"
            :disabled="!checkboxes.deposit"
        />
      </div>

      <!-- Minimum Turnover -->
      <div class="col-md-6 col-lg-3">
        <label>
          <input type="checkbox" v-model="checkboxes.turnover" class="me-2 custom-checkbox"/>
          Minimum Turnover
        </label>
        <input
            v-model="form.minimumTurnover"
            type="text"
            class="form-control custom-input"
            :disabled="!checkboxes.turnover"
        />
      </div>

      <!-- Member Group -->
      <div class="col-md-6 col-lg-3">
        <label>Member Group</label>
        <Multiselect
            v-model="form.memberGroup"
            :options="memberGroups"
            :multiple="true"
            :searchable="true"
            :close-on-select="false"
            :clear-on-select="false"
            :limit="2"
            placeholder="Please Select Member Group"
        />
      </div>
    </div>
  </div>

  <div class="row" style="font-size: 18px; font-weight: 600; margin: 10px 1px 10px 4px;">
    Player Bonus Claiming Disqualify Setting
  </div>
  <div class="col-md-12 col-lg-12">
    <label>Bonus Claiming Disqualify Tags</label>
    <Multiselect
        v-model="form.memberTag"
        :options="memberTags"
        :multiple="true"
        :searchable="true"
        :close-on-select="false"
        :clear-on-select="false"
        :limit="2"
        placeholder="Please Select Member Tage"
    />
  </div>

  <!-- Risk Setting Section -->
  <div class="row" style="font-size: 18px; font-weight: 600; margin: 10px 1px 10px 4px;">
    Risk Setting
  </div>
  <div class="row text-secondary" style="font-size: 13px; font-weight: 500; margin: 5px 1px 0 2px;">
    Risk Options
  </div>
  <!-- Risk Options as Toggle Buttons -->
  <div class="d-flex flex-wrap gap-2 mb-3">

    <button
        v-for="option in riskOptions"
        :key="option.key"
        :class="['risk-btn', { active: form.risks.includes(option.key) }]"
        @click="toggleRisk(option.key)"
    >
      {{ option.label }}
    </button>
  </div>

  <!-- Violation Limit Input -->
  <div class="row text-secondary" style="font-size: 13px; font-weight: 500; margin: 5px 1px 0 2px;">
    Violation Limit
  </div>
  <div class="d-flex align-items-center mb-4">
    <span class="me-2" style="font-size: 12px">If violated count is above or equal</span>
    <input
        v-model="form.violationLimit"
        type="number"
        class="violation-input mx-2"
    />
    <span style="font-size: 12px">, claim will be declined</span>
  </div>

  <div class="button-group">
    <button class="btn search-btn">Save</button>
  </div>
</template>

<script setup>
import {ref} from 'vue';
import Multiselect from "vue-multiselect";

const form = ref({
  minimumDeposit: '',
  minimumTurnover: '',
  memberGroup: '',
  currency: 'BDT',
  memberTag: '',
  risks: [],
  violationLimit: ''
});

const memberGroups = ref(["All", "Regular", "Regular 2", "Risk", "PLATINUM", "DIAMOND", "PAYMENT GATEWAY TEST"]);

const memberTags = ref(["All", "Same Fingerprint", "Same IP", "Same Real Name", "Same Email", "Same Mobile Number",
  "Same  Password"]);

const checkboxes = ref({
  deposit: false,
  turnover: false,
});

const riskOptions = [
  {key: 'ip', label: 'Do not allow same IP address'},
  {key: 'fingerprint', label: 'Do not allow same finger print ID'},
  {key: 'realname', label: 'Do not allow same real name'},
  {key: 'mobile', label: 'Do not allow same mobile number'},
  {key: 'email', label: 'Do not allow same email address'}
];

function toggleRisk(key) {
  const index = form.value.risks.indexOf(key);
  if (index > -1) {
    form.value.risks.splice(index, 1);
  } else {
    form.value.risks.push(key);
  }
}
</script>

<style scoped>
label {
  font-size: 12px;
  font-weight: 600;
  margin-bottom: 5px;
}

input {
  font-size: 13px;
  border: 1px solid #ccc;
  border-radius: 5px;
}

select {
  font-size: 13px;
  border: 1px solid #ccc;
  border-radius: 5px;
}

.button-group {
  display: flex;
  justify-content: flex-end;
  gap: 15px;
  margin-top: 20px;
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
  width: 15px;
  height: 15px;
  border: 2px solid #ccc;
  border-radius: 50%;
  position: relative;
  cursor: pointer;
  outline: none;
  transition: 0.3s;
}

input[type="radio"]:checked {
  border-color: #ffcc00;
  background-color: #ffcc00;
}

input[type="radio"]:checked::before {
  content: "";
  width: 4px;
  height: 4px;
  background: white;
  border-radius: 50%;
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
}

label {
  font-size: 12px;
  font-weight: 600;
  display: block;
  margin-bottom: 5px;
}

.custom-input {
  font-size: 13px;
  border: 2px solid #ffecb3;
  background-color: #f9f9e3;
  border-radius: 5px;
}

.custom-input:disabled {
  background-color: #e0e0e0;
  cursor: not-allowed;
}

.custom-checkbox {
  appearance: none;
  width: 16px;
  height: 16px;
  border: 2px solid #ffcc00;
  border-radius: 3px;
  background-color: #fff;
  cursor: pointer;
  position: relative;
  margin-right: 5px;
  vertical-align: middle;
  transition: all 0.2s;
}

.custom-checkbox:checked {
  background-color: #ffcc00;
  border-color: #ffcc00;
}

.custom-checkbox:checked::after {
  content: '';
  position: absolute;
  top: 2px;
  left: 5px;
  width: 3px;
  height: 8px;
  border: solid white;
  border-width: 0 2px 2px 0;
  transform: rotate(45deg);
}

.risk-btn {
  font-size: 12px;
  font-weight: 600;
  padding: 5px 10px;
  border: 1px solid #ccc;
  background: #f9f9f9;
  border-radius: 6px;
  cursor: pointer;
  transition: all 0.2s ease-in-out;
}

.risk-btn.active {
  background-color: #ffcc00;
  border-color: #ffcc00;
  color: #000;
}

.violation-input {
  width: 80px;
  border: 2px solid #ffcc00;
  border-radius: 5px;
  padding: 4px;
  font-size: 13px;
  font-weight: 600;
  background: #f6f6f6;
}
</style>
