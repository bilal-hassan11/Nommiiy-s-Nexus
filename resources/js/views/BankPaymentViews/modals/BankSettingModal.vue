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
            <div class="row mb-3">
              <div class="col-md-6">
                <label class="form-label">Merchant</label>
                <select v-model="form.merchant" class="form-select">
                  <option value="MJB">MJB</option>
                </select>
              </div>
              <div class="col-md-6">
                <label class="form-label">Currency</label>
                <select v-model="form.currency" class="form-select">
                  <option value="BDT">BDT</option>
                </select>
              </div>
            </div>
            <div class="mb-3">
              <label class="form-label">Bank</label>
              <select v-model="form.bank" class="form-select">
                <option value="Sonali Bank Limited">Sonali Bank Limited</option>
                <option value="HBL">HBL</option>
                <option value="ABL">ABL</option>
              </select>
            </div>

            <div class="mb-3">
              <label class="form-label">Bank Type</label>
              <input type="text" v-model="form.bankType" class="form-control border-warning" disabled/>
            </div>
            <div class="mb-3">
              <label class="form-label">Display Name</label>
              <input type="text" v-model="form.displayName" class="form-control"/>
            </div>
            <div class="mb-3">
              <label class="form-label">QR Code</label>
              <input type="file" class="form-control"/>
              <p style="font-size: 10px; font-weight: 500; margin: 10px 1px 10px 4px; color: #d87a00">
                Image Size below 400px x 400px
              </p>
            </div>
            <div class="mb-3">
              <label class="form-label">Bank Branch</label>
              <input type="text" v-model="form.bankBranch" class="form-control"/>
              <div class="d-flex align-items-center mb-3">
                <input
                    type="checkbox"
                    v-model="form.active"
                    class="custom-checkbox form-check-input me-2"
                    id="active"
                />
                <label for="active" class="checkbox-label form-check-label mb-0">Display</label>
              </div>
            </div>
            <div class="mb-3">
              <label class="form-label">Account Name</label>
              <input type="text" v-model="form.accountName" class="form-control"/>
            </div>
            <div class="mb-3">
              <label class="form-label">Account Number</label>
              <input type="text" v-model="form.accountNumber" class="form-control"/>
            </div>
            <div class="row mb-3">
              <!-- Maximum Balance -->
              <div class="col-md-6">
                <label class="form-label">Maximum Balance</label>
                <input type="text" v-model="form.maximumBalance" class="form-control mb-2"/>
                <div class="form-check">
                  <input
                      type="checkbox"
                      v-model="form.noMax"
                      class="custom-checkbox form-check-input"
                      id="max-active"
                  />
                  <label for="max-active" class="checkbox-label form-check-label">No Max</label>
                </div>
              </div>

              <!-- Minimum Balance -->
              <div class="col-md-6">
                <label class="form-label">Minimum Balance</label>
                <input type="text" v-model="form.minimumBalance" class="form-control mb-2"/>
                <div class="form-check">
                  <input
                      type="checkbox"
                      v-model="form.noMin"
                      class="custom-checkbox form-check-input"
                      id="min-active"
                  />
                  <label for="min-active" class="checkbox-label form-check-label">No Min</label>
                </div>
              </div>
            </div>
            <div class="mb-3">
              <label class="form-label">Balance</label>
              <input type="text" v-model="form.balance" class="form-control"/>
            </div>
            <div class="mb-3">
              <label class="form-label">Purpose</label>
              <select v-model="form.purpose" class="form-select">
                <option value="Deposit">Deposit</option>
                <option value="HBL">HBL</option>
                <option value="ABL">ABL</option>
              </select>
            </div>
            <div class="mb-3">
              <label class="form-label">Status</label>
              <select v-model="form.status" class="form-select">
                <option value="Active">Active</option>
                <option value="Active">Active</option>
                <option value="Active">Active</option>
              </select>
            </div>
            <div class="mb-3">
              <label class="form-label">Payment Type</label>
              <select v-model="form.paymentType" class="form-select">
                <option value="Online/Atm">Online / Atm</option>
                <option value="Active">Active</option>
                <option value="Active">Active</option>
              </select>
            </div>

            <div class="mb-3">
              <label class="form-label">Sequence</label>
              <input type="text" v-model="form.sequence" class="form-control"/>
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
import {onMounted, ref} from 'vue'

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
  currency: 'BDT',
  bank: 'Sonali Bank Limited',
  bankType: 'bank',
  accountName: '',
  accountNumber: '',
  maximumBalance: '',
  noMax: false,
  minimumBalance: '',
  noMin: false,
  balance: '',
  purpose: 'Deposit',
  status: 'Active',
  paymentType: 'Online/Atm',
  sequence: '',
})

onMounted(() => {
  form.value.displayName = form.value.bank;
});

const resetForm = () => {
  form.value = {
    merchant: 'MJB',
    currency: 'BDT',
    bank: 'Sonali Bank Limited',
    bankType: 'bank',
    accountName: '',
    accountNumber: '',
    maximumBalance: '',
    noMax: false,
    minimumBalance: '',
    noMin: false,
    balance: '',
    purpose: 'Deposit',
    status: 'Active',
    paymentType: 'Online/Atm',
    sequence: '',
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
