function submitOnClick(formname){
    document.forms[formname].submit();
}

function submitToPage(form, page){
    document.getElementById(form).action = page;
    document.forms[form].submit();
}
