<template>
  <div v-if="modelValue" class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0, 0, 0, 0.5);">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" style="font-size: 18px">Predictor Display Setting</h5>
          <button type="button" class="btn-close" style="font-size: 12px; font-weight: 600;" @click="closeModal"/>
        </div>

        <form @submit.prevent="submit">
          <div class="modal-body p-5">
            <div class="row">
              <div class="mb-3 col-md-5">
                <label class="form-label">Merchant</label>
                <select v-model="form.merchant" class="form-select">
                  <option>MJB</option>
                </select>
              </div>
              <div class="mb-3 col-md-5">
                <label class="form-label fw-bold">Currency</label>
                <select class="form-select" v-model="form.currency">
                  <option>BDT</option>
                  <option>NPR</option>
                </select>
              </div>

              <div class="col-md-11">
                <label class="form-label">Display Predictor in Top menu</label>

                <div class="form-check form-check-inline mx-3">
                  <input
                      class="form-check-input"
                      type="radio"
                      id="yes"
                      value="yes"
                      v-model="form.displayInTopMenu"
                  />
                  <label class="form-check-label" for="yes">On</label>
                </div>

                <div class="form-check form-check-inline">
                  <input
                      class="form-check-input"
                      type="radio"
                      id="no"
                      value="no"
                      v-model="form.displayInTopMenu"
                  />
                  <label class="form-check-label" for="no">Off</label>
                </div>
              </div>
              <div class="col-md-11">
                <label class="form-label">Display Predictor in Side Bar</label>

                <div class="form-check form-check-inline mx-3">
                  <input
                      class="form-check-input"
                      type="radio"
                      id="yes"
                      value="yes"
                      v-model="form.displayInSidebar"
                  />
                  <label class="form-check-label" for="yes">On</label>
                </div>

                <div class="form-check form-check-inline">
                  <input
                      class="form-check-input"
                      type="radio"
                      id="no"
                      value="no"
                      v-model="form.displayInSidebar"
                  />
                  <label class="form-check-label" for="no">Off</label>
                </div>
              </div>
            </div>
          </div>

          <div class="modal-footer d-flex align-items-center justify-content-center">
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
  merchant: 'MJB',
  currency: 'BDT',
  displayInSidebar: 'yes',
  displayInTopMenu: 'yes',
})


const resetForm = () => {
  form.value = {
    merchant: 'MJB',
    currency: 'BDT',
    displayInSidebar: 'yes',
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

input[type="radio"] {
  appearance: none;
  width: 12px;
  height: 12px;
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
</style>
