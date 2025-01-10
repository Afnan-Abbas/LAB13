document.addEventListener('DOMContentLoaded', () => {
    // GSAP Animation for Header
    gsap.from(".logo", { opacity: 0, duration: 1, x: -50 });
    gsap.from(".nav-links li", { opacity: 0, y: 20, duration: 0.5, stagger: 0.2 });
    gsap.from(".login-button", { opacity: 0, scale: 0.5, duration: 1, delay: 0.5 });
    gsap.from(".lout-button", { opacity: 0, scale: 0.5, duration: 1, delay: 0.5 });

    // GSAP Animation for Footer
    gsap.from("footer .footer-copy", { opacity: 0, y: 20, duration: 0.5, delay: 0.5 });

    // GSAP Animation for Hero Section
    gsap.from(".hero-section h1", { opacity: 0, y: -50, duration: 1 });
    gsap.from(".hero-section p", { opacity: 0, y: 20, duration: 1, delay: 0.3 });
    gsap.from(".hero-section .btn", { opacity: 0, scale: 0.8, duration: 1, delay: 0.6 });

    // GSAP Animation for Pop-up
    gsap.to(".popup-container", { opacity: 1, scale: 1, duration: 1, ease: "power4.out" });
    gsap.from(".popup-container ul.features li", { opacity: 0, x: -20, duration: 0.5, stagger: 0.2, delay: 0.7 });

    //GSAP Animation for Login-container
    gsap.to(".login-container", { opacity: 1, scale: 1, duration: 1, ease: "power4.out" });
    gsap.from(".login-container label,input", { opacity: 0, x: -20, duration: 1, stagger: 0.2, delay: 0.3 });
    gsap.to(".login-btn", { opacity: 1, y: 10, duration: 1, delay: 0.2 });

    // Animate login Button on hover
    const logButton = document.querySelector('.login-btn');
    logButton.addEventListener('mouseenter', () => {
        gsap.to(logButton, { scale: 1.009, duration: 0.1 });
    });
    logButton.addEventListener('mouseleave', () => {
        gsap.to(logButton, { scale: 1, duration: 0.1 });
    });

});

document.addEventListener('DOMContentLoaded', () => {
    // Animate quiz container on load
    const quizContainer = document.querySelector('.quiz-container');
    gsap.to(quizContainer, { opacity: 2, scale: 1, duration: 1, ease: "power3.out" });

    // Animate Next Button on hover
    const nextButton = document.querySelector('.next-btn');
    nextButton.addEventListener('mouseenter', () => {
        gsap.to(nextButton, { scale: 1.009, duration: 0.2 });
    });
    nextButton.addEventListener('mouseleave', () => {
        gsap.to(nextButton, { scale: 1, duration: 0.2 });
    });

});

document.addEventListener('DOMContentLoaded', () => {
    // Fade in the table rows
    const rows = document.querySelectorAll("table tbody tr");
    gsap.from(rows, {
        opacity: 0,
        y: 20,
        duration: 1,
        stagger: 0.2
    });

    // Auto-dismiss message script
    const message = document.getElementById('message');
    if (message) {
        setTimeout(() => {
            gsap.to(message, { opacity: 0, duration: 1, onComplete: () => message.style.display = 'none' });
        }, 3000);
    }
});

document.addEventListener('DOMContentLoaded', () => {
    // GSAP Animations
    gsap.from(".admin-popup-container", {
        duration: 1,
        scale: 0.8,
        opacity: 0,
        ease: "power3.out",
    });

    gsap.from(".admin-popup-title", {
        duration: 1,
        y: -50,
        opacity: 0,
        ease: "power2.out",
    });

    gsap.from(".admin-popup-group", {
        duration: 0.8,
        x: -30,
        opacity: 0,
        ease: "power2.out",
        stagger: 0.2,
    });

    gsap.from(".admin-popup-submit-btn, .admin-popup-back-link", {
        duration: 1,
        scale: 0.8,
        opacity: 0,
        ease: "bounce.out",
        delay: 0.8,
    });

});
