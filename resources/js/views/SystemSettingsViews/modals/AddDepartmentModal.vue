<template>
  <div v-if="modelValue" class="modal fade show d-block" tabindex="-1" style="background: rgba(0,0,0,0.5);">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h5 class="modal-title">Create A User Role</h5>
          <button type="button" class="btn-close" @click="closeModal">x</button>
        </div>

        <!-- Modal Body -->
        <div class="modal-body">
          <form @submit.prevent="submit">

            <!-- Top Form Row -->
            <div class="row g-3 mb-4">
              <div class="col-md-4" v-for="(label, key) in formFields" :key="key">
                <label :for="key" class="form-label">{{ label.label }}</label>
                <component
                    :is="label.type === 'select' ? 'select' : 'input'"
                    v-model="form[key]"
                    :class="label.type === 'select' ? 'form-select' : 'form-control'"
                    :type="label.type === 'text' ? 'text' : undefined"
                >
                  <option v-for="option in label.options || []" :key="option" :value="option">
                    {{ option }}
                  </option>
                </component>
              </div>
            </div>

            <!-- Permission Table -->
            <div class="table-responsive">
              <table class="table table-striped text-center align-middle">
                <thead class="table-light">
                <tr>
                  <th class="text-start">
                    <input
                        type="checkbox"
                        :checked="allSelected('access')"
                        :indeterminate="someSelected('access') && !allSelected('access')"
                        @change="toggleAll('access', $event.target.checked)"
                        class="custom-checkbox me-1"
                    />
                    Access
                  </th>
                  <th v-for="col in permissions.columns.slice(1)" :key="col" class="text-center">
                    <input
                        type="checkbox"
                        :checked="allSelected(col.toLowerCase())"
                        :indeterminate="someSelected(col.toLowerCase()) && !allSelected(col.toLowerCase())"
                        @change="toggleAll(col.toLowerCase(), $event.target.checked)"
                        class="custom-checkbox me-1"
                    />
                    {{ col }}
                  </th>
                </tr>
                </thead>

                <tbody>
                <tr v-for="item in permissions.modules" :key="item.name">
                  <td class="text-start">
                    <input
                        type="checkbox"
                        v-model="item.access"
                        class="custom-checkbox me-1"
                    />
                    <component
                        :is="iconMap[item.icon]"
                        class="me-2"
                        size="16"
                        stroke-width="2"
                    />
                    {{ item.name }}
                  </td>
                  <td v-for="col in permissions.columns.slice(1)" :key="col" class="text-center">
                    <input
                        type="checkbox"
                        v-model="item[col.toLowerCase()]"
                        class="custom-checkbox"
                    />
                  </td>
                </tr>
                </tbody>
              </table>
            </div>

          </form>
        </div>

        <!-- Footer -->
        <div class="modal-footer d-flex justify-content-center">
          <button type="button" class="btn btn-outline-light text-dark clear-btn" @click="closeModal">Cancel</button>
          <button type="submit" class="btn btn-warning search-btn" @click="submit">Save</button>
        </div>

      </div>
    </div>
  </div>
</template>

<script setup>
import {reactive} from 'vue';
import {
  BadgeCheck, Banknote, Boxes, CalendarClock, ChevronRight, Clock, Crown, Dot, Gift,
  Goal, Home, Mail, Megaphone, Network, Star, Tag, Trophy, UsersRound, Wallet, Box, Settings, BriefcaseBusiness,
  FileQuestion
} from "lucide-vue-next";

const iconMap = {
  BadgeCheck, Banknote, Boxes, CalendarClock, ChevronRight, Clock, Crown, Dot, Gift,
  Goal, Home, Mail, Megaphone, Network, Star, Tag, Trophy, UsersRound, Wallet, Box, Settings, BriefcaseBusiness,
  FileQuestion
};

defineProps({modelValue: Boolean});
const emit = defineEmits(['update:modelValue', 'submit']);

const formFields = {
  merchant: {label: 'Merchant', type: 'select', options: ['MJB', 'MJB2']},
  name: {label: 'Name', type: 'text'},
  role: {label: 'Role', type: 'select', options: ['Admin', 'Editor', 'Viewer']},
  remark: {label: 'Remark', type: 'text'},
  status: {label: 'Status', type: 'select', options: ['Active', 'Inactive']},
  sensitiveMobile: {label: 'Sensitive Data (Mobile)', type: 'select', options: ['Viewable', 'Hidden']},
  sensitiveEmail: {label: 'Sensitive Data (Email)', type: 'select', options: ['Viewable', 'Hidden']},
  sensitiveLineId: {label: 'Sensitive Data (Line ID)', type: 'select', options: ['Viewable', 'Hidden']}
};

const form = reactive({
  merchant: '',
  name: '',
  role: 'Admin',
  remark: '',
  status: 'Active',
  sensitiveMobile: 'Viewable',
  sensitiveEmail: 'Viewable',
  sensitiveLineId: 'Viewable'
});

const permissions = reactive({
  columns: ['Access', 'Viewable', 'Editable', 'Creatable', 'Exportable'],
  modules: [
    {
      name: '0. Dashboard',
      icon: 'Home',
      access: true,
      viewable: true,
      editable: false,
      creatable: false,
      exportable: false
    },
    {
      name: '1. Member',
      icon: 'UsersRound',
      access: true,
      viewable: true,
      editable: true,
      creatable: false,
      exportable: false
    },
    {
      name: '2. Deposit/Withdraw',
      icon: 'Wallet',
      access: true,
      viewable: true,
      editable: true,
      creatable: true,
      exportable: false
    },
    {
      name: '3. Promotion',
      icon: 'Gift',
      access: true,
      viewable: true,
      editable: true,
      creatable: true,
      exportable: false
    },
    {
      name: '4. VIP Mode',
      icon: 'Crown',
      access: true,
      viewable: true,
      editable: true,
      creatable: false,
      exportable: false
    },
    {
      name: '5. Event Management',
      icon: 'CalendarClock',
      access: true,
      viewable: true,
      editable: false,
      creatable: false,
      exportable: false
    },
    {
      name: '6. Mission Daily Setting',
      icon: 'Goal',
      access: true,
      viewable: true,
      editable: false,
      creatable: false,
      exportable: false
    },
    {
      name: '7. Referral',
      icon: 'Boxes',
      access: true,
      viewable: true,
      editable: false,
      creatable: false,
      exportable: false
    },
    {
      name: '8. Tournament',
      icon: 'Trophy',
      access: true,
      viewable: true,
      editable: false,
      creatable: false,
      exportable: false
    },
    {
      name: '9. Verify Reward',
      icon: 'BadgeCheck',
      access: true,
      viewable: true,
      editable: false,
      creatable: false,
      exportable: false
    },
    {
      name: '10. Soccer',
      icon: 'Star',
      access: true,
      viewable: true,
      editable: false,
      creatable: false,
      exportable: false
    },
    {
      name: '11. Angpow',
      icon: 'Mail',
      access: true,
      viewable: true,
      editable: false,
      creatable: false,
      exportable: false
    },
    {
      name: '12. Rebate',
      icon: 'Tag',
      access: true,
      viewable: true,
      editable: false,
      creatable: false,
      exportable: false
    },
    {
      name: '13. Report',
      icon: 'Clock',
      access: true,
      viewable: true,
      editable: false,
      creatable: false,
      exportable: false
    },
    {
      name: '14. System Message',
      icon: 'Megaphone',
      access: true,
      viewable: true,
      editable: false,
      creatable: false,
      exportable: false
    },
    {
      name: '15. Bank/Payment',
      icon: 'Banknote',
      access: true,
      viewable: true,
      editable: false,
      creatable: false,
      exportable: false
    },
    {
      name: '16. Affiliate',
      icon: 'Network',
      access: true,
      viewable: true,
      editable: false,
      creatable: false,
      exportable: false
    },
    {
      name: '17. Affiliate Comm',
      icon: 'Box',
      access: true,
      viewable: true,
      editable: false,
      creatable: false,
      exportable: false
    },
    {
      name: '18. System Settings',
      icon: 'Settings',
      access: true,
      viewable: true,
      editable: false,
      creatable: false,
      exportable: false
    },
    {
      name: '19. CMS',
      icon: 'BriefcaseBusiness',
      access: true,
      viewable: true,
      editable: false,
      creatable: false,
      exportable: false
    },
    {
      name: '20. Compliance',
      icon: 'FileQuestion',
      access: true,
      viewable: true,
      editable: false,
      creatable: false,
      exportable: false
    },
    {
      name: '21. Leaderboard Data',
      icon: 'BriefcaseBusiness',
      access: true,
      viewable: true,
      editable: false,
      creatable: false,
      exportable: false
    }
  ]
});

const closeModal = () => emit('update:modelValue', false);

const allSelected = (key) =>
    permissions.modules.every((m) => m[key]);

const someSelected = (key) =>
    permissions.modules.some((m) => m[key]);

const toggleAll = (key, checked) => {
  permissions.modules.forEach((m) => {
    m[key] = checked;
  });
};

const submit = () => {
  emit('submit', {
    ...form,
    permissions: permissions.modules.map((m) => ({
      name: m.name,
      viewable: m.viewable,
      editable: m.editable,
      creatable: m.creatable,
      exportable: m.exportable
    }))
  });
  closeModal();
};
</script>

<style scoped>
.modal-title {
  font-size: 18px;
  font-weight: 600;
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

.form-label {
  font-size: 13px;
  font-weight: 500;
}

.btn-close {
  background: none;
  border: none;
  font-size: 20px;
}

th,
td {
  padding: 10px;
  text-align: left;
  font-size: 13px;
}

th {
  background-color: #fff8f8;
  cursor: pointer;
  user-select: none;
}

tr:hover td {
  background-color: #f0f0f0;
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

.clear-btn {
  font-size: 12px;
  font-weight: 600;
  padding: 5px 20px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
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
</style>
