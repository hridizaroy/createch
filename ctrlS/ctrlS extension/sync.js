
var username;
var teamName;
var projectName;
var check = false;

get();

//ctrlS sync button
function set(a, b) {
    b = b || 0;
    if (b === 0) {
        a = this;
    }
    else {
        a = b;
    }
    if (a.checked) {
        check = true;

        document.body.addEventListener('mouseup', copy);
        document.body.addEventListener('keyup', copy);
    }
    else {
        check = false;

        document.body.removeEventListener('mouseup', copy);
        document.body.removeEventListener('keyup', copy);
    }
}

//Getting data from storage
function get() {
    chrome.storage.sync.get(['s_user'], function (result) {
        username = result.s_user;
    });

    chrome.storage.local.get(['s_team'], function (result) {
        teamName = result.s_team;
    });

    chrome.storage.local.get(['s_project'], function (result) {
        projectName = result.s_project;
        setInterval(checkActive, 1000);
    });
}

//Checking if user is active on any ctrlS Project page
function checkActive() {

    const params = "projectName=" + projectName + "&teamName=" + teamName + "&username=" + username;

    var xhttp = new XMLHttpRequest();
    var url = "http://localhost/Remote%20Collab%20app/ifActive.php";
    xhttp.open("POST", url, true);
    xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            if (xhttp.responseText == 1) {
                if (document.getElementById('ctrlSButton') != null ) {
                    document.getElementById('ctrlSButton').style.display = "block";
                    document.querySelector('#ctrlSButton input').addEventListener('input', set);
                }
                else {
                    var button = document.createElement('div');
                    var sync = document.createElement('input');
                    var label = document.createElement('label');

                    button.id = "ctrlSButton";
                    button.style.position = "fixed";
                    button.style.top = 0;
                    button.style.right = 0;

                    sync.type = "checkbox";
                    sync.name = "ctrlSButton";

                    label.innerText = "ctrlS sync";
                    label.for = "ctrlSButton";

                    button.appendChild(sync);
                    button.appendChild(label);

                    button.style.zIndex = "100000";

                    document.body.appendChild(button);

                    document.querySelector('#ctrlSButton input').addEventListener('input', set);
                }
            }
            else if (xhttp.responseText == 0) {
                if (document.getElementById('ctrlSButton') != null) {
                    document.getElementById('ctrlSButton').style.display = "none";
                }   
            }
        }
    };
    xhttp.send(params);
}

function copy() {
    var selection = window.getSelection().toString();

    if (selection.trim() != "") {

        var fileCont = encodeURIComponent(selection);

        const params = `projectName=` + projectName + `&teamName=` + teamName + `&fileCont=` + fileCont;

        var xhttp = new XMLHttpRequest();
        var url = "http://localhost/Remote%20Collab%20app/copy.php";
        xhttp.open("POST", url, true);
        xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                
            }
        };
        xhttp.send(params);
    }
}
