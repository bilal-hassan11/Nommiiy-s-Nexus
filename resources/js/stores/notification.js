import { defineStore } from 'pinia'

export const useNotificationStore = defineStore('notification', {
    state: () => ({
        showSuccess: false,
    }),
    actions: {
        triggerSuccess() {
            this.showSuccess = true;
            setTimeout(() => {
                this.showSuccess = false
            }, 4000)
        }
    }
});
