import { ref } from 'vue';

const isDark = ref(false);

function init() {
    const stored = localStorage.getItem('theme');
    // Default = dark unless user has explicitly chosen light
    isDark.value = stored ? stored === 'dark' : true;
    apply();
}

function apply() {
    document.documentElement.classList.toggle('dark', isDark.value);
}

export function useDarkMode() {
    function toggle() {
        isDark.value = !isDark.value;
        localStorage.setItem('theme', isDark.value ? 'dark' : 'light');
        apply();
    }

    return { isDark, toggle, init };
}
