document.addEventListener("DOMContentLoaded", function () {
    // Partie qui gère le zoom des images
    function AjouterOnMouseOver() {
      const catalogue = document.getElementById("catalogue");
      if (!catalogue) return;
      const images = catalogue.getElementsByTagName("img");
      for (let i = 0; i < images.length; i++) {
        images[i].addEventListener("mouseover", zoom);
      }
    }
  
    function AjouterOnMouseOut() {
      const catalogue = document.getElementById("catalogue");
      if (!catalogue) return;
      const images = catalogue.getElementsByTagName("img");
      for (let i = 0; i < images.length; i++) {
        images[i].addEventListener("mouseout", dezoom);
      }
    }
  
    function zoom(event) {
      const img = event.target;
      img.style.transform = "scale(2)";
      img.style.transition = "transform 0.3s ease, box-shadow 0.3s ease";
      img.style.transformOrigin = "center center";
      img.style.zIndex = "10";
      img.style.boxShadow = "0 8px 16px rgba(0,0,0,0.3)";
    }
  
    function dezoom(event) {
      const img = event.target;
      img.style.transform = "scale(1)";
      img.style.zIndex = "1";
      img.style.boxShadow = "none";
    }
  
    AjouterOnMouseOut();
    AjouterOnMouseOver();
  
    // Gestion du bouton masquer/afficher stock
    const stockButton = document.getElementById("toggleStock");
    const stockCols = document.querySelectorAll("th.stock-col, td.stock-col");
  
    if (stockButton && stockCols.length > 0) {
        // État initial
        let isVisible = true;
        stockCols.forEach(col => col.style.display = "table-cell");
        stockButton.textContent = "Masquer Stock";
  
        // Gestionnaire de clic
        stockButton.addEventListener("click", function() {
            isVisible = !isVisible;
            stockCols.forEach(col => {
                col.style.display = isVisible ? "table-cell" : "none";
            });
            stockButton.textContent = isVisible ? "Masquer Stock" : "Afficher Stock";
        });
    }
  
    // Boutons "+" et "-" pour modifier la quantité commandée
    const plusButtons = document.querySelectorAll(".plus");
    const minusButtons = document.querySelectorAll(".minus");
  
    function updateStockDisplay(row) {
        const stockNumber = row.querySelector(".stock-number");
        const qtyElement = row.querySelector(".qty-commandee");
        const addToCartButton = row.querySelector(".add-to-cart");
        const plusButton = row.querySelector(".plus");
        const minusButton = row.querySelector(".minus");
        const panierInfo = row.querySelector(".panier-info");
        
        const currentQty = parseInt(qtyElement.textContent) || 0;
        const stockInitial = parseInt(stockNumber.getAttribute("data-stock-initial"));
        let qtyInCart = 0;
        
        if (panierInfo) {
            const match = panierInfo.textContent.match(/\d+/);
            if (match) {
                qtyInCart = parseInt(match[0]);
            }
        }
        
        const stockDisponible = stockInitial - qtyInCart;
        
        // Mettre à jour le bouton d'ajout au panier
        addToCartButton.disabled = currentQty === 0;
        
        // Mettre à jour les boutons + et -
        plusButton.disabled = currentQty >= stockDisponible;
        minusButton.disabled = currentQty <= 0;

        // Mettre à jour l'affichage du stock disponible
        stockNumber.textContent = stockDisponible;
    }
  
    if (plusButtons.length > 0 && minusButtons.length > 0) {
        plusButtons.forEach(button => {
            // Supprimer les anciens event listeners
            const newButton = button.cloneNode(true);
            button.parentNode.replaceChild(newButton, button);
            
            newButton.addEventListener("click", function () {
                const row = this.closest("tr");
                const qtyElement = this.previousElementSibling;
                const currentQty = parseInt(qtyElement.textContent) || 0;
                const stockNumber = row.querySelector(".stock-number");
                const stockInitial = parseInt(stockNumber.getAttribute("data-stock-initial"));
                const panierInfo = row.querySelector(".panier-info");
                let qtyInCart = 0;

                if (panierInfo) {
                    const match = panierInfo.textContent.match(/\d+/);
                    if (match) {
                        qtyInCart = parseInt(match[0]);
                    }
                }

                const stockDisponible = stockInitial - qtyInCart;

                if (currentQty < stockDisponible) {
                    qtyElement.textContent = (currentQty + 1).toString();
                    updateStockDisplay(row);
                }
            });
        });
  
        minusButtons.forEach(button => {
            // Supprimer les anciens event listeners
            const newButton = button.cloneNode(true);
            button.parentNode.replaceChild(newButton, button);
            
            newButton.addEventListener("click", function () {
                const row = this.closest("tr");
                const qtyElement = this.nextElementSibling;
                const currentQty = parseInt(qtyElement.textContent) || 0;
  
                if (currentQty > 0) {
                    qtyElement.textContent = (currentQty - 1).toString();
                    updateStockDisplay(row);
                }
            });
        });
    }
  
    // Formulaire de contact
    const form = document.getElementById("contactForm");
    if (form) {
      const champs = [
        { id: "prenom", message: "Veuillez entrer votre prénom." },
        { id: "nom", message: "Veuillez entrer votre nom." },
        { id: "email", message: "Veuillez entrer une adresse email valide." },
        { id: "naissance", message: "Veuillez entrer votre date de naissance." },
        { id: "sujet", message: "Veuillez entrer un sujet." },
        { id: "message", message: "Veuillez écrire un message." }
      ];
  
      // Initialisation des bordures
      form.querySelectorAll("input, textarea").forEach(champ => {
        champ.style.border = "1px solid #ccc";
  
        // Supprime l'erreur dès qu'on modifie un champ
        champ.addEventListener("input", () => {
          champ.style.border = "1px solid #ccc";
          const next = champ.nextElementSibling;
          if (next && next.classList.contains("error")) {
            next.remove();
          }
        });
      });
  
      // Supprimer l'erreur du champ radio quand on change de sélection
      const genreRadios = form.querySelectorAll("input[name='genre']");
      genreRadios.forEach(radio => {
        radio.addEventListener("change", () => {
          const fieldset = form.querySelector("fieldset");
          const error = fieldset.querySelector(".error");
          if (error) error.remove();
        });
      });
  
      form.addEventListener("submit", function (e) {
        e.preventDefault();
        let isValid = true;
  
        form.querySelectorAll(".error").forEach(el => el.remove());
  
        champs.forEach(({ id, message }) => {
          const champ = form.querySelector("#" + id);
          const value = champ.value.trim();
          let invalide = false;
  
          if (value === "") {
            invalide = true;
          } else if (
            id === "email" &&
            !/^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/.test(value)
          ) {
            invalide = true;
          }
  
          if (invalide) {
            isValid = false;
            champ.style.border = "2px solid red";
            const erreur = document.createElement("div");
            erreur.className = "error";
            erreur.style.color = "red";
            erreur.textContent = message;
            champ.parentNode.insertBefore(erreur, champ.nextSibling);
          } else {
            champ.style.border = "1px solid #ccc";
          }
        });
  
        // Vérification du champ radio "genre"
        const genreChecked = form.querySelector("input[name='genre']:checked");
        const fieldset = form.querySelector("fieldset");
        const genreError = fieldset.querySelector(".error");
  
        if (genreError) genreError.remove();
  
        if (!genreChecked) {
          isValid = false;
          const erreur = document.createElement("div");
          erreur.className = "error";
          erreur.style.color = "red";
          erreur.textContent = "Veuillez sélectionner un genre.";
          fieldset.appendChild(erreur);
        }
  
        if (isValid) {
          // Soumettre le formulaire
          form.submit();
        }
      });
    }
  
    // Création de l'élément d'animation pour le panier
    const tankAnimation = document.createElement('div');
    tankAnimation.className = 'tank-animation';
    const message = document.createElement('div');
    message.className = 'message';
    message.textContent = '💥 ARTICLE AJOUTÉ ! 💥';
    tankAnimation.appendChild(message);
    document.body.appendChild(tankAnimation);

    // Création de l'élément d'animation pour la connexion
    const loginAnimation = document.createElement('div');
    loginAnimation.className = 'tank-animation login-animation';
    const loginMessage = document.createElement('div');
    loginMessage.className = 'message';
    loginMessage.textContent = '⚠️ CONNECTION REQUISE ! ⚠️';
    loginAnimation.appendChild(loginMessage);
    document.body.appendChild(loginAnimation);

    // Création de l'élément d'animation pour le formulaire
    const formAnimation = document.createElement('div');
    formAnimation.className = 'tank-animation form-animation';
    const formMessage = document.createElement('div');
    formMessage.className = 'message';
    formMessage.textContent = '✅ MESSAGE ENVOYÉ ! ✅';
    formAnimation.appendChild(formMessage);
    document.body.appendChild(formAnimation);

    // Fonction pour gérer l'affichage des animations
    function showAnimation(animation) {
        animation.classList.add('active');
        setTimeout(() => {
            animation.classList.remove('active');
        }, 2000);
    }

    // Vérifier s'il y a un message de succès pour le formulaire
    const successMessage = document.querySelector('.success-message');
    if (successMessage) {
        showAnimation(formAnimation);
    }

    // Gestion du formulaire de connexion
    const loginForm = document.querySelector('.connexion form[action="VerifierConnection.php"]');
    if (loginForm) {
        loginForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            try {
                const formData = new FormData(this);
                const response = await fetch('VerifierConnection.php', {
                    method: 'POST',
                    body: formData
                });
                
                const data = await response.json();
                
                if (data.success) {
                    window.location.reload();
                } else {
                    alert(data.message || 'Erreur de connexion');
                }
            } catch (error) {
                console.error('Erreur:', error);
                alert('Une erreur est survenue lors de la connexion');
            }
        });
    }

    // Initialisation du contexte audio
    const audioContext = new (window.AudioContext || window.webkitAudioContext)();
    let tankShotBuffer = null;

    // Fonction pour charger un fichier audio
    async function loadSound(url) {
        try {
            const response = await fetch(url);
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            const arrayBuffer = await response.arrayBuffer();
            const audioBuffer = await audioContext.decodeAudioData(arrayBuffer);
            return audioBuffer;
        } catch (error) {
            console.error(`Erreur lors du chargement du son ${url}:`, error);
            return null;
        }
    }

    // Charger le son au démarrage
    loadSound('sound/TankShot.mp3')
        .then((tankShot) => {
            tankShotBuffer = tankShot;
            console.log("Son chargé avec succès");
        })
        .catch(error => {
            console.error("Erreur lors du chargement du son:", error);
        });

    // Fonction pour jouer un son
    function playSound(buffer) {
        if (!buffer) {
            console.error("Buffer audio non disponible");
            return;
        }
        
        try {
            const source = audioContext.createBufferSource();
            const gainNode = audioContext.createGain();
            
            source.buffer = buffer;
            gainNode.gain.value = 0.5; // Volume à 50%
            
            source.connect(gainNode);
            gainNode.connect(audioContext.destination);
            
            source.start(0);
            return source;
        } catch (error) {
            console.error("Erreur lors de la lecture du son:", error);
        }
    }

    // Fonction pour jouer l'animation du tank
    function playTankAnimation() {
        tankAnimation.classList.add('active');
        setTimeout(() => {
            if (tankAnimation.classList.contains('active')) {
                tankAnimation.classList.remove('active');
            }
        }, 2000);
    }

    // Fonction pour jouer le son du tank
    function playTankSound() {
        if (tankShotBuffer) {
            playSound(tankShotBuffer);
        } else {
            console.error("Son de tir non chargé");
        }
    }

    // Fonction pour afficher l'animation du message de connexion
    function showLoginAnimation() {
        const loginAnimation = document.querySelector('.login-animation');
        if (loginAnimation) {
            loginAnimation.classList.add('active');
            setTimeout(() => {
                loginAnimation.classList.remove('active');
            }, 2000);
        }
    }

    // Gestion du bouton "Ajouter au panier"
    const addToCartButtons = document.querySelectorAll(".add-to-cart");
    if (addToCartButtons.length > 0) {
        // Charger l'état initial du panier et mettre à jour l'affichage
        function updatePanierDisplay() {
            fetch("GetPanierQuantites.php")
                .then(response => response.json())
                .then(panierData => {
                    addToCartButtons.forEach(button => {
                        const row = button.closest("tr");
                        if (!row) return; // Skip si la ligne n'existe pas
                        
                        const stockCol = row.querySelector(".stock-col");
                        if (!stockCol) return; // Skip si la colonne stock n'existe pas
                        
                        const stockNumber = row.querySelector(".stock-number");
                        if (!stockNumber) return; // Skip si le nombre de stock n'existe pas
                        
                        const productId = button.getAttribute('data-product-id');
                        const stockInitial = parseInt(stockNumber.getAttribute("data-stock-initial"));
                        
                        // Supprimer l'ancien panierInfo s'il existe
                        const oldPanierInfo = row.querySelector(".panier-info");
                        if (oldPanierInfo) {
                            oldPanierInfo.remove();
                        }
                        
                        // Récupérer la quantité dans le panier
                        const qtyInCart = panierData[productId] ? parseInt(panierData[productId].quantite) : 0;
                        
                        // Mettre à jour le stock disponible
                        const stockDisponible = stockInitial - qtyInCart;
                        stockNumber.textContent = stockDisponible;
                        
                        // Conserver le style display actuel
                        const currentDisplay = stockCol.style.display;
                        
                        // Ajouter le nouveau panierInfo si nécessaire
                        if (qtyInCart > 0) {
                            const panierInfo = document.createElement("span");
                            panierInfo.className = "panier-info";
                            panierInfo.textContent = `(${qtyInCart} dans votre panier)`;
                            stockCol.appendChild(panierInfo);
                        }
                        
                        // Restaurer le style display
                        stockCol.style.display = currentDisplay;

                        // Mettre à jour l'état des boutons
                        const qtyElement = row.querySelector(".qty-commandee");
                        if (!qtyElement) return; // Skip si l'élément quantité n'existe pas
                        
                        const currentQty = parseInt(qtyElement.textContent) || 0;
                        const plusButton = row.querySelector(".plus");
                        const minusButton = row.querySelector(".minus");
                        
                        if (plusButton) plusButton.disabled = currentQty >= stockDisponible;
                        if (minusButton) minusButton.disabled = currentQty <= 0;
                        button.disabled = currentQty === 0;
                    });
                })
                .catch(error => console.error("Erreur lors du chargement du panier:", error));
        }

        // Appeler la fonction au chargement
        updatePanierDisplay();

        addToCartButtons.forEach(button => {
            button.addEventListener("click", async function() {
                const row = button.closest("tr");
                const qtyElement = row.querySelector(".qty-commandee");
                const quantite = parseInt(qtyElement.textContent);

                if (quantite === 0) {
                    return;
                }

                const formData = new FormData();
                formData.append("productId", this.getAttribute("data-product-id"));
                formData.append("quantite", quantite);

                try {
                    const response = await fetch("AjouterAuPanier.php", {
                        method: "POST",
                        body: formData
                    });

                    const data = await response.json();
                    if (data.success) {
                        // Jouer l'animation et le son
                        playTankAnimation();
                        playTankSound();
                        
                        // Réinitialiser la quantité commandée à 0
                        qtyElement.textContent = "0";
                        
                        // Mettre à jour immédiatement l'affichage du stock et du panier
                        const stockNumber = row.querySelector(".stock-number");
                        const stockInitial = parseInt(stockNumber.getAttribute("data-stock-initial"));
                        const stockCol = row.querySelector(".stock-col");
                        
                        // Supprimer l'ancien panierInfo s'il existe
                        const oldPanierInfo = row.querySelector(".panier-info");
                        if (oldPanierInfo) {
                            oldPanierInfo.remove();
                        }
                        
                        // Mettre à jour l'affichage complet du panier après un court délai
                        setTimeout(updatePanierDisplay, 100);
                    } else if (data.message === "Veuillez vous connecter") {
                        showLoginAnimation();
                    } else {
                        alert(data.message || "Erreur lors de l'ajout au panier");
                    }
                } catch (error) {
                    console.error("Erreur:", error);
                    alert("Une erreur est survenue lors de l'ajout au panier.");
                }
            });
        });
    }

    // Le formulaire de déconnexion n'a pas besoin d'être intercepté
    // Il sera traité directement par Deconnexion.php
  });
  