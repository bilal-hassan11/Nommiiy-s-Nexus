<template>
  <div v-if="modelValue" class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0, 0, 0, 0.5);">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" style="font-size: 18px">Create Country Restriction</h5>
          <button type="button" class="btn-close" style="font-size: 12px; font-weight: 600;"
                  @click="closeModal"></button>
        </div>
        <form @submit.prevent="submit">
          <div class="modal-body">
            <div class="mb-3 col-lg-12 col-md-12 col-sm-12">
              <label class="form-label">Merchant ID</label>
              <select v-model="form.merchant" class="form-select">
                <option value="All">All</option>
                <option>MJB</option>
                <option>MJB2</option>
                <option>MJB3</option>
              </select>
            </div>
            <div class="mb-3 col-lg-12 col-md-12 col-sm-12">
              <label class="form-label">Country</label>
              <select v-model="form.country" class="form-select">
                <option value="All">All</option>
                <option>Afghanistan</option>
                <option>Pakistan</option>
                <option>Bangladesh</option>
                <option>Nepal</option>
              </select>
            </div>
            <div class="mb-3 col-lg-12 col-md-12 col-sm-12">
              <label class="form-label">Name</label>
              <input v-model="form.name" class="form-control" type="text"/>
            </div>
            <div class="mb-3 col-lg-12 col-md-12 col-sm-12">
              <label class="form-check-label checkbox-label" for="whitelist">Whitelist</label>
              <input type="checkbox" v-model="form.whitelist" class="custom-checkbox form-check-input"
                     id="whitelist"/>
            </div>
            <div class="mb-3 col-lg-12 col-md-12 col-sm-12">
              <label class="form-label">Status</label>
              <select v-model="form.status" class="form-select">
                <option value="All">All</option>
                <option>Active</option>
                <option>Inactive</option>
              </select>
            </div>
            <div class="mb-3 col-lg-12 col-md-12 col-sm-12">
              <label class="form-label">Remark</label>
              <input type="text" class="form-control" v-model="form.remark"/>
            </div>
          </div>
          <div class="modal-footer d-flex align-items-center justify-content-center">
            <button @click="resetForm" type="button" class="clear-btn btn btn-outline-dark">Clear</button>
            <button type="submit" class="btn submit-btn">Save</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
import {computed, ref} from 'vue';

defineProps({
  modelValue: Boolean
});

const emit = defineEmits(['update:modelValue', 'submit']);
const selectedFile = ref(null);

const initialForm = {
  merchant: 'MJB',
  country: 'Afghanistan',
  name: '',
  status: 'Active',
  whitelist: true,
  remark: ''
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

.clear-btn {
  font-size: 12px;
  font-weight: 600;
  padding: 5px 20px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

input[type="checkbox"] {
  transform: scale(0.85);
  margin-right: 6px;
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
</style>