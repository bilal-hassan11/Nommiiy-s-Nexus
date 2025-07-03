<template>
  <div v-if="modelValue" class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0, 0, 0, 0.5);">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content px-3 pt-3 pb-2">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h5 class="modal-title">Adjust Wallet</h5>
          <button type="button" class="btn-close" @click="closeModal">X</button>
        </div>

        <form @submit.prevent="submit">
          <div class="mb-3">
            <label class="form-label">Affiliate Username</label>
            <div class="input-group">
              <input v-model="form.username" type="text" class="form-control border-warning"/>
              <button type="button" class="btn search-btn" @click="searchUser">Search</button>
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label">Current Balance</label>
            <input v-model="form.balance" type="text" class="form-control border-warning" disabled/>
          </div>

          <div class="mb-3">
            <label class="form-label">Amount</label>
            <input v-model="form.amount" type="number" class="form-control"/>
          </div>

          <div class="mb-3">
            <label class="form-label">Type</label>
            <div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" id="commWallet" value="comm" v-model="form.walletType"/>
                <label class="form-check-label" for="commWallet">Comm Wallet</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" id="depositWallet" value="deposit"
                       v-model="form.walletType"/>
                <label class="form-check-label" for="depositWallet">Deposit Wallet</label>
              </div>
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label">Remark</label>
            <input v-model="form.remark" type="text" class="form-control"/>
          </div>

          <div class="d-flex justify-content-center gap-3 mt-3">
            <button type="button" class="btn btn-outline-dark clear-btn" @click="closeModal">Cancel</button>
            <button type="submit" class="btn search-btn">Adjust</button>
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
  username: '',
  balance: '0.00',
  amount: '',
  walletType: '',
  remark: ''
});

const searchUser = () => {
  // Mock balance update - replace with real fetch
  form.value.balance = '123.45';
};

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

input, select, textarea {
  font-size: 13px;
  padding: 6px;
  border: 1px solid #ccc;
  border-radius: 5px;
  width: 100%;
}

.form-label {
  font-size: 13px;
  font-weight: 500;
}

.form-control {
  font-size: 13px;
  padding: 6px;
}

.btn-close {
  background: none;
  border: none;
  font-size: 20px;
}

input[type="radio"] {
  appearance: none;
  width: 15px;
  height: 15px;
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

.clear-btn {
  font-size: 12px;
  font-weight: 600;
  padding: 5px 20px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

.search-btn {
  font-size: 12px;
  font-weight: 600;
  background: #d6b402;
  padding: 5px 20px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

.search-btn:hover {
  background: #a18923;
}
</style>
