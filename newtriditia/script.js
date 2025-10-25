// ============================================
// TRIDITIA TRADE - OPTIMIZED JAVASCRIPT
// ============================================

document.addEventListener('DOMContentLoaded', function() {
    
    // ============================================
    // 1. ANIMASI PROGRESIF UNTUK PRODUCT CARDS
    // ============================================
    const productCards = document.querySelectorAll('.product-card');
    
    if (productCards.length > 0) {
        const cardObserver = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const visibleCards = Array.from(productCards).filter(card => {
                        const rect = card.getBoundingClientRect();
                        return rect.top < window.innerHeight && rect.bottom > 0;
                    });
                    
                    const index = visibleCards.indexOf(entry.target);
                    
                    setTimeout(() => {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }, index * 100);
                    
                    cardObserver.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        });
        
        productCards.forEach(card => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            card.style.transition = 'opacity 0.5s ease-out, transform 0.5s ease-out';
            cardObserver.observe(card);
        });
    }

    // ============================================
    // 2. SMOOTH SCROLL UNTUK LINK "#about"
    // ============================================
    const anchorLinks = document.querySelectorAll('a[href^="index.php#"]');
    
    anchorLinks.forEach(link => {
        link.addEventListener('click', function (e) {
            const href = this.getAttribute('href');
            const hash = href.substring(href.indexOf('#')); // Dapatkan bagian #about
            
            if (hash !== '#' && hash !== '') {
                const target = document.querySelector(hash);
                if (target) {
                    e.preventDefault();
                    const headerOffset = 80; // Sesuaikan dengan tinggi nav Anda
                    const elementPosition = target.getBoundingClientRect().top;
                    const offsetPosition = elementPosition + window.pageYOffset - headerOffset;
                    
                    window.scrollTo({
                        top: offsetPosition,
                        behavior: 'smooth'
                    });
                }
            }
        });
    });
    
});