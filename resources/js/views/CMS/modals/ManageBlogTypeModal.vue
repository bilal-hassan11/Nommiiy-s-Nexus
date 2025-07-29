<template>
  <div v-if="modelValue" class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0, 0, 0, 0.5);">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Manage Blog Type</h5>
          <button type="button" class="btn-close" @click="closeModal"></button>
        </div>
        <div class="tab-container px-4 pt-2">
          <ul class="nav nav-tabs border-0">
            <li class="nav-item">
              <a class="nav-link active custom-tab" data-bs-toggle="tab" href="#">Add</a>
            </li>
          </ul>
        </div>

        <form @submit.prevent="submitForm">
          <div class="modal-body px-3 py-3">
            <div class="mb-3">
              <label class="form-label">Blog Type*</label>
              <input
                  type="text"
                  class="form-control"
                  :class="{'is-invalid': errors.blog_type}"
                  v-model="form.blogType"
                  @blur="clearError('blog_type')"
              />
              <p style="font-size: 10px; font-weight: 500; margin: 10px 1px 10px 4px; color: #d87a00">
                Only alphabets, numbers, underscore and space allowed. Must be unique.
              </p>
              <span v-if="errors.blog_type" class="text-danger">{{ errors.blog_type.join(', ') }}</span>
            </div>

            <div class="mb-3">
              <label class="form-label">Priority*</label>
              <input
                  type="number" class="form-control"
                  :class="{'is-invalid': errors.priority}"
                  v-model="form.priority"
                  @blur="clearError('priority')"
              />
              <span v-if="errors.priority" class="text-danger">{{ errors.priority.join(', ') }}</span>
            </div>

            <div class="row">
              <div class="col-md-11 mb-3" v-for="(value, key) in form.locales" :key="key">
                <label class="form-label">{{ key.toUpperCase() }}</label> <input
                    type="text"
                    class="form-control"
                    :class="{'is-invalid': errors[`locales.${key}`]}"
                    v-model="form.locales[key]"
                    @blur="clearError(`locales.${key}`)"
                />
                <span v-if="errors[`locales.${key}`]" class="text-danger">{{ errors[`locales.${key}`].join(', ') }}</span>
              </div>
            </div>
          </div>

          <div class="modal-footer justify-content-center">
            <button type="submit" class="btn submit-btn" :disabled="isLoading">
              <span v-if="isLoading" class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
              {{ isLoading ? 'Submitting...' : 'Submit' }}
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
import {ref} from 'vue';
import axios from 'axios'; // Import Axios
import toastr from 'toastr'; // Import Toastr

// Props and Emits
defineProps({
  modelValue: Boolean
});

const emit = defineEmits(['update:modelValue', 'blogTypeAdded']); // Renamed 'submit' to 'blogTypeAdded' for clarity

// Initial form state
const initialForm = {
  blogType: '',
  priority: null, // Changed to null for number input
  locales: {
    'en-bd': '',
    'bn-bd': '',
    'en-np': '',
    'ne-np': ''
  }
};

const form = ref({ ...initialForm });
const errors = ref({}); // Stores validation errors from backend
const isLoading = ref(false); // Controls loading state of the submit button

// Configure Axios base URL to point to your Laravel API
axios.defaults.baseURL = import.meta.env.VITE_API_BASE_URL || 'http://127.0.0.1:8000/api';

// Clears specific error messages for a given field
const clearError = (field) => {
  if (errors.value[field]) {
    errors.value[field] = [];
  }
};

// Handles form submission
const submitForm = async () => {
  isLoading.value = true;
  errors.value = {}; // Clear all previous errors before a new submission

  try {
    const response = await axios.post('/blog-types', form.value); // Use form.value directly as it's not multipart
    toastr.success('Blog Type added successfully!');
    emit('blogTypeAdded', response.data); // Emit event to parent component with new data
    closeModal(); // Close the modal and reset form
  } catch (error) {
    if (error.response && error.response.status === 422) {
      errors.value = error.response.data.errors; // Store validation messages
      toastr.error('Please correct the highlighted errors.');
    } else {
      console.error('Error submitting form:', error);
      toastr.error('Failed to add blog type. Please try again.');
    }
  } finally {
    isLoading.value = false; // Always reset loading state
  }
};

// Resets the form to its initial state and clears errors
const resetForm = () => {
  form.value = { ...initialForm };
  errors.value = {};
};

// Closes the modal and resets the form
const closeModal = () => {
  emit('update:modelValue', false); // Notify parent to close modal
  resetForm(); // Reset form state
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

.nav-tabs {
  border-bottom: none !important;
}

.nav-link {
  border: none !important;
  color: #000;
}

.nav-link.active.custom-tab {
  border-bottom: 3px solid #f3c400 !important;
  font-weight: 600;
  background-color: transparent !important;
  color: #000 !important;
  cursor: default;
}

/* Styles for displaying validation errors */
.is-invalid {
  border-color: #dc3545; /* Red border for invalid inputs */
}

.text-danger {
  font-size: 10px;
  color: #dc3545; /* Red text for error messages */
  margin-top: 0.25rem;
  display: block; /* Ensures error message appears on its own line */
}
</style>