
var s_user = document.getElementById('s_user').innerText;
var s_team = document.getElementById('s_team').innerText;
var s_project = document.getElementById('s_project').innerText;

chrome.storage.sync.set({ s_user : s_user });
chrome.storage.local.set({ s_team: s_team });
chrome.storage.local.set({ s_project: s_project });