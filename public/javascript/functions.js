function submitOnClick(formname){
    document.forms[formname].submit();
}

function submitToPage(form, page){
    document.getElementById(form).action = page;
    document.forms[form].submit();
}

function updateAmount(element){
    var parent = element.parentNode;
    var aantal = element.value;
    if(aantal > 1000){
        aantal = 1000;
    }
    var id = parent.getAttribute("id");
    var product_id = id.replace( /^\D+/g, '');
    var hidden = document.getElementById(product_id);
    hidden.value = aantal;
}

