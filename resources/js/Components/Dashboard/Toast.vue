<script setup>
import { computed, onMounted, ref } from 'vue';
import { usePage } from '@inertiajs/vue3';

const page    = usePage();
const visible = ref(false);
const type    = ref('success');
const text    = ref('');

const flash = computed(() => page.props.flash);

function show(msg, t = 'success') {
    text.value    = msg;
    type.value    = t;
    visible.value = true;
    setTimeout(() => visible.value = false, 4000);
}

// Watch for flash messages from Inertia
import { watch } from 'vue';
watch(() => flash.value?.success, (v) => v && show(v, 'success'));
watch(() => flash.value?.error,   (v) => v && show(v, 'error'));

defineExpose({ show });
</script>

<template>
    <Teleport to="body">
        <Transition name="toast">
            <div
                v-if="visible"
                :class="[
                    'fixed bottom-6 end-6 z-50 flex items-center gap-3 rounded-xl border px-4 py-3 shadow-lg text-sm font-medium max-w-sm',
                    type === 'success'
                        ? 'border-emerald-200 bg-emerald-50 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-300 dark:border-emerald-800'
                        : 'border-red-200 bg-red-50 text-red-800 dark:bg-red-900/30 dark:text-red-300 dark:border-red-800',
                ]"
            >
                <span>{{ type === 'success' ? '✓' : '✕' }}</span>
                {{ text }}
            </div>
        </Transition>
    </Teleport>
</template>

<style scoped>
.toast-enter-active, .toast-leave-active { transition: all 0.3s ease; }
.toast-enter-from, .toast-leave-to { opacity: 0; transform: translateY(1rem); }
</style>
