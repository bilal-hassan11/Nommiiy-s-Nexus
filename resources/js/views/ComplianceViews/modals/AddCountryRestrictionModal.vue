<template>
  <div v-if="modelValue" class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0, 0, 0, 0.5);">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" style="font-size: 18px">Create Country Restriction</h5>
          <button type="button" class="btn-close" style="font-size: 12px; font-weight: 600;"
                    @click="closeModal"></button>
        </div>
        <form @submit.prevent="submitForm">
          <div class="modal-body">
            <div class="mb-3 col-lg-12 col-md-12 col-sm-12">
              <label class="form-label">Merchant ID</label>
              <select
                v-model="form.merchant"
                class="form-select"
                :class="{'is-invalid': errors.merchant}"
                @change="clearError('merchant')"
              >
                <option value="All">All</option>
                <option>MJB</option>
                <option>MJB2</option>
                <option>MJB3</option>
              </select>
              <span v-if="errors.merchant" class="text-danger">{{ errors.merchant.join(', ') }}</span>
            </div>
            <div class="mb-3 col-lg-12 col-md-12 col-sm-12">
              <label class="form-label">Country</label>
              <select
                v-model="form.country"
                class="form-select"
                :class="{'is-invalid': errors.country}"
                @change="clearError('country')"
              >
                <option value="All">All</option>
                <option>Afghanistan</option>
                <option>Pakistan</option>
                <option>Bangladesh</option>
                <option>Nepal</option>
              </select>
              <span v-if="errors.country" class="text-danger">{{ errors.country.join(', ') }}</span>
            </div>
            <div class="mb-3 col-lg-12 col-md-12 col-sm-12">
              <label class="form-label">Name</label>
              <input
                v-model="form.name"
                class="form-control"
                type="text"
                :class="{'is-invalid': errors.name}"
                @input="clearError('name')"
              />
              <span v-if="errors.name" class="text-danger">{{ errors.name.join(', ') }}</span>
            </div>
            <div class="mb-3 col-lg-12 col-md-12 col-sm-12">
              <label class="form-check-label checkbox-label" for="whitelist">Whitelist</label>
              <input
                type="checkbox"
                v-model="form.whitelist"
                class="custom-checkbox form-check-input"
                id="whitelist"
                :class="{'is-invalid': errors.whitelist}"
                @change="clearError('whitelist')"
              />
              <span v-if="errors.whitelist" class="text-danger">{{ errors.whitelist.join(', ') }}</span>
            </div>
            <div class="mb-3 col-lg-12 col-md-12 col-sm-12">
              <label class="form-label">Status</label>
              <select
                v-model="form.status"
                class="form-select"
                :class="{'is-invalid': errors.status}"
                @change="clearError('status')"
              >
                <option value="Active">Active</option> <option>Inactive</option>
              </select>
              <span v-if="errors.status" class="text-danger">{{ errors.status.join(', ') }}</span>
            </div>
            <div class="mb-3 col-lg-12 col-md-12 col-sm-12">
              <label class="form-label">Remark</label>
              <input
                type="text"
                class="form-control"
                v-model="form.remark"
                :class="{'is-invalid': errors.remark}"
                @input="clearError('remark')"
              />
              <span v-if="errors.remark" class="text-danger">{{ errors.remark.join(', ') }}</span>
            </div>
          </div>
          <div class="modal-footer d-flex align-items-center justify-content-center">
            <button @click="resetForm" type="button" class="clear-btn btn btn-outline-dark" :disabled="isSaving">Clear</button>
            <button type="submit" class="btn submit-btn" :disabled="isSaving">
              <span v-if="isSaving" class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
              {{ isSaving ? 'Saving...' : 'Save' }}
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
import {ref} from 'vue';
import axios from 'axios';
import toastr from 'toastr'; // Ensure toastr is installed and accessible

defineProps({
  modelValue: Boolean
});

// Emits for updating modal visibility and notifying parent on submission
const emit = defineEmits(['update:modelValue', 'restrictionCreated']);

const isSaving = ref(false);
const errors = ref({});

const initialForm = {
  merchant: 'MJB',
  country: 'Afghanistan',
  name: '',
  status: 'Active',
  whitelist: false, // Defaulting to false for "restrictions"
  remark: ''
}

const form = ref({...initialForm});

const clearError = (field) => {
  if (errors.value[field]) {
    errors.value[field] = [];
  }
};

const resetForm = () => {
  form.value = {...initialForm};
  errors.value = {};
};

axios.defaults.baseURL = import.meta.env.VITE_API_BASE_URL || 'http://127.0.0.1:8000/api';

const submitForm = async () => {
  isSaving.value = true;
  errors.value = {};

  try {
    const response = await axios.post('/country-restrictions', form.value);

    toastr.success(response.data.message || 'Country restriction created successfully!');
    emit('restrictionCreated', response.data.restriction);
    closeModal();

  } catch (error) {
    if (error.response && error.response.status === 422) {
      errors.value = error.response.data.errors;
      toastr.error('Please correct the highlighted errors.');
    } else if (error.response && error.response.status === 409) {
      toastr.error(error.response.data.message);
    } else {
      console.error('Error creating country restriction:', error);
      toastr.error('Failed to create country restriction. Please try again.');
    }
  } finally {
    isSaving.value = false;
  }
};

const closeModal = () => {
  emit('update:modelValue', false)
  resetForm();
};
</script>

<style scoped>
/* Modal overlay styling */
.modal {
  background-color: rgba(0, 0, 0, 0.5);
}

/* Original styles from your component */
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

/* New styles for validation errors */
.is-invalid {
  border-color: #dc3545;
}

.text-danger {
  font-size: 10px;
  color: #dc3545;
  margin-top: 0.25rem;
  display: block;
}
</style>