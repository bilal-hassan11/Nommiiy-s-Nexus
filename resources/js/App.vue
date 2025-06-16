
<script setup>
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap/dist/js/bootstrap.bundle.min.js';
import SidebarMenu from "@/components/navbars/SideNavbar.vue";
import TopNavbar from "@/components/navbars/TopNavbar.vue";
import { onMounted, onUnmounted, ref } from "vue";

const isSidebarOpen = ref(false);
const isMobile = ref(window.innerWidth < 768);

const updateScreenSize = () => {
  console.log(isSidebarOpen.value)

  isMobile.value = window.innerWidth < 768;
  if (!isMobile.value) isSidebarOpen.value = true; // Always show sidebar on large screens
};

onMounted(() => {
  window.addEventListener('resize', updateScreenSize);
  updateScreenSize();
});

onUnmounted(() => {
  window.removeEventListener('resize', updateScreenSize);

});
const closeSidebar = () => {
  isSidebarOpen.value = false;
};
</script>

<template>
  <div class="container-fluid p-0">
    <!-- Top Navbar -->
    <nav class="d-flex justify-content-between align-items-center text-white top-nav">
      <TopNavbar :isMobile="isMobile" @toggle-sidebar="isSidebarOpen = !isSidebarOpen" />
    </nav>

    <div class="d-flex">
      <div :class="[{ 'd-none': isMobile && !isSidebarOpen }]">
        <SidebarMenu @close-sidebar="closeSidebar" />
      </div>

      <div class="main-content">
        <router-view />
      </div>
    </div>
  </div>
</template>

<style scoped>
html, body {
  overflow-x: hidden;
  width: 100%;
  margin: 0;
  padding: 0;
}

.container-fluid {
  max-width: 100vw;
  overflow-x: hidden;
}

.main-content {
  flex-grow: 1;
  min-width: 0;
  background: whitesmoke;
  padding: 20px 30px 20px 30px;
  overflow-x: hidden;
}

.top-nav {
  background-color: #2c2c2c;
  padding: 5px;
  width: 100%;
  z-index: 1000;
}

</style>