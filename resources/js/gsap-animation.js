// gsap-animation.js
document.addEventListener("DOMContentLoaded", function() {
    gsap.registerPlugin(ScrollTrigger);

    // Animation pour l'élément ayant la classe "yoyo"
    gsap.to(".yoyo", {
        scrollTrigger: {
            scrollTrigger: ".yoyo",
            scale: 0.7,
            repeat: -1,
            yoyo: true,
            ease: "power5"
        }
    });
});