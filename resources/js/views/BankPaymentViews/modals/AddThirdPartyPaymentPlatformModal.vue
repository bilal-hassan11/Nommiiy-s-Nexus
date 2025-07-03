<template>
  <div v-if="modelValue" class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0, 0, 0, 0.5);">
    <div class="modal-dialog modal-dialog-centered modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Add -Third Party Platform Information</h5>
          <button type="button" class="btn-close" style="font-size: 12px; font-weight: 600;"
                  @click="closeModal"></button>
        </div>

        <form @submit.prevent="submit">
          <div class="modal-body">

            <div class="mb-3 col-lg-3 col-md-4 col-sm-12">
              <label class="form-label">Currency</label>
              <select v-model="form.currency" class="form-select" style="border-color: #ffcc00; border-radius: 2px">
                <option value="BDT">BDT</option>
                <option value="BDT">NPR</option>
                <option value="PKR">PKR</option>
                <option value="INR">INR</option>
              </select>
            </div>

            <div class="mb-3">
              <label class="form-label d-block">* Third Party Platform</label>
              <div class="row gx-2 gy-2">
                <div class="col-6 col-md-4 col-lg-3" v-for="platform in platforms" :key="platform">
                  <button type="button"
                          class="btn w-75 add-btn"
                          :class="form.platform === platform ? 'btn-warning' : 'btn-outline-secondary'"
                          @click="form.platform = platform">
                    {{ platform }}
                  </button>
                </div>
              </div>
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

const form = ref({
  currency: 'BDT',
  platform: ''
});

const platforms = [
  'AEEPAY', 'AMOPAY', 'BABUPAY', 'BDPAY', 'ECPAY', 'EXPAY',
  'FPAY', 'GANYOPAY', 'GENKINPAY', 'META2PAY', 'MJPAY',
  'PAYCENTER', 'RAPIDPAY', 'SLPAY', 'SULFJUPAY', 'TAKAPAY', 'WINBMPAY'
];

const submit = () => {
  emit('submit', {...form.value});
  emit('update:modelValue', false);
  form.value = {
    currency: 'BDT',
    platform: ''
  };
};

const closeModal = () => {
  emit('update:modelValue', false);
  form.value = {
    currency: 'BDT',
    platform: ''
  };
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

.add-btn {
  font-size: 12px;
  font-weight: 600;
  padding: 5px 12px;
  cursor: pointer;
  white-space: nowrap;
}

.btn-outline-secondary {
  background-color: #f8f9fa;
  border: 1px solid #ccc;
}

.row {
  margin-top: 5px;
}

</style>
