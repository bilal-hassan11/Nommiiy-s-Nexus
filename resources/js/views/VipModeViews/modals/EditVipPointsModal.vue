<template>
  <div v-if="modelValue" class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0, 0, 0, 0.5);">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" style="font-size: 18px">Edit VIP Points</h5>
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

            <div class="mb-3">
              <label>Type</label>
              <div class="radio-group gap-3 d-flex">
                <div class="form-check gap-2 d-flex align-center">
                  <input class="form-check-input" type="radio" v-model="form.pointTypes" id="manuallyIncreasePoints"
                         value="manually-increase-points">
                  <label class="form-check-label" for="manuallyIncreasePoints">Transfer to provider</label>
                </div>
                <div class="form-check gap-2 d-flex align-center">
                  <input class="form-check-input" type="radio" v-model="form.pointTypes" id="manuallyDeductPoints"
                         value="manually-deduct-points">
                  <label class="form-check-label" for="manuallyDeductPoints">Transfer to Main Wallet</label>
                </div>
              </div>
            </div>
            <div class="mb-3 col-lg-12 col-md-12 col-sm-12">
              <label class="form-label">Points</label>
              <input type="text" v-model="form.points" class="form-control"
              />
            </div>
            <div class="mb-3 col-lg-12 col-md-12 col-sm-12">
              <label class="form-label">Remark</label>
              <input type="text" v-model="form.remark" class="form-control"
              />
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
  points: '',
  pointTypes: 'manually-increase-points',
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
</style>