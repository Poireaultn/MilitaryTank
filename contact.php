<?php
session_start();
include 'Header.php';
?>

<main>
    <h1>Contactez-nous</h1>

    <?php if (isset($_SESSION['message_succes'])): ?>
        <div class="success-message" style="display: none;">
            <?php 
            $message = $_SESSION['message_succes'];
            unset($_SESSION['message_succes']); // Supprimer immédiatement le message
            echo $message;
            ?>
        </div>
    <?php endif; ?>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const successMessage = document.querySelector('.success-message');
            if (successMessage) {
                // Utiliser l'animation existante
                const formAnimation = document.querySelector('.tank-animation.form-animation');
                if (formAnimation) {
                    formAnimation.classList.add('active');
                    setTimeout(() => {
                        formAnimation.classList.remove('active');
                    }, 2000);
                }
            }
        });
    </script>

    <form id="contactForm" action="traitement_formulaire.php" method="POST">
        <div class="form-group">
            <label for="prenom">Prénom :</label>
            <input type="text" id="prenom" name="prenom" value="<?php echo isset($_SESSION['donnees_formulaire']['prenom']) ? htmlspecialchars($_SESSION['donnees_formulaire']['prenom']) : ''; ?>">
            <?php if (isset($_SESSION['erreurs']['prenom'])): ?>
                <div class="error"><?php echo $_SESSION['erreurs']['prenom']; ?></div>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="nom">Nom :</label>
            <input type="text" id="nom" name="nom" value="<?php echo isset($_SESSION['donnees_formulaire']['nom']) ? htmlspecialchars($_SESSION['donnees_formulaire']['nom']) : ''; ?>">
            <?php if (isset($_SESSION['erreurs']['nom'])): ?>
                <div class="error"><?php echo $_SESSION['erreurs']['nom']; ?></div>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="email">Email :</label>
            <input type="email" id="email" name="email" value="<?php echo isset($_SESSION['donnees_formulaire']['email']) ? htmlspecialchars($_SESSION['donnees_formulaire']['email']) : ''; ?>">
            <?php if (isset($_SESSION['erreurs']['email'])): ?>
                <div class="error"><?php echo $_SESSION['erreurs']['email']; ?></div>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="naissance">Date de naissance :</label>
            <input type="date" id="naissance" name="naissance" value="<?php echo isset($_SESSION['donnees_formulaire']['naissance']) ? htmlspecialchars($_SESSION['donnees_formulaire']['naissance']) : ''; ?>">
            <?php if (isset($_SESSION['erreurs']['naissance'])): ?>
                <div class="error"><?php echo $_SESSION['erreurs']['naissance']; ?></div>
            <?php endif; ?>
        </div>

        <fieldset>
            <legend>Genre :</legend>
            <div>
                <input type="radio" id="homme" name="genre" value="homme" <?php echo (isset($_SESSION['donnees_formulaire']['genre']) && $_SESSION['donnees_formulaire']['genre'] == 'homme') ? 'checked' : ''; ?>>
                <label for="homme">Homme</label>
            </div>
            <div>
                <input type="radio" id="femme" name="genre" value="femme" <?php echo (isset($_SESSION['donnees_formulaire']['genre']) && $_SESSION['donnees_formulaire']['genre'] == 'femme') ? 'checked' : ''; ?>>
                <label for="femme">Femme</label>
            </div>
            <?php if (isset($_SESSION['erreurs']['genre'])): ?>
                <div class="error"><?php echo $_SESSION['erreurs']['genre']; ?></div>
            <?php endif; ?>
        </fieldset>

        <div class="form-group">
            <label for="sujet">Sujet :</label>
            <input type="text" id="sujet" name="sujet" value="<?php echo isset($_SESSION['donnees_formulaire']['sujet']) ? htmlspecialchars($_SESSION['donnees_formulaire']['sujet']) : ''; ?>">
            <?php if (isset($_SESSION['erreurs']['sujet'])): ?>
                <div class="error"><?php echo $_SESSION['erreurs']['sujet']; ?></div>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="message">Message :</label>
            <textarea id="message" name="message"><?php echo isset($_SESSION['donnees_formulaire']['message']) ? htmlspecialchars($_SESSION['donnees_formulaire']['message']) : ''; ?></textarea>
            <?php if (isset($_SESSION['erreurs']['message'])): ?>
                <div class="error"><?php echo $_SESSION['erreurs']['message']; ?></div>
            <?php endif; ?>
        </div>

        <button type="submit">Envoyer</button>
    </form>
</main>

<?php
// Nettoyer les données de session après affichage
unset($_SESSION['erreurs']);
unset($_SESSION['donnees_formulaire']);
include 'Footer.php';
?> 