<template>
  <div v-if="modelValue" class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0, 0, 0, 0.5);">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" style="font-size: 18px">Adjust Activity Points</h5>
          <button type="button" class="btn-close" style="font-size: 12px; font-weight: 600;"
                  @click="closeModal"></button>
        </div>
        <form @submit.prevent="submit">
          <div class="modal-body">
            <div class="mb-3 col-lg-12 col-md-12 col-sm-12">
              <label class="form-label">Search Username</label>
              <select v-model="form.searchUsername" class="form-select"
                      style="border-color: #ffcc00; border-radius: 2px" disabled>
                <option v-for="user in usernameOptions" :key="user" :value="user">
                  {{ user }}
                </option>
              </select>
            </div>
            <div class="mb-3 col-lg-12 col-md-12 col-sm-12">
              <label class="form-label">Currency</label>
              <select v-model="form.currency" class="form-select" style="border-color: #ffcc00; border-radius: 2px"
                      disabled>
                <option>BDT</option>
                <option>NPR</option>
              </select>
            </div>
            <div class="mb-3 col-lg-12 col-md-12 col-sm-12">
              <label class="form-label">Currency Point</label>
              <select v-model="form.currencyPoint" class="form-select" style="border-color: #ffcc00; border-radius: 2px"
                      disabled>
                <option>Point 1</option>
                <option>Point 2</option>
              </select>
            </div>

            <div class="mb-3 col-lg-12 col-md-12 col-sm-12">
              <label class="form-label">Activity Points</label>
              <span style="font-size: 10px; font-weight: 500; margin: 10px 1px 10px 4px; color: #ae0404">*if deduct put "."</span>
              <input type="text" v-model="form.activityPoints" class="form-control"
              />
            </div>
            <div class="mb-3 col-lg-12 col-md-12 col-sm-12">
              <label class="form-label">Remark</label>
              <textarea type="text" v-model="form.remark" class="form-control"
              />
            </div>
          </div>
          <div class="modal-footer d-flex align-items-center justify-content-center">
            <button type="button" class="btn cancel-btn" @click="closeModal">Cancel</button>
            <button type="submit" class="btn submit-btn">Adjust</button>
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
  currency: '',
  searchUsername: '',
  currencyPoint: '',
  activityPoints: '',
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