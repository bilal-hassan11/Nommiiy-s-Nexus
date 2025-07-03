<template>
  <div v-if="modelValue" class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0, 0, 0, 0.5);">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Approve</h5>
          <button type="button" class="btn-close" @click="closeModal"></button>
        </div>

        <form @submit.prevent="submit">
          <div class="modal-body">

            <div class="mb-3">
              <label class="form-label">Remark</label>
              <input v-model="form.remark" type="text" class="form-control" placeholder="Enter remark..." />
            </div>

            <p style="font-size: 10px; font-weight: 500; margin: 10px 1px 10px 4px; color: #d87a00">
              Currency Conversion Rates on Releasing Commission
            </p>

            <div class="mb-2 input-group align-items-center">
              <span class="input-group-text" style="font-size: 12px;">1 BDT =</span>
              <input v-model="form.rateBDT" type="number" class="form-control" />
              <span class="input-group-text">USD</span>
            </div>

            <div class="mb-2 input-group align-items-center">
              <span class="input-group-text" style="font-size: 12px;">1 NPR =</span>
              <input v-model="form.rateNPR" type="number" class="form-control" />
              <span class="input-group-text">USD</span>
            </div>

          </div>

          <div class="modal-footer d-flex justify-content-center">
            <button type="button" class="btn cancel-btn" @click="closeModal">Cancel</button>
            <button type="submit" class="btn btn-success release-btn">Release Directly</button>
          </div>
        </form>

      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';

defineProps({
  modelValue: Boolean
});

const emit = defineEmits(['update:modelValue', 'submit']);

const form = ref({
  remark: '',
  rateBDT: 0.0095,
  rateNPR: 1
});

const submit = () => {
  emit('submit', { ...form.value });
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

.form-label {
  font-size: 13px;
  font-weight: 500;
}

input.form-control {
  font-size: 13px;
  padding: 6px;
}

.input-group-text {
  font-size: 12px;
}

.cancel-btn {
  font-size: 12px;
  font-weight: 600;
  border-radius: 3px;
  padding: 6px 20px;
}

.release-btn {
  font-size: 12px;
  font-weight: 600;
  color: white;
  padding: 6px 20px;
  border: none;
  border-radius: 3px;
}

.release-btn:hover {
  background-color: #218838;
}
</style>
