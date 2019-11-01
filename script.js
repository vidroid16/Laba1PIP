var submit;


function docLoad(){
    submit = document.getElementById("go");
}
function getCookie(name) {
    let matches = document.cookie.match(new RegExp(
        "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
    ));
    return matches ? decodeURIComponent(matches[1]) : undefined;
}
function check(x, y, r) {
    //alert(x+y+r);
    let vars =[];
    if (x === undefined) vars.push("X");
    if (y === undefined || y === "") vars.push("Y");
    if (r === undefined) vars.push("R");
    if (/^(2.9+)$/.test(y)) {
        y = 2.9999;
    } else if (/^-4.9+$/.test(y)) {
        y = -4.9999;
    }
    if (vars.length !== 0) return 'Значения ' + vars.join(', ') + ' не инициализированы';
    if (isNaN(Number(y))) return 'Значение Y должно быть числом';
    if ((y >= 3 || y <= -5)) return 'Значение Y должно быть в промежутке (-5; 3)';
    return 'ok';
}
function submitForm(){
    var x=document.querySelector('input[name="x"]:checked').value;
    var y=document.getElementById("Y").value;
    var r=document.querySelector('input[name="r"]:checked').value;

    var isOk = check(x,y,r);
    if(isOk=="ok"){
        let form = document.createElement("form");
        form.method = "GET";
        form.type = "hidden";
        form.innerHTML = "<input type='hidden' name='x' value=" + x + ">" +
            "<input type='hidden' name='y' value=" + y + ">" +
            "<input type='hidden' name='r' value=" + r + ">" +
            document.body.appendChild(form);
        form.submit();
    }else{
        var output = document.getElementById("invalid_data");
        output.innerHTML = isOk;
    }

}
function check2(){
    //alert("selected: " + $('input[name=radio_div]:checked').value);

}


