<template>
  <div v-if="modelValue" class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0, 0, 0, 0.5);">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" style="font-size: 18px">Create Web Setting</h5>
          <button type="button" class="btn-close" style="font-size: 12px; font-weight: 600;"
                  @click="closeModal"></button>
        </div>
        <form @submit.prevent="submitForm">
          <div class="modal-body">
            <div class="mb-3 col-lg-12 col-md-12 col-sm-12">
              <label class="form-label">Merchant*</label>
              <select v-model="form.merchant" class="form-select" :class="{'is-invalid': errors.merchant}" @change="clearError('merchant')">
                <option value="">Select Merchant</option> <option value="All">All</option>
                <option value="MJB">MJB</option>
                <option value="MJB2">MJB2</option>
                <option value="MJB3">MJB3</option>
              </select>
              <span v-if="errors.merchant" class="text-danger">{{ errors.merchant.join(', ') }}</span>
            </div>
            <div class="mb-3 col-lg-12 col-md-12 col-sm-12">
              <label class="form-label">Type*</label>
              <select v-model="form.type" class="form-select" :class="{'is-invalid': errors.type}" @change="clearError('type')">
                <option value="">Select Type</option> <option value="Back Office">Back Office</option>
              </select>
              <span v-if="errors.type" class="text-danger">{{ errors.type.join(', ') }}</span>
            </div>
            <div class="mb-3 col-lg-12 col-md-12 col-sm-12">
              <label class="form-label">Name*</label>
              <select v-model="form.name" class="form-select" :class="{'is-invalid': errors.name}" @change="clearError('name')">
                <option value="">Select Name</option> <option value="Logo">Logo</option>
                <option value="Favicon">Favicon</option>
              </select>
              <span v-if="errors.name" class="text-danger">{{ errors.name.join(', ') }}</span>
            </div>
            <div class="mb-3 col-lg-12 col-md-12 col-sm-12">
              <label class="form-label">Status*</label>
              <select v-model="form.status" class="form-select" :class="{'is-invalid': errors.status}" @change="clearError('status')">
                <option value="">Select Status</option> <option value="Active">Active</option>
                <option value="Inactive">Inactive</option>
              </select>
              <span v-if="errors.status" class="text-danger">{{ errors.status.join(', ') }}</span>
            </div>
            <div class="mb-3 col-lg-12 col-md-12 col-sm-12">
              <label class="form-label">Image*</label>
              <div class="d-flex align-items-center">
                <input type="file" @change="handleFileChange" class="form-control" :class="{'is-invalid': errors.image}" style="max-width: 250px;" accept="image/*"/>
                <img
                    v-if="previewUrl"
                    :src="previewUrl"
                    alt="Preview"
                    style="height: 40px; width: auto; margin-left: 10px;"
                />
              </div>
              <small style="font-size: 10px; font-weight: 500; margin: 10px 1px 10px 4px; color: #d87a00">
                Maximum file size: 1MB. Max Height: 80px<br/>Recommended website for file compress: tinypng.com
              </small>
              <span v-if="errors.image" class="text-danger">{{ errors.image.join(', ') }}</span>
            </div>
            <div class="mb-3 col-lg-12 col-md-12 col-sm-12">
              <label class="form-label">Remark</label>
              <input type="text" class="form-control" v-model="form.remark" :class="{'is-invalid': errors.remark}" @blur="clearError('remark')"/>
              <span v-if="errors.remark" class="text-danger">{{ errors.remark.join(', ') }}</span>
            </div>
          </div>
          <div class="modal-footer d-flex align-items-center justify-content-center">
            <button type="button" class="btn cancel-btn" @click="closeModal" :disabled="isLoading">Cancel</button>
            <button type="submit" class="btn submit-btn" :disabled="isLoading">
              <span v-if="isLoading" class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
              {{ isLoading ? 'Saving...' : 'Save' }}
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
import {computed, ref} from 'vue';
import axios from 'axios'; // Import Axios
import toastr from 'toastr'; // Import Toastr

const props = defineProps({
  modelValue: Boolean
});

const emit = defineEmits(['update:modelValue', 'submit']);

const initialForm = {
  merchant: '', // Changed to empty string for required validation
  type: '',     // Changed to empty string for required validation
  name: '',     // Changed to empty string for required validation
  status: '',   // Changed to empty string for required validation
  image: null,  // Changed to null for file input
  remark: ''
};

const form = ref({...initialForm});
const errors = ref({}); // To store validation errors
const isLoading = ref(false); // To manage loading state for the button

const handleFileChange = (event) => {
  const file = event.target.files[0];
  if (file) {
    form.value.image = file; // Store the file directly in form.value.image
    clearError('image'); // Clear error for this file input
  } else {
    form.value.image = null; // If no file is selected
  }
};

const previewUrl = computed(() => {
  if (typeof window !== "undefined" && form.value.image) { // Use form.value.image for preview
    return URL.createObjectURL(form.value.image);
  }
  return null;
});

const resetForm = () => {
  form.value = {...initialForm}; // Reset to initial state
  errors.value = {}; // Clear any errors
  // To visually clear the file input, you might need a ref to the input
  // Or simply re-creating the modal via v-if in the parent will do it.
};

const clearError = (field) => {
  if (errors.value[field]) {
    errors.value[field] = []; // Clear specific error array
  }
};

// Set Axios base URL if not already global
axios.defaults.baseURL = import.meta.env.VITE_API_BASE_URL || 'http://127.0.0.1:8000/api';

const submitForm = async () => {
  isLoading.value = true;
  errors.value = {}; // Clear previous errors

  const formData = new FormData();
  for (const key in form.value) {
    // Append files directly as File objects
    if (form.value[key] instanceof File) {
      formData.append(key, form.value[key]);
    } else if (form.value[key] !== null && form.value[key] !== undefined && form.value[key] !== '') {
      // Append other non-null, non-undefined, non-empty string values
      formData.append(key, form.value[key]);
    }
  }

  try {
    const response = await axios.post('/web-settings', formData, { // Assuming a new endpoint for web settings
      headers: {
        'Content-Type': 'multipart/form-data', // Important for file uploads
      },
    });
    toastr.success('Web Setting created successfully!');
    emit('submit', response.data); // Emit the successful data
    closeModal(); // Close modal and reset form
  } catch (error) {
    if (error.response && error.response.status === 422) {
      // Validation errors from Laravel
      errors.value = error.response.data.errors;
      toastr.error('Please correct the highlighted errors.');
    } else {
      // Other network or server errors
      console.error('Error submitting form:', error);
      toastr.error('Failed to create web setting. Please try again.');
    }
  } finally {
    isLoading.value = false;
  }
};

const closeModal = () => {
  emit('update:modelValue', false);
  resetForm(); // Reset form on close
};
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

/* Added for error display */
.is-invalid {
  border-color: #dc3545; /* Bootstrap's invalid border color */
}

.text-danger {
  font-size: 10px;
  color: #dc3545; /* Bootstrap's text-danger color */
  margin-top: 0.25rem;
  display: block; /* Ensures it takes full width below the input */
}
</style>