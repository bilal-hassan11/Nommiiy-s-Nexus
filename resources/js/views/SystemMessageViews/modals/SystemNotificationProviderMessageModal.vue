<template>
  <div v-if="modelValue" class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0,0,0,0.5);">
    <div class="modal-dialog modal-dialog-centered modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Add Provider Maintenance</h5>
          <button type="button" class="btn-close" @click="closeModal"/>
        </div>

        <div class="modal-body">
          <div class="row gx-3 gy-3">

            <div class="col-md-12 col-lg-12">
              <label class="form-label">Currency</label>
              <select class="form-select" v-model="form.currency">
                <option value="BDT">BDT</option>
                <option value="INR">INR</option>
                <option value="NPR">NPR</option>
              </select>
            </div>

            <div class="col-md-12 col-lg-12">
              <label class="form-label">Provider</label>
              <select class="form-select" v-model="form.provider">
                <option v-for="p in providerOptions" :key="p" :value="p">{{ p }}</option>
              </select>
            </div>

            <div class="col-md-12 col-lg-12">
              <label class="form-label d-block">Unlock Type</label>
              <div class="form-check form-check-inline">
                <input class="custom-checkbox form-check-input" type="checkbox" id="unlockAuto" value="Auto"
                       v-model="form.unlockType">
                <label class="checkbox-label" for="unlockAuto">Auto</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="custom-checkbox form-check-input" type="checkbox" id="unlockManual" value="Manual"
                       v-model="form.unlockType">
                <label class="checkbox-label" for="unlockManual">Manual</label>
              </div>
            </div>

            <div class="col-md-12 col-lg-12">
              <label class="form-label d-block">Maintenance Type</label>
              <div class="form-check form-check-inline">
                <input class="custom-checkbox form-check-input" type="checkbox" id="maintGame" value="Game"
                       v-model="form.maintenanceType">
                <label class="checkbox-label" for="maintGame">Game</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="custom-checkbox form-check-input" type="checkbox" id="maintSystem" value="System"
                       v-model="form.maintenanceType">
                <label class="checkbox-label" for="maintSystem">System</label>
              </div>
            </div>

            <div class="col-md-12 col-lg-12">
              <label class="form-label">Start Date</label>
              <input type="datetime-local" class="form-control" v-model="form.startDate">
            </div>

            <div class="col-md-12 col-lg-12">
              <label class="form-label">End Date</label>
              <input type="datetime-local" class="form-control" v-model="form.endDate">
            </div>

            <div class="col-md-12 col-lg-12">
              <label class="form-label">Remark</label>
              <input type="text" class="form-control" v-model="form.remark">
            </div>

            <div class="col-md-12 col-lg-12">
              <label class="form-label">Status</label>
              <select class="form-select" v-model="form.status">
                <option>Active</option>
                <option>Inactive</option>
              </select>
            </div>
          </div>

          <div class="modal-footer d-flex justify-content-center">
            <button class="btn btn-outline-secondary clear-btn" @click="closeModal">Cancel</button>
            <button class="btn btn-warning submit-btn" @click="submitForm">Save</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import {ref} from 'vue'

const emit = defineEmits(['update:modelValue', 'submit']);
defineProps({modelValue: Boolean});

const providerOptions = ['Rich Gaming', 'NovaTech', 'OrbitX', 'Global Bet'];

const form = ref({
  currency: 'BDT',
  provider: 'Rich Gaming',
  unlockType: ['Auto'],
  maintenanceType: [],
  startDate: '',
  endDate: '',
  remark: '',
  status: 'Active'
});

const submitForm = () => {
  emit('submit', {...form.value});
  emit('update:modelValue', false);
}

const closeModal = () => {
  emit('update:modelValue', false);
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
  margin-bottom: 4px;
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

.clear-btn {
  font-size: 12px;
  font-weight: 600;
  padding: 5px 20px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
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
