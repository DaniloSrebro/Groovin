const tl = gsap.timeline({ defaults: { ease: "power1.out" } });

tl.to(".textoasis", { y: "0%", duration: 1, stagger: 0.25 });
tl.to(".slider", { y: "-100%", duration: 1.5, delay: 0.5 });
tl.to(".intro", { y: "-100%", duration: 1 }, "-=1.2");

tl.fromTo(".card-left", { opacity: 0 }, { opacity: 1, duration: 0.1, ease: "power2.out"});
tl.fromTo(".card-top", { opacity: 0 }, { opacity: 1, duration: 0.1, ease: "power2.out"});
tl.fromTo(".card-right", { opacity: 0 }, { opacity: 1, duration: 0.1, ease: "power2.out"});
tl.fromTo(".card-bottom", { opacity: 0 }, { opacity: 1, duration: 0.1, ease: "power2.out"})

