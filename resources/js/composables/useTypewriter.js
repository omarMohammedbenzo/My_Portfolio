import { ref, onMounted, onUnmounted } from 'vue';

/**
 * Cycles through an array of strings with a typewriter effect.
 * Types each word, holds, then deletes, then types the next.
 *
 * @param {string[]} words        - Array of words to cycle through
 * @param {number}   typeSpeed    - ms per character when typing (default 80)
 * @param {number}   deleteSpeed - ms per character when deleting (default 40)
 * @param {number}   holdMs      - ms to hold after fully typed (default 2000)
 */
export function useTypewriter(words, typeSpeed = 80, deleteSpeed = 40, holdMs = 2000) {
    const displayed = ref('');
    const isTyping  = ref(true);

    let wordIndex  = 0;
    let charIndex  = 0;
    let timerId    = null;
    let reducedMotion = false;

    function tick() {
        if (reducedMotion) {
            // Static fallback — just show the first word
            displayed.value = words[0] ?? '';
            return;
        }

        const word = words[wordIndex] ?? '';

        if (isTyping.value) {
            if (charIndex < word.length) {
                displayed.value = word.slice(0, charIndex + 1);
                charIndex++;
                timerId = setTimeout(tick, typeSpeed);
            } else {
                // Fully typed — hold then start deleting
                timerId = setTimeout(() => {
                    isTyping.value = false;
                    tick();
                }, holdMs);
            }
        } else {
            if (charIndex > 0) {
                charIndex--;
                displayed.value = word.slice(0, charIndex);
                timerId = setTimeout(tick, deleteSpeed);
            } else {
                // Fully deleted — move to next word
                wordIndex     = (wordIndex + 1) % words.length;
                isTyping.value = true;
                timerId = setTimeout(tick, typeSpeed);
            }
        }
    }

    onMounted(() => {
        reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        tick();
    });

    onUnmounted(() => clearTimeout(timerId));

    return { displayed, isTyping };
}
