<script setup>
import { computed }    from 'vue';
import { Icon }        from '@iconify/vue';

const props = defineProps({
    skills: Object, // { backend: [...], frontend: [...], tools: [...] }
});

const categoryOrder  = ['backend', 'frontend', 'tools', 'other'];
const categoryLabels = {
    backend:  'Backend',
    frontend: 'Frontend',
    tools:    'Tools & DevOps',
    other:    'Other',
};

const orderedCategories = computed(() =>
    categoryOrder.filter(c => props.skills?.[c]?.length)
);

function iconName(skill) {
    const set  = skill.icon_set ?? 'lucide';
    const slug = skill.icon_slug ?? 'code';
    if (set === 'simple-icons') return `simple-icons:${slug}`;
    return `lucide:${slug}`;
}

function iconColor(skill) {
    // Special handling: GitHub white can look harsh — 90% opacity via CSS
    if (skill.icon_slug === 'github') return '#e5e5e5';
    if (skill.icon_color) return skill.icon_color;
    // Lucide fallback — use theme accent
    return 'var(--color-accent-primary)';
}

function glowColor(skill) {
    const c = skill.icon_color;
    if (!c || c === '#FFFFFF') return 'rgba(var(--color-accent-primary-rgb), 0.25)';
    // Derive rgba from hex
    const r = parseInt(c.slice(1, 3), 16);
    const g = parseInt(c.slice(3, 5), 16);
    const b = parseInt(c.slice(5, 7), 16);
    return `rgba(${r}, ${g}, ${b}, 0.25)`;
}
</script>

<template>
    <section id="skills" class="py-24" style="background: var(--color-background);">
        <div class="mx-auto max-w-6xl px-4">

            <!-- Header -->
            <div class="mb-14 text-center">
                <p class="eyebrow mb-3">What I Work With</p>
                <h2 class="text-3xl font-bold text-foreground sm:text-4xl">Skills &amp; Tools</h2>
            </div>

            <!-- Categories -->
            <div class="space-y-12">
                <div
                    v-for="cat in orderedCategories"
                    :key="cat"
                >
                    <!-- Category label -->
                    <h3 class="mb-5 text-xs font-bold uppercase tracking-widest text-muted-foreground">
                        {{ categoryLabels[cat] ?? cat }}
                    </h3>

                    <!-- Card grid -->
                    <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5">
                        <div
                            v-for="(skill, idx) in skills[cat]"
                            :key="skill.id"
                            v-motion
                            :initial="{ opacity: 0, y: 30 }"
                            :visibleOnce="{ opacity: 1, y: 0, transition: { duration: 450, delay: idx * 60 } }"
                            class="skill-card glass-card p-5 flex flex-col items-center gap-3 cursor-default group"
                            :style="{ '--glow': glowColor(skill) }"
                        >
                            <!-- Icon -->
                            <div class="skill-icon transition-transform duration-300 group-hover:scale-110">
                                <Icon
                                    :icon="iconName(skill)"
                                    :style="{ color: iconColor(skill), fontSize: '48px' }"
                                    :class="skill.icon_slug === 'github' ? 'opacity-90' : ''"
                                />
                            </div>

                            <!-- Name -->
                            <p class="text-center text-sm font-medium text-foreground leading-tight">
                                {{ skill.name?.en ?? skill.name }}
                            </p>

                            <!-- Proficiency dots -->
                            <div v-if="skill.level" class="flex gap-1">
                                <div
                                    v-for="n in 5"
                                    :key="n"
                                    :class="[
                                        'h-1.5 w-3.5 rounded-full transition-colors duration-300',
                                        n <= skill.level
                                            ? 'bg-[color:var(--color-accent-primary)]'
                                            : 'bg-white/10'
                                    ]"
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<style scoped>
.skill-card {
    transition: transform 0.25s ease, border-color 0.25s ease, box-shadow 0.25s ease;
}
.skill-card:hover {
    transform: translateY(-4px) scale(1.03);
    border-color: rgba(var(--color-accent-primary-rgb), 0.5);
    box-shadow: 0 8px 30px var(--glow, rgba(var(--color-accent-primary-rgb), 0.2));
}
.skill-card:hover .skill-icon {
    filter: drop-shadow(0 0 8px var(--glow, rgba(var(--color-accent-primary-rgb), 0.4)));
}
</style>
