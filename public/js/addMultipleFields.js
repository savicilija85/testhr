var room = 1;
function addMultipleFields() {

    room++;
    var objTo = document.getElementById('accountFields');
    var divtest = document.createElement("div");
    divtest.setAttribute("class", "form-group removeclass"+room);
    var rdiv = 'removeclass'+room;

    divtest.innerHTML = '<label for="account" class="col-md-4 control-label">Broj računa</label>\n' +
        '    <div class="col-md-6"> \n' +
        '   <div class="input-group">\n' +
        '        <input type="text" class="form-control" name="accountSmall[]" required pattern="[0-9]*" placeholder="000" maxlength="3" size="3">\n' +
        '        <span class="input-group-addon">-</span>\n' +
        '        <input type="text" class="form-control" name="accountLarge[]" required pattern="[0-9]*" placeholder="000000000000" maxlength="13" size="13">\n' +
        '        <span class="input-group-addon">-</span>\n' +
        '        <input type="text" class="form-control" name="accountMini[]" required pattern="[0-9]*" placeholder="00" maxlength="2" size="2">\n' +
        '        <div class="input-group-btn"> \n' +
        '        <button class="btn btn-danger" type="button" onclick="remove_fields('+ room +');"> \n' +
        '        <span class="glyphicon glyphicon-minus" aria-hidden="true"></span> \n' +
        '        </button>\n' +
        '        </div>\n' +
        '    </div></div>\n' +
        '    </div><div class="clear">';

        objTo.appendChild(divtest);
}
function remove_fields(rid) {
    $('.removeclass'+rid).remove();
}