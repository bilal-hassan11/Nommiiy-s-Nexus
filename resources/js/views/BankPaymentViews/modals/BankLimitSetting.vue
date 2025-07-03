<template>
  <div v-if="modelValue" class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0, 0, 0, 0.5);">
    <div class="modal-dialog modal-dialog-centered modal-l">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"> Bank Limit Setting</h5>
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
              <label class="form-label">Add Bank Limit</label>
              <input type="text" v-model="form.addBankLimit" class="form-control" placeholder="0-50"/>
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
  addBankLimit: '4',
  currency: 'BDT',
})

const resetForm = () => {
  form.value = {
    addBankLimit: '4',
    currency: 'BDT',
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
