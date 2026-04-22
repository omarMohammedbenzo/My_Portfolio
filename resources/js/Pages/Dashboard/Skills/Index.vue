<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import { ref, computed }       from 'vue';
import DashboardLayout         from '@/Layouts/DashboardLayout.vue';
import ConfirmDialog           from '@/Components/Dashboard/ConfirmDialog.vue';
import Badge                   from '@/Components/ui/Badge.vue';
import Button                  from '@/Components/ui/Button.vue';

const props      = defineProps({ skills: Array, categories: Array });
const confirmRef = ref(null);
const toDeleteId = ref(null);

const grouped = computed(() => {
    const map = {};
    for (const s of props.skills) {
        if (!map[s.category]) map[s.category] = [];
        map[s.category].push(s);
    }
    return map;
});

function catLabel(val) { return props.categories.find(c => c.value === val)?.label ?? val; }
function confirmDelete(id) { toDeleteId.value = id; confirmRef.value.show(); }
function doDelete() { router.delete(route('dashboard.skills.destroy', toDeleteId.value), { preserveScroll: true }); }
</script>

<template>
    <Head title="Skills" />
    <DashboardLayout>
        <template #title>Skills</template>
        <div class="mb-5 flex items-center justify-between">
            <p class="text-sm text-muted-foreground">{{ skills.length }} skills</p>
            <Link :href="route('dashboard.skills.create')"><Button>+ Add Skill</Button></Link>
        </div>
        <div class="space-y-6">
            <div v-for="(items, cat) in grouped" :key="cat">
                <h3 class="mb-2 text-xs font-semibold uppercase tracking-wider text-muted-foreground">{{ catLabel(cat) }}</h3>
                <div class="grid gap-2 sm:grid-cols-2 lg:grid-cols-3">
                    <div v-for="skill in items" :key="skill.id" class="rounded-lg border border-border bg-card p-3 flex items-center justify-between gap-2">
                        <div>
                            <p class="text-sm font-medium text-foreground">{{ skill.name?.en }}</p>
                            <div class="mt-1 flex gap-0.5">
                                <div v-for="n in 5" :key="n" :class="['h-1.5 w-4 rounded-full', n <= skill.level ? 'bg-primary' : 'bg-muted']" />
                            </div>
                        </div>
                        <div class="flex gap-1 shrink-0">
                            <Link :href="route('dashboard.skills.edit', skill.id)"><Button variant="outline" size="sm">Edit</Button></Link>
                            <Button variant="destructive" size="sm" @click="confirmDelete(skill.id)">Del</Button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <ConfirmDialog ref="confirmRef" message="Delete this skill?" @confirm="doDelete" />
    </DashboardLayout>
</template>
