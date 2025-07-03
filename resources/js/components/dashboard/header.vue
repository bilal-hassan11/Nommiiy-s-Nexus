<script setup>
import { ref, onMounted } from "vue";

const systemTimeZone = ref("");

onMounted(() => {
  const offset = new Date().getTimezoneOffset();
  const hours = Math.abs(Math.floor(offset / 60));
  const minutes = Math.abs(offset % 60);
  const sign = offset > 0 ? "-" : "+";
  systemTimeZone.value = `GMT${sign}${String(hours).padStart(2, "0")}${String(minutes).padStart(2, "0")}`;
});
</script>

<template>
  <div class="container-fluid p-3">
    <div class="row align-items-center">
      <!-- Left Section -->
      <div class="col-12 col-md-4 mb-3 mb-md-0 text-center text-md-start">
        <h2 class="fs-5 fw-semibold">Overview</h2>
        <p class="text-secondary small m-0">Overview > <span class="text-dark fw-bold">Graph</span></p>
      </div>

      <!-- Right Section -->
      <div class="col-12 col-md-8 d-flex flex-wrap gap-2 justify-content-center justify-content-md-end align-items-center">
        <button class="btn btn-warning text-white fw-semibold bdt">BDT</button>
        <button class="btn btn-light text-secondary fw-semibold border npr">NPR</button>
        <span class="text-danger fw-semibold" style="font-size: 13px">Update per 30 minutes</span>
        <button class="btn btn-warning text-dark fw-semibold refresh-btn">Refresh</button>
        <button class="btn btn-outline-dark fw-semibold small px-2 sys-time-zone">
          {{ systemTimeZone }} (System Time Zone)
        </button>
      </div>
    </div>
  </div>
</template>

<style scoped>
button {
  height: 35px;
  font-size: 13px;
  font-weight: 600;
}

.bdt, .npr {
  width: 72px;
}

.refresh-btn {
  width: 92px;
}

.sys-time-zone {
  font-size: 11px;
  padding: 5px 10px;
  cursor: default;
  color: black;
}

.sys-time-zone:hover {
  color: white;
}

.bdt {
  background: #f4c938;
}

.bdt:hover {
  background: #d8ac13;
}

/* Mobile Responsiveness */
@media (max-width: 767.98px) {
  .container-fluid {
    padding: 10px !important;
  }

  .row {
    flex-direction: column;
    align-items: center;
    gap: 10px;
  }

  .col-12 {
    width: 100%;
    text-align: center;
  }

  .bdt, .npr, .refresh-btn {
    width: 100%;
    max-width: 150px;
  }

  .sys-time-zone {
    width: 100%;
    max-width: 200px;
  }

  .text-danger {
    font-size: 12px !important;
  }
}
</style>
