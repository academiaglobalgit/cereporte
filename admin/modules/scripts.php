<!-- Scripts Generales -->
<script src="assets/js/jquery.js"></script>
<script src="assets/js/jquery-ui-1.11.4.custom/jquery-ui.min.js"></script>

<script src="assets/js/bootstrap.js"></script>
<script src="assets/js/formValidation.js"></script>
<script src="assets/js/framework/bootstrap.min.js"></script>
<script src="../ayuda/controllerchat_jquery_prueba.js"></script>

<!-- Scripts para el calendario -->
<?php
    if($activePage == 'calendario'){
        echo '
        <script src="assets/js/moment.js"></script>
        <script src="assets/js/bootstrap_datetimepicker.js"></script>
        <script src="assets/js/fullcalendar.js"></script>
        ';
    }
?>

<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if gt IE 7]>
<script src="assets/js/html5shiv.js"></script>
<script src="assets/js/respond.js"></script>
<![endif]-->

<!-- Globals Scripts -->
<script src="controllers/footer.js"></script>
 