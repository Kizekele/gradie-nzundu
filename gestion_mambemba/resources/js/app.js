/**
 * ============================================
 *  FICHIER JS PRINCIPAL
 *  Scripts globaux pour l'ensemble de l'app
 * ============================================
 */

import './store.js';

document.addEventListener('DOMContentLoaded', function () {

    // ============================================
    //  1. PRELOADER — cache l'écran de chargement
    // ============================================
    const preloader = document.getElementById('preloader');
    if (preloader) {
        // Dès que la page est complètement chargée
        window.addEventListener('load', function () {
            setTimeout(function () {
                preloader.classList.add('hidden');
            }, 400); // petit délai pour voir l'animation
        });
        // Sécurité : force la disparition après 4s max
        setTimeout(function () {
            if (!preloader.classList.contains('hidden')) {
                preloader.classList.add('hidden');
            }
        }, 4000);
    }

    // ============================================
    //  2. ANIMATIONS AU SCROLL (IntersectionObserver)
    //     Déclenche fadeInUp quand un élément devient visible
    // ============================================
    const animatedElements = document.querySelectorAll('.animate-on-scroll');
    if (animatedElements.length > 0) {
        const observer = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-fade-in-up');
                    observer.unobserve(entry.target); // une seule fois
                }
            });
        }, { threshold: 0.15 }); // 15% visible = déclenché
        animatedElements.forEach(function (el) {
            observer.observe(el);
        });
    }

    // ============================================
    //  3. PARALLAXE — déplacement lent du fond hero
    // ============================================
    const hero = document.querySelector('.hero-parallax');
    if (hero) {
        window.addEventListener('scroll', function () {
            const offset = window.scrollY * 0.4;
            hero.style.backgroundPositionY = offset + 'px';
        }, { passive: true });
    }

    // ============================================
    //  4. HOVER-LIFT — animation survol des cartes
    // ============================================
    document.querySelectorAll('.hover-lift').forEach(function (card) {
        card.addEventListener('mouseenter', function () {
            this.style.transform = 'translateY(-4px)';
        });
        card.addEventListener('mouseleave', function () {
            this.style.transform = 'translateY(0)';
        });
    });

    // ============================================
    //  5. SMOOTH SCROLL — ancres internes
    // ============================================
    document.querySelectorAll('a[href^="#"]').forEach(function (anchor) {
        anchor.addEventListener('click', function (e) {
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                e.preventDefault();
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    });

    console.log('Gestion Mambemba — Application chargée avec succès !');
});
