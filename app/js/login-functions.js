var openInput = (e) => {
    $(e.currentTarget).children('.info').addClass('focused');
    $(e.currentTarget).children('.tel-input').focus();
}

// Add focus on focus of the field (
$('.focus-style-js-input').focus((e) =>{
    $(e.currentTarget).parent().children('.info').addClass('focused');
    
});

// Add focus on click of the field (div)
$('.focus-style-js').on('click', openInput);

// On blur remove the focus if input length is 0
$('.focus-style-js-input').on('blur', (e) => {
    var el = $(e.currentTarget);
    if(el.val().length < 1) {
        el.parent().children('.info').removeClass('focused');
    }
});


function showErrorMessage(msg) {
    $('#messageError').removeClass('hide');
    $('#messageError .text').html(msg);
}

$('.render-page-click').click((e) => {
    onePage.render($(e.currentTarget).attr('to-page'));
});

$("#loginTelNr").keyup(() => {
    var telNr = $('#loginTelNr').val();
    $('#telNrError').addClass('not-visible');
    if(telNr.length > 5) {
        verifyTelNr()
    }
});

// Returns true if the telnr is validated otherwise false
var verifyTelNr = function() {
    var telNr = $('#loginTelNr').val();
    $('#telNrError').addClass('not-visible');

    // Check if the telNr contains numbers only
    if(isNaN(telNr)){
        $('#telNrError').removeClass('not-visible').children('.text').text(`Telefonnummeret er ikke gyldig`);
    }
    // Tel nr is not equals to 8, show error
    else if(telNr.length < 8) {
        $('#telNrError').removeClass('not-visible').children('.text').text(`Det mangler ${8 - telNr.length} tall i telefonnummeret`);
    }
    else if(telNr.length > 8) {
        $('#telNrError').removeClass('not-visible').children('.text').text(`Det er for mange tall i telefonnummeret`);
    }
    else {
        return true;
    }
    return false;
}

$('.show-hide-password').click((e) => {
    var el = $(e.currentTarget);
    var input = el.parent().parent().children('.show-hide-input');

    console.log('a');

    if(input.attr('type') == 'password') {
        input.attr('type', 'text');
        el.text('skjul');
    }
    else {
        input.attr('type', 'password');
        el.text('vis');
    }
});


// Dette sjekkes også i backend (file: UserPdo.php)
function validatePassword(p, errorEl, show) {
    errors = [];

    errorEl.children('*').detach();
    
    if(p.length < 6 && show != true) {
        errorEl.children('*').detach();
        return;
    }
    if(p.length < 8) {
        errors.push("Passordet må inneholde minst 8 tegn");
    }
    if(p.search(/[a-z]/i) < 0) {
        errors.push("Passordet må inneholde minst 1 bokstav");
    }
    if(p.search(/^(?=.*[A-Z])/) < 0) {
        errors.push("Passordet må inneholde minst 1 stor bokstav");
    }
    if(p.search(/(?=.*[0-9])/) < 0) {
        errors.push("Passordet må inneholde minst 1 tall"); 
    }
    if(p.search(/(?=.*[%@$])/) > -1) {
        errors.push("Passordet kan ikke inneholde symbolene %@$"); 
    }
    if (errors.length > 0) {
        for(var err of errors) {
            addErrorMessage(errorEl, err);
        }
        
        return false;
    }
    return true;
}
