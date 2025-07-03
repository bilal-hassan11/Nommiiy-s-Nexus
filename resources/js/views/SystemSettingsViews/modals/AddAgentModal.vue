<template>
  <div v-if="modelValue" class="modal fade show d-block" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Add New Agent</h5>
          <button type="button" class="btn-close" @click="closeModal">x</button>
        </div>
        <div class="modal-body">
          <form @submit.prevent="submit">
            <div class="mb-3">
              <label class="form-label">Merchant ID</label>
              <select v-model="form.merchant" class="form-select">
                <option value="MJB">MJB</option>
                <!-- Add other merchant IDs if needed -->
              </select>
            </div>

            <div class="mb-3">
              <label class="form-label">Department</label>
              <select v-model="form.department" class="form-select">
                <option value="Deposit/Withdraw">Deposit/Withdraw</option>
                <!-- Add other departments -->
              </select>
            </div>

            <div class="mb-3">
              <label class="form-label">Username</label>
              <input v-model="form.username" type="text" class="form-control"/>
            </div>

            <div class="mb-3">
              <label class="form-label">Password</label>
              <input v-model="form.password" type="password" class="form-control"/>
            </div>

            <div class="mb-3">
              <label class="form-label">Confirm Password</label>
              <input v-model="form.confirmPassword" type="password" class="form-control"/>
            </div>

            <div class="mb-3">
              <label class="form-label">Name</label>
              <input v-model="form.name" type="text" class="form-control"/>
            </div>

            <div class="mb-3">
              <label class="form-label">Mobile No.</label>
              <input v-model="form.mobile" type="text" class="form-control"/>
            </div>

            <div class="mb-3">
              <label class="form-label">Status</label>
              <select v-model="form.status" class="form-select">
                <option value="Active">Active</option>
                <option value="Inactive">Inactive</option>
              </select>
            </div>

            <div class="mb-3">
              <label class="form-label d-block">Currency</label>
              <div class="form-check form-check-inline">
                <input
                    v-model="form.currency"
                    type="checkbox"
                    id="currencyBDT"
                    value="BDT"
                    class="form-check-input custom-checkbox"
                />
                <label class="form-check-label checkbox-label" for="currencyBDT">BDT</label>
              </div>
              <div class="form-check form-check-inline">
                <input
                    v-model="form.currency"
                    type="checkbox"
                    id="currencyNPR"
                    value="NPR"
                    class="form-check-input custom-checkbox"
                />
                <label class="form-check-label checkbox-label" for="currencyNPR">NPR</label>
              </div>

            </div>
          </form>
        </div>

        <div class="modal-footer d-flex justify-content-center">
          <button class="btn btn-outline-light text-dark clear-btn" @click="closeModal">Cancel</button>
          <button class="btn search-btn" @click="submit">Save</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import {reactive, defineProps, defineEmits} from 'vue'

defineProps({modelValue: Boolean});
const emit = defineEmits(['update:modelValue', 'submit']);

const form = reactive({
  merchant: 'MJB',
  department: 'Deposit/Withdraw',
  username: '',
  password: '',
  confirmPassword: '',
  name: '',
  mobile: '',
  status: 'Active',
  currency: []
})

const submit = () => {
  if (form.password !== form.confirmPassword) {
    alert('Password and Confirm Password must match.');
    return;
  }

  emit('submit', {...form});
  emit('update:modelValue', false);
};

const closeModal = () => {
  emit('update:modelValue', false);
};
</script>

<style scoped>
.modal-title {
  font-size: 18px;
  font-weight: 600;
}

label {
  font-size: 12px;
  font-weight: 600;
  margin-bottom: 5px;
}

input, select, textarea {
  font-size: 13px;
  padding: 6px;
  border: 1px solid #ccc;
  border-radius: 5px;
  width: 100%;
}

.form-label {
  font-size: 13px;
  font-weight: 500;
}

.btn-close {
  background: none;
  border: none;
  font-size: 20px;
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
  background: #d6b402;
  padding: 5px 20px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

.search-btn:hover {
  background: #a18923;
}
</style>
