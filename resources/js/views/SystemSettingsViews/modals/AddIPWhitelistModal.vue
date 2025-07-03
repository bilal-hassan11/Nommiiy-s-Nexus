<template>
  <div v-if="modelValue" class="modal fade show d-block" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content p-3">
        <div class="modal-header border-0">
          <h5 class="modal-title fw-bold">Add IP Whitelist</h5>
          <button type="button" class="btn-close" @click="closeModal"></button>
        </div>

        <div class="modal-body pt-0">
          <form @submit.prevent="submit">
            <div class="mb-3">
              <label class="form-label">IP Address</label>
              <input
                  v-model="form.ip"
                  type="text"
                  placeholder="e.g. 192.168.1.1"
                  class="form-control"
              />
            </div>

            <div class="mb-3">
              <label class="form-label">Remark</label>
              <input
                  v-model="form.remark"
                  type="text"
                  class="form-control"
              />
            </div>

            <div class="mb-4">
              <label class="form-label">Status</label>
              <select v-model="form.status" class="form-select">
                <option value="Active">Active</option>
                <option value="Inactive">Inactive</option>
              </select>
            </div>
          </form>
        </div>

        <div class="modal-footer border-0 justify-content-center">
          <button class="btn btn-outline-dark me-2 cancel-btn" @click="closeModal">Cancel</button>
          <button class="btn btn-warning submit-btn" @click="submit">Save</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import {ref, defineEmits, defineProps} from 'vue';

const emit = defineEmits(['submit', 'update:modelValue']);
defineProps({modelValue: Boolean});

const form = ref({
  ip: '',
  remark: '',
  status: 'Active'
});

const submit = () => {
  emit('submit', {...form.value});
  emit('update:modelValue', false);
};

const closeModal = () => {
  emit('update:modelValue', false);
};
</script>

<style scoped>
.modal-title {
  font-size: 18px;
  font-weight: 600;
}

label {
  font-size: 12px;
  font-weight: 600;
  margin-bottom: 5px;
}

input,
select,
textarea {
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
  font-size: 13px;
  font-weight: 600;
  padding: 6px 20px;
  border: none;
  border-radius: 4px;
  background: #e0e0e0;
}
</style>
