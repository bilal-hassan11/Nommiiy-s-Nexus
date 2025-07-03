<template>
  <div v-if="modelValue" class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0, 0, 0, 0.5);">
    <div class="modal-dialog modal-dialog-centered modal-l">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Add Merchant Bank Transfer</h5>
          <button type="button" class="btn-close" @click="closeModal"/>
        </div>

        <form @submit.prevent="submit">
          <div class="modal-body px-4">
            <div class="mb-3">
              <label class="form-label">Type</label>
              <select v-model="form.type" class="form-select">
                <option value="shareholder">Shareholder</option>
              </select>
            </div>
            <div class="mb-3">
              <label class="form-label">Currency</label>
              <select v-model="form.currency" class="form-select">
                <option value="BDT">BDT</option>
              </select>
            </div>
            <div class="mb-3">
              <label class="form-label">Transfer Out Bank</label>
              <select v-model="form.transferOutBank" class="form-select">
                <option value="Bkash-Withdraw-0000001">Bkash-Withdraw-0000001</option>
                <option value="HBL">HBL</option>
                <option value="ABL">ABL</option>
              </select>
            </div>

            <div class="mb-3">
              <label class="form-label">Transfer Out Bank's Current Balance</label>
              <select v-model="form.transferOutBankBalance" class="form-select border-warning" disabled>
                <option value="-3265462.10">-3265462.10</option>
                <option value="HBL">HBL</option>
                <option value="ABL">ABL</option>
              </select>
            </div>
            <div class="mb-3">
              <label class="form-label">Transfer In Bank</label>
              <select v-model="form.transferOutBank" class="form-select">
                <option value="Bkash-Withdraw-0000001">Bkash-Withdraw-0000001</option>
                <option value="HBL">HBL</option>
                <option value="ABL">ABL</option>
              </select>
            </div>
            <div class="mb-3">
              <label class="form-label">Transfer In Bank's Current Balance</label>
              <select v-model="form.transferOutBankBalance" class="form-select border-warning" disabled>
                <option value="-3265462.10">-3265462.10</option>
                <option value="HBL">HBL</option>
                <option value="ABL">ABL</option>
              </select>
            </div>
            <div class="mb-3">
              <label class="form-label">Trade Time</label>
              <input type="date" v-model="form.tradeTime" class="form-control"/>
            </div>
            <div class="row mb-3">
              <div class="col-md-6">
                <label class="form-label">Amount</label>
                <input type="text" v-model="form.amount" class="form-control"/>

              </div>
              <div class="col-md-6">
                <label class="form-label">Processing Fee</label>
                <input type="text" v-model="form.processingFee" class="form-control"/>

              </div>
            </div>
            <div class="mb-3">
              <label class="form-label">Remark</label>
              <input type="text" v-model="form.remark" class="form-control"/>
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
  type: 'shareholder',
  currency: 'BDT',
  transferOutBank: 'Bkash-Withdraw-0000001',
  transferOutBankBalance: '-3265462.10',
  transferInBank: 'Bkash-Withdraw-0000001',
  transferInBankBalance: '-3265462.10',
  tradeTime: '2025-06-20',
  amount: '',
  processingFee: '',
  remark: '',
})

const resetForm = () => {
  form.value = {
    type: 'shareholder',
    currency: 'BDT',
    transferOutBank: 'Bkash-Withdraw-0000001',
    transferOutBankBalance: '-3265462.10',
    transferInBank: 'Bkash-Withdraw-0000001',
    transferInBankBalance: '-3265462.10',
    tradeTime: '2025-06-20',
    amount: '',
    processingFee: '',
    remark: '',
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
