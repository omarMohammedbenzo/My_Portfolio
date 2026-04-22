<script setup>
import { ref } from 'vue';
import Button from '@/Components/ui/Button.vue';

const props  = defineProps({ message: { type: String, default: 'Are you sure?' } });
const emit   = defineEmits(['confirm', 'cancel']);
const open   = ref(false);

function show()    { open.value = true; }
function confirm() { open.value = false; emit('confirm'); }
function cancel()  { open.value = false; emit('cancel'); }

defineExpose({ show });
</script>

<template>
    <slot :show="show" />

    <Teleport to="body">
        <Transition name="fade">
            <div v-if="open" class="fixed inset-0 z-50 flex items-center justify-center">
                <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" @click="cancel" />
                <div class="relative z-10 w-full max-w-sm rounded-xl border border-border bg-card p-6 shadow-xl">
                    <p class="mb-6 text-sm text-foreground">{{ props.message }}</p>
                    <div class="flex justify-end gap-3">
                        <Button variant="outline" @click="cancel">Cancel</Button>
                        <Button variant="destructive" @click="confirm">Delete</Button>
                    </div>
                </div>
            </div>
        </Transition>
    </Teleport>
</template>

<style scoped>
.fade-enter-active, .fade-leave-active { transition: opacity 0.15s; }
.fade-enter-from, .fade-leave-to { opacity: 0; }
</style>
