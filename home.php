<?php
// 1. Configurações de Conexão com o MySQL
$host = 'localhost';  // Host do banco de dados
$user = 'root';        // Usuário do banco de dados
$password = '';        // Senha (se houver)
$database = 'AgendamentoSala';  // Nome do banco de dados

// 2. Conectar ao banco de dados
$conn = new mysqli($host, $user, $password, $database);

// Verificar conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="UTF-8">
  <title>Drop Down Sidebar Menu</title>
  <link rel="stylesheet" href="css/home.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <div class="sidebar">
        <span id="notification-count" class="notification-count"></span>
        <ul class="nav-links">
            <li>
                <a href="#" onclick="showContent('menuContent')">
                    <i class="fa-solid fa-bars"></i>
                    <span class="link_name">Menu</span>
                </a>
            </li>
            <li>
                <a href="#" onclick="showContent('reservationsContent')">
                    <i class="fa-solid fa-box-archive"></i>
                    <span class="link_name">Minhas Reservas</span>
                </a>
            </li>
            <li>
                <a href="#" onclick="showNotifications()" id="btnNotificacoes">
                    <i class="fa-solid fa-bell"></i>
                    <span class="link_name">Notificações</span>
                </a>
            </li>            
            <li class="profile-item">
                <a href="#" onclick="showContent('profileContent')">
                    <i class="fa-solid fa-user"></i>
                    <span class="link_name">Perfil</span>
                </a>
            </li>
            <li>
                <a href="#" onclick="showContent('faqContent')">
                    <i class="fa-solid fa-question"></i>
                    <span class="link_name">FAQ</span>
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
                            <img src="img/destaques.jpeg" alt="Descrição da imagem 1" style="width: 100%; height: auto;">
                        </div>
                        <div class="swiper-slide">
                            <img src="img/destaques2.jpeg" alt="Descrição da imagem 2" style="width: 100%; height: auto;">
                        </div>
                        <div class="swiper-slide">
                            <img src="img/destaques3.jpeg" alt="Descrição da imagem 3" style="width: 100%; height: auto;">
                        </div>
                    </div>
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-pagination"></div>
                </div>
                <div class="containersalas">
                    <h1>Gerenciamento de Salas</h1>
                    <div class="salas-disponiveis">
                        <ul class="lista-salas">
                            <li>
                                <button onclick="mostrarInformacoes('Sala Chromebook')">Sala Chromebook</button>
                            </li>
                            <li>
                                <button onclick="mostrarInformacoes('Sala de Dança')">Sala de Dança</button>
                            </li>
                            <li>
                                <button onclick="mostrarInformacoes('Laboratório')">Laboratório</button>
                            </li>
                            <li>
                                <button onclick="mostrarInformacoes('Auditório')">Auditório</button>
                            </li>
                            <li>
                                <button onclick="mostrarInformacoes('Laboratório de Química')">Laboratório de Química</button>
                            </li>
                            <li>
                                <button onclick="mostrarInformacoes('Sala de Computação')">Sala de Computação</button>
                            </li>
                        </ul>
                    </div>
            
                    <!-- Área para mostrar informações das salas -->
                    <div id="informacoes-sala" style="margin-top: 20px;"></div>
                </div> 
            </div>








    










            <div class="content-container" id="reservationsContent">
                <div class="button-container">
                    <button class="info-button" onclick="showInfo('emAberto')">Em aberto</button>
                    <button class="info-button" onclick="showInfo('finalizadas')">Finalizadas</button>
                    <button class="info-button" onclick="showInfo('verTodas')">Ver todas</button>
                  </div>
        
                  <div id="infoDisplay" class="info-display">
                    <p id="infoText"></p>
                  </div>
            </div>












            <div id="notificationsContent" class="notification-panel"> 
                <!-- Botão de Fechar no Topo -->
                <div class="notification-header">
                    <h3>Notificações</h3>
                    <button id="close-notification" class="close-button" onclick="closeNotifications()">✖</button>
                </div>
                
                <hr class="divider">
                
                <!-- Janela de Notificações -->
                <div class="notification-window">
                    <div class="notification-header1">
                        <button id="mark-all-as-read" class="btn-clear" onclick="markAllAsRead()">Marcar todas como lidas</button>
                    </div>
                    <div class="divider1"></div>
                    <div class="notification-list">
                        <!-- Notificação -->
                        <div class="notification-item">
                            <img src="https://via.placeholder.com/40" alt="thumb" class="thumb">
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
                        <!-- Repita o bloco para mais notificações -->
                    </div>
                </div>
            </div>
            


            
            <div class="content-container" id="profileContent">
                <main class="profile-container">
                    <div class="profile-img">
                      <i class="fas fa-user-circle fa-7x"></i>
                    </div>
                  
                    <div class="profile-content p-4">
                      <h3 class="text-center">Professor</h3>
                      <p class="text-muted text-center">Professor@professor.enova.educacao.gov.br</p>
                  
                      <div class="profile-actions d-flex justify-content-end gap-2">
                        <button class="btn btn-secondary">Carregar foto</button>
                        <button class="btn btn-danger">Excluir</button>
                      </div>
                  
                      <div class="disciplines-card mt-4 p-3">
                        <h5>Disciplinas ensinadas:</h5>
                        <textarea class="form-control" rows="3" disabled></textarea>
                      </div>
                  
                      <h5 class="mt-4">Trocar Senha</h5>
                      <form class="password-form">
                        <div class="row g-3">
                          <div class="col-md-6">
                            <input type="password" class="form-control" placeholder="Senha anterior" required>
                          </div>
                          <div class="col-md-6">
                            <input type="password" class="form-control" placeholder="Nova senha" required>
                          </div>
                          <div class="col-md-6">
                            <input type="password" class="form-control" placeholder="Confirme nova senha" required>
                          </div>
                          <div class="col-md-6 d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary w-100">Alterar Senha</button>
                          </div>
                        </div>
                      </form>
                    </div>
                  </main>
            </div>
    







            <div class="content-container" id="faqContent">
                 <section class="faq-section">
          <div class="container">
              <div class="row">
                  <!-- ***** FAQ Start ***** -->
                  <div class="col-md-6 offset-md-3">
                      <div class="faq-title text-center pb-3">
                          <h2>FAQ</h2>
                      </div>
                  </div>
                  <div class="col-md-6 offset-md-3">
                      <div class="faq" id="accordion">
                          <!-- FAQ Item 1 -->
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
      
                          <!-- FAQ Item 2 -->
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
      
                          <!-- FAQ Item 3 -->
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
      
                          <!-- FAQ Item 4 -->
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
      
                          <!-- FAQ Item 5 -->
                          <div class="card">
                              <div class="card-header" id="faqHeading-5">
                                  <h5 class="mb-0">
                                      <button class="faq-title btn btn-link" data-toggle="collapse" data-target="#faqCollapse-5" aria-expanded="false" aria-controls="faqCollapse-5">
                                          <span class="badge">5</span> O Eduspace é gratuito?
                                      </button>
                                  </h5>
                              </div>
                              <div id="faqCollapse-5" class="collapse" aria-labelledby="faqHeading-5" data-parent="#accordion">
                                  <div class="card-body">
                                      <p>Sim, o Eduspace é uma plataforma gratuita para uso por professores e alunos...</p>
                                  </div>
                              </div>
                          </div>
      
                          <!-- FAQ Item 6 -->
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
                                      <p>Você pode entrar em contato com o suporte através do nosso formulário de contato...</p>
                                  </div>
                              </div>
                          </div>
      
                          <!-- FAQ Item 7 -->
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
      
                          <!-- FAQ Item 8 -->
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
                                      <p>Sim, a segurança dos dados dos usuários é uma prioridade para o Eduspace...</p>
                                  </div>
                              </div>
                          </div>
      
                          <!-- FAQ Item 9 -->
                          <div class="card">
                              <div class="card-header" id="faqHeading-9">
                                  <h5 class="mb-0">
                                      <button class="faq-title btn btn-link" data-toggle="collapse" data-target="#faqCollapse-9" aria-expanded="false" aria-controls="faqCollapse-9">
                                          <span class="badge">9</span> O Eduspace tem suporte para dispositivos móveis?
                                      </button>
                                  </h5>
                              </div>
                              <div id="faqCollapse-9" class="collapse" aria-labelledby="faqHeading-9" data-parent="#accordion">
                                  <div class="card-body">
                                      <p>Sim, o Eduspace é otimizado para uso em dispositivos móveis e tablets...</p>
                                  </div>
                              </div>
                          </div>
      
                          <!-- FAQ Item 10 -->
                          <div class="card">
                              <div class="card-header" id="faqHeading-10">
                                  <h5 class="mb-0">
                                      <button class="faq-title btn btn-link" data-toggle="collapse" data-target="#faqCollapse-10" aria-expanded="false" aria-controls="faqCollapse-10">
                                          <span class="badge">10</span> Onde posso aprender mais?
                                      </button>
                                  </h5>
                              </div>
                              <div id="faqCollapse-10" class="collapse" aria-labelledby="faqHeading-10" data-parent="#accordion">
                                  <div class="card-body">
                                      <p>Você pode aprender mais sobre o Eduspace visitando nosso site e nossas redes sociais...</p>
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
  <script src="java/home.js"></script>
</body>
</html>
