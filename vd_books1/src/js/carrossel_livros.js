// ---------------------- Exibir Livros com Carrossel ----------------------
let slideIndexLivrosSite = 0;

function definirLivrosPorVezSite() {
    if (window.innerWidth <= 480) {
        return 1; // 1 livro em telas muito pequenas
    } else if (window.innerWidth <= 600) {
        return 2; // 2 livros em telas pequenas
    } else if (window.innerWidth <= 800) {
        return 3; // 3 livros em telas médias
    } else if (window.innerWidth <= 1000) {
        return 4; // 4 livros em telas um pouco maiores
    } else if (window.innerWidth <= 1200) {
        return 5; // 5 livros em telas grandes
    }
    return 6; // 6 livros por vez em telas muito grandes
}

const livroSlidesSite = document.querySelectorAll('.carrossel-slide-livro-site');
let livrosPorVezSite = definirLivrosPorVezSite();
const totalSlidesSite = livroSlidesSite.length;

function mostrarSlidesLivrosSite() {
    livroSlidesSite.forEach((slide) => {
        slide.classList.remove('visible', 'slide-in', 'slide-out');
        slide.style.opacity = 0; 
    });

    for (let i = 0; i < livrosPorVezSite; i++) {
        let index = (slideIndexLivrosSite + i) % totalSlidesSite; 
        livroSlidesSite[index].classList.add('visible', 'slide-in');
        setTimeout(() => {
            livroSlidesSite[index].style.opacity = 1; 
        }, 50);
    }
}

function moverSlideLivrosSite(n) {
    livroSlidesSite.forEach((slide) => {
        slide.classList.remove('slide-in');
        slide.classList.add('slide-out');
    });

    slideIndexLivrosSite = (slideIndexLivrosSite + n + totalSlidesSite) % totalSlidesSite;

    setTimeout(() => {
        mostrarSlidesLivrosSite();
    }, 300);
}

// Inicializa o carrossel
mostrarSlidesLivrosSite();

// Evento de redimensionamento
window.addEventListener('resize', () => {
    livrosPorVezSite = definirLivrosPorVezSite();
    mostrarSlidesLivrosSite();
});

// Eventos dos botões
document.querySelector(".proximo-livro-site").addEventListener("click", () => {
    moverSlideLivrosSite(1);
});

document.querySelector(".anterior-livro-site").addEventListener("click", () => {
    moverSlideLivrosSite(-1);
});
