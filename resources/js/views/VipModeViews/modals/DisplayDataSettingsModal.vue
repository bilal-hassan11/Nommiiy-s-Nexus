<template>
  <div v-if="modelValue" class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0, 0, 0, 0.5);">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" style="font-size: 18px">Add/Edit Data</h5>
          <button type="button" class="btn-close" style="font-size: 12px; font-weight: 600;"
                  @click="closeModal"></button>
        </div>
        <form @submit.prevent="submit">
          <div class="modal-body">
            <div class="mb-3">
              <div class="radio-group gap-3 d-flex">
                <div class="form-check gap-2 d-flex align-center">
                  <input class="form-check-input" type="radio" v-model="form.resultOptions" id="actualResult"
                         value="actual-result">
                  <label class="form-check-label" for="actualResult">Actual Result</label>
                </div>
                <div class="form-check gap-2 d-flex align-center">
                  <input class="form-check-input" type="radio" v-model="form.resultOptions" id="generateBySystem"
                         value="generate-by-system">
                  <label class="form-check-label" for="generateBySystem">Generate By System</label>
                </div>
                <div class="form-check gap-2 d-flex align-center">
                  <input class="form-check-input" type="radio" v-model="form.resultOptions" id="uploadDocument"
                         value="upload-document">
                  <label class="form-check-label" for="uploadDocument">Upload Document</label>
                </div>
              </div>
            </div>
            <div class="alert-player-info mb-3">
              <strong>Player List</strong><br />
              <small>Real Player (Mask some letter)</small>
            </div>
            <div class="row">
              <div class="mb-3 col-md-6">
                <label class="form-label">Activity Type</label>
                <select v-model="form.activityType" class="form-select">
                  <option>Explosive Prize Show</option>
                </select>
              </div>
              <div class="mb-3 col-md-6">
                <label class="form-label">Currency</label>
                <select v-model="form.currency" class="form-select">
                  <option>BDT</option>
                  <option>NPR</option>
                </select>
              </div>
            </div>
            <div class="mb-3">
              <label class="form-label">Display Row</label>
              <div class="radio-group gap-3 d-flex">
                <div class="form-check gap-2 d-flex align-center">
                  <input class="form-check-input" type="radio" v-model="form.displayRow" id="10"
                         value="10">
                  <label class="form-check-label" for="10">10</label>
                </div>
                <div class="form-check gap-2 d-flex align-center">
                  <input class="form-check-input" type="radio" v-model="form.displayRow" id="30"
                         value="30">
                  <label class="form-check-label" for="30">30</label>
                </div>
                <div class="form-check gap-2 d-flex align-center">
                  <input class="form-check-input" type="radio" v-model="form.displayRow" id="50"
                         value="50">
                  <label class="form-check-label" for="50">50</label>
                </div>
                <div class="form-check gap-2 d-flex align-center">
                  <input class="form-check-input" type="radio" v-model="form.displayRow" id="100"
                         value="upload-document">
                  <label class="form-check-label" for="100">100</label>
                </div>
              </div>
            </div>

            <div class="mb-3">
              <label class="form-label">Date</label>
              <div class="radio-group gap-3 d-flex">
                <div class="form-check gap-2 d-flex align-center">
                  <input class="form-check-input" type="radio" v-model="form.date" id="date"
                         value="date">
                  <label class="form-check-label" for="date">Dates within the event period</label>
                </div>
              </div>
            </div>

            <div class="mb-3">
              <label class="form-label">Order By Descending</label>
              <div class="radio-group gap-3 d-flex">
                <div class="form-check gap-2 d-flex align-center">
                  <input class="form-check-input" type="radio" v-model="form.orderByDescending" id="orderBy"
                         value="descending">
                  <label class="form-check-label" for="orderBy">Dates</label>
                </div>
              </div>
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
import {ref} from 'vue';

defineProps({
  modelValue: Boolean
});

const emit = defineEmits(['update:modelValue', 'submit']);

const initialForm = {
  activityType: 'Explosive Prize Show',
  currency: 'BDT',
  resultOptions: 'actual-result',
  displayRow: '10',
  date: 'date',
  orderByDescending: 'descending',
}

const form = ref({...initialForm});

const resetForm = () => {
  form.value = {...initialForm}
}

const submit = () => {
  emit('submit', {...form.value})
  emit('update:modelValue', false)
  resetForm();
}

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

.alert-player-info {
  background-color: #fff8dc;
  border: 1px solid #ffe58f;
  color: black;
  padding: 10px 15px;
  border-radius: 5px;
  font-size: 12px;
  font-weight: 500;
}
</style>