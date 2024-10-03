
  // Inicializando Swiper
// Função para exibir a seção correspondente ao clique
function showContent(contentId) {
  const allContents = document.querySelectorAll('.content-container');
  allContents.forEach(content => content.classList.remove('active'));

  const selectedContent = document.getElementById(contentId);
  selectedContent.classList.add('active');

  // Reinicializar Swiper ao mostrar o conteúdo
  if (contentId === "calendarContent") {
    swiper.update(); // Atualiza o Swiper quando exibido
  }
}

let sidebar = document.querySelector(".sidebar");
let sidebarBtn = document.querySelector(".bx-menu");
sidebarBtn.addEventListener("click", () => {
  sidebar.classList.toggle("close");
});

// Inicializando Swiper
var swiper = new Swiper(".mySwiper", {
  slidesPerView: 1,
  spaceBetween: 10,
  loop: true,
  pagination: {
    el: ".swiper-pagination",
    clickable: true,
  },
  navigation: {
    nextEl: ".swiper-button-next",
    prevEl: ".swiper-button-prev",
  },
});





