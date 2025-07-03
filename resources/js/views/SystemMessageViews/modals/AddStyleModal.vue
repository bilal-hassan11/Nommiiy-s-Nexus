<template>
  <div v-if="modelValue" class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0, 0, 0, 0.5);">
    <div class="modal-dialog modal-dialog-centered modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Add Style</h5>
          <button type="button" class="btn-close" @click="closeModal"/>
        </div>

        <form @submit.prevent="submit">
          <div class="modal-body px-4">
            <!-- Desktop Section -->
            <div class="mb-4">
              <h6>Desktop</h6>
              <div class="mb-3">
                <label class="form-label">Speed</label>
                <select v-model="form.desktop.speed" class="form-select">
                  <option value="Slow">Slow</option>
                  <option value="Medium">Medium</option>
                  <option value="Fast">Fast</option>
                </select>
              </div>
              <div class="mb-3">
                <label class="form-label">Color</label>
                <div class="row d-flex align-items-center">
                  <div class="col-lg-2 col-md-3">
                    <input v-model="form.desktop.color" type="color" class="form-control-color"
                           style="border-radius: 35px"/>
                  </div>
                  <div class="col-lg-8 col-md-7">
                    <input v-model="form.desktop.color" type="text" class="form-control mt-1"/>
                  </div>
                </div>
              </div>
            </div>

            <!-- Mobile Section -->
            <div>
              <h6>Mobile</h6>
              <div class="mb-3">
                <label class="form-label">Speed</label>
                <select v-model="form.mobile.speed" class="form-select">
                  <option value="Slow">Slow</option>
                  <option value="Medium">Medium</option>
                  <option value="Fast">Fast</option>
                </select>
              </div>
              <div class="mb-3">
                <label class="form-label">Color</label>
                <div class="row d-flex align-items-center">
                  <div class="col-lg-2 col-md-3">
                    <input v-model="form.mobile.color" type="color" class="form-control-color"
                           style="border-radius: 35px"/>
                  </div>
                  <div class="col-lg-8 col-md-7">
                    <input v-model="form.mobile.color" type="text" class="form-control mt-1"/>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="modal-footer d-flex justify-content-center">
            <button type="button" class="btn btn-outline-light clear-btn" @click="closeModal">Cancel</button>
            <button type="submit" class="btn btn-warning submit-btn">Save</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
import {ref} from 'vue'

defineProps({
  modelValue: Boolean
})

const emit = defineEmits(['update:modelValue', 'submit'])

const form = ref({
  desktop: {
    speed: 'Medium',
    color: '#ff0000',
  },
  mobile: {
    speed: 'Slow',
    color: '#ff0000',
  },
})

const resetForm = () => {
  form.value = {
    desktop: {
      speed: 'Medium',
      color: '#ff0000',
    },
    mobile: {
      speed: 'Slow',
      color: '#ff0000',
    },
  }
}

const submit = () => {
  emit('submit', {...form.value})
  emit('update:modelValue', false)
  resetForm()
}

const closeModal = () => {
  emit('update:modelValue', false)
  resetForm()
}
</script>

<style scoped>
.modal-title {
  font-size: 18px;
  font-weight: 600;
}

.form-control-color {
  width: 40px;
  height: 40px;
  border: none;
  padding: 0;
}

label {
  font-size: 12px;
  font-weight: 600;
  margin-bottom: 5px;
}

input,
select {
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
  color: black;
}
</style>
