<template>
  <div v-if="modelValue" class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0, 0, 0, 0.5);">
    <div class="modal-dialog modal-xl modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Add Referral Setting</h5>
          <button type="button" class="btn-close" style="font-size: 12px; font-weight: 600;"
                  @click="closeModal"></button>
        </div>
        <form @submit.prevent="submit">
          <div class="modal-body row g-3">

            <!-- Top Form Inputs -->
            <div class="col-lg-8">

              <div class="row">
                <div class="col-md-6">
                  <label class="form-label">Merchant</label>
                  <select v-model="form.merchant" class="form-select">
                    <option disabled value="">Select Merchant</option>
                    <option v-for="m in merchants" :key="m">{{ m }}</option>
                  </select>
                </div>
                <div class="col-md-6">
                  <label class="form-label">Currency</label>
                  <select v-model="form.currency" class="form-select">
                    <option>BDT</option>
                    <option>USD</option>
                  </select>
                </div>
              </div>

              <div class="row">
                <div class="col-md-6">
                  <label class="form-label">Referrer Wallet</label>
                  <select v-model="form.referrerWallet" class="form-select" disabled
                          style="border-color: #ffcc00; border-radius: 2px">
                    <option>Main</option>
                  </select>
                </div>
                <div class="col-md-6">
                  <label class="form-label">Referee Wallet</label>
                  <select v-model="form.refereeWallet" class="form-select" disabled
                          style="border-color: #ffcc00; border-radius: 2px">
                    <option>Main</option>
                  </select>
                </div>
              </div>

              <div class="row">
                <div class="col-md-6">
                  <label class="form-label">Setting</label>
                  <select v-model="form.setting" class="form-select">
                    <option>Auto</option>
                    <option>Manual</option>
                  </select>
                </div>
                <div class="col-md-6">
                  <label class="form-label">Expired Days</label>
                  <input type="number" v-model="form.expiredDays" class="form-control"/>
                </div>
              </div>

              <div class="row">
                <div class="col-md-6">
                  <label class="form-label">Status</label>
                  <select v-model="form.status" class="form-select">
                    <option>Active</option>
                    <option>Inactive</option>
                  </select>
                </div>
              </div>

            </div>

            <div class="col-lg-4">
              <img src="../../../assets/logo.svg" alt="Logo" class="logo"/>
            </div>


            <!-- Level Configuration Table -->
            <div class="col-lg-12">
              <table class="table table-responsive table-striped">
                <thead>
                <tr>
                  <th>Level</th>
                  <th>Referrer Bonus</th>
                  <th>Referrer Target Multiplier</th>
                  <th>Referee Bonus</th>
                  <th>Referee Target Multiplier</th>
                  <th>Referee Target Deposit</th>
                  <th>Referee Target Turnover</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(level, index) in form.levels" :key="index">

                  <td>{{ index + 1 }}</td>
                  <td><input type="number" v-model="level.referrerBonus" class="form-control form-control-sm"/></td>
                  <td><input type="number" v-model="level.referrerMultiplier" class="form-control form-control-sm"/>
                  </td>
                  <td><input type="number" v-model="level.refereeBonus" class="form-control form-control-sm"/></td>
                  <td><input type="number" v-model="level.refereeMultiplier" class="form-control form-control-sm"/></td>
                  <td><input type="number" v-model="level.refereeDeposit" class="form-control form-control-sm"/></td>
                  <td><input type="number" v-model="level.refereeTurnover" class="form-control form-control-sm"/></td>
                  <td>
                    <button class="btn btn-sm btn-outline-danger" type="button" @click="removeLevel(index)">Delete
                    </button>
                  </td>
                </tr>
                </tbody>
              </table>
              <button class="btn btn-outline-warning btn-sm header-btn" type="button" @click="addLevel">Add</button>
            </div>

            <!-- Risk Settings -->
            <div class="col-12">
              <label class="form-label">Risk Setting</label>
              <div class="row">
                <div class="col-md-3" v-for="(val, key) in form.risks" :key="key">
                  <label class="checkbox-label">
                    <input type="checkbox" v-model="form.risks[key]" class="custom-checkbox"/>
                    {{ riskLabels[key] }}
                  </label>
                </div>
              </div>
            </div>

            <!-- Violation Count -->
            <div class="col-lg-12">
              <div class="row">
                <label class="form-label">Violated Count</label>
              </div>
              <div class="d-flex align-items-center gap-2 flex-wrap">
                <small class="text-muted">If violated count is above or equal,</small>
                <input type="number" v-model="form.violationCount" class="form-control form-control-sm" disabled
                       style="border-color: #ffcc00; border-radius: 2px; width: 80px;"
                />
                <small class="text-muted">request will be auto declined</small>
              </div>

            </div>

          </div>
          <div class="modal-footer d-flex justify-content-center align-items-center">
            <button type="button" class="btn btn-outline-dark cancel-btn" @click="closeModal">Cancel</button>
            <button type="submit" class="btn btn-primary submit-btn">Add</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>


<script setup>
import {ref} from 'vue';

const merchants = ['MJB', 'XYZ'];

defineProps({
  modelValue: Boolean
});

const emit = defineEmits(['update:modelValue', 'submit']);

const form = ref({
  merchant: '',
  currency: 'BDT',
  referrerWallet: 'Main',
  refereeWallet: 'Main',
  setting: 'Auto',
  expiredDays: '',
  status: 'Active',
  levels: [],
  risks: {
    fingerprint: false,
    ip: false,
    realName: false,
    mobile: false,
    email: false,
    bank: false,
    password: false,
  },
  violationCount: 0
});

const riskLabels = {
  fingerprint: 'Is Unique Fingerprint',
  ip: 'Is Unique IP',
  realName: 'Is Unique Real Name',
  mobile: 'Is Unique Mobile Number',
  email: 'Is Unique Email',
  bank: 'Unique Bank Account',
  password: 'Unique Password'
};

const addLevel = () => {
  form.value.levels.push({
    referrerBonus: 0,
    referrerMultiplier: 0,
    refereeBonus: 0,
    refereeMultiplier: 0,
    refereeDeposit: 0,
    refereeTurnover: 0
  });
};

const removeLevel = (index) => {
  form.value.levels.splice(index, 1);
};

const submit = () => {
  emit('submit', form.value);
  closeModal();
};

const resetForm = () => {
  form.value = {
    merchant: '',
    currency: 'BDT',
    referrerWallet: 'Main',
    refereeWallet: 'Main',
    setting: 'Auto',
    expiredDays: '',
    status: 'Active',
    risks: {fingerprint: false, ip: false, realName: false, mobile: false, email: false, bank: false, password: false},
    violationCount: 0,
    levels: []
  };
};

const closeModal = () => {
  emit('update:modelValue', false)
  resetForm();
}
</script>

<style scoped>
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

.submit-btn {
  font-size: 12px;
  font-weight: 600;
  color: black;
  background: #d6b402;
  padding: 5px 20px;
  border: none;
  border-radius: 3px;
  cursor: pointer;
}

.submit-btn:hover {
  background: #a18923;
}

.cancel-btn {
  font-size: 12px;
  font-weight: 600;
  color: black;
  padding: 5px 20px;
  border: none;
  border-radius: 3px;
  cursor: pointer;
}

.cancel-btn:hover {
  background: #a5a5a1;
}

.table input.form-control-sm {
  padding: 4px 6px;
  font-size: 12px;
}

.table td button {
  padding: 2px 6px;
  font-size: 11px;
}

.table {
  width: 100%;
  margin-top: 10px;
}

th, td {
  padding: 10px;
  border: none;
  text-align: right;
}

th {
  background-color: #fff8f8;
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

.header-btn {
  font-size: 12px;
  font-weight: 600;
  padding: 8px 26px;
  cursor: pointer;
}

input[type="checkbox"] {
  transform: scale(0.85);
  margin-right: 6px;
}

.checkbox-label {
  font-size: 11px;
  font-weight: 500;
  color: #2c2c2c;
  display: flex;
  align-items: center;
  gap: 4px;
}

.checkbox-label {
  margin-bottom: 6px;
}

.custom-checkbox {
  appearance: none;
  -webkit-appearance: none;
  width: 16px;
  height: 16px;
  border: 2px solid #ccc;
  border-radius: 3px;
  background-color: #fff;
  cursor: pointer;
  position: relative;
  display: inline-block;
  vertical-align: middle;
}

.custom-checkbox:checked {
  background-color: #f1c40f;
  border-color: #f1c40f;
}

.custom-checkbox:checked::after {
  content: '✓';
  color: #fff !important;
  font-size: 11px;
  position: absolute;
  left: 2px;
  top: -1px;
}

.custom-checkbox:hover {
  border-color: #d4ac0d;
}
</style>