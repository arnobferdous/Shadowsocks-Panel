function sslink(data) {
    $('.sslink').html(data);
    $('#sslink').modal({
        show : true,
        backdrop: 'static',
        keyboard: false
    });
}
$('.bclose').on("click", function () {
    document.getElementById('copy').innerText = 'Copy to clipboard';
});

function getQRCode(data, name){
    manipulate(data, name);
    $('#qrCode').modal({
        show : true,
        backdrop: 'static',
        keyboard: false
    });
}

var qrcode = new QRCode("qrcode");
function manipulate(origstr, name) {
    var b64str = origstr;
    qrcode.makeCode(b64str + '#'+name);
}

function utf8_to_b64(str) {
    return window.btoa(unescape(encodeURIComponent(str)));
}

function getCredentials(data) {

    $("#credentials").html(
        "<tr class='table-light'><td class='row'><b>Server</b></td><td>"+JSON.parse(data).server+"</td></tr>"+
        "<tr class='table-light'><td class='row'><b>Port</b></td><td>"+JSON.parse(data).port+"</td></tr>"+
        "<tr class='table-light'><td class='row'><b>Password</b></td><td>"+JSON.parse(data).password+"</td></tr>"+
        "<tr class='table-light'><td class='row'><b>Method</b></td><td>"+JSON.parse(data).method+"</td></tr>"
    );

    $('#credentialsMod').modal({
        show : true,
        backdrop: 'static',
        keyboard: false
    });
}

function suspendUser(uid, sid) {

    $("#serverData").html(sid);
    $("#userData").html(uid);

    $('#suspend').modal({
        show : true,
        backdrop: 'static',
        keyboard: false
    });
}

function processSuspend() {
    let uid = $("#userData").html();
    let sid = $("#serverData").html();

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        beforeSend: function() {
          $('#suspendButton').html('<div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div>');
        },
        type:'POST',
        url: 'includes/process_suspend.php',
        data:{uid:uid, sid:sid},
        success: function(data){
            //console.log(data);

            location.reload();
        },
        error: function(data){
            //console.log(data);
            location.reload();
        }
    });
}

function restoreUser(uid, sid) {

    $("#serverData").html(sid);
    $("#userData").html(uid);

    $('#restore').modal({
        show : true,
        backdrop: 'static',
        keyboard: false
    });
}

function processRestoreUser() {

    let uid = $("#userData").html();
    let sid = $("#serverData").html();

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        beforeSend: function() {
            $('#restoreButton').html('<div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div>');
        },
        type:'POST',
        url: 'includes/process_restore.php',
        data:{uid: uid, sid:sid},
        success: function(){
            location.reload();
        },
        error: function(){
            location.reload();
        }
    });
}

//Add user from
function addUserSubmit() {
    $("button#addUserButton").attr("disabled", true);
    $("button#addUserButton").html('<div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div>');
    $("#addUserMsg").html("<hr /> The user is being created, it may take 1-2 minutes depending on servers condition. Please do not close/reload your browser tab...");
    $("#addUserForm").submit();
}