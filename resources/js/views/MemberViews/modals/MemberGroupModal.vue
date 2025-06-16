<template>
    <div v-if="modelValue" class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0, 0, 0, 0.5);">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" style="font-size: 18px">Create Group</h5>
            <button type="button" class="btn-close" style="font-size: 12px; font-weight: 600;" @click="closeModal"></button>
          </div>
          <form @submit.prevent="submitForm">
            <div class="modal-body">
              <div class="mb-3">
                <label class="form-label">Code*</label>
                <input v-model="form.code" class="form-control" @blur="clearError('code')" required />
                <span v-if="errors.code" class="text-danger">{{ errors.code.join(', ') }}</span>
              </div>

              <div class="mb-3">
                <label class="form-label">Group Name*</label>
                <input v-model="form.name" class="form-control" @blur="clearError('name')" required />
                <span v-if="errors.name" class="text-danger">{{ errors.name.join(', ') }}</span>
              </div>

              <div class="mb-3">
                <label class="form-label">Level*</label>
                <input type="number" v-model="form.level" class="form-control" @blur="clearError('level')" required />
                <span v-if="errors.level" class="text-danger">{{ errors.level.join(', ') }}</span>
              </div>

              <label class="form-label">Group Logo</label>
              <div class="mb-3 d-flex align-items-center gap-2">
                <input type="file" class="form-control choose-file" @change="handleFileChange" />
              </div>

              <div class="mb-3 d-flex gap-3">
                <div class="form-check">
                  <input class="form-check-input" type="radio" id="status-default" value="Default" v-model="form.status" />
                  <label class="form-check-label" for="status-default">Default</label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" id="status-active" value="Active" v-model="form.status" />
                  <label class="form-check-label" for="status-active">Active</label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" id="status-inactive" value="Inactive" v-model="form.status" />
                  <label class="form-check-label" for="status-inactive">Inactive</label>
                </div>
              </div>

              <div class="mb-3">
                <label class="form-label">Sequence*</label>
                <input type="number" v-model="form.sequence" class="form-control" @blur="clearError('sequence')" required />
                <span v-if="errors.sequence" class="text-danger">{{ errors.sequence.join(', ') }}</span>
              </div>

              <div class="mb-3">
                <label class="form-label">Remark</label>
                <input v-model="form.remark" class="form-control" />
              </div>
            </div>

            <div class="modal-footer d-flex justify-content-center">
              <button type="button" class="btn cancel-btn" @click="closeModal">Cancel</button>
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
  import { ref } from 'vue';
  import axios from 'axios';
  import toastr from 'toastr';

  const props = defineProps({ modelValue: Boolean });
  const emit = defineEmits(['update:modelValue', 'submit']);

  const initialForm = {
    code: '',
    name: '',
    level: null,
    status: 'Active',
    sequence: null,
    remark: '',
    logo: null,
  };

  const form = ref({ ...initialForm });
  const errors = ref({});
  const isLoading = ref(false);

  const resetForm = () => {
    form.value = { ...initialForm };
    errors.value = {};
  };

  const handleFileChange = (e) => {
    form.value.logo = e.target.files[0];
  };

  const clearError = (field) => {
    if (errors.value[field]) {
      errors.value[field] = [];
    }
  };

  axios.defaults.baseURL = import.meta.env.VITE_API_BASE_URL || 'http://localhost/api';

  const submitForm = async () => {
    isLoading.value = true;
    const formData = new FormData();
    Object.entries(form.value).forEach(([key, value]) => {
      formData.append(key, value);
    });

    try {
      const response = await axios.post('/groups', formData, {
        headers: { 'Content-Type': 'multipart/form-data' },
      });
      toastr.success('Group added successfully!');
      emit('submit', response.data);
      closeModal();
    } catch (error) {
      if (error.response?.data?.errors) {
        errors.value = error.response.data.errors;
      }
      toastr.error('Failed to submit form');
    } finally {
      isLoading.value = false;
    }
  };

  const closeModal = () => {
    emit('update:modelValue', false);
    resetForm();
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

  .choose-file {
    border-radius: 8px;
    border-color: #d6b402;
  }

  input[type='radio'] {
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

  input[type='radio']:checked {
    border-color: #ffcc00;
    background-color: #ffcc00;
  }

  input[type='radio']:checked::before {
    content: '';
    width: 4px;
    height: 4px;
    background: white;
    border-radius: 50%;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
  }

  .text-danger {
    font-size: 10px;
  }
  </style>
