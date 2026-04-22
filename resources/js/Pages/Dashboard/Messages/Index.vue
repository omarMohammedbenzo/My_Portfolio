<script setup>
import { Head, router } from '@inertiajs/vue3';
import { ref }          from 'vue';
import DashboardLayout  from '@/Layouts/DashboardLayout.vue';
import ConfirmDialog    from '@/Components/Dashboard/ConfirmDialog.vue';
import Badge            from '@/Components/ui/Badge.vue';
import Button           from '@/Components/ui/Button.vue';

const props      = defineProps({ messages: Object });
const confirmRef = ref(null);
const toDeleteId = ref(null);
const expanded   = ref(null);

function confirmDelete(id) { toDeleteId.value = id; confirmRef.value.show(); }
function doDelete()        { router.delete(route('dashboard.messages.destroy', toDeleteId.value), { preserveScroll: true }); }
function markRead(id)      { router.put(route('dashboard.messages.read', id), {}, { preserveScroll: true }); }
function toggle(id)        { expanded.value = expanded.value === id ? null : id; }

function mailtoLink(msg) {
    return `mailto:${msg.email}?subject=Re: ${encodeURIComponent(msg.subject ?? 'Your message')}&body=Hi ${encodeURIComponent(msg.name)},`;
}
</script>

<template>
    <Head title="Messages" />
    <DashboardLayout>
        <template #title>Messages</template>

        <div class="mb-5 flex items-center justify-between">
            <p class="text-sm text-muted-foreground">{{ messages.total }} messages</p>
        </div>

        <div class="space-y-2">
            <div
                v-for="msg in messages.data"
                :key="msg.id"
                class="rounded-lg border bg-card transition-colors"
                :class="msg.read_at ? 'border-border' : 'border-primary/40 bg-primary/5'"
            >
                <!-- Header row -->
                <div
                    class="flex items-center gap-3 p-4 cursor-pointer select-none"
                    @click="toggle(msg.id)"
                >
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2 flex-wrap">
                            <span class="text-sm font-medium text-foreground">{{ msg.name }}</span>
                            <span class="text-xs text-muted-foreground">{{ msg.email }}</span>
                            <Badge v-if="!msg.read_at" variant="default" class="text-xs">New</Badge>
                        </div>
                        <p class="mt-0.5 text-xs text-muted-foreground truncate">
                            {{ msg.subject ?? '(no subject)' }}
                        </p>
                    </div>
                    <span class="text-xs text-muted-foreground shrink-0">
                        {{ new Date(msg.created_at).toLocaleDateString() }}
                    </span>
                    <span class="text-muted-foreground text-xs">{{ expanded === msg.id ? '▲' : '▼' }}</span>
                </div>

                <!-- Expanded body -->
                <div v-if="expanded === msg.id" class="border-t border-border px-4 pb-4 pt-3 space-y-3">
                    <p class="text-sm whitespace-pre-wrap">{{ msg.message }}</p>
                    <div class="flex gap-2 flex-wrap">
                        <a :href="mailtoLink(msg)">
                            <Button variant="outline" size="sm">Reply via Email</Button>
                        </a>
                        <Button v-if="!msg.read_at" variant="secondary" size="sm" @click="markRead(msg.id)">
                            Mark as Read
                        </Button>
                        <Button variant="destructive" size="sm" @click="confirmDelete(msg.id)">Delete</Button>
                    </div>
                </div>
            </div>

            <p v-if="!messages.data?.length" class="py-12 text-center text-sm text-muted-foreground">
                No messages yet.
            </p>
        </div>

        <!-- Pagination -->
        <div v-if="messages.last_page > 1" class="mt-6 flex items-center justify-center gap-2">
            <Button
                v-for="page in messages.last_page"
                :key="page"
                :variant="page === messages.current_page ? 'default' : 'outline'"
                size="sm"
                @click="router.get(route('dashboard.messages.index'), { page }, { preserveScroll: true })"
            >{{ page }}</Button>
        </div>

        <ConfirmDialog ref="confirmRef" message="Delete this message permanently?" @confirm="doDelete" />
    </DashboardLayout>
</template>
