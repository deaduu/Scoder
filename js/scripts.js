$(document).ready(() => {
    $('#startproject').click(() => {
        $.post('ajax/createproject.php', { name: $('#projectname').val() }, () => {

        });
    });
});