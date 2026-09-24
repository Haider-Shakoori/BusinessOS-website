(() => {
    const root = document.documentElement;
    const finePointer = window.matchMedia('(hover: hover) and (pointer: fine)');
    const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)');

    const autoTiltSelectors = [
        '.pricing-grid article',
        '.trust-card-grid article',
        '.resource-card',
        '.contact-form-card',
        '.app-card',
        '.feature-grid article'
    ];

    document.querySelectorAll(autoTiltSelectors.join(',')).forEach((element) => {
        if (!element.classList.contains('js-tilt')) {
            element.classList.add('js-tilt');
            element.dataset.tiltStrength = '3';
        }
    });

    const applyEnhancementClass = () => {
        root.classList.toggle('has-3d', finePointer.matches && !reducedMotion.matches);
    };

    applyEnhancementClass();
    finePointer.addEventListener?.('change', applyEnhancementClass);
    reducedMotion.addEventListener?.('change', applyEnhancementClass);

    if (!finePointer.matches || reducedMotion.matches) {
        return;
    }

    let lightFrame = 0;

    window.addEventListener('pointermove', (event) => {
        if (lightFrame) return;

        lightFrame = requestAnimationFrame(() => {
            root.style.setProperty('--pointer-x', `${event.clientX}px`);
            root.style.setProperty('--pointer-y', `${event.clientY}px`);
            lightFrame = 0;
        });
    }, { passive: true });

    document.querySelectorAll('.js-tilt').forEach((element) => {
        let frame = 0;

        const reset = () => {
            element.style.setProperty('--tilt-x', '0deg');
            element.style.setProperty('--tilt-y', '0deg');
            element.style.setProperty('--shine-x', '50%');
            element.style.setProperty('--shine-y', '50%');
        };

        element.addEventListener('pointermove', (event) => {
            if (frame) cancelAnimationFrame(frame);

            frame = requestAnimationFrame(() => {
                const rect = element.getBoundingClientRect();
                const x = (event.clientX - rect.left) / rect.width;
                const y = (event.clientY - rect.top) / rect.height;
                const strength = Number(element.dataset.tiltStrength || 4);

                element.style.setProperty('--tilt-x', `${((0.5 - y) * strength).toFixed(2)}deg`);
                element.style.setProperty('--tilt-y', `${((x - 0.5) * strength).toFixed(2)}deg`);
                element.style.setProperty('--shine-x', `${(x * 100).toFixed(1)}%`);
                element.style.setProperty('--shine-y', `${(y * 100).toFixed(1)}%`);
                frame = 0;
            });
        }, { passive: true });

        element.addEventListener('pointerleave', reset, { passive: true });
    });
})();
