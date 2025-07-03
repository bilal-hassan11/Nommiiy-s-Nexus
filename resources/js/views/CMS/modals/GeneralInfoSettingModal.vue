<template>
  <div v-if="modelValue" class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0, 0, 0, 0.5);">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" style="font-size: 18px">General Info Modal</h5>
          <button type="button" class="btn-close" style="font-size: 12px; font-weight: 600;" @click="closeModal"/>
        </div>

        <form @submit.prevent="submit">
          <div class="modal-body">
            <div class="row">
              <div class="mb-3 col-md-4">
                <label class="form-label fw-bold">Currency</label>
                <select class="form-select" v-model="form.currency">
                  <option>BDT</option>
                  <option>NPR</option>
                </select>
                <p style="font-size: 10px; font-weight: 500; margin: 10px 1px 10px 4px; color: #d87a00">
                  Editing this setting will turn On/Off general info
                </p>
              </div>
            </div>
            <div class="table-responsive mb-4">
              <table class="table table-striped align-middle text-center">
                <thead class="table-light">
                <tr>
                  <th class="text-start px-3">General Info</th>
                  <th class="text-start" style="width: 120px;">Turn On/Off</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                  <td class="text-start px-3">About Us</td>
                  <td class="text-start">
                    <div class="form-check form-switch d-flex justify-content-center">
                      <input class="form-check-input" type="checkbox" v-model="form.aboutUs"/>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td class="text-start px-3">FAQ</td>
                  <td>
                    <div class="form-check form-switch d-flex justify-content-center">
                      <input class="form-check-input" type="checkbox" v-model="form.faq"/>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td class="text-start px-3">Terms & Conditions</td>
                  <td>
                    <div class="form-check form-switch d-flex justify-content-center">
                      <input class="form-check-input" type="checkbox" v-model="form.terms"/>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td class="text-start px-3">Privacy Policy</td>
                  <td>
                    <div class="form-check form-switch d-flex justify-content-center">
                      <input class="form-check-input" type="checkbox" v-model="form.privacyPolicy"/>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td class="text-start px-3">Responsible Gaming</td>
                  <td>
                    <div class="form-check form-switch d-flex justify-content-center">
                      <input class="form-check-input" type="checkbox" v-model="form.responsibleGaming"/>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td class="text-start px-3">Disconnect Policy</td>
                  <td>
                    <div class="form-check form-switch d-flex justify-content-center">
                      <input class="form-check-input" type="checkbox" v-model="form.disconnectPolicy"/>
                    </div>
                  </td>
                </tr>
                </tbody>
              </table>
            </div>
          </div>

          <div class="modal-footer d-flex align-items-center justify-content-center">
            <button type="button" class="btn cancel-btn" @click="closeModal">Cancel</button>
            <button type="submit" class="btn submit-btn">Save</button>
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

const form = ref({
  currency: 'BDT',
  aboutUs: true,
  faq: true,
  terms: false,
  privacyPolicy: false,
  responsibleGaming: false,
  disconnectPolicy: false,
})

const resetForm = () => {
  form.value = {
    currency: 'BDT',
    aboutUs: true,
    faq: true,
    terms: false,
    privacyPolicy: false,
    responsibleGaming: false,
    disconnectPolicy: false,
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
label {
  font-size: 12px;
  font-weight: 600;
  margin-bottom: 5px;
}

input,
select {
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

.cancel-btn {
  font-size: 12px;
  font-weight: 600;
  padding: 5px 20px;
  border: none;
  border-radius: 3px;
  cursor: pointer;
}

.cancel-btn:hover {
  background: #a5a5a1;
}

.table {
  font-size: 12px;
  border-radius: 5px;
  overflow: hidden;
}

th {
  background-color: #faf1e8;
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

.form-check-input:checked {
  background-color: #d6b402;
  border-color: #d6b402;
}
</style>
