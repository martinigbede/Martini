{{-- resources/views/public/condition_generale.blade.php --}}
<x-layouts.public>
    @section('title', 'Conditions Générales de Vente - Miadjoe Beach Resort')
    
 
    <div class="cgu-container">
        <!-- En-tête avec image de fond -->
        <div class="cgu-hero">
            <div class="cgu-hero-content">
                <h1 class="cgu-title">Conditions Générales de Vente</h1>
                <p class="cgu-subtitle">Miadjoe Beach Resort - Aného</p>
                <div class="cgu-scroll-indicator">
                    <span>Défiler pour découvrir</span>
                    <div class="scroll-arrow"></div>
                </div>
            </div>
        </div>

        <!-- Navigation rapide -->
        <nav class="cgu-nav">
            <div class="container">
                <ul class="cgu-nav-list">
                    <li><a href="#objet" class="nav-link">Objet</a></li>
                    <li><a href="#reservations" class="nav-link">Réservations</a></li>
                    <li><a href="#paiement" class="nav-link">Paiement</a></li>
                    <li><a href="#annulation" class="nav-link">Annulation</a></li>
                    <li><a href="#sejour" class="nav-link">Séjour</a></li>
                    <li><a href="#responsabilite" class="nav-link">Responsabilité</a></li>
                </ul>
            </div>
        </nav>

        <!-- Contenu principal -->
        <div class="container">
            <div class="cgu-content">
                <!-- Section 1: Objet -->
                <section id="objet" class="cgu-section">
                    <div class="section-header">
                        <div class="section-number">1</div>
                        <h2>Objet</h2>
                    </div>
                    <div class="section-content">
                        <p>Les présentes conditions régissent la vente de prestations d'hébergement et de services annexes proposés par Miadjoe Beach Resort, situé à Aného.</p>
                    </div>
                </section>

                <!-- Section 2: Réservations -->
                <section id="reservations" class="cgu-section">
                    <div class="section-header">
                        <div class="section-number">2</div>
                        <h2>Réservations</h2>
                    </div>
                    <div class="section-content">
                        <div class="info-card">
                            <ul class="feature-list">
                                <li>
                                    <div class="icon-wrapper">
                                        <i class="icon-confirm"></i>
                                    </div>
                                    <div class="text-content">
                                        <strong>Confirmation de réservation</strong>
                                        <p>Toute réservation est confirmée après réception d'un acompte de 50% du montant total du séjour.</p>
                                    </div>
                                </li>
                                <li>
                                    <div class="icon-wrapper">
                                        <i class="icon-warning"></i>
                                    </div>
                                    <div class="text-content">
                                        <strong>Garantie</strong>
                                        <p>Sans paiement de l'acompte, la réservation n'est ni garantie ni confirmée.</p>
                                    </div>
                                </li>
                                <li>
                                    <div class="icon-wrapper">
                                        <i class="icon-payment"></i>
                                    </div>
                                    <div class="text-content">
                                        <strong>Solde</strong>
                                        <p>Le solde est à régler à l'arrivée ou selon les conditions convenues.</p>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </section>

                <!-- Section 3: Modes de paiement -->
                <section id="paiement" class="cgu-section">
                    <div class="section-header">
                        <div class="section-number">3</div>
                        <h2>Modes de paiement acceptés</h2>
                    </div>
                    <div class="section-content">
                        <div class="payment-methods">
                            <div class="payment-method">
                                <div class="payment-icon">💵</div>
                                <span>Espèces (FCFA)</span>
                            </div>
                            <div class="payment-method">
                                <div class="payment-icon">💳</div>
                                <span>Carte bancaire</span>
                            </div>
                            <div class="payment-method">
                                <div class="payment-icon">📱</div>
                                <span>Paiement mobile (TMoney, Flooz)</span>
                            </div>
                            <div class="payment-method">
                                <div class="payment-icon">🏦</div>
                                <span>Virement bancaire</span>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Section 4: Annulation et modification -->
                <section id="annulation" class="cgu-section highlight-section">
                    <div class="section-header">
                        <div class="section-number">4</div>
                        <h2>Conditions d'annulation et de modification</h2>
                    </div>
                    <div class="section-content">
                        <div class="timeline-cancellation">
                            <div class="timeline-item positive">
                                <div class="timeline-marker"></div>
                                <div class="timeline-content">
                                    <h4>Plus de 7 jours avant l'arrivée</h4>
                                    <p>Remboursement intégral de l'acompte</p>
                                </div>
                            </div>
                            <div class="timeline-item warning">
                                <div class="timeline-marker"></div>
                                <div class="timeline-content">
                                    <h4>Entre 7 et 3 jours avant l'arrivée</h4>
                                    <p>50% de l'acompte retenu</p>
                                </div>
                            </div>
                            <div class="timeline-item negative">
                                <div class="timeline-marker"></div>
                                <div class="timeline-content">
                                    <h4>Moins de 72 heures ou non-présentation</h4>
                                    <p>Aucun remboursement de l'acompte</p>
                                </div>
                            </div>
                        </div>
                        <div class="additional-info">
                            <p><strong>Modifications :</strong> Toute modification est soumise à disponibilité et peut entraîner un ajustement tarifaire.</p>
                        </div>
                    </div>
                </section>

                <!-- Section 5: Heures d'arrivée et de départ -->
                <section id="sejour" class="cgu-section">
                    <div class="section-header">
                        <div class="section-number">5</div>
                        <h2>Heures d'arrivée et de départ</h2>
                    </div>
                    <div class="section-content">
                        <div class="schedule-cards">
                            <div class="schedule-card arrival">
                                <div class="schedule-icon">🕑</div>
                                <h3>Arrivée</h3>
                                <p class="schedule-time">À partir de 14h00</p>
                            </div>
                            <div class="schedule-card departure">
                                <div class="schedule-icon">🚪</div>
                                <h3>Départ</h3>
                                <p class="schedule-time">Avant 12h00</p>
                            </div>
                        </div>
                        <div class="schedule-note">
                            <p><strong>Note :</strong> Tout départ tardif pourra faire l'objet d'une facturation supplémentaire (voir réception).</p>
                        </div>
                    </div>
                </section>

                <!-- Sections restantes -->
                <section id="responsabilite" class="cgu-section">
                    <div class="section-header">
                        <div class="section-number">6</div>
                        <h2>Responsabilité du client</h2>
                    </div>
                    <div class="section-content">
                        <div class="warning-card">
                            <div class="warning-header">
                                <i class="warning-icon">⚠️</i>
                                <h4>Responsabilités importantes</h4>
                            </div>
                            <ul>
                                <li>Le client est responsable de tout dommage causé dans la chambre ou les espaces communs.</li>
                                <li>Les objets de valeur doivent être gardés sur soi ou déposés à la réception.</li>
                            </ul>
                            <p class="warning-note">L'établissement décline toute responsabilité en cas de perte ou de vol si ces règles ne sont pas respectées.</p>
                        </div>
                    </div>
                </section>

                <!-- Autres sections (7-10) -->
                <section class="cgu-section">
                    <div class="section-header">
                        <div class="section-number">7</div>
                        <h2>Règlement intérieur</h2>
                    </div>
                    <div class="section-content">
                        <div class="rules-list">
                            <div class="rule-item">
                                <span class="rule-icon">🚭</span>
                                <span>Il est strictement interdit de fumer dans les chambres</span>
                            </div>
                            <div class="rule-item">
                                <span class="rule-icon">🔇</span>
                                <span>Le bruit excessif, nuisible aux autres clients, est interdit</span>
                            </div>
                            <div class="rule-item">
                                <span class="rule-icon">👥</span>
                                <span>Les visiteurs extérieurs ne sont pas autorisés à accéder aux chambres sans autorisation préalable</span>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="cgu-section">
                    <div class="section-header">
                        <div class="section-number">8</div>
                        <h2>Force majeure</h2>
                    </div>
                    <div class="section-content">
                        <div class="info-note">
                            <p>Miadjoe Beach Resort ne pourra être tenu responsable en cas d'événements imprévus (grève, intempéries, catastrophes naturelles…) entraînant l'annulation ou la modification du séjour.</p>
                        </div>
                    </div>
                </section>

                <section class="cgu-section">
                    <div class="section-header">
                        <div class="section-number">9</div>
                        <h2>Réclamations</h2>
                    </div>
                    <div class="section-content">
                        <div class="claim-process">
                            <div class="claim-step">
                                <div class="step-number">1</div>
                                <p><strong>Pendant le séjour :</strong> Toute réclamation doit être formulée pendant le séjour pour une résolution immédiate.</p>
                            </div>
                            <div class="claim-step">
                                <div class="step-number">2</div>
                                <p><strong>Après le départ :</strong> Seules les réclamations écrites reçues sous 7 jours seront prises en compte.</p>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="cgu-section acceptance-section">
                    <div class="section-header">
                        <div class="section-number">10</div>
                        <h2>Acceptation des CGV</h2>
                    </div>
                    <div class="section-content">
                        <div class="acceptance-card">
                            <div class="acceptance-icon">✅</div>
                            <p>Toute réservation implique l'adhésion pleine et entière aux présentes conditions générales.</p>
                        </div>
                    </div>
                </section>
            </div>
        </div>

        <!-- Pied de page des CGV -->
        <footer class="cgu-footer">
            <div class="container">
                <p>Document valable à compter du 1er janvier 2023 - Miadjoe Beach Resort</p>
            </div>
        </footer>
    </div>

    <style>
        /* Variables CSS */
        :root {
            --primary: #2c5530;
            --primary-light: #4a7852;
            --secondary: #d4af37;
            --accent: #e8f5e9;
            --text: #333;
            --text-light: #666;
            --background: #f8f9fa;
            --white: #ffffff;
            --border: #e0e0e0;
            --positive: #4caf50;
            --warning: #ff9800;
            --negative: #f44336;
        }

        /* Styles généraux */
        .cgu-container {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: var(--text);
            line-height: 1.6;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* Hero Section */
        .cgu-hero {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            color: var(--white);
            padding: 80px 0 60px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .cgu-hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" fill="%23ffffff" opacity="0.1"><polygon points="0,0 1000,50 1000,100 0,100"/></svg>') no-repeat bottom;
            background-size: cover;
        }

        .cgu-hero-content {
            position: relative;
            z-index: 2;
        }

        .cgu-title {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 1rem;
            text-shadow: 0 2px 4px rgba(0,0,0,0.3);
        }

        .cgu-subtitle {
            font-size: 1.3rem;
            opacity: 0.9;
            margin-bottom: 2rem;
        }

        .cgu-scroll-indicator {
            display: inline-flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
            font-size: 0.9rem;
            opacity: 0.8;
            animation: bounce 2s infinite;
        }

        .scroll-arrow {
            width: 20px;
            height: 20px;
            border-right: 2px solid var(--white);
            border-bottom: 2px solid var(--white);
            transform: rotate(45deg);
        }

        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% {transform: translateY(0);}
            40% {transform: translateY(-10px);}
            60% {transform: translateY(-5px);}
        }

        /* Navigation */
        .cgu-nav {
            background: var(--white);
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .cgu-nav-list {
            display: flex;
            justify-content: center;
            list-style: none;
            padding: 0;
            margin: 0;
            overflow-x: auto;
        }

        .cgu-nav-list li {
            margin: 0;
        }

        .nav-link {
            display: block;
            padding: 15px 20px;
            color: var(--text);
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            white-space: nowrap;
        }

        .nav-link:hover {
            color: var(--primary);
            background: var(--accent);
        }

        /* Sections principales */
        .cgu-content {
            padding: 60px 0;
        }

        .cgu-section {
            background: var(--white);
            border-radius: 12px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            border: 1px solid var(--border);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .cgu-section:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0,0,0,0.1);
        }

        .highlight-section {
            border-left: 4px solid var(--secondary);
        }

        .section-header {
            display: flex;
            align-items: center;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 2px solid var(--accent);
        }

        .section-number {
            background: var(--primary);
            color: var(--white);
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            margin-right: 15px;
            flex-shrink: 0;
        }

        .section-header h2 {
            color: var(--primary);
            margin: 0;
            font-size: 1.8rem;
        }

        /* Cartes d'information */
        .info-card {
            background: var(--accent);
            border-radius: 8px;
            padding: 20px;
        }

        .feature-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .feature-list li {
            display: flex;
            align-items: flex-start;
            margin-bottom: 20px;
            padding-bottom: 20px;
            border-bottom: 1px solid rgba(0,0,0,0.1);
        }

        .feature-list li:last-child {
            margin-bottom: 0;
            padding-bottom: 0;
            border-bottom: none;
        }

        .icon-wrapper {
            background: var(--white);
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            flex-shrink: 0;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .icon-confirm, .icon-warning, .icon-payment {
            width: 24px;
            height: 24px;
            background-color: var(--primary);
            border-radius: 50%;
            position: relative;
        }

        .icon-confirm::after {
            content: '✓';
            color: white;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .text-content strong {
            display: block;
            margin-bottom: 5px;
            color: var(--primary);
        }

        /* Méthodes de paiement */
        .payment-methods {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
        }

        .payment-method {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
            background: var(--background);
            border-radius: 8px;
            transition: transform 0.3s ease;
        }

        .payment-method:hover {
            transform: translateY(-5px);
        }

        .payment-icon {
            font-size: 2rem;
            margin-bottom: 10px;
        }

        /* Timeline d'annulation */
        .timeline-cancellation {
            position: relative;
            max-width: 600px;
            margin: 0 auto 30px;
        }

        .timeline-cancellation::before {
            content: '';
            position: absolute;
            left: 20px;
            top: 0;
            bottom: 0;
            width: 2px;
            background: var(--border);
        }

        .timeline-item {
            display: flex;
            margin-bottom: 30px;
            position: relative;
        }

        .timeline-marker {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 20px;
            flex-shrink: 0;
            position: relative;
            z-index: 2;
        }

        .positive .timeline-marker {
            background: var(--positive);
        }

        .warning .timeline-marker {
            background: var(--warning);
        }

        .negative .timeline-marker {
            background: var(--negative);
        }

        .timeline-content {
            flex: 1;
            padding-top: 5px;
        }

        .timeline-content h4 {
            margin: 0 0 5px;
            color: var(--text);
        }

        /* Cartes d'horaire */
        .schedule-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }

        .schedule-card {
            background: var(--background);
            padding: 25px;
            border-radius: 8px;
            text-align: center;
            transition: transform 0.3s ease;
        }

        .schedule-card:hover {
            transform: translateY(-5px);
        }

        .arrival {
            border-top: 4px solid var(--positive);
        }

        .departure {
            border-top: 4px solid var(--warning);
        }

        .schedule-icon {
            font-size: 2.5rem;
            margin-bottom: 15px;
        }

        .schedule-card h3 {
            margin: 0 0 10px;
            color: var(--primary);
        }

        .schedule-time {
            font-size: 1.2rem;
            font-weight: bold;
            margin: 0;
            color: var(--text);
        }

        /* Cartes d'avertissement */
        .warning-card {
            background: #fff3e0;
            border-left: 4px solid var(--warning);
            padding: 20px;
            border-radius: 8px;
        }

        .warning-header {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }

        .warning-icon {
            font-size: 1.5rem;
            margin-right: 10px;
        }

        .warning-header h4 {
            margin: 0;
            color: var(--text);
        }

        .warning-card ul {
            padding-left: 20px;
            margin-bottom: 15px;
        }

        .warning-note {
            font-style: italic;
            margin: 0;
            color: var(--text-light);
        }

        /* Règles */
        .rules-list {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .rule-item {
            display: flex;
            align-items: center;
            padding: 15px;
            background: var(--background);
            border-radius: 8px;
        }

        .rule-icon {
            font-size: 1.5rem;
            margin-right: 15px;
        }

        /* Processus de réclamation */
        .claim-process {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
        }

        .claim-step {
            display: flex;
            align-items: flex-start;
            background: var(--accent);
            padding: 20px;
            border-radius: 8px;
        }

        .step-number {
            background: var(--primary);
            color: var(--white);
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            margin-right: 15px;
            flex-shrink: 0;
        }

        /* Section d'acceptation */
        .acceptance-section {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            color: var(--white);
        }

        .acceptance-section .section-header {
            border-bottom-color: rgba(255,255,255,0.3);
        }

        .acceptance-section .section-number {
            background: var(--white);
            color: var(--primary);
        }

        .acceptance-section h2 {
            color: var(--white);
        }

        .acceptance-card {
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 30px;
        }

        .acceptance-icon {
            font-size: 3rem;
            margin-right: 20px;
        }

        /* Pied de page */
        .cgu-footer {
            background: var(--background);
            padding: 30px 0;
            text-align: center;
            color: var(--text-light);
            border-top: 1px solid var(--border);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .cgu-title {
                font-size: 2.2rem;
            }
            
            .cgu-subtitle {
                font-size: 1.1rem;
            }
            
            .cgu-nav-list {
                justify-content: flex-start;
            }
            
            .section-header {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .section-number {
                margin-bottom: 10px;
            }
            
            .feature-list li {
                flex-direction: column;
            }
            
            .icon-wrapper {
                margin-bottom: 10px;
            }
            
            .acceptance-card {
                flex-direction: column;
                text-align: center;
            }
            
            .acceptance-icon {
                margin-right: 0;
                margin-bottom: 15px;
            }
        }
    </style>

    <script>
        // Script pour la navigation fluide et l'activation des liens
        document.addEventListener('DOMContentLoaded', function() {
            // Navigation fluide
            const navLinks = document.querySelectorAll('.nav-link');
            
            navLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    const targetId = this.getAttribute('href');
                    const targetSection = document.querySelector(targetId);
                    
                    if (targetSection) {
                        window.scrollTo({
                            top: targetSection.offsetTop - 100,
                            behavior: 'smooth'
                        });
                    }
                });
            });
            
            // Highlight de la section active
            const sections = document.querySelectorAll('.cgu-section');
            
            function highlightActiveSection() {
                let currentSection = '';
                
                sections.forEach(section => {
                    const sectionTop = section.offsetTop - 150;
                    const sectionHeight = section.clientHeight;
                    const sectionId = section.getAttribute('id');
                    
                    if (scrollY >= sectionTop && scrollY < sectionTop + sectionHeight) {
                        currentSection = sectionId;
                    }
                });
                
                navLinks.forEach(link => {
                    link.classList.remove('active');
                    if (link.getAttribute('href') === `#${currentSection}`) {
                        link.classList.add('active');
                    }
                });
            }
            
            window.addEventListener('scroll', highlightActiveSection);
            
            // Animation d'apparition des sections
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };
            
            const observer = new IntersectionObserver(function(entries) {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = 1;
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            }, observerOptions);
            
            sections.forEach(section => {
                section.style.opacity = 0;
                section.style.transform = 'translateY(20px)';
                section.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                observer.observe(section);
            });
        });
    </script>

</x-layouts.public>