<template>
  <div v-if="modelValue" class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0, 0, 0, 0.5);">
    <div class="modal-dialog modal-dialog-centered modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Add Merchant Bank</h5>
          <button type="button" class="btn-close" @click="closeModal"/>
        </div>

        <form @submit.prevent="submit">
          <div class="modal-body px-4">
            <div class="mb-3">
              <label class="form-label">Currency</label>
              <select v-model="form.currency" class="form-select">
                <option value="BDT">BDT</option>
              </select>
            </div>
            <div class="mb-3">
              <label class="form-label">Bank Name(EN)</label>
              <input type="text" v-model="form.bankNameEn" class="form-control"/>
            </div>
            <div class="mb-3">
              <label class="form-label">Bank Name(BN)</label>
              <input type="text" v-model="form.bankNameBn" class="form-control"/>
            </div>
            <div class="mb-3">
              <label class="form-label">System Bank</label>
              <select v-model="form.systemBank" class="form-select">
                <option value="Please Select Bank">Please Select Bank</option>
                <option value="HBL">HBL</option>
                <option value="ABL">ABL</option>
              </select>
              <div class="d-flex align-items-center mb-3">
                <input
                    type="checkbox"
                    v-model="form.active"
                    class="custom-checkbox form-check-input me-2"
                    id="active"
                />
                <label for="active" class="checkbox-label form-check-label mb-0">Display Bank Branch</label>
              </div>
            </div>
            <div class="mb-3">
              <label class="form-label">Min Account Number Length</label>
              <input type="text" v-model="form.minAccountNumber" class="form-control" placeholder="0-50"/>
            </div>
            <div class="mb-3">
              <label class="form-label">Max Account Number Length</label>
              <input type="text" v-model="form.maxAccountNumber" class="form-control" placeholder="0-50"/>
            </div>
            <div class="mb-3">
              <label class="form-label">Status</label>
              <select v-model="form.status" class="form-select">
                <option value="Active">Active</option>
                <option value="HBL">HBL</option>
                <option value="ABL">ABL</option>
              </select>
            </div>
          </div>

          <div class="modal-footer d-flex justify-content-center">
            <button type="button" class="btn btn-outline-secondary clear-btn" @click="closeModal">Cancel</button>
            <button type="submit" class="btn btn-warning submit-btn">Save</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
import {ref} from 'vue'

defineProps({
  modelValue: Boolean
})

const emit = defineEmits(['update:modelValue', 'submit'])

// Utility: Format date to 'YYYY-MM-DD'
const formatDate = (date) => {
  return date.toISOString().split('T')[0]
}

// Set dynamic default dates
const today = new Date()
const nextWeek = new Date()
nextWeek.setDate(today.getDate() + 7)

// Reactive form with dynamic dates
const form = ref({
  bankNameEn: '',
  currency: 'BDT',
  bankNameBn: '',
  systemBank: 'Please Select Bank',
  minAccountNumber: '',
  maxAccountNumber: '',
  status: 'Active',
})

const resetForm = () => {
  form.value = {
    bankNameEn: '',
    currency: 'BDT',
    bankNameBn: '',
    systemBank: 'Please Select Bank',
    minAccountNumber: '',
    maxAccountNumber: '',
    status: 'Active',
  }
}

const submit = () => {
  emit('submit', {...form.value})
  emit('update:modelValue', false)
  resetForm()
}

const closeModal = () => {
  emit('update:modelValue', false)
  resetForm()
}
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

input,
select,
textarea {
  font-size: 13px;
  padding: 6px;
  border: 1px solid #ccc;
  border-radius: 5px;
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

.submit-btn {
  font-size: 12px;
  font-weight: 600;
  background: #d6b402;
  padding: 5px 20px;
  border: none;
  border-radius: 3px;
  cursor: pointer;
}

.submit-btn:hover {
  background: #a18923;
}

.clear-btn {
  font-size: 12px;
  font-weight: 600;
  padding: 5px 20px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  color: black;
}
</style>
