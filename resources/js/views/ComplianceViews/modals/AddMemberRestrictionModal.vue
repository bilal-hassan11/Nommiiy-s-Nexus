<template>
  <div v-if="modelValue" class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0, 0, 0, 0.5);">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" style="font-size: 18px">Create Member Restriction</h5>
          <button type="button" class="btn-close" style="font-size: 12px; font-weight: 600;"
                  @click="closeModal"></button>
        </div>
        <form @submit.prevent="submit">
          <div class="modal-body">
            <div class="mb-3 col-12">
              <label class="form-label">Merchant ID</label>
              <select v-model="form.merchant" class="form-select">
                <option value="All">All</option>
                <option>MJB</option>
                <option>MJB2</option>
                <option>MJB3</option>
              </select>
            </div>

            <div class="mb-3 col-12">
              <label class="form-label">Member Group</label>
              <select v-model="form.memberGroup" class="form-select">
                <option value="-">-</option>
                <option>Group1</option>
                <option>Group2</option>
                <option>Group3</option>
              </select>
            </div>

            <div class="mb-3 col-12">
              <label class="form-label">Username</label>
              <select v-model="form.username" class="form-select" style="border-color: #ffcc00; border-radius: 2px">
                <option disabled value="">Please select a username</option>
                <option v-for="user in usernameOptions" :key="user" :value="user">{{ user }}</option>
              </select>
            </div>

            <div class="mb-3 col-12">
              <label class="form-check-label checkbox-label" for="whitelist">Block Deposit</label>
              <input type="checkbox" v-model="form.blockDeposit" class="custom-checkbox form-check-input"
                     id="whitelist"/>
            </div>

            <!-- Provider Blocks -->
            <div class="mb-3 col-12">
              <div v-for="(section, index) in form.providerBlocks" :key="index" class="mb-4">
                <label class="form-check-label checkbox-label d-block mb-2">{{ section.title }}</label>
                <div class="row" style="background: whitesmoke; margin: 1px;">
                  <div class="col-md-4" v-for="(provider, i) in section.providers" :key="i">
                    <div class="form-check">
                      <input
                          type="checkbox"
                          class="form-check-input custom-checkbox"
                          v-model="provider.checked"
                          :id="section.title + '-' + provider.name"
                      />
                      <label class="form-check-label" :for="section.title + '-' + provider.name">
                        {{ provider.name }}
                      </label>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="mb-3 col-12">
              <label class="form-label">Status</label>
              <select v-model="form.status" class="form-select">
                <option value="All">All</option>
                <option>Active</option>
                <option>Inactive</option>
              </select>
            </div>

            <div class="mb-3 col-12">
              <label class="form-label">Remark</label>
              <input type="text" class="form-control" v-model="form.remark"/>
            </div>
          </div>

          <div class="modal-footer d-flex align-items-center justify-content-center">
            <button @click="resetForm" type="button" class="clear-btn btn btn-outline-dark">Clear</button>
            <button type="submit" class="btn submit-btn">Save</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
import {ref, watch} from 'vue';

defineProps({
  modelValue: Boolean
});

const emit = defineEmits(['update:modelValue', 'submit']);

const usernameOptions = [
  'john.doe@gmail.com',
  'jane.smith@gmail.com',
  'alice.johnson@gmail.com',
  'bob.lee@gmail.com'
];

const initialProviderBlocks = [
  {
    title: 'Provider',
    providers: [
      {name: 'Select All', checked: false},
      {name: '3SING', checked: false},
      {name: '9WICKETS', checked: false},
      {name: 'M8', checked: false},
      {name: 'NAGA', checked: false},
      {name: 'NextSpin', checked: false}
    ]
  },
  {
    title: 'Block Game Only',
    providers: [
      {name: 'Select All', checked: false},
      {name: '3SING', checked: false},
      {name: '9WICKETS', checked: false},
      {name: 'M8', checked: false},
      {name: 'NAGA', checked: false},
      {name: 'NextSpin', checked: false}
    ]
  },
  {
    title: 'Block Transfer Only',
    providers: [
      {name: 'Select All', checked: false},
      {name: '3SING', checked: false},
      {name: '9WICKETS', checked: false},
      {name: 'M8', checked: false},
      {name: 'NAGA', checked: false},
      {name: 'NextSpin', checked: false}
    ]
  }
];

const initialForm = {
  merchant: 'MJB',
  memberGroup: '-',
  username: '',
  blockDeposit: true,
  status: 'Active',
  remark: '',
  providerBlocks: JSON.parse(JSON.stringify(initialProviderBlocks))
};

const form = ref({...initialForm});

// Watcher for handling "Select All"
watch(() => form.value.providerBlocks, (newVal) => {
  newVal.forEach(section => {
    const selectAll = section.providers.find(p => p.name === 'Select All');
    if (selectAll?.checked) {
      section.providers.forEach(p => {
        if (p.name !== 'Select All') p.checked = true;
      });
    } else {
      const otherChecked = section.providers.filter(p => p.name !== 'Select All' && p.checked).length;
      if (otherChecked < section.providers.length - 1) {
        selectAll.checked = false;
      }
    }
  });
}, {deep: true});

const resetForm = () => {
  form.value = {
    ...initialForm,
    providerBlocks: JSON.parse(JSON.stringify(initialProviderBlocks))
  };
};

const submit = () => {
  emit('submit', {...form.value});
  emit('update:modelValue', false);
  resetForm();
};

const closeModal = () => {
  emit('update:modelValue', false);
  resetForm();
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

.clear-btn {
  font-size: 12px;
  font-weight: 600;
  padding: 5px 20px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

input[type="checkbox"] {
  transform: scale(0.85);
  margin-right: 6px;
}

.checkbox-label {
  font-size: 11px;
  font-weight: 500;
  color: #2c2c2c;
  display: flex;
  align-items: center;
  gap: 4px;
}

.custom-checkbox {
  appearance: none;
  -webkit-appearance: none;
  width: 16px;
  height: 16px;
  border: 2px solid #ccc;
  border-radius: 3px;
  background-color: #fff;
  cursor: pointer;
  position: relative;
  display: inline-block;
  vertical-align: middle;
}

.custom-checkbox:checked {
  background-color: #f1c40f;
  border-color: #f1c40f;
}

.custom-checkbox:checked::after {
  content: '✓';
  color: #fff !important;
  font-size: 11px;
  position: absolute;
  left: 2px;
  top: -1px;
}

.custom-checkbox:hover {
  border-color: #d4ac0d;
}

.form-check {
  margin-bottom: 6px;
}
</style>
