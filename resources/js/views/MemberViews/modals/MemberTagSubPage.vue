<template>
    <div class="row align-items-center form-header">
      <div class="col-lg-7 col-md-4 col-sm-6">
        <h2 class="form-title">Member</h2>
        <p class="breadcrumb">Member > <strong>Tag Management</strong></p>
      </div>
      <div class="col-lg-5 col-md-8 col-sm-6 d-flex align-items-center justify-content-end">
        <button class="btn tag-btn me-2 disabled">Tags Adjustment History</button>
      </div>
    </div>

    <div class="form-container py-4">
      <h3 class="form-title mb-4">New Tag</h3>
      <form @submit.prevent="submit">
        <div class="mb-3 btn-group gap-3" role="group">
          <button type="button"
                  class="btn mode-btn"
                  :class="{ 'active-mode': mode === 'single' }"
                  @click="mode = 'single'">Single
          </button>
          <button type="button"
                  class="btn mode-btn"
                  :class="{ 'active-mode': mode === 'batch' }"
                  @click="mode = 'batch'">Batch
          </button>
        </div>

        <div class="mb-3 col-lg-6">
          <label class="form-label">*Tag Name</label>
          <input type="text" v-model="form.tag_name" class="form-control" placeholder="Please Enter Text" required/>
        </div>

        <div class="row mb-3">
          <div class="col-lg-6">
            <label class="form-label">Description</label>
            <textarea v-model="form.description" class="form-control"></textarea>
          </div>
          <div class="col-lg-6">
            <label class="form-label">Remark</label>
            <textarea v-model="form.remark" class="form-control"></textarea>
          </div>
        </div>

        <div class="mb-3">
          <h6>Domain Binding</h6>
          <div class="radio-group gap-3">
            <div class="form-check gap-2 d-flex align-center">
              <input class="form-check-input" type="radio" v-model="form.domainBinding" id="domainYes" :value="true">
              <label class="form-check-label" for="domainYes">Yes</label>
            </div>
            <div class="form-check gap-2 d-flex align-center">
              <input class="form-check-input" type="radio" v-model="form.domainBinding" id="domainNo" :value="false">
              <label class="form-check-label" for="domainNo">No</label>
            </div>
          </div>
        </div>

        <div class="d-flex justify-content-end mt-4">
          <button type="button" class="btn cancel-btn me-2" @click="cancelForm">Cancel</button>
          <button type="submit" class="btn submit-btn" :disabled="isLoading">
            {{ isLoading ? 'Saving...' : 'Save' }}
          </button>
        </div>
      </form>
    </div>
  </template>

  <script setup>
  import {ref} from 'vue';
  import {useRouter} from 'vue-router';
  import axios from 'axios';
  import toastr from 'toastr'

  // Set base URL for axios requests
  // In a real project, this might be in a separate axios config file or main.js
  axios.defaults.baseURL = import.meta.env.VITE_API_BASE_URL || 'http://localhost/api';

  const router = useRouter();

  const mode = ref('single');
  const initialForm = {
    tag_name: '',
    description: '',
    remark: '',
    domainBinding: false
  };
  const form = ref({...initialForm});
  const isLoading = ref(false);

  // Function to show custom message for user feedback (simulating toastr)
  const showMessage = (message, type = 'info') => {
    const messageBox = document.createElement('div');
    messageBox.className = `fixed bottom-4 right-4 p-4 rounded-md shadow-lg text-white z-50 transition-all duration-300 ease-in-out transform opacity-0 translate-y-full`;

    let bgColor;
    if (type === 'success') {
      bgColor = 'bg-green-500';
    } else if (type === 'error') {
      bgColor = 'bg-red-500';
    } else {
      bgColor = 'bg-blue-500';
    }

    messageBox.classList.add(bgColor);
    messageBox.textContent = message;
    document.body.appendChild(messageBox);

    // Trigger the transition
    requestAnimationFrame(() => {
      messageBox.classList.remove('opacity-0', 'translate-y-full');
      messageBox.classList.add('opacity-100', 'translate-y-0');
    });


    setTimeout(() => {
      messageBox.classList.remove('opacity-100', 'translate-y-0');
      messageBox.classList.add('opacity-0', 'translate-y-full');
      messageBox.addEventListener('transitionend', () => messageBox.remove(), {once: true});
    }, 3000);
  };

  // Form validation logic
  const validateForm = () => {
    let isValid = true;
    // Basic validation for tag_name (required)
    if (!form.value.tag_name || form.value.tag_name.trim() === '') {
      isValid = false;
      showMessage('Tag Name is required.', 'error');
    }
    // Add more validation rules as needed for other fields
    // Example:
    // if (form.value.description && form.value.description.length > 255) {
    //   isValid = false;
    //   showMessage('Description cannot exceed 255 characters.', 'error');
    // }
    return isValid;
  };

  // Form submission logic
  const submit = async () => {
    // Run client-side validation first
    if (!validateForm()) {
      return; // Stop if validation fails
    }

    isLoading.value = true; // Set loading state to true
    const formData = new FormData();

    // Append all form fields to FormData object
    Object.entries(form.value).forEach(([key, value]) => {
      // Convert boolean values (from radio buttons) to strings for FormData,
      // as backend typically expects strings for form data.
      formData.append(key, typeof value === 'boolean' ? value.toString() : value);
    });
    // Also append the current mode (single/batch)
    formData.append('mode', mode.value);

    try {
      // --- AXIOS CALL (Uncomment and configure in your actual Laravel project) ---
      // In a real Laravel/Vue.js project, you would use axios like this:
      const response = await axios.post('/add-member-tag', formData, { // Changed endpoint to /add-member-tag
        headers: {
          'Content-Type': 'multipart/form-data', // Important for FormData
          // If using Laravel Sanctum or similar, you might need CSRF token:
          // 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
      });
      const responseData = response.data; // Get response data from Axios

      // Handle successful submission
      toastr.success('Member Tag added successfully!', 'Success', {
          positionClass: 'toast-top-right',
          timeOut: 5000, // Toast disappears after 5 seconds
        })

      // If using Vue Router, you might redirect here:
      //router.push({ name: 'tag-management', state: { newTag: responseData.data } }); // Retained router push

    } catch (error) {
      console.error('Error submitting tag:', error); // Log the error for debugging

      // --- ERROR HANDLING (Enhanced for Laravel backend responses) ---
      if (error.response) {
        // The request was made and the server responded with a status code
        // that falls out of the range of 2xx (e.g., 422 for validation errors, 500 for server errors)
        if (error.response.status === 422 && error.response.data.errors) {
          // Handle Laravel validation errors (if backend sends 'errors' object)
          for (const field in error.response.data.errors) {
            error.response.data.errors[field].forEach(msg => showMessage(msg, 'error'));
          }
        } else if (error.response.data && error.response.data.message) {
          // Handle other specific error messages from the backend
          showMessage(error.response.data.message, 'error');
        } else {
          // Generic error for other HTTP error statuses
          showMessage(`Server Error: ${error.response.status}. Please try again.`, 'error');
        }
      } else if (error.request) {
        // The request was made but no response was received (e.g., network error, CORS issue)
        showMessage('Network Error: No response from server. Please check your connection.', 'error');
      } else {
        // Something happened in setting up the request that triggered an Error
        showMessage('An unexpected error occurred. Please try again.', 'error');
      }
      // --- END ERROR HANDLING ---

    } finally {
      isLoading.value = false; // Always reset loading state
    }
  };

  // Reset form fields to their initial state
  const resetForm = () => {
    form.value = { ...initialForm };
    mode.value = 'single'; // Reset mode to default
  };

  // Handle cancel button click
  const cancelForm = () => {
    resetForm(); // Reset form on cancel
    showMessage('Form cancelled.', 'info');
    router.push({ name: 'tag-management' });
  };
  </script>

  <style scoped>
  .form-container {
    width: 99%;
    background: #fff;
    padding: 10px 20px 10px 20px;
    border-radius: 5px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
  }

  .form-header {
    padding-right: 10px;
  }

  .form-title {
    font-size: 18px;
    font-weight: bold;
  }

  .breadcrumb {
    font-size: 12px;
    color: #3a3a3a;
  }

  label {
    font-size: 12px;
    font-weight: 600;
    margin-bottom: 5px;
  }

  input, select, textarea {
    font-size: 13px;
    padding: 6px;
    border: 1px solid #ccc;
    border-radius: 5px;
    width: 100%;
  }

  .radio-group {
    display: flex;
  }

  .form-check {
    display: flex;
    align-items: flex-start;
    margin: 0 10px 0 0;
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
    background: #ccc;
  }

  .cancel-btn:hover {
    background: #a5a5a1;
  }

  .mode-btn {
    font-size: 12px;
    font-weight: 600;
    padding: 5px 20px;
    border: 1px solid #ddd;
    background: white;
    color: #333;
  }

  .mode-btn.active-mode {
    background: #d6b402;
    color: white;
    border-color: #d6b402;
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

  .tag-btn {
    font-size: 12px;
    font-weight: 600;
    background: #e8c015;
    padding: 8px 26px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
  }

  .tag-btn:hover {
    background: #d6b402;
  }
  </style>
