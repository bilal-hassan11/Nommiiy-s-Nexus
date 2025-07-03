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

        <form @submit.prevent="submit">
          <div class="modal-body px-3 py-3">
            <div class="mb-3">
              <label class="form-label">Blog Type*</label>
              <input
                  type="text"
                  class="form-control"
                  v-model="form.blogType"
              />
              <p style="font-size: 10px; font-weight: 500; margin: 10px 1px 10px 4px; color: #d87a00">
                Only alphabets, numbers, underscore and space allowed. Must be unique.
              </p>
            </div>

            <div class="mb-3">
              <label class="form-label">Priority*</label>
              <input
                  type="text"
                  class="form-control"
                  v-model="form.priority"
              />
            </div>

            <div class="row">
              <div class="col-md-11 mb-3" v-for="(value, key) in form.locales" :key="key">
                <label class="form-label">{{ key }}</label>
                <input
                    type="text"
                    class="form-control"
                    v-model="form.locales[key]"
                />
              </div>
            </div>
          </div>

          <div class="modal-footer justify-content-center">
            <button type="submit" class="btn submit-btn">Submit</button>
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
  blogType: '',
  priority: '',
  locales: {
    'en-bd': '',
    'bn-bd': '',
    'en-np': '',
    'ne-np': ''
  }
})

const submit = () => {
  emit('submit', {...form.value})
  emit('update:modelValue', false)
  resetForm()
}

const closeModal = () => {
  emit('update:modelValue', false)
  resetForm()
}

const resetForm = () => {
  form.value = {
    blogType: '',
    priority: '',
    locales: {
      'en-bd': '',
      'bn-bd': '',
      'en-np': '',
      'ne-np': ''
    }
  }
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
</style>
