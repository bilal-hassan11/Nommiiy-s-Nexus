<template>
  <div v-if="modelValue" class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0, 0, 0, 0.5);">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" style="font-size: 18px">Create Domain</h5>
          <button type="button" class="btn-close" style="font-size: 12px; font-weight: 600;"
                  @click="closeModal"></button>
        </div>
        <form @submit.prevent="submit">
          <div class="modal-body">
            <div class="mb-3 col-lg-12 col-md-6 col-sm-6">
              <label class="form-label">Merchant</label>
              <input type="text" v-model="form.merchant" class="form-control" disabled
                     style="cursor: not-allowed; border-color: #ffcc00"/>
            </div>

            <label class="form-label row" style="margin-left: 4px">Affiliate Login</label>
            <div class="mb-3 col-lg-12 col-md-6 col-sm-6 d-flex align-items-center justify-between">
              <input v-model="form.affiliateLogin" class="form-control" disabled style="border-color: #ffcc00;
              cursor: not-allowed"/>
            </div>
            <div class="mb-3 col-lg-12 col-md-6 col-sm-6 d-flex align-items-center gap-3 justify-start">
              <div class="d-flex align-center">
                <button type="button" class="btn btn-outline-success affiliate-btn" @click="doSomething"> Select
                  Affiliate
                </button>
              </div>
              <div class="d-flex align-center">
                <button type="button" class="btn btn-outline-danger affiliate-btn" @click="doSomething"> Unlink
                  Affiliate
                </button>
              </div>
            </div>
            <div class="mb-3 col-lg-12 col-md-6 col-sm-6">
              <label class="form-label">Domain</label>
              <input v-model="form.domain" class="form-control"/>
              <p style="font-size: 10px; font-weight: 500; margin: 10px 1px 10px 4px; color: #d87a00">
                e.g: aff.com (without www)</p>
            </div>
            <div class="mb-3 col-lg-12 col-md-6 col-sm-6">
              <label class="form-label">Money Site</label>
              <input type="text" v-model="form.moneySite" class="form-control" disabled
                     style="cursor: not-allowed; border-color: #ffcc00"/>
            </div>
            <div class="mb-3 col-lg-12 col-md-6 col-sm-6">
              <label class="form-label">Affiliate Site</label>
              <input type="text" v-model="form.affiliateSite" class="form-control" disabled
                     style="cursor: not-allowed; border-color: #ffcc00"/>
            </div>
            <div class="mb-3 col-lg-12 col-md-6 col-sm-6">
              <label class="form-label">Default Language</label>
              <select v-model="form.defaultLanguage" class="form-select">
                <option>EN-BD</option>
                <option>EN-UK</option>
              </select>
            </div>
            <div class="mb-3 col-lg-12 col-md-6 col-sm-6">
              <p style="font-size: 15px; font-weight: 600; color: #d87a00">Note:</p>
              <p style="font-size: 10px; font-weight: 400; color: gray">
                1. Add affiliate domain here first, if required multiple domains for affiliate, add them
                separately.<br/>
                2. Submit the added domain(s) to customer service.<br/>
                3. Change the ns address of the domain(s) to assigned address.<br/>
                4. Wait until customer service bind the affiliate domain(s).<br/>
                5. Secondary domain name and root domain name will be priority match, if not found then only<br/>
                &nbsp;&nbsp;&nbsp;&nbsp;match the wildcard domain name (including root domain name).

              </p>
              <p style="font-size: 9px; font-weight: 500; margin: 10px 1px 10px 4px; color: #d87a00">
                Attention: Do not simply modify domain's ns address, otherwise the binding will fail!</p>
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
  merchant: 'MJB',
  affiliateLogin: '',
  domain: '',
  moneySite: 'https://',
  affiliateSite: 'https://',
  defaultLanguage: 'EN-BD',
}

const form = ref({...initialForm});

const resetForm = () => {
  form.value = {...initialForm}
}

// TODO: Implement this functionality
const doSomething = (e) => {
  console.log("Functionality yet to be built", e);
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

.affiliate-btn {
  font-size: 12px;
  font-weight: 600;
  padding: 2px 6px;
  min-width: 80px;
  height: 30px;
  border-radius: 3px;
  cursor: pointer;
  white-space: nowrap;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  background: #f1f1f1;
}

.affiliate-btn:hover {
  color: black;
}

</style>
