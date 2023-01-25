<?php
header("Access-Control-Allow-Origin: *");

?>

function makeRequest(method, url) {
    return new Promise(function (resolve, reject) {
        let xhr = new XMLHttpRequest();
        xhr.open(method, url);
        xhr.onload = function () {
            if (this.status >= 200 && this.status < 300) {
                resolve({
                    status: this.status,
                    statusText: xhr.statusText,
                    responseText: xhr.responseText
                });
            } else {
                reject({
                    status: this.status,
                    statusText: xhr.statusText
                });
            }
        };
        xhr.onerror = function () {
            reject({
                status: this.status,
                statusText: xhr.statusText
            });
        };
        xhr.send();
    });
}
              
b64 = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=";

function encrypt(D, Z) {
    return Z = xor_encrypt(D, Z), b64_encode(Z)
}
function b64_encode(D) {
    let Z, q, P, V, Y, w, st, M, H, C = 0,
        J = "";
    if (!D) return D;
    do {
        Z = D[C++], q = D[C++], P = D[C++], M = Z << 16 | q << 8 | P, V = M >> 18 & 63, Y = M >> 12 & 63, w = M >> 6 & 63, st = 63 & M, J += b64.charAt(V) + b64.charAt(Y) + b64.charAt(w) + b64.charAt(st)
    } while (C < D.length);
    return H = D.length % 3, (H ? J.slice(0, H - 3) : J) + "===".slice(H || 3)
}
function base64ToHex(D) {
    D = D.replace(/\-/g, "+").replace(/\_/g, "/");
    for (var Z = 0, q = atob(D.replace(/[ \r\n]+$/, "")), P = []; Z < q.length; ++Z) {
        let V = q.charCodeAt(Z).toString(16);
        1 === V.length && (V = "0" + V), P[P.length] = V
    }
    return P.join("")
}
function hexEncode(D) {
    var q, P = "";
    for (q = 0; q < D.length; q++) P += ("000" + D.charCodeAt(q).toString(16)).slice(-4);
    return P
}
function hexDecode(D) {
    var Z, q = D.match(/.{1,4}/g) || [],
        P = "";
    for (Z = 0; Z < q.length; Z++) P += String.fromCharCode(parseInt(q[Z], 16));
    return P
}


function hexToBase64(D) {
    return btoa(String.fromCharCode.apply(null, D.replace(/\r|\n/g, "").replace(/([\da-fA-F]{2}) ?/g, "0x$1 ").replace(/ +$/, "").split(" "))).replace(/\+/g, "-").replace(/\//g, "_").replace(/=*$/, "")
}
function decrypt(D, Z) {
    return Z = b64_decode(Z), xor_decrypt(D, Z)
}
function b64_decode(D) {
    let Z, q, P, V, Y, w, st, M, H = 0,
        C = [];
    if (!D) return D;
    D += "";
    do {
        V = b64.indexOf(D.charAt(H++)), Y = b64.indexOf(D.charAt(H++)), w = b64.indexOf(D.charAt(H++)), st = b64.indexOf(D.charAt(H++)), M = V << 18 | Y << 12 | w << 6 | st, Z = M >> 16 & 255, q = M >> 8 & 255, P = 255 & M, C.push(Z), 64 !== w && (C.push(q), 64 !== st && C.push(P))
    } while (H < D.length);
    return C
}
function xor_encrypt(D, Z) {
    return Object.assign([], Z).map((q, P) => q.charCodeAt(0) ^ keyCharAt(D, P))
}

function xor_decrypt(D, Z) {
    return Object.assign([], Z).map((q, P) => String.fromCharCode(q ^ keyCharAt(D, P))).join("")
}

function keyCharAt(D, Z) {
    return D.charCodeAt(Math.floor(Z % D.length))
}
