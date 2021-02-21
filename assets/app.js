/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';

// start the Stimulus application
import './bootstrap';

$('#app-notifs div').each(function(){
    var type = $(this).data('type');

    var icon = '';
    if(type == 'success') icon = 'fas fa-check-circle';
    if(type == 'danger') icon = 'fas fa-exclamation-circle';
    if(type == 'info') icon = 'fas fa-info-circle';
    if(type == 'warning') icon = 'fas fa-exclamation-triangle';

    $.notify({
        icon: icon,
        message: $(this).html()
    },{
        type: $(this).data('type'),
        delay: 5000
    })
});

require('ion-rangeslider');

$("#slider").ionRangeSlider({
    skin: "big",
    min: 0,
    max: 5,
    step: 1,
    type: 'single',
    postfix: "/5",
    grid: true,
    grid_num: 5
});

$(function () {
    $('[data-toggle="tooltip"]').tooltip()
});

require('datatables.net');
require('datatables.net-bs');

$(document).ready(function() {
    $('#tableauadmin').DataTable({
        'paging'      : true,
        'lengthChange': false,
        'searching'   : true,
        'ordering'    : false,
        'autoWidth'   : true,
        "dom": '<"top right search"f>t<"left"i><"align-center"p>',
        "language": {
            "processing":     "Traitement en cours...",
            "infoEmpty":      "Affichage de l'&eacute;l&eacute;ment 0 &agrave; 0 sur 0 &eacute;l&eacute;ment",
            "info": "Affichage de l'&eacute;l&eacute;ment _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
            "search": "Rechercher",
            "infoFiltered":   "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
            "loadingRecords": "Chargement en cours...",
            "zeroRecords":    "Aucun &eacute;l&eacute;ment &agrave; afficher",
            "emptyTable":     "Aucune donn&eacute;e disponible dans le tableau",
            "paginate" : {
                "previous" : "Précédent",
                "next" : "Suivant"
            }
        }
    });
} );

