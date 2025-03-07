<?php

include('protect.php');

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="UTF-8">
  <title>Eduspace</title>
  <link rel="stylesheet" href="/css/home.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <div class="sidebar" role="navigation" aria-label="Menu Principal">
        <span id="notification-count" class="notification-count"></span>
        <ul class="nav-links">
            <li>
                <a href="#" href="#" role="button" onclick="showContent('menuContent')">
                    <i class="fa-solid fa-bars"></i>
                    <span class="link_name">Menu</span>
                </a>
            </li>
            <li>
                <a href="reservas.php" role="button">
                    <i class="fa-solid fa-box-archive"></i>
                    <span class="link_name">Minhas Reservas</span>
                </a>
            </li>
            <li>
                <a href="#" href="#" role="button" onclick="showNotifications()" id="btnNotificacoes">
                    <i class="fa-solid fa-bell"></i>
                    <span class="link_name">Notificações</span>
                </a>
            </li>            
            <li class="profile-item">
                <a href="perfil.php" role="button">
                    <i class="fa-solid fa-user"></i>
                    <span class="link_name">Perfil</span>
                </a>
            </li>
            <li>
                <a href="#" href="#" role="button" onclick="showContent('faqContent')">
                    <i class="fa-solid fa-question"></i>
                    <span class="link_name">FAQ</span>
                </a>
            </li>
            <li class="logout-item">
                <a href="logout.php" class="botao-sair">
                    <i class="fas fa-sign-out-alt"></i> <span class="link-text">Sair</span>
                </a>
            </li>
        </ul>
        <div class="sidebar-footer">
            <p>Eduspace, seu site de agendamentos.</p>
        </div>
    </div>
    
    <div class="home-section">


        <div class="home-section">
            <div class="content-container active" id="menuContent">
                <div class="swiper mySwiper">
                    <div class="swiper-wrapper">
                    <div class="swiper-slide">
                    <img src="/assets/imagens/destaques.jpeg" alt="Descrição da imagem 1" class="swiper-image">
                </div>
                <div class="swiper-slide">
                    <img src="/assets/imagens/destaques2.jpeg" alt="Descrição da imagem 2" class="swiper-image">
                </div>
                <div class="swiper-slide">
                <img src="/assets/imagens/destaques3.jpeg" alt="Descrição da imagem 3" class="swiper-image">
               </div>
                    </div>
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-pagination"></div>
                </div>
                <div class="salas-calendario-container">
                    <div class="salas-disponiveis">
                        <h3>Salas disponíveis</h3>
                        <ul class="lista-salas">
                            <li>Sala Chromebook</li>
                            <li>Sala de Dança</li>
                            <li>Sala Multimidia</li>
                            <li>Laboratório de Informática</li>
                            <li class="extra-salas" style="display: none;">Laboratório de Química</li>
                            <li class="extra-salas" style="display: none;">Biblioteca</li>
                            <li class="extra-salas" style="display: none;">Auditório</li>
                        </ul>
                        <a href="#" class="ver-mais" onclick="mostrarSalas(event)">Ver mais</a>
                        <a href="#" class="esconder" style="display: none;" onclick="esconderSalas(event)">Esconder</a>
                    </div>
            </div>
            <button id="agendar" onclick="window.location.href='agendamento.php'">Agendar Salas</button>
            </div>
    


            <div id="notificationsContent" class="notification-panel"> 
                <div class="notification-header">
                    <h3>Notificações</h3>
                    <button id="close-notification" aria-label="Fechar notificações" class="close-button" onclick="closeNotifications()">✖</button>
                </div>
                
                <hr class="divider">
                <div class="notification-window">
                    <div class="notification-header1">
                        <button id="mark-all-as-read" class="btn-clear" onclick="markAllAsRead()">Marcar todas como lidas</button>
                    </div>
                    <div class="divider1"></div>
                    <div class="notification-list">
                        <div class="notification-item">
                            <img src="/img/ceaat.jpg" alt="thumb" class="thumb">
                            <div class="notification-details">
                                <p class="notification-title">SEM AULA 04 E 07 DE OUTUBRO</p>
                                <p class="notification-description">A escola estará sob responsabilidade do TRE devido às eleições.</p>
                                <span class="notification-time"></span>
                            </div>
                            <div class="notification-actions">
                                <button class="btn-action" onclick="markAsRead(this)">
                                    <i class="fas fa-check"></i>
                                </button>
                                <button class="btn-action" onclick="deleteNotification(this)">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                        <div class="divider2"></div>
                    </div>
                </div>
            </div>




            <div class="content-container" id="faqContent">
                 <section class="faq-section">
          <div class="container">
              <div class="row">
                  <div class="col-md-6 offset-md-3">
                      <div class="faq-title text-center pb-3">
                          <h2>FAQ</h2>
                      </div>
                  </div>
                  <div class="col-md-6 offset-md-3">
                      <div class="faq" id="accordion">
                          <div class="card">
                              <div class="card-header" id="faqHeading-1">
                                  <h5 class="mb-0">
                                      <button class="faq-title btn btn-link" data-toggle="collapse" data-target="#faqCollapse-1" aria-expanded="true" aria-controls="faqCollapse-1">
                                          <span class="badge">1</span> O que é Eduspace?
                                      </button>
                                  </h5>
                              </div>
                              <div id="faqCollapse-1" class="collapse" aria-labelledby="faqHeading-1" data-parent="#accordion">
                                  <div class="card-body">
                                      <p>Eduspace é uma plataforma que simplifica e agiliza o agendamento de salas no CEAAT...</p>
                                  </div>
                              </div>
                          </div>
      
                          <div class="card">
                              <div class="card-header" id="faqHeading-2">
                                  <h5 class="mb-0">
                                      <button class="faq-title btn btn-link" data-toggle="collapse" data-target="#faqCollapse-2" aria-expanded="false" aria-controls="faqCollapse-2">
                                          <span class="badge">2</span> De onde vem o Eduspace?
                                      </button>
                                  </h5>
                              </div>
                              <div id="faqCollapse-2" class="collapse" aria-labelledby="faqHeading-2" data-parent="#accordion">
                                  <div class="card-body">
                                      <p>O Eduspace foi desenvolvido por alunos do 3º AM Tec como uma solução para a gestão de reservas...</p>
                                  </div>
                              </div>
                          </div>
      
                        
                          <div class="card">
                              <div class="card-header" id="faqHeading-3">
                                  <h5 class="mb-0">
                                      <button class="faq-title btn btn-link" data-toggle="collapse" data-target="#faqCollapse-3" aria-expanded="false" aria-controls="faqCollapse-3">
                                          <span class="badge">3</span> Por que usar o Eduspace?
                                      </button>
                                  </h5>
                              </div>
                              <div id="faqCollapse-3" class="collapse" aria-labelledby="faqHeading-3" data-parent="#accordion">
                                  <div class="card-body">
                                      <p>O Eduspace ajuda a otimizar o tempo dos professores e facilitar o agendamento de salas...</p>
                                  </div>
                              </div>
                          </div>
      
                          
                          <div class="card">
                              <div class="card-header" id="faqHeading-4">
                                  <h5 class="mb-0">
                                      <button class="faq-title btn btn-link" data-toggle="collapse" data-target="#faqCollapse-4" aria-expanded="false" aria-controls="faqCollapse-4">
                                          <span class="badge">4</span> Onde posso acessar o Eduspace?
                                      </button>
                                  </h5>
                              </div>
                              <div id="faqCollapse-4" class="collapse" aria-labelledby="faqHeading-4" data-parent="#accordion">
                                  <div class="card-body">
                                      <p>O Eduspace pode ser acessado através do nosso site oficial...</p>
                                  </div>
                              </div>
                          </div>
      
                         
                          <div class="card">
                              <div class="card-header" id="faqHeading-5">
                                  <h5 class="mb-0">
                                      <button class="faq-title btn btn-link" data-toggle="collapse" data-target="#faqCollapse-5" aria-expanded="false" aria-controls="faqCollapse-5">
                                          <span class="badge">5</span> O que o Eduspace oferece?
                                      </button>
                                  </h5>
                              </div>
                              <div id="faqCollapse-5" class="collapse" aria-labelledby="faqHeading-5" data-parent="#accordion">
                             <div class="card-body">
                               <p>Oferecemos um fácil agendamento de salas da escola Ceaat.</p>
                                <p>
                               Para mais informações, confira as <a href="/tec/recursos.html">salas</a>.
                                  </p>
                               </div>
                           </div>
                          </div>
      
                         
                          <div class="card">
                              <div class="card-header" id="faqHeading-6">
                                  <h5 class="mb-0">
                                      <button class="faq-title btn btn-link" data-toggle="collapse" data-target="#faqCollapse-6" aria-expanded="false" aria-controls="faqCollapse-6">
                                          <span class="badge">6</span> Como posso entrar em contato com o suporte?
                                      </button>
                                  </h5>
                              </div>
                              <div id="faqCollapse-6" class="collapse" aria-labelledby="faqHeading-6" data-parent="#accordion">
                                  <div class="card-body">
                                <p>
                                Confira os nosso contatos <a href="/tec/contato.html">aqui</a>.
                                  </p>
                                  </div>
                              </div>
                          </div>
      
                         
                          <div class="card">
                              <div class="card-header" id="faqHeading-7">
                                  <h5 class="mb-0">
                                      <button class="faq-title btn btn-link" data-toggle="collapse" data-target="#faqCollapse-7" aria-expanded="false" aria-controls="faqCollapse-7">
                                          <span class="badge">7</span> Quais são as vantagens do Eduspace?
                                      </button>
                                  </h5>
                              </div>
                              <div id="faqCollapse-7" class="collapse" aria-labelledby="faqHeading-7" data-parent="#accordion">
                                  <div class="card-body">
                                      <p>As vantagens do Eduspace incluem uma interface intuitiva e um sistema de agendamento eficiente...</p>
                                  </div>
                              </div>
                          </div>
      
                         
                          <div class="card">
                              <div class="card-header" id="faqHeading-8">
                                  <h5 class="mb-0">
                                      <button class="faq-title btn btn-link" data-toggle="collapse" data-target="#faqCollapse-8" aria-expanded="false" aria-controls="faqCollapse-8">
                                          <span class="badge">8</span> É seguro usar o Eduspace?
                                      </button>
                                  </h5>
                              </div>
                              <div id="faqCollapse-8" class="collapse" aria-labelledby="faqHeading-8" data-parent="#accordion">
                                  <div class="card-body">
                                      <p>Sim, a segurança dos dados dos usuários é uma prioridade para o Eduspace, também oferecemos certificados SSL...</p>
                                  </div>
                              </div>
                          </div>
      
                         
                          <div class="card">
                              <div class="card-header" id="faqHeading-9">
                                  <h5 class="mb-0">
                                      <button class="faq-title btn btn-link" data-toggle="collapse" data-target="#faqCollapse-9" aria-expanded="false" aria-controls="faqCollapse-9">
                                          <span class="badge">9</span>  Onde posso aprender mais?
                                      </button>
                                  </h5>
                              </div>
                              <div id="faqCollapse-9" class="collapse" aria-labelledby="faqHeading-9" data-parent="#accordion">
                                  <div class="card-body">
                                  <p>Você pode aprender mais sobre o Eduspace conferindo o nosso manual...</p>
                                  <a href="/tec/img/manualeduspace.pdf" download>Baixe nosso Manual aqui</a>
                                  </div>
                              </div>
                          </div>
      
                          
                          <div class="card">
                              <div class="card-header" id="faqHeading-10">
                                  <h5 class="mb-0">
                                      <button class="faq-title btn btn-link" data-toggle="collapse" data-target="#faqCollapse-10" aria-expanded="false" aria-controls="faqCollapse-10">
                                          <span class="badge">10</span> O Eduspace tem suporte para dispositivos móveis?
                                      </button>
                                  </h5>
                              </div>
                              <div id="faqCollapse-10" class="collapse" aria-labelledby="faqHeading-10" data-parent="#accordion">
                              <div id="faqCollapse-10" class="collapse" aria-labelledby="faqHeading-10" data-parent="#accordion">
                              <div class="card-body">
                              <p>Sim, o Eduspace é otimizado para uso em dispositivos móveis e tablets...</p>
                              </div>
</div>

                              </div>
                          </div>
      
                      </div>
                  </div>
              </div>
          </div>
      </section>
            </div>
        </div>
    </div>
    




  <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script src="/assets/js/home.js"></script>
</body>
</html>
