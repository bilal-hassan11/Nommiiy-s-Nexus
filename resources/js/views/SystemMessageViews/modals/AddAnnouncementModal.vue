<template>
  <div v-if="modelValue" class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0, 0, 0, 0.5);">
    <div class="modal-dialog modal-dialog-centered modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Add New Announcement</h5>
          <button type="button" class="btn-close" @click="closeModal" />
        </div>

        <form @submit.prevent="submit">
          <div class="modal-body px-4">
            <div class="mb-3">
              <label class="form-label">Merchant</label>
              <select v-model="form.merchant" class="form-select border-warning" disabled>
                <option value="MJB">MJB</option>
              </select>
            </div>

            <div class="mb-3">
              <label class="form-label">Type</label>
              <select v-model="form.type" class="form-select">
                <option value="Home (Before And After Login)">Home (Before And After Login)</option>
                <option value="Before Login">Before Login</option>
                <option value="After Login">After Login</option>
              </select>
            </div>

            <div class="mb-3">
              <label class="form-label">Sequence</label>
              <input type="text" v-model="form.sequence" class="form-control" />
            </div>

            <div class="row mb-3">
              <div class="col-md-6">
                <label for="active" class="form-check-label checkbox-label d-block">Active</label>
                <input type="checkbox" v-model="form.active" class="custom-checkbox form-check-input" id="active" />
              </div>
              <div class="col-md-6">
                <label for="popup" class="form-check-label checkbox-label d-block">Pop Up</label>
                <input type="checkbox" v-model="form.popup" class="custom-checkbox form-check-input" id="popup" />
              </div>
            </div>

            <div class="row mb-2">
              <div class="col-md-6">
                <label class="form-label">Start Time</label>
                <input type="date" v-model="form.startTime" class="form-control" />
              </div>
              <div class="col-md-6">
                <label class="form-label">Expire Time</label>
                <input type="date" v-model="form.expireTime" class="form-control" />
              </div>
            </div>
            <p style="font-size: 10px; font-weight: 500; margin: 10px 1px 10px 4px; color: #d87a00">
              Please be reminded that this date input are GMT+8 standard.
            </p>

            <div class="mt-3 mb-2">
              <label class="form-label">EN-BD Content</label>
              <textarea v-model="form.enBdContent" rows="2" class="form-control" />
            </div>

            <div class="mb-2">
              <label class="form-label">BN-BD Content</label>
              <textarea v-model="form.bnBdContent" rows="2" class="form-control" />
            </div>

            <div class="mb-2">
              <label class="form-label">EN-NP Content</label>
              <textarea v-model="form.enNpContent" rows="2" class="form-control" />
            </div>
            <div class="mb-2">
              <label class="form-label">NE-NP Content</label>
              <textarea v-model="form.neNpContent" rows="2" class="form-control" />
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
import { ref } from 'vue'

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
  merchant: 'MJB',
  type: 'Home (Before And After Login)',
  sequence: '',
  active: false,
  popup: false,
  startTime: formatDate(today),
  expireTime: formatDate(nextWeek),
  enBdContent: '',
  bnBdContent: '',
  enNpContent: '',
  neNpContent: '',
})

const resetForm = () => {
  form.value = {
    merchant: 'MJB',
    type: 'Home (Before And After Login)',
    sequence: '',
    active: false,
    popup: false,
    startTime: formatDate(new Date()),
    expireTime: formatDate(new Date(Date.now() + 7 * 24 * 60 * 60 * 1000)),
    enBdContent: '',
    bnBdContent: '',
    enNpContent: '',
    neNpContent: '',
  }
}

const submit = () => {
  emit('submit', { ...form.value })
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
