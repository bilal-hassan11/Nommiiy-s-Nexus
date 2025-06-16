<template>
  <div class="col-md-6 col-lg-3">
    <label>Language</label>
    <select v-model="form.language" class="form-select">
      <option>All</option>
      <option>EN-BD</option>
      <option>EN-UK</option>
      <option>EN-US</option>
    </select>
  </div>
    <div class="row" style="font-size: 18px; font-weight: 600; margin: 30px 1px 10px 4px;">
      Terms & Conditions {{form.language}}
    </div>
    <TipTapEditor/>
    <div class="button-group">
      <button class="btn search-btn">Save</button>
    </div>
</template>

<script setup>
import {ref} from 'vue';
import TipTapEditor from '@/components/editor/TipTapEditor.vue';

const form = ref({
  language: 'EN-BD',
});
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

.button-group {
  display: flex;
  justify-content: flex-end;
  gap: 15px;
  margin-top: 20px;
}
</style>
