<div class="membership">
    <div class="subscription">
        <h3 class="subscription__title">¡Únete a nuestra comunidad!</h3>
        <p class="subscription__description">Sé la primera en enterarte de las últimas novedades, ofertas y lanzamientos exclusivos de nuestras marcas.</p>
        <div class="subscription__input">
            <div class="group-form">
                <input type="email" class="input-email" placeholder="Ingresa tu correo electrónico">
                <input type="hidden" name="origin" value="<?php echo $origin; ?>">
                <div class="form-button">
                    <button id="js-subscription" class="btn-send" type="button">
                        <svg width="20" height="16" viewBox="0 0 20 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M16.826 6.99934L12.241 1.65034C11.881 1.23034 11.93 0.599344 12.349 0.240344C12.768 -0.118656 13.399 -0.069656 13.759 0.348344L19.759 7.34834C19.801 7.39634 19.822 7.45434 19.853 7.50734C19.877 7.55034 19.908 7.58734 19.926 7.63434C19.972 7.75034 19.999 7.87134 19.999 7.99434C19.999 7.99634 20 7.99834 20 7.99934C19.999 8.12734 19.972 8.24834 19.926 8.36434C19.908 8.41134 19.877 8.44834 19.853 8.49134C19.822 8.54434 19.801 8.60234 19.759 8.65034L13.759 15.6503C13.562 15.8803 13.281 15.9993 13 15.9993C12.769 15.9993 12.538 15.9203 12.349 15.7583C11.93 15.3993 11.881 14.7683 12.241 14.3483L16.826 8.99934L1 8.99934C0.448 8.99934 0 8.55134 0 7.99934C0 7.44734 0.448 6.99934 1 6.99934L16.826 6.99934Z" fill="white"/>
                        </svg>
                    </button>
                </div>
            </div>
            <div class="error-message hidden">
                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M7.99967 14.6668C11.6818 14.6668 14.6663 11.6823 14.6663 8.00016C14.6663 4.31807 11.6818 1.3335 7.99967 1.3335C4.31758 1.3335 1.33301 4.31807 1.33301 8.00016C1.33301 11.6823 4.31758 14.6668 7.99967 14.6668ZM7.99967 2.66683C10.9454 2.66683 13.333 5.05447 13.333 8.00016C13.333 10.9459 10.9454 13.3335 7.99967 13.3335C5.05398 13.3335 2.66634 10.9459 2.66634 8.00016C2.66634 5.05447 5.05398 2.66683 7.99967 2.66683ZM7.99967 5.66683C7.53944 5.66683 7.16634 5.29373 7.16634 4.8335C7.16634 4.37326 7.53944 4.00016 7.99967 4.00016C8.45991 4.00016 8.83301 4.37326 8.83301 4.8335C8.83301 5.29373 8.45991 5.66683 7.99967 5.66683ZM7.99967 6.3335C7.63148 6.3335 7.33301 6.63197 7.33301 7.00016V11.6668C7.33301 12.035 7.63148 12.3335 7.99967 12.3335C8.36786 12.3335 8.66634 12.035 8.66634 11.6668V7.00016C8.66634 6.63197 8.36786 6.3335 7.99967 6.3335Z" fill="#D40000"/>
                </svg>
                <p>Este correo electrónico ya está suscrito, ingresa otro</p>
            </div>
        </div>
        <p class="subscription__terms">Al suscribirte, aceptas nuestra <a href="<?php echo get_template_directory_uri(); ?>/pdf/Política_de_Privacidad.pdf" target="_blank">Política de Privacidad</a> y <a href="<?php echo get_template_directory_uri(); ?>/pdf/Autorización_para_el_Envío_de_Publicidad.pdf" target="_blank">Autorización para el Envío de Publicidad</a>.</p>
        <p class="subscription__recaptcha">Este sitio está protegido por reCAPTCHA. Aplican la Política de Privacidad y los Términos del Servicio de Google.</p>
    </div>
    <div class="confirmation">
        <svg width="56" height="56" viewBox="0 0 56 56" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" clip-rule="evenodd" d="M23.333 15.1668C23.333 12.5895 25.4223 10.5002 27.9997 10.5002C30.577 10.5002 32.6663 12.5895 32.6663 15.1668C32.6663 17.7442 30.577 19.8335 27.9997 19.8335C25.4223 19.8335 23.333 17.7442 23.333 15.1668ZM27.9997 5.8335C22.845 5.8335 18.6663 10.0122 18.6663 15.1668C18.6663 20.3215 22.845 24.5002 27.9997 24.5002C33.1543 24.5002 37.333 20.3215 37.333 15.1668C37.333 10.0122 33.1543 5.8335 27.9997 5.8335ZM18.6663 38.5002C18.6663 34.6342 21.8003 31.5002 25.6663 31.5002H30.333C34.199 31.5002 37.333 34.6342 37.333 38.5002V47.8335C37.333 49.1222 38.3777 50.1668 39.6663 50.1668C40.955 50.1668 41.9997 49.1222 41.9997 47.8335V38.5002C41.9997 32.0568 36.7763 26.8335 30.333 26.8335H25.6663C19.223 26.8335 13.9997 32.0568 13.9997 38.5002V47.8335C13.9997 49.1222 15.0443 50.1668 16.333 50.1668C17.6217 50.1668 18.6663 49.1222 18.6663 47.8335V38.5002ZM6.99967 38.5002C6.99967 35.9228 9.08901 33.8335 11.6663 33.8335H12.833C14.1217 33.8335 15.1663 32.7888 15.1663 31.5002C15.1663 30.2115 14.1217 29.1668 12.833 29.1668H11.6663C6.51168 29.1668 2.33301 33.3455 2.33301 38.5002V43.1668C2.33301 44.4555 3.37768 45.5002 4.66634 45.5002C5.95501 45.5002 6.99967 44.4555 6.99967 43.1668V38.5002ZM40.833 31.5002C40.833 30.2115 41.8777 29.1668 43.1663 29.1668H44.333C49.4877 29.1668 53.6663 33.3455 53.6663 38.5002V43.1668C53.6663 44.4555 52.6217 45.5002 51.333 45.5002C50.0443 45.5002 48.9997 44.4555 48.9997 43.1668V38.5002C48.9997 35.9228 46.9103 33.8335 44.333 33.8335H43.1663C41.8777 33.8335 40.833 32.7888 40.833 31.5002ZM11.6663 17.5002C10.3777 17.5002 9.33301 18.5448 9.33301 19.8335C9.33301 21.1222 10.3777 22.1668 11.6663 22.1668C12.955 22.1668 13.9997 21.1222 13.9997 19.8335C13.9997 18.5448 12.955 17.5002 11.6663 17.5002ZM4.66634 19.8335C4.66634 15.9675 7.80035 12.8335 11.6663 12.8335C15.5323 12.8335 18.6663 15.9675 18.6663 19.8335C18.6663 23.6995 15.5323 26.8335 11.6663 26.8335C7.80035 26.8335 4.66634 23.6995 4.66634 19.8335ZM41.9997 19.8335C41.9997 18.5448 43.0443 17.5002 44.333 17.5002C45.6217 17.5002 46.6663 18.5448 46.6663 19.8335C46.6663 21.1222 45.6217 22.1668 44.333 22.1668C43.0443 22.1668 41.9997 21.1222 41.9997 19.8335ZM44.333 12.8335C40.467 12.8335 37.333 15.9675 37.333 19.8335C37.333 23.6995 40.467 26.8335 44.333 26.8335C48.199 26.8335 51.333 23.6995 51.333 19.8335C51.333 15.9675 48.199 12.8335 44.333 12.8335Z" fill="black"/>
        </svg>
        <h3 class="confirmation__title">¡Gracias por suscribirte a nuestra comunidad!</h3>
        <p class="confirmation__description">Desde ahora recibirás las últimas novedades, ofertas y lanzamientos exclusivos de nuestras marcas.</p>
    </div>
</div>