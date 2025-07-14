<template>
    <div v-if="modelValue" class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0, 0, 0, 0.5);">
      <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" style="font-size: 18px">Add Banner</h5>
            <button type="button" class="btn-close" style="font-size: 12px; font-weight: 600;" @click="closeModal" :disabled="isLoading" />
          </div>

          <form @submit.prevent="submitForm">
            <div class="modal-body">
              <div class="row">
                <div class="mb-3 col-md-4">
                  <label class="form-label">Merchant ID <span class="text-red-500">*</span></label>
                  <select v-model="form.merchantId" class="form-select" :disabled="isLoading">
                    <option value="" disabled>Select Merchant ID</option>
                    <option>MJB</option>
                  </select>
                </div>

                <div class="mb-3 col-md-4">
                  <label class="form-label">Status <span class="text-red-500">*</span></label>
                  <select v-model="form.status" class="form-select" :disabled="isLoading">
                    <option value="" disabled>Select Status</option>
                    <option>Active</option>
                    <option>Inactive</option>
                  </select>
                </div>

                <div class="mb-3 col-md-4">
                  <label class="form-label">Title <span class="text-red-500">*</span></label>
                  <input v-model="form.title" type="text" class="form-control" placeholder="Enter Title" :disabled="isLoading" />
                </div>
              </div>

              <div class="row">
                <div class="mb-3 col-md-4">
                  <label class="form-label">Description <span class="text-red-500">*</span></label>
                  <input v-model="form.description" type="text" class="form-control" placeholder="Enter Description" :disabled="isLoading" />
                </div>

                <div class="mb-3 col-md-4">
                  <label class="form-label">Language <span class="text-red-500">*</span></label>
                  <select v-model="form.language" class="form-select" :disabled="isLoading">
                    <option value="" disabled>Select Language</option>
                    <option>EN-BD</option>
                  </select>
                </div>

                <div class="mb-3 col-md-4">
                  <label class="form-label">Sequence <span class="text-red-500">*</span></label>
                  <input v-model.number="form.sequence" type="number" class="form-control" placeholder="Enter Sequence Number" :disabled="isLoading" />
                </div>
              </div>

              <div class="row">
                <div class="mb-3 col-md-6">
                  <label class="form-label">Start Date <span class="text-red-500">*</span></label>
                  <input v-model="form.startDate" type="date" class="form-control" :disabled="isLoading" />
                </div>

                <div class="mb-3 col-md-6">
                  <label class="form-label">End Date <span class="text-red-500">*</span></label>
                  <input v-model="form.endDate" type="date" class="form-control" :disabled="isLoading" />
                </div>
              </div>

              <div class="row">
                <div class="mb-3 col-md-6">
                  <label class="form-label">Mobile Image <span class="text-red-500">*</span></label>
                  <input type="file" @change="onFileChange($event, 'mobileImage')" class="form-control" accept="image/*" :disabled="isLoading" />
                  <small style="color: orange;">Mobile image size: 1920 x 600</small>
                </div>

                <div class="mb-3 col-md-6">
                  <label class="form-label">Web Image <span class="text-red-500">*</span></label>
                  <input type="file" @change="onFileChange($event, 'webImage')" class="form-control" accept="image/*" :disabled="isLoading" />
                  <small style="color: orange;">Web image size: 1920 x 600</small>
                </div>
              </div>
            </div>

            <div class="modal-footer d-flex align-items-center justify-content-center">
              <button type="button" class="btn cancel-btn" @click="closeModal" :disabled="isLoading">Cancel</button>
              <button type="submit" class="btn submit-btn" :disabled="isLoading">
                {{ isLoading ? 'Saving...' : 'Save' }}
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </template>

  <script setup>
  import { ref } from 'vue';
  import axios from 'axios';
  import toastr from 'toastr'; // Import toastr

  defineProps({
    modelValue: Boolean
  });

  const emit = defineEmits(['update:modelValue', 'submit']);

  const initialForm = {
    merchantId: '',
    status: '',
    title: '',
    description: '',
    language: '',
    sequence: null,
    startDate: '',
    endDate: '',
    mobileImage: null,
    webImage: null
  };

  const form = ref({ ...initialForm });
  const isLoading = ref(false);

  // Axios base URL setup
  axios.defaults.baseURL = import.meta.env.VITE_API_BASE_URL || 'http://localhost:8000/api';

  const onFileChange = (event, key) => {
    const file = event.target.files[0];
    if (file) {
      form.value[key] = file;
    } else {
      form.value[key] = null;
    }
  };

  // Client-side form validation
  const validateForm = () => {
    if (!form.value.merchantId) { toastr.error('Merchant ID is required.'); return false; }
    if (!form.value.status) { toastr.error('Status is required.'); return false; }
    if (!form.value.title || form.value.title.trim() === '') { toastr.error('Title is required.'); return false; }
    if (!form.value.description || form.value.description.trim() === '') { toastr.error('Description is required.'); return false; }
    if (!form.value.language) { toastr.error('Language is required.'); return false; }
    if (form.value.sequence === null || form.value.sequence <= 0 || !Number.isInteger(form.value.sequence)) {
      toastr.error('Sequence must be a positive integer.'); return false;
    }
    if (!form.value.startDate) { toastr.error('Start Date is required.'); return false; }
    if (!form.value.endDate) { toastr.error('End Date is required.'); return false; }
    if (new Date(form.value.startDate) > new Date(form.value.endDate)) {
      toastr.error('Start Date cannot be after End Date.'); return false;
    }
    if (!form.value.mobileImage) { toastr.error('Mobile Image is required.'); return false; }
    if (!form.value.webImage) { toastr.error('Web Image is required.'); return false; }

    return true;
  };

  // Form submission logic
  const submitForm = async () => {
    if (!validateForm()) {
      return; // Stop if client-side validation fails
    }

    isLoading.value = true; // Set loading state

    // Create FormData object for file uploads
    const formData = new FormData();
    for (const key in form.value) {
      if (form.value[key] !== null) {
        formData.append(key, form.value[key]);
      }
    }

    try {
      // Make the Axios POST request to your Laravel backend
      // Replace '/api/banners' with your actual API endpoint for banner creation
      const response = await axios.post('/add-member-tag', formData, {
        headers: {
          'Content-Type': 'multipart/form-data', // Important for file uploads
        },
      });

      // Show success message using toastr
      toastr.success(response.data.message || 'Banner added successfully!');

      emit('submit', response.data); // Emit success data to parent component
      closeModal(); // Close modal on successful submission
    } catch (error) {
      console.error('Error submitting Add Banner form:', error);

      if (error.response) {
        // Server responded with a status other than 2xx
        if (error.response.status === 422 && error.response.data.errors) {
          // Handle Laravel validation errors (assuming 'errors' object structure)
          for (const field in error.response.data.errors) {
            toastr.error(Array.isArray(error.response.data.errors[field]) ? error.response.data.errors[field].join(', ') : error.response.data.errors[field]);
          }
        } else if (error.response.data && error.response.data.message) {
          // Handle other specific error messages from the backend
          toastr.error(error.response.data.message);
        } else {
          // Generic error for other HTTP error statuses
          toastr.error(`Server Error: ${error.response.status}. Please try again.`);
        }
      } else if (error.request) {
        // The request was made but no response was received (e.g., network error, CORS issue)
        toastr.error('Network Error: No response from server. Please check your connection.');
      } else {
        // Something happened in setting up the request that triggered an Error
        toastr.error('An unexpected error occurred. Please try again.');
      }
    } finally {
      isLoading.value = false; // Always reset loading state
    }
  };

  const resetForm = () => {
    form.value = { ...initialForm };
    // File inputs are tricky to reset programmatically if not using v-model directly on file input.
    // The above line resets the model, but for the visual input, you might need to
    // clear the input value directly if it causes issues in some browsers:
    // const mobileInput = document.querySelector('input[type="file"][name="mobileImage"]');
    // if (mobileInput) mobileInput.value = '';
    // const webInput = document.querySelector('input[type="file"][name="webImage"]');
    // if (webInput) webInput.value = '';
  };

  const closeModal = () => {
    emit('update:modelValue', false);
    resetForm();
    toastr.info('Add Banner operation cancelled.');
  };
  </script>

  <style scoped>
  /* Tailwind CSS classes are used directly in the template for most styling,
     but these specific styles are kept for elements that might not have direct
     Tailwind equivalents or for specific overrides. */

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

  .modal-content {
    border-radius: 8px;
    overflow: hidden; /* Ensures rounded corners apply to children */
  }

  .modal-header {
    background-color: #f8f9fa;
    border-bottom: 1px solid #e9ecef;
    padding: 1rem 1.5rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
  }

  .modal-title {
    color: #343a40;
    font-weight: 700;
  }

  .btn-close {
    background: none;
    border: none;
    font-size: 1.5rem; /* Larger 'X' for better clickability */
    color: #6c757d;
    cursor: pointer;
    padding: 0;
    line-height: 1;
    opacity: 0.7;
    transition: opacity 0.2s;
  }

  .btn-close:hover {
    opacity: 1;
    color: #000;
  }

  .modal-body {
    padding: 1.5rem;
  }

  .form-label {
    font-size: 13px;
    font-weight: 500;
    color: #495057;
  }

  .form-control, .form-select {
    border: 1px solid #ced4da;
    border-radius: 0.25rem;
    padding: 0.375rem 0.75rem;
    transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
  }

  .form-control:focus, .form-select:focus {
    border-color: #80bdff;
    outline: 0;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
  }

  .form-select {
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e");
    background-repeat: no-repeat;
    background-position: right 0.75rem center;
    background-size: 16px 12px;
  }

  .modal-footer {
    background-color: #f8f9fa;
    border-top: 1px solid #e9ecef;
    padding: 1rem 1.5rem;
    display: flex;
    justify-content: center;
    gap: 1rem;
  }

  .submit-btn {
    font-size: 12px;
    font-weight: 600;
    background: #d6b402; /* Yellow color */
    padding: 8px 25px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    color: white;
    transition: background-color 0.2s ease-in-out;
  }

  .submit-btn:hover {
    background: #a18923; /* Darker yellow on hover */
  }

  .submit-btn:disabled {
    background: #fed7aa; /* Lighter yellow when disabled */
    cursor: not-allowed;
    opacity: 0.7;
  }

  .cancel-btn {
    font-size: 12px;
    font-weight: 600;
    padding: 8px 25px;
    border: 1px solid #6c757d; /* Gray border */
    border-radius: 5px;
    cursor: pointer;
    background-color: #f8f9fa;
    color: #343a40;
    transition: background-color 0.2s ease-in-out, border-color 0.2s ease-in-out;
  }

  .cancel-btn:hover {
    background: #e2e6ea;
    border-color: #5a6268;
  }

  .cancel-btn:disabled {
    opacity: 0.7;
    cursor: not-allowed;
  }

  /* Styles for the red asterisk */
  .text-red-500 {
    color: #ef4444;
  }
  </style>
