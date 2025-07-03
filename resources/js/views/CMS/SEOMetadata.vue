<template>
  <div class="row align-items-center form-header">
    <div class="col-lg-7 col-md-4 col-sm-6">
      <h2 class="form-title">CMS</h2>
      <p class="breadcrumb">CMS > <strong>SEO Metadata</strong></p>
    </div>
  </div>

  <div class="form-container">
    <div class="row gx-3 gy-3 mb-3">
      <div class="col-md-6 col-lg-4">
        <label>language</label>
        <select v-model="form.language" class="form-select">
          <option value="All">All</option>
          <option>EN-BD</option>
          <option>EN-US</option>
        </select>
      </div>
    </div>
  </div>

  <div class="form-container mt-3">
    <div class="table-responsive">
      <table class="table table-striped table-hover mb-0">
        <thead class="table-light">
        <tr>
          <th class="px-3 py-2 text-start">Display</th>
          <th class="px-3 py-2 text-center">Title</th>
          <th class="px-3 py-2 text-end">Description</th>
          <th class="px-3 py-2 text-end">Keyword</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="(data, index) in metadata" :key="index">
          <td class="px-3 py-2 text-start">{{ data.display }}</td>
          <td class="px-3 py-2 text-center" style="background-color: #e9ecef; border: 1px solid #ffc107;">
            {{ data.title }}
          </td>
          <td class="px-3 py-2 text-end" style="background-color: #e9ecef; border: 1px solid #ffc107;">
            {{ data.description }}
          </td>
          <td class="px-3 py-2 text-end" style="background-color: #e9ecef; border: 1px solid #ffc107;">
            {{ data.keyword }}
          </td>
        </tr>
        </tbody>
      </table>
    </div>
  </div>

</template>


<script setup>
import {ref} from "vue";

const form = ref({
  language: "EN-BD",
});

const metadata = ref([
  {
    display: "Home", title: "MajuBaji: The Premier Luxury Online Gaming Platform",
    description: "MajuBaji: Experience the premier online casino platform",
    keyword: "majubaji, majubaji bangladesh, majubaji casino"
  },

  {
    display: "Sports", title: "MajuBaji: The Premier Luxury Online Gaming Platform",
    description: "MajuBaji: Experience the premier online casino platform",
    keyword: "majubaji, majubaji bangladesh, majubaji casino"
  },

  {
    display: "Live Casino", title: "MajuBaji: The Premier Luxury Online Gaming Platform",
    description: "MajuBaji: Experience the premier online casino platform",
    keyword: "majubaji, majubaji bangladesh, majubaji casino"
  },

  {
    display: "Slot Games", title: "MajuBaji: The Premier Luxury Online Gaming Platform",
    description: "MajuBaji: Experience the premier online casino platform",
    keyword: "majubaji, majubaji bangladesh, majubaji casino"
  },

  {
    display: "Card", title: "MajuBaji: The Premier Luxury Online Gaming Platform",
    description: "MajuBaji: Experience the premier online casino platform",
    keyword: "majubaji, majubaji bangladesh, majubaji casino"
  },
]);

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

.table {
  font-size: 12px;
  border-radius: 5px;
  overflow: hidden;
}

th {
  background-color: #faf1e8;
  font-weight: 500;
  font-size: 13px;
  color: #5a5858;
  cursor: pointer;
  user-select: none;
}

td {
  font-size: 12px;
  font-weight: 500;
  color: #2c2c2c;
}

tr:hover td {
  background: #fde2c1;
}
</style>