<template>
  <GeneralInfoSettingModal v-model="showModal" @submit="handleFormSubmit"/>
  <div class="row align-items-center form-header">
    <div class="col-lg-10 col-md-8 col-sm-12">
      <h2 class="form-title">CMS</h2>
      <p class="breadcrumb">CMS > <strong>General Info</strong></p>
    </div>
    <div class="col-lg-2 col-md-4 col-4 col-sm-12 d-flex justify-content-end gap-2">
      <button class="btn tag-btn d-flex align-items-center justify-content-center"
              @click="showModal = true">
        Display Setting
      </button>
    </div>
  </div>
  <div class="form-container pb-4">
    <div class="row gx-3 gy-3">
      <div class="col-md-6 col-lg-3">
        <label>Merchant</label>
        <select v-model="form.merchant" class="form-select">
          <option value="All">All</option>
          <option>MJB</option>
          <option>MJB2</option>
          <option>MJB3</option>
        </select>
      </div>
      <div class="col-md-6 col-lg-3">
        <label>Language</label>
        <select v-model="form.language" class="form-select">
          <option>All</option>
          <option>EN-BD</option>
          <option>EN-UK</option>
          <option>EN-US</option>
        </select>
      </div>
    </div>
    <div class="col-12 d-flex justify-content-end gap-2 mt-3">
      <button @click="clearForm" class="clear-btn btn btn-outline-dark">Clear</button>
      <button class="search-btn btn btn-primary text-dark">Search</button>
    </div>
  </div>
  <div class="form-container mt-3">
    <div class="row" style="font-size: 18px; font-weight: 600; margin: 30px 1px 10px 4px;">
      About Us {{ form.language }}
    </div>
    <TipTapEditor v-model="form.aboutUs"/>
    <div class="button-group">
      <button class="btn search-btn">Save</button>
    </div>
  </div>

  <div class="form-container mt-3">
    <div class="row" style="font-size: 18px; font-weight: 600; margin: 30px 1px 10px 4px;">
      FAQ {{ form.language }}
    </div>
    <TipTapEditor v-model="form.faq"/>
    <div class="button-group">
      <button class="btn search-btn">Save</button>
    </div>
  </div>

  <div class="form-container mt-3">
    <div class="row" style="font-size: 18px; font-weight: 600; margin: 30px 1px 10px 4px;">
      Terms & Conditions {{ form.language }}
    </div>
    <TipTapEditor v-model="form.terms"/>
    <div class="button-group">
      <button class="btn search-btn">Save</button>
    </div>
  </div>

  <div class="form-container mt-3">
    <div class="row" style="font-size: 18px; font-weight: 600; margin: 30px 1px 10px 4px;">
      Privacy Policy {{ form.language }}
    </div>
    <TipTapEditor v-model="form.privacyPolicy"/>
    <div class="button-group">
      <button class="btn search-btn">Save</button>
    </div>
  </div>

  <div class="form-container mt-3">
    <div class="row" style="font-size: 18px; font-weight: 600; margin: 30px 1px 10px 4px;">
      Responsible Gaming {{ form.language }}
    </div>
    <TipTapEditor v-model="form.responsibleGaming"/>
    <div class="button-group">
      <button class="btn search-btn">Save</button>
    </div>
  </div>

  <div class="form-container mt-3">
    <div class="row" style="font-size: 18px; font-weight: 600; margin: 30px 1px 10px 4px;">
      Disconnect Policy {{ form.language }}
    </div>
    <TipTapEditor v-model="form.disconnectPolicy"/>
    <div class="button-group">
      <button class="btn search-btn">Save</button>
    </div>
  </div>
</template>

<script setup>
import {onMounted, ref, watch} from 'vue';
import TipTapEditor from '@/components/editor/TipTapEditor.vue';
import GeneralInfoSettingModal from "@/views/CMS/modals/GeneralInfoSettingModal.vue";

const showModal = ref(false);

const handleFormSubmit = (formData) => {
  console.log("Received Form Data:", formData)
  // Process submission (API call etc.)
}

const form = ref({
  language: 'EN-BD',
  merchant: 'MJB',
  aboutUs: '',
  faq: '',
  terms: '',
  privacyPolicy: '',
  responsibleGaming: '',
  disconnectPolicy: '',
});

const languageContent = {
  'EN-BD': {
    faq: 'This is the FAQ content for EN-BD.',
    privacyPolicy: 'Commission details for EN-BD go here.',
    aboutUs: 'We are the EN-BD affiliate team.',
    terms: 'Terms and Conditions for EN-BD.',
    responsibleGaming: 'Terms and Conditions for EN-BD.',
    disconnectPolicy: 'Terms and Conditions for EN-BD.'
  },
  'EN-UK': {
    faq: 'FAQ for UK region.',
    privacyPolicy: 'Commission Plan UK.',
    aboutUs: 'UK Affiliate Description.',
    terms: 'UK Terms and Conditions.',
    responsibleGaming: 'UK Terms and Conditions.',
    disconnectPolicy: 'UK Terms and Conditions.'
  },
  'EN-US': {
    faq: 'FAQ for US region.',
    privacyPolicy: 'US commission policy.',
    aboutUs: 'About EN-US team.',
    terms: 'US T&C content.',
    responsibleGaming: 'US T&C content.',
    disconnectPolicy: 'US T&C content.'
  }
};

const preloadContent = () => {
  const content = languageContent[form.value.language] || {};
  form.value.faq = content.faq || '';
  form.value.privacyPolicy = content.privacyPolicy || '';
  form.value.responsibleGaming = content.responsibleGaming || '';
  form.value.disconnectPolicy = content.disconnectPolicy || '';
  form.value.aboutUs = content.aboutUs || '';
  form.value.terms = content.terms || '';
};

onMounted(preloadContent);

watch(() => form.value.language, preloadContent);

const clearForm = () => {
  form.value.merchant = "MJB";
  form.value.language = "EN-BD";
}
</script>

<style scoped>
.form-header {
  padding-right: 10px;
}

.form-container {
  width: 99%;
  background: #fff;
  padding: 10px 20px 10px 20px;
  border-radius: 5px;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
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

.clear-btn {
  font-size: 12px;
  font-weight: 600;
  padding: 5px 20px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

.button-group {
  display: flex;
  justify-content: flex-end;
  gap: 15px;
  margin-top: 20px;
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
