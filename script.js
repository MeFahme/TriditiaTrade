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
            card.style.transform = 'translateY(30px)';
            card.style.transition = 'opacity 0.6s ease-out, transform 0.6s ease-out';
            cardObserver.observe(card);
        });
    }
    
    
    // ============================================
    // 2. ANIMASI UNTUK SECTION KONTEN
    // ============================================
    const contentElements = document.querySelectorAll('.hero, .about-section, .contact-section, .category-title');
    
    if (contentElements.length > 0) {
        const contentObserver = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                    contentObserver.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '0px 0px -80px 0px'
        });
        
        contentElements.forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(40px)';
            el.style.transition = 'opacity 0.8s ease-out, transform 0.8s ease-out';
            contentObserver.observe(el);
        });
    }
    
    
    // ============================================
    // 3. ANIMASI UNTUK CONTACT ITEMS
    // ============================================
    const contactItems = document.querySelectorAll('.contact-item');
    
    if (contactItems.length > 0) {
        const contactObserver = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const allItems = Array.from(contactItems);
                    const index = allItems.indexOf(entry.target);
                    
                    setTimeout(() => {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'scale(1)';
                    }, index * 150);
                    
                    contactObserver.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.1
        });
        
        contactItems.forEach(item => {
            item.style.opacity = '0';
            item.style.transform = 'scale(0.9)';
            item.style.transition = 'opacity 0.5s ease-out, transform 0.5s ease-out';
            contactObserver.observe(item);
        });
    }
    
    
    // ============================================
    // 4. TOMBOL SCROLL TO TOP
    // ============================================
    const scrollTopBtn = document.createElement('button');
    scrollTopBtn.innerHTML = '↑';
    scrollTopBtn.className = 'scroll-to-top-btn';
    scrollTopBtn.setAttribute('aria-label', 'Scroll to top');
    scrollTopBtn.title = 'Kembali ke atas';
    document.body.appendChild(scrollTopBtn);
    
    const btnStyle = document.createElement('style');
    btnStyle.textContent = `
        .scroll-to-top-btn {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 55px;
            height: 55px;
            background: linear-gradient(135deg, #dc2626 0%, #991b1b 100%);
            color: white;
            border: none;
            border-radius: 50%;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            z-index: 1000;
            box-shadow: 0 4px 15px rgba(220, 38, 38, 0.4);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .scroll-to-top-btn.visible {
            opacity: 1;
            visibility: visible;
        }
        
        .scroll-to-top-btn:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 20px rgba(220, 38, 38, 0.6);
        }
        
        .scroll-to-top-btn:active {
            transform: translateY(-2px);
        }
        
        @media (max-width: 768px) {
            .scroll-to-top-btn {
                width: 50px;
                height: 50px;
                bottom: 20px;
                right: 20px;
                font-size: 24px;
            }
        }
    `;
    document.head.appendChild(btnStyle);
    
    window.addEventListener('scroll', function() {
        if (window.pageYOffset > 300) {
            scrollTopBtn.classList.add('visible');
        } else {
            scrollTopBtn.classList.remove('visible');
        }
    });
    
    scrollTopBtn.addEventListener('click', function() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
    
    
    // ============================================
    // 5. PROGRESS BAR SCROLL
    // ============================================
    const progressBar = document.createElement('div');
    progressBar.className = 'scroll-progress-bar';
    document.body.appendChild(progressBar);
    
    const progressStyle = document.createElement('style');
    progressStyle.textContent = `
        .scroll-progress-bar {
            position: fixed;
            top: 0;
            left: 0;
            width: 0%;
            height: 4px;
            background: linear-gradient(90deg, #dc2626 0%, #991b1b 100%);
            z-index: 9999;
            transition: width 0.1s ease;
            box-shadow: 0 2px 4px rgba(220, 38, 38, 0.3);
        }
    `;
    document.head.appendChild(progressStyle);
    
    window.addEventListener('scroll', function() {
        const windowHeight = document.documentElement.scrollHeight - document.documentElement.clientHeight;
        const scrolled = (window.pageYOffset / windowHeight) * 100;
        progressBar.style.width = scrolled + '%';
    });
    
    
    // ============================================
    // 6. SMOOTH SCROLL UNTUK ANCHOR LINKS
    // ============================================
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            const href = this.getAttribute('href');
            if (href !== '#' && href !== '') {
                e.preventDefault();
                const target = document.querySelector(href);
                if (target) {
                    const headerOffset = 80;
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


// ============================================
// FUNCTION: SHOW SECTION (untuk single page)
// ============================================
function showSection(sectionId) {
    const sections = document.querySelectorAll('.section');
    const buttons = document.querySelectorAll('.nav-btn');
   
    sections.forEach(section => section.classList.remove('active'));
    buttons.forEach(button => button.classList.remove('active'));
   
    const targetSection = document.getElementById(sectionId);
    if (targetSection) {
        targetSection.classList.add('active');
    }
    
    if (typeof event !== 'undefined' && event.target) {
        event.target.classList.add('active');
    }
    
    window.scrollTo({ top: 0, behavior: 'smooth' });
}