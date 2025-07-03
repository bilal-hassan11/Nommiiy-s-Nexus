<template>
  <div v-if="modelValue" class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0, 0, 0, 0.5);">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" style="font-size: 18px">VIP Gift Dispatch</h5>
          <button type="button" class="btn-close" style="font-size: 12px; font-weight: 600;"
                  @click="closeModal"></button>
        </div>
        <form @submit.prevent="submit">
          <div class="modal-body">
            <div class="mb-3 col-lg-12 col-md-12 col-sm-12">
              <label class="form-label">Search Username</label>
              <select v-model="form.searchUsername" class="form-select"
                      style="border-color: #ffcc00; border-radius: 2px">
                <option v-for="user in usernameOptions" :key="user" :value="user">
                  {{ user }}
                </option>
              </select>
            </div>
            <div class="mb-3 col-lg-12 col-md-12 col-sm-12">
              <label class="form-label">Username</label>
              <select v-model="form.username" class="form-select">
                <option v-for="user in usernameOptions" :key="user" :value="user">
                  {{ user }}
                </option>
              </select>
            </div>
            <div class="mb-3 col-lg-12 col-md-12 col-sm-12">
              <label class="form-label">
                New VIP Level
              </label>
              <select class="form-select" v-model="form.vipLevel">
                <option value="vip1">VIP 1</option>
                <option value="vip2">VIP 2</option>
              </select>
            </div>

            <div class="mb-3 col-lg-12 col-md-12 col-sm-12">
              <label class="form-label">Real Deliver</label>
              <input type="text" v-model="form.realDeliver" class="form-control"/>
            </div>
            <div class="mb-3 col-lg-12 col-md-12 col-sm-12">
              <label class="form-label">Member's Address</label>
              <input type="text" v-model="form.memberAddress" class="form-control"/>
            </div>
            <div class="mb-3 col-lg-12 col-md-12 col-sm-12">
              <label class="form-label">Remark</label>
              <input type="text" v-model="form.remark" class="form-control"/>
            </div>
          </div>
          <div class="modal-footer d-flex align-items-center justify-content-center">
            <button type="button" class="btn cancel-btn" @click="closeModal">Cancel</button>
            <button type="submit" class="btn submit-btn">Save</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
import {ref} from 'vue';

defineProps({
  modelValue: Boolean
});

const emit = defineEmits(['update:modelValue', 'submit']);

const initialForm = {
  username: '',
  searchUsername: '',
  vipLevel: '',
  realDeliver: '',
  memberAddress: '',
  remark: '',
}

const usernameOptions = [
  'john.doe@gmail.com',
  'jane.smith@gmail.com',
  'alice.johnson@gmail.com',
  'bob.lee@gmail.com'
];

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
</style>