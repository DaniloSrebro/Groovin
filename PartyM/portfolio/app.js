const tl = gsap.timeline({ defaults: { ease: 'power1.out' } });

tl.to('.text', { y: "0%", duration: 1, stagger: 0.25 });
tl.to('.slider', { y: "-100%", duration: 1.5, delay: 0.5 });
tl.to('.intro', { y: "-100%", duration: 1 }, "-=1.1");


tl.fromTo('.container', { opacity: 0 }, { opacity: 1, duration: 1 }, '-=1');

tl.fromTo('.skills1', { opacity: 0 }, { opacity: 1, duration: 0.2 }, '+=0.02');
tl.fromTo('.skills2', { opacity: 0 }, { opacity: 1, duration: 0.2 }, '+=0.022');
tl.fromTo('.skills3', { opacity: 0 }, { opacity: 1, duration: 0.2 }, '+=0.024');
tl.fromTo('.skills4', { opacity: 0 }, { opacity: 1, duration: 0.2 }, '+=0.026');





