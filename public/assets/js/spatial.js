(() => {
    const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    const finePointer = window.matchMedia('(pointer: fine)').matches;

    const root = document.documentElement;
    let pointerFrame = 0;

    if (!reducedMotion && finePointer) {
        window.addEventListener('pointermove', (event) => {
            if (pointerFrame) return;

            pointerFrame = requestAnimationFrame(() => {
                root.style.setProperty('--pointer-x', `${event.clientX}px`);
                root.style.setProperty('--pointer-y', `${event.clientY}px`);
                pointerFrame = 0;
            });
        }, { passive: true });

        document.querySelectorAll('[data-tilt]').forEach((element) => {
            let frame = 0;

            const reset = () => {
                element.style.setProperty('--tilt-x', '0deg');
                element.style.setProperty('--tilt-y', '0deg');
                element.style.setProperty('--glow-x', '50%');
                element.style.setProperty('--glow-y', '50%');
                element.style.setProperty('--lift', '0px');
            };

            element.addEventListener('pointermove', (event) => {
                if (frame) return;

                frame = requestAnimationFrame(() => {
                    const rect = element.getBoundingClientRect();
                    const x = Math.max(0, Math.min(1, (event.clientX - rect.left) / rect.width));
                    const y = Math.max(0, Math.min(1, (event.clientY - rect.top) / rect.height));
                    const strength = Number.parseFloat(element.dataset.tiltStrength || '1');
                    const rotateY = (x - 0.5) * 8 * strength;
                    const rotateX = (0.5 - y) * 6 * strength;

                    element.style.setProperty('--tilt-x', `${rotateX.toFixed(2)}deg`);
                    element.style.setProperty('--tilt-y', `${rotateY.toFixed(2)}deg`);
                    element.style.setProperty('--glow-x', `${(x * 100).toFixed(1)}%`);
                    element.style.setProperty('--glow-y', `${(y * 100).toFixed(1)}%`);
                    element.style.setProperty('--lift', '-4px');
                    frame = 0;
                });
            }, { passive: true });

            element.addEventListener('pointerleave', reset, { passive: true });
            reset();
        });
    }
})();