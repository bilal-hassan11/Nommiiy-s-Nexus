<template>
  <div v-if="modelValue" class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0, 0, 0, 0.5);">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" style="font-size: 18px">Bulk Transfer Wallet</h5>
          <button type="button" class="btn-close" style="font-size: 12px; font-weight: 600;"
                  @click="closeModal"></button>
        </div>
        <form @submit.prevent="submit">
          <div class="modal-body">
            <div class="mb-3 row col-lg-12 col-md-12 col-sm-12">

            <div class="col-lg-6">
              <label class="form-label">Import</label>
              <input type="file" class="form-control choose-file"
                     @change="handleFileUpload"
                     style="border-color: #ffcc00; border-radius: 2px"/>
            </div>

            <div class="col-lg-3">
              <label class="form-label">Remark</label>
              <input type="text" v-model="form.remark" class="form-control"/>
            </div>

            <div class="col-lg-3">
              <label class="form-label">Type</label>
              <select v-model="form.type" class="form-select">
                <option>Bonus</option>
                <option>Deposit</option>
              </select>
            </div>
            </div>
          </div>
          <div class="modal-footer d-flex align-items-center justify-content-end">
            <button class="export-btn btn btn-outline-secondary" @click="downloadSampleFile">
              <Download size="16" stroke-width="2" class="me-2"/>
              Sample File
            </button>
            <button type="button" class="btn cancel-btn" @click="closeModal">Cancel</button>
            <button type="submit" class="btn submit-btn">Submit</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
import {ref} from 'vue';
import {Download} from "lucide-vue-next";
import * as XLSX from 'xlsx';

defineProps({
  modelValue: Boolean
});

const emit = defineEmits(['update:modelValue', 'submit']);

const initialForm = {
  transferFile: null,
  remark: '',
  type: 'Bonus',
}

const form = ref({...initialForm});

const handleFileUpload = (event) => {
  form.value.transferFile = event.target.files[0];
};

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

const downloadSampleFile = () => {
  const sampleData = [
    { Type: 'Bonus', Remark: 'Initial Bonus' },
    { Type: 'Deposit', Remark: 'Monthly Top-up' }
  ];

  const worksheet = XLSX.utils.json_to_sheet(sampleData);
  const workbook = XLSX.utils.book_new();
  XLSX.utils.book_append_sheet(workbook, worksheet, "BulkTransferSample");
  XLSX.writeFile(workbook, "bulk-transfer-sample.xlsx");
};
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

.export-btn {
  padding: 5px 20px;
  font-size: 12px;
  font-weight: 500;
}
</style>