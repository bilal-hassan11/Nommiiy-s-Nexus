<template>
  <div class="row align-items-center form-header">
    <div class="col-lg-10 col-md-9 col-sm-12">
      <h2 class="form-title">Affiliate</h2>
      <p class="breadcrumb">Affiliate > <strong>Affiliate Page Setting</strong></p>
    </div>
  </div>
  <div class="form-container pb-4">
    <div class="row gx-3 gy-3">
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
  </div>
  <div class="form-container mt-3">
    <div class="row" style="font-size: 18px; font-weight: 600; margin: 30px 1px 10px 4px;">
      Affiliate FAQ {{ form.language }}
    </div>
    <TipTapEditor v-model="form.faq"/>
    <div class="button-group">
      <button class="btn search-btn">Save</button>
    </div>

    <div class="row" style="font-size: 18px; font-weight: 600; margin: 30px 1px 10px 4px;">
      Affiliate Contact Us {{ form.language }}
    </div>
    <TipTapEditor v-model="form.contactUs"/>
    <div class="button-group">
      <button class="btn search-btn">Save</button>
    </div>

    <div class="row" style="font-size: 18px; font-weight: 600; margin: 30px 1px 10px 4px;">
      Affiliate Commission Plan {{ form.language }}
    </div>
    <TipTapEditor v-model="form.commissionPlan"/>
    <div class="button-group">
      <button class="btn search-btn">Save</button>
    </div>

    <div class="row" style="font-size: 18px; font-weight: 600; margin: 30px 1px 10px 4px;">
      Affiliate About Us {{ form.language }}
    </div>
    <TipTapEditor v-model="form.aboutUs"/>
    <div class="button-group">
      <button class="btn search-btn">Save</button>
    </div>

    <div class="row" style="font-size: 18px; font-weight: 600; margin: 30px 1px 10px 4px;">
      Affiliate Terms and Conditions {{ form.language }}
    </div>
    <TipTapEditor v-model="form.terms"/>
    <div class="button-group">
      <button class="btn search-btn">Save</button>
    </div>

  </div>
</template>

<script setup>
import {ref} from 'vue';
import TipTapEditor from '@/components/editor/TipTapEditor.vue';
import {watch, onMounted} from 'vue';

const form = ref({
  language: 'EN-BD',
  faq: '',
  contactUs: '',
  commissionPlan: '',
  aboutUs: '',
  terms: ''
});

const languageContent = {
  'EN-BD': {
    faq: 'This is the FAQ content for EN-BD.',
    contactUs: 'Contact us at info@example.com.',
    commissionPlan: 'Commission details for EN-BD go here.',
    aboutUs: 'We are the EN-BD affiliate team.',
    terms: 'Terms and Conditions for EN-BD.'
  },
  'EN-UK': {
    faq: 'FAQ for UK region.',
    contactUs: 'Contact us at uk@example.com.',
    commissionPlan: 'Commission Plan UK.',
    aboutUs: 'UK Affiliate Description.',
    terms: 'UK Terms and Conditions.'
  },
  'EN-US': {
    faq: 'FAQ for US region.',
    contactUs: 'Contact info for US.',
    commissionPlan: 'US commission policy.',
    aboutUs: 'About EN-US team.',
    terms: 'US T&C content.'
  }
};

const preloadContent = () => {
  const content = languageContent[form.value.language] || {};
  form.value.faq = content.faq || '';
  form.value.contactUs = content.contactUs || '';
  form.value.commissionPlan = content.commissionPlan || '';
  form.value.aboutUs = content.aboutUs || '';
  form.value.terms = content.terms || '';
};

onMounted(preloadContent);

watch(() => form.value.language, preloadContent);

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

.button-group {
  display: flex;
  justify-content: flex-end;
  gap: 15px;
  margin-top: 20px;
}
</style>
