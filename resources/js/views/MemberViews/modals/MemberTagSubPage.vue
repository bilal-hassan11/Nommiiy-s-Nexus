<template>
    <div class="row align-items-center form-header">
      <div class="col-lg-7 col-md-4 col-sm-6">
        <h2 class="form-title">Member</h2>
        <p class="breadcrumb">Member > <strong>Tag Management</strong></p>
      </div>
      <div class="col-lg-5 col-md-8 col-sm-6 d-flex align-items-center justify-content-end">
        <button class="btn tag-btn me-2 disabled">Tags Adjustment History</button>
      </div>
    </div>

    <div class="form-container py-4">
      <h3 class="form-title mb-4">New Tag</h3>
      <form @submit.prevent="submit">
        <div class="mb-3 btn-group gap-3" role="group">
          <button type="button"
                  class="btn mode-btn"
                  :class="{ 'active-mode': mode === 'single' }"
                  @click="mode = 'single'">Single
          </button>
          <button type="button"
                  class="btn mode-btn"
                  :class="{ 'active-mode': mode === 'batch' }"
                  @click="mode = 'batch'">Batch
          </button>
        </div>

        <div class="mb-3 col-lg-6">
          <label class="form-label">*Tag Name</label>
          <input type="text" v-model="form.tag_name" class="form-control" placeholder="Please Enter Text" required/>
        </div>

        <div class="row mb-3">
          <div class="col-lg-6">
            <label class="form-label">Description</label>
            <textarea v-model="form.description" class="form-control"/>
          </div>
          <div class="col-lg-6">
            <label class="form-label">Remark</label>
            <textarea v-model="form.remark" class="form-control"/>
          </div>
        </div>

        <div class="mb-3">
          <h6>Domain Binding</h6>
          <div class="radio-group gap-3">
            <div class="form-check gap-2 d-flex align-center">
              <input class="form-check-input" type="radio" v-model="form.domainBinding" id="domainYes" value=true>
              <label class="form-check-label" for="domainYes">Yes</label>
            </div>
            <div class="form-check gap-2 d-flex align-center">
              <input class="form-check-input" type="radio" v-model="form.domainBinding" id="domainNo" value=false>
              <label class="form-check-label" for="domainNo">No</label>
            </div>
          </div>
        </div>

        <div class="d-flex justify-content-end mt-4">
          <button type="button" class="btn cancel-btn me-2" @click="cancel">Cancel</button>
          <button type="submit" class="btn submit-btn">Save</button>
        </div>
      </form>
    </div>
  </template>


  <script setup>
  import {ref} from 'vue';
  import {useRouter} from 'vue-router';

  const router = useRouter();

  const mode = ref('single');
  const initialForm = {
    tag_name: '',
    description: '',
    remark: '',
    domainBinding: false
  };
  const form = ref({...initialForm});

  const submit = () => {
    const payload = {
      ...form.value,
      mode: mode.value
    };

    router.push({
      name: 'tag-management',
      state: {newTag: payload}
    });
  };

  const cancel = () => {
    router.push({name: 'tag-management'});
  };
  </script>

  <style scoped>
  .form-container {
    width: 99%;
    background: #fff;
    padding: 10px 20px 10px 20px;
    border-radius: 5px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
  }

  .form-header {
    padding-right: 10px;
  }

  .form-title {
    font-size: 18px;
    font-weight: bold;
  }

  .breadcrumb {
    font-size: 12px;
    color: #3a3a3a;
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

  .radio-group {
    display: flex;
  }

  .form-check {
    display: flex;
    align-items: flex-start;
    margin: 0 10px 0 0;
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
    background: #ccc;
  }

  .cancel-btn:hover {
    background: #a5a5a1;
  }

  .mode-btn {
    font-size: 12px;
    font-weight: 600;
    padding: 5px 20px;
    border: 1px solid #ddd;
    background: white;
    color: #333;
  }

  .mode-btn.active-mode {
    background: #d6b402;
    color: white;
    border-color: #d6b402;
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

  .tag-btn {
    font-size: 12px;
    font-weight: 600;
    background: #e8c015;
    padding: 8px 26px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
  }

  .tag-btn:hover {
    background: #d6b402;
  }
  </style>
